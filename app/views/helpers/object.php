<?php
class ObjectHelper extends AppHelper {

    /*
     * @name : isDeleted
     * @description : Accepts an array and returns a bool on whether deleted. 
     * @updated : 1st June 2011
     * @by : Charles Jackson
     */
    function isDeleted( $podcast = array() ) {

        if( $podcast['deleted'] )
            return true;

        return false;
    }

    /*
     * @name : intendedForItunes
     * @description : Retruns a bool depending up the value of the flag set (Y or N)
     * @updated : 20th June 2011
     * @by : Charles Jackson
     */
    function intendedForItunes( $podcast = array() ) {

        if( strtoupper( $podcast['intended_itunesu_flag'] ) == 'Y' )
            return true;

        return false;
    }

    /*
     * @name : intendedForYoutube
     * @description : Retruns a bool depending up the value of the flag set (Y or N)
     * @updated : 20th June 2011
     * @by : Charles Jackson
     */
    function intendedForYoutube( $podcast = array() ) {

        if( strtoupper( $podcast['intended_youtube_flag'] ) == 'Y' )
            return true;

        return false;
    }

}
