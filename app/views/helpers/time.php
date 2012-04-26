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
	
		/*
		 * @name : getTimeSMPTE
		 * @description : Returns a SMPTE formatted time string, slightly modified as it doesn't show frames
		 * @updated : 26th April 2012
		 * @by : Ben Hawkridge
		 */
		public function getTimeSMPTE( $time = null, $timebase = 0 , $decimalpoints = 0) {

			//
			// Creates formated SMPTE string of either HH:MM:SS:FF OR HH:MM:SS.SSS
			// Does not support Drop frames format for NTSC (typical provided as HH:MM:SS.FF)
			// Only support 25 and 30 fps as timebase
			// timebase only required for HH:MM:SS:FF format - if timebase=0 then assume HH:MM:SS.SSS required
			// supports decimalpoints, but defaults to none.
			
			$time = ($time != null) ? $time : 0;
			$timebase = ($timebase==25 || $timebase==30) ? $timebase : 0;
			$decimalpoints = ($decimalpoints > 0) ? min($decimalpoints, 3) : 0;  // limit decimal points to 3 at moost

			if ($time == 0) {
				return "n/a";
			}
			
			$hours = floor($time/3600);
			$mins = floor(($time-($hours*3600))/60);
			if ($decimalpoints > 0) {
				$secs= round(($time-($hours*3600)-($mins*60)),$decimalpoints);
			} else {
				$secs= floor($time-($hours*3600)-($mins*60));
			}
			
			if ($timebase==0) {
				// assume HH:MM:SS.SSS required
				$h = ($hours < 10) ? "0".$hours : $hours;
				$m = ($mins < 10) ? "0".$mins : $mins;
				$s = ($secs < 10) ? "0".$secs : $secs;
				$smpte_string=$h.":".$m.":".$s;
			} else {
				$wholeSecs = floor($secs); 
				$frames=round(($secs-$wholeSecs)*$timebase,0);
				$h = ($hours < 10) ? "0".$hours : $hours;
				$m = ($mins < 10) ? "0".$mins : $mins;
				$s = ($wholeSecs < 10) ? "0".$wholeSecs : $wholeSecs;
				$f = ($frames < 10) ? "0".$frames : $frames;
				$smpte_string=$h.":".$m.":".$s.":".$f;
			}
			
			return $smpte_string;
		}
	
}
?>
