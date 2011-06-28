<?php
class MiscellaneousHelper extends AppHelper {

    /*
     * @name : isDeleted
     * @description : Accepts an array and returns a bool on whether deleted. 
     * @updated : 1st June 2011
     * @by : Charles Jackson
     */
    function isAdminRouting() {

		return isSet( $this->params['admin'] );
    }

}
