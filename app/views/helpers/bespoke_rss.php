<?php
App::import('Helper', 'Xml');

/*
 * @name : BespokseRssHelper
 * @description : This helper extends the core RSS helper to incorporate
 * new element types over and above the core elements defined in the extended helper
 */
class BespokeRssHelper extends RssHelper {

	/*
	 * @name : channel
	 * @description : Extension of the base channel method.
	 * @TODO : Not sure this extension is now needed. To be checked but doing no harm.
	 * @updated : 19th August 2011
	 * @by : Charles Jackson
	 */
    function channel($attrib = array(), $elements = array(), $content = null) {

        $view =& ClassRegistry::getObject('view');

        if (!isset($elements['title']) && !empty($view->pageTitle)) {
                $elements['title'] = $view->pageTitle;
        }
        if (!isset($elements['link'])) {
                $elements['link'] = '/';
        }
        if (!isset($elements['description'])) {
                $elements['description'] = '';
        }
        $elements['link'] = $this->url($elements['link'], true);

        $elems = '';
        foreach ($elements as $elem => $data) {
            $attributes = array();
            if (is_array($data)) {
                if (strtolower($elem) == 'cloud') {
                    $attributes = $data;
                    $data = array();
                } elseif (isset($data['attrib']) && is_array($data['attrib'])) {
                    $attributes = $data['attrib'];
                    unset($data['attrib']);
                } else {
                    $innerElements = '';
                    foreach ($data as $subElement => $value) {
                            $innerElements .= $this->elem($subElement, array(), $value);
                    }
                    $data = $innerElements;
                }
            }
            $elems .= $this->elem($elem, $attributes, $data);
        }
        return $this->elem('channel', $attrib, $elems . $content, !($content === null));
    }

	/*
	 * @name : item
	 * @description : I have extended the base 'item' helper to cope with the weired and wonderful stuff 
	 * we are doing in the RSS feeds. Mostly, it is the many attributes we need to process.
	 * @updated : 19th August 2011
	 * @by : Charles Jackson
	 */
    function item( $att = array(), $elements = array() ) {

        $content = null;

        if ( isSet( $elements['link'] ) && !isset( $elements['guid'] ) )
            $elements['guid'] = $elements['link'];

        foreach ($elements as $key => $val) {

            $attrib = array();

            $escape = true;
            
            if ( is_array( $val ) && isset( $val['convertEntities'] ) ) {

                $escape = $val['convertEntities'];
                unset( $val['convertEntities'] );
            }

            switch ($key) {
                case 'title' :
                case 'description' :
                case 'media:title' :
                case 'media:description' :
                case 'media:keywords' :
                case 'itunes:summary' :
                case 'itunes:keywords' :
                case 'itunes:author' :
                case 'itunes:subtitle' :
                    $val = $this->clean( $val );
                    break;
                case 'itunes:explicit':
                case 'itunes:subtitle' :
                    $val = ucfirst( $val );
                    break;
                case 'pubDate' :
                    $val = date('r', strtotime( $val ) );
                    break;
                case 'category' :
                    if ( is_array( $val ) && !empty( $val[0] ) ) {

                        foreach ($val as $category) {

                            $attrib = array();
                            if ( isSet( $category['domain'] ) ) {

                                $attrib['domain'] = $category['domain'];
                                unset($category['domain']);
                            }

                            $categories[] = $this->elem($key, $attrib, $category);
                        }

                        $elements[$key] = implode('', $categories);
                        continue 2;

                    } else if (is_array($val) && isset($val['domain'])) {
                        $attrib['domain'] = $val['domain'];
                    }
                break;
                case 'link':
                case 'guid':
                case 'comments':
                        if (is_array($val) && isset($val['url'])) {
                                $attrib = $val;
                                unset($attrib['url']);
                                $val = $val['url'];
                        }
                        $val = $this->url( $this->clean( $val ), true);
                break;
                case 'source':
                    if (is_array($val) && isset($val['url'])) {
                            $attrib['url'] = $this->url($val['url'], true);
                            $val = $val['title'];
                    } elseif (is_array($val)) {
                            $attrib['url'] = $this->url($val[0], true);
                            $val = $val[1];
                    }
                    break;
                case 'enclosure':
                    if ( is_string( $val['url'] ) ) {

                        $headers = get_headers( $val['url'], true );
                        if ( !isSet( $val['length'] ) && isSet( $headers['Content-Length'][1] ) )
                            $val['length'] = sprintf("%u", $headers['Content-Length'][1] );

                        if ( !isSet( $val['type'] ) && isSet( $headers['Content-Type'][1] ) )
                            $val['type'] = $headers['Content-Type'][1];
                    }
                    $val['url'] = $this->url($val['url'], true);
                    $attrib = $val;
                    $val = null;
                    break;
                case 'media:thumbnail':
                    if ( is_string( $val['url'] ) ) {

                        if ( !isSet( $val['height'] ) && !isSet( $val['width'] ) ) {
                            $val['height'] = '400px';
                            $val['width'] = '400px';
                        }
                    }
                    $val['url'] = $this->url($val['url'], true);
                    $attrib = $val;
                    $val = null;
                    break;
                case 'itunes:category':
                    $attrib = $val;
                    $val = null;
                    break;
				case 'atom:link' :
					$elements[$key] = $this->itemLevelAtom( $key, $val );	
					break;
				case 'media:group' :
					$val = $this->itemLevelMedia( $key, $val );	
					break;
            }

			// Not an atom:link, process as normal.
			if( $key != 'atom:link' ) {

				if ( !is_null( $val ) && $escape )
					$val = h($val);
	
				$elements[$key] = $this->elem($key, $attrib, $val);
			}
        }

        if ( !empty( $elements ) )
            $content = implode('', $elements);

        return $this->elem('item', $att, $content, !($content === null));
    }

	/*
	 * @name : itemLevelMedia
	 * @description : We need too create "media:group" with several sub properties not catered for within the basic helpers.
	 * @updated : 23rd August 2011
	 * @by : Charles Jackson
	 */
    function itemLevelMedia($key, $values = array() ) {

        $elems = '';
        foreach ($values as $value ) {
			foreach ($value as $elem => $data) {
				$attributes = array();
				if (is_array($data)) {
					if (isset($data['attrib']) && is_array($data['attrib'])) {
						$attributes = $data['attrib'];
						unset($data['attrib']);
					} else {
						$innerElements = '';
						foreach ($data as $subElement => $value) {
								$innerElements .= $this->elem($subElement, array(), $value);
						}
						$data = $innerElements;
					}
				}
				$elems .= $this->elem($elem, $attributes, $data);

			}
		}
       	return $elems;
    }
	
    /*
     * @name : clean
     * @description : Cleans all characters not supported by UTF-8 on RSS. Taken
     * directly from the original implementation.
     * @updated : 3rd June 2011
     * @by : Charles Jackson
     */
    function clean( $string = null ) {

        # entities
        $string = str_replace("&", "&amp;", $string );
        $string = str_replace("'", "&apos;", $string ); # single quote
        $string = str_replace('"', '&quot;', $string ); # double quote
        $string = str_replace("<", "&lt;", $string );
        $string = str_replace(">", "&gt;", $string );
        return $string;
    }
	
	/*
	 * @name : itemLevelAtom
	 * @description : We need to include atom:link within the item elements so it maybe picked up and read by the media player
	 * because it contains the shortcode to the media item. It is above an beyond the scope of the built-in helpers hence
	 * we extend here to cope.
	 * @updated : 19th August 2011
	 * @by : Charles Jackson
	 */
    function itemLevelAtom( $elem, $data = array() ) {

        $view =& ClassRegistry::getObject('view');

		$attributes = array();
		
		if ( is_array( $data ) ) {
			
			if ( isSet( $data['attrib'] ) && is_array( $data['attrib'] ) ) {
				
				$attributes = $data['attrib'];
				unset( $data['attrib'] );
				
			} else {
				
				$innerElements = '';
				
				foreach ( $data as $subElement => $value ) {
					
						$innerElements .= $this->elem( $subElement, array(), $value );
				}
				
				$data = $innerElements;
			}
		}
		
		return $this->elem($elem, $attributes, $data);
    }	
}