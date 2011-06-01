<?php
class ObjectHelper extends AppHelper {

    /*
     * @name : isDeleted
     * @description : Accepts an array and returns a bool on whether deleted. At time of publication
     * this method is specific to the podcast object
     * @updated : 1st June 2011
     * @by : Charles Jackson
     */
    function isDeleted( $object = array() ) {

        if( $object['deleted'] )
            return true;

        return false;
    }

}
