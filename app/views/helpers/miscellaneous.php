<?php
class MiscellaneousHelper extends AppHelper {

    /*
     * @name : isAdminRouting
     * @description : Returns a bool
     * @updated : 1st June 2011
     * @by : Charles Jackson
     */
    function isAdminRouting() {

		return isSet( $this->params['admin'] );
    }

}
