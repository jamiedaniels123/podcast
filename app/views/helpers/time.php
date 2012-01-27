<?php
class TimeHelper extends AppHelper
{
    /*
     * @name : getPrettyLongDate
     * @description : Returns a long formatted date
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    public function getPrettyLongDate( $date = null, $system_date = false ) {

        if( $date )
            return date("l, jS F Y", strtotime($date));

        if( $system_date )
            return date("l, jS F Y");

    }

    /*
     * @name : getPrettyShortDate
     * @description : Returns a long formatted date
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    public function getPrettyShortDate( $date = null, $system_date = false ) {

        if( $date )
            return date("D, j M y", strtotime($date));

        if( $system_date )
            return date("D, j M y");

    }

    /*
     * @name : getPrettyLongDateTime
     * @description : Returns a short formatted date
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    public function getPrettyLongDateTime( $date = null ) {

        if( $date )
            return date("l, jS F Y H:ia", strtotime($date));
        return date("l, jS F Y H:ia");

    }
	
}
?>
