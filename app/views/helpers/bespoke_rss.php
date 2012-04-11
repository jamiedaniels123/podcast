<?php

/*
 * @name : BespokseRssHelper
 * @description : This helper extends the core RSS helper to incorporate
 * new element types over and above the core elements defined in the extended helper
 */
class BespokeRssHelper extends RssHelper {

	/*
	 * @name : channel
	 * @description : Extension of the base channel method.
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
                        $contenttype=explode(';',$headers['Content-Type']);
                        $contentlen=explode(';',$headers['Content-Length']);
                        if ( !isSet( $val['length'] ) && isSet( $headers['Content-Length'][1] ) )
                            $val['length'] = sprintf("%u", $contentlen[0] );

                        if ( !isSet( $val['type'] ) && isSet( $headers['Content-Type'][1] ) )
                            $val['type'] = $contenttype[0];
                    }
                    $val['url'] = $this->url($val['url'], true);
                    $attrib = $val;
                    $val = null;
                    break;
                case 'media:content':
                    if ( is_string( $val['url'] ) ) {

                        $headers = get_headers( $val['url'], true );
                        $contenttype=explode(';',$headers['Content-Type']);
                        $contentlen=explode(';',$headers['Content-Length']);
                        if ( !isSet( $val['fileSize'] ) && isSet( $headers['Content-Length'][1] ) )
                            $val['fileSize'] = sprintf("%u", $contentlen[0] );

                        if ( !isSet( $val['type'] ) && isSet( $headers['Content-Type'][1] ) )
                            $val['type'] = $contenttype[0];
                    }
                    $val['url'] = $this->url($val['url'], true);
                    $attrib = $val;
                    $val = null;
                    break;                  
                case 'media:thumbnail':
                    $val['url'] = $this->url($val['url'], true);
                    $attrib = $val;
                    $val = null;
                    break;
                case 'itunesu:category':
                    $attrib = $val['attrib'];
                    $val = null;
                    break;
				case 'atom:link':
					$elements[$key] = $this->itemLevelAtom( $key, $val );	
					break;	
				case 'atom:link1':
					$elements[$key] = $this->itemLevelAtom( $key, $val );
					break;
				case 'atom:linklong':
					$elements[$key] = $this->itemLevelAtom( $key, $val );
					break;	
				case 'atom:link3':
					$elements[$key] = $this->itemLevelAtom( $key, $val );
					break;										
				case 'atom:content':
					$elements[$key] = $this->itemLevelAtom( $key, $val );
					break;	
				case 'atom:categorycourse':
					$elements[$key] = $this->itemLevelAtom( $key, $val );
					break;																
				case 'media:group' :
					$val = $this->itemLevelMedia( $key, $val );	
					break;
            }

			// Not an atom:link, process as normal.
			if( $key != 'atom:link' && $key != 'atom:link1' &&  $key != 'atom:linklong'  &&  $key != 'atom:link3' && $key != 'atom:content' && $key != 'atom:categorycourse') {

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
    

	/*
	 * @name : elem
	 * @description : An extension of the method found in the core xml.php helper.
	 * @updated : 21st September 2011
	 * @by : Charles Jackson
	 */	
	function elem($name, $attrib = array(), $content = null, $endTag = true) {
		$namespace = null;
		if (isset($attrib['namespace'])) {
			$namespace = $attrib['namespace'];
			unset($attrib['namespace']);
		}
		$cdata = false;
		if (is_array($content) && isset($content['cdata'])) {
			$cdata = true;
			unset($content['cdata']);
		}
		if (is_array($content) && array_key_exists('value', $content)) {
			$content = $content['value'];
		}
		$children = array();
		if (is_array($content)) {
			$children = $content;
			$content = null;
		}

//		print_r($attrib);
		$elem =& $this->Xml->createElement($name, $content, $attrib, $namespace);
		foreach ($children as $child) {
			$elem->createElement($name, Null, array('text'=>$child['attrib']['text']));
		}

		$out = $elem->toString(array('cdata' => $cdata, 'leaveOpen' => !$endTag));

		if (!$endTag) {
			$this->Xml =& $elem;
		}

		// Because we use the element name as the key we have a problem where two elements
		// have exactly the same name in the channel data. This bit of "logic by exception" does a
		// preg_replace on any alias of the atom:category that can be identified by atom:category_.
		if( preg_match( '/atom:category_./',  $out ) ) {
			$out = preg_replace( '/atom:category_./', 'atom:category', $out );
		}
		if( preg_match( '/atom:categorycourse./',  $out ) ) {
			$out = preg_replace( '/atom:categorycourse./', 'atom:category ', $out );
		}		
		
		// We called atom:link atom:linkitunesu ealier becuase it doesn't like two elements with the same name
		if( preg_match( '/atom:linkitunesu./',  $out ) ) {
			$out = preg_replace( '/atom:linkitunesu./', 'atom:link ', $out );
		}	
		
		if( preg_match( '/atom:link1./',  $out ) ) {
			$out = preg_replace( '/atom:link1./', 'atom:link ', $out );
		}
		if( preg_match( '/atom:linklong./',  $out ) ) {
			$out = preg_replace( '/atom:linklong./', 'atom:link ', $out );
		}
		if( preg_match( '/atom:link3./',  $out ) ) {
			$out = preg_replace( '/atom:link3./', 'atom:link ', $out );
		}				
				
		if( preg_match( '/atom:linkalternative./',  $out ) ) {
			$out = preg_replace( '/atom:linkalternative./', 'atom:link ', $out );
		}
		
		if( preg_match( '/atom:linkrelated./',  $out ) ) {
			$out = preg_replace( '/atom:linkrelated./', 'atom:link ', $out );
		}
		if( preg_match( '/atom:linkshortcode./',  $out ) ) {
			$out = preg_replace( '/atom:linkshortcode./', 'atom:link ', $out );
		}
			
		
		// Do the same for itunes:category which has the same problem
		if( preg_match( '/itunes:category_./',  $out ) ) {
			$out = preg_replace( '/itunes:category_./', 'itunes:category', $out );
		}		

		// Append a new line "\n" to the end of the return value to aid formatting when viewing the 
		// soure code of an XML feed.
		return $out."\n"; 
	}	
}