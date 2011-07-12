<?php
class ObjectHelper extends AppHelper {

    var $helpers = array('Permission');

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
     * @name : considerForItunes
     * @description : Retruns a bool depending up the value of the flag.
     * @updated : 20th June 2011
     * @by : Charles Jackson
     */
    function considerForItunes( $podcast = array() ) {

        return $podcast['consider_for_itunesu'];
    }

    /*
     * @name : considerForYoutube
     * @description : Retruns a bool depending up the value of the flag set (Y or N)
     * @updated : 20th June 2011
     * @by : Charles Jackson
     */
    function considerForYoutube( $podcast = array() ) {

        return $podcast['consider_for_youtube'];
    }

    /*
     * @name : intendedForItunes
     * @description : Retruns a bool depending up the value of the flag set (Y or N)
     * @updated : 20th June 2011
     * @by : Charles Jackson
     */
    function intendedForItunes( $podcast = array() ) {

        return $podcast['intended_itunesu_flag'] == strtoupper( YES );
    }

    /*
     * @name : itunesPublished
     * @description : Retruns a bool depending up the value of the flag set (Y or N)
     * @updated : 20th June 2011
     * @by : Charles Jackson
     */
    function itunesPublished( $podcast = array() ) {

        return $podcast['itunes_flag'] == strtoupper( YES );
    }

    /*
     * @name : youtubePublished
     * @description : Retruns a bool depending up the value of the flag set (Y or N)
     * @updated : 20th June 2011
     * @by : Charles Jackson
     */
    function youtubePublished( $podcast = array() ) {

        return $podcast['youtube_flag'] == strtoupper( YES );
    }

    /*
     * @name : intendedForItunes
     * @description : Retruns a bool depending up the value of the flag set (Y or N)
     * @updated : 20th June 2011
     * @by : Charles Jackson
     */
    function intendedForYoutube( $podcast = array() ) {

        return $podcast['intended_youtube_flag'] == strtoupper( YES );
    }
	
	function editing( $object = array() ) {
	
		if( !isSet( $object['id'] ) )
			return false;
			
		if( (int)$object['id'] )
			return true;	
	}
	
    /*
     * @name : changeOfOwnership
     * @description : Checks to see if a podcast is in a statement of 'unconfirmed change of ownership' and returns a bool
     * @updated : 28th June 2011
     * @by : Charles Jackson
     */
	function changeOfOwnership( $podcast = array() ) {
		
		return isSet( $podcast['current_owner_id'] );
	}
	
	
	/*
	 * @name : waitingYoutubeApproval
	 * @description : Called from the approver screen it checks to see the status of any podcast on the approval listing.
	 * @updated : 6th July 2011
	 * @by : Charles Jackson
	 */	
	function waitingYoutubeApproval( $podcast = array() ) {
	
		// Is this podcast under consideration?
		if( $this->considerForYoutube( $podcast ) == false )	{
			return false;
		}
		
		// Has it already been approved?
		if( $this->intendedForYoutube( $podcast ) ) {
			return false;
		}
			
		// Not yet been approved.	
		return true;
			
	}
	
	/*
	 * @name : waitingItunesApproval
	 * @description : Called from the approver screen it checks to see the status of any podcast on the approval listing.
	 * @updated : 6th July 2011
	 * @by : Charles Jackson
	 */	
	function waitingItunesApproval( $podcast = array() ) {
	
		// Is this podcast under consideration?
		if( $this->considerForItunes( $podcast ) == false )	
			return false;
			
		// Has it already been approved?
		if( $this->intendedForItunes( $podcast ) )
			return false;
			
		// Not yet been approved.	
		return true;
			
	}
	
}
