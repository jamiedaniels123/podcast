<?php

class AppModel extends Model {

    /*
     * @name : removeDuplicates
     * @description : Compares two arrays and removes any duplicate elements from the first parameter
     * passed $array. This is used for the dynamic select boxes to ensure for example, a user does not exist
     * in the list of "All Users" if they have already been added to the 'Members' list.
     * @updated : 12th May 2011
     * @by : Charles Jackson
     */
    function removeDuplicates( $array = array(), $subset_array = array(), $data_key = null  ) {

        // Does the subset array element exist
        if( isSet( $subset_array[$data_key] ) ) {

            $list = array();
            $subset_list = array();


            // Rebuild the users list into an acceptable array
            foreach( $array as $key => $element ) {

                $list[] = $key;
            }

            foreach( $subset_array[$data_key] as $row ) {

                $subset_list[] = $row['id'];
            }

            // Read through the main array and remove any elements from
            // the list (passed as a parameter) that exist in the
            // members/moderator arrays.
            foreach( $list as $element ) {

                if( in_array( $element, $subset_list ) ) {
                    if( isSet( $array[$element] ) ) {
                        unset($array[$element]);
                    }
                }
            }
        }

        // Return the trimmed array.
        return $array;
    }

    /*
     * @name : unsetAttachments
     * @description : This unique method will unset the array element from the file uploads before saving then return the
     * last_insert_id that 'maybe' used as part of the folder structure when saving associated assets.
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function unsetAttachments( $data ) {

        foreach( $data[$this->name] as $key => $element ) {

            // If it's an upload identified by an array and the existence of the tmp_name element then unset it.
            if( is_array( $element ) && isSet( $element['tmp_name'] ) )
                unset( $data[$this->name][$key] );
        }

        return $data;
    }

    /*
     * @name : buildSafeFilename
     * @description : Will replace various characters with underscores so they maybe safely used as a folder
     * name on the server.
     * @updated : 24th May 2011
     * @by : Charles Jackson
     */
    function buildSafeFilename( $string, $force_lowercase = true, $anal = true ) {

        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                       "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                       "â€”", "â€“", ",", "<", ".", ">", "/", "?");

        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }
}