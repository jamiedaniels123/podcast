<?php
class BespokeRssHelper extends AppHelper {


    /*
     * @name : interlaceTranscript
     * @description :
     * @updated : 2nd June 2011
     * @by : Charles Jackson
     */
    function interlaceTranscript( $params = array() ) {

        if( $params['interlace'] == false )
            return false;

        if( in_array( $params['media_type'], $valid_media_type ) )
            return true;
        
        return false;
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
        $str = str_replace("&", "&amp;", $str);
        $str = str_replace("'", "&apos;", $str); # single quote
        $str = str_replace('"', '&quot;', $str); # double quote
        $str = str_replace("<", "&lt;", $str);
        $str = str_replace(">", "&gt;", $str);
        return $str;
    }
}
?>
