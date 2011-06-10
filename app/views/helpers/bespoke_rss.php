<?php
App::import('Helper', 'Xml');

/*
 * @name : BespokseRssHelper
 * @description : This helper extends the core RSS helper to incorporate
 * new element types over and above the core elements defined in the extended helper
 */
class BespokeRssHelper extends RssHelper {

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
                        $val = $this->url($val, true);
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
                    if ( is_string( $val['url'] ) && get_headers( $val['url'] ) ) {

                        $headers = get_headers( $val['url'] );

                        if ( !isSet( $val['length'] ) )
                            $val['length'] = sprintf("%u", $headers['Content-Length'] );

                        if ( !isSet( $val['type'] ) )
                                $val['type'] = $headers['Content-Type'];
                    }
                    $val['url'] = $this->url($val['url'], true);
                    $attrib = $val;
                    $val = null;
                    break;
                case 'itunes:explicit':
                    $val = ucfirst( $val );
            }

            if ( !is_null( $val ) && $escape )
                    $val = h($val);

            $elements[$key] = $this->elem($key, $attrib, $val);
        }

        if ( !empty( $elements ) )
                $content = implode('', $elements);

        return $this->elem('item', $att, $content, !($content === null));
    }

}
