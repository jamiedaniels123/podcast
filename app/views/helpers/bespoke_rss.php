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





}
?>
