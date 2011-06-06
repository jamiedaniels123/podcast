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
        $string = str_replace("&", "&amp;", $string );
        $string = str_replace("'", "&apos;", $string ); # single quote
        $string = str_replace('"', '&quot;', $string ); # double quote
        $string = str_replace("<", "&lt;", $string );
        $string = str_replace(">", "&gt;", $string );
        return $string;
    }

    /*
     * @name : cleanAttribute
     * @description : Cleans all characters not supported by UTF-8 on RSS. Differs
     * slightly from the method aboce in that it also cleans the ":" that is needed in
     * attributes only. Not to be used on plain data.
     * @updated : 3rd June 2011
     * @by : Charles Jackson
     */
    function cleanAttribute( $string = null ) {

        # entities
        $string = str_replace("&", "&amp;", $string );
        $string = str_replace("'", "&apos;", $string ); # single quote
        $string = str_replace('"', '&quot;', $string ); # double quote
        $string = str_replace("<", "&lt;", $string );
        $string = str_replace(">", "&gt;", $string );
        $string = str_replace(":", "%3A", $string );
        return $string;
    }
}
?>
