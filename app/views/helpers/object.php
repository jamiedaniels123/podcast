<?php
class ObjectHelper extends AppHelper {

    var $helpers = array('Permission');

	var $processed_state = array(
	
		'-2' => array('message' => 'failed to copy file back', 'icon' => ERROR_IMAGE ),
		'-1' => array('message' => 'error in transcoding', 'icon' => ERROR_IMAGE ),
		'0' => array('message' => 'no media file at all', 'icon' => INCORRECT_IMAGE ),
		'1' => array('message' => 'awaiting transcoding choice', 'icon' => INCORRECT_IMAGE ),
		'2' => array('message' => 'transcoding in progress', 'icon' => INCORRECT_IMAGE ),
		'3' => array('message' => 'transcoded but awaiting approval', 'icon' => INCORRECT_IMAGE ),
		'9' => array('message' => 'media available', 'icon' => CORRECT_IMAGE ),
	);
	
    /*
     * @name : isDeleted
     * @description : Accepts an array and returns a bool on whether deleted. 
     * @updated : 1st June 2011
     * @by : Charles Jackson
     */
    function isDeleted( $object = array() ) {

        if( $object['deleted'] )
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
    function itunesPublished( $object = array() ) {
    	
    	if( isSet( $object['publish_itunes_u'] ) )
        	return $object['publish_itunes_u'] == strtoupper( YES );

    	if( isSet( $object['itunes_flag'] ) )
        	return $object['itunes_flag'] == strtoupper( YES );
        	
    }

    /*
     * @name : youtubePublished
     * @description : Retruns a bool depending up the value of the flag set (Y or N)
     * @updated : 20th June 2011
     * @by : Charles Jackson
     */
    function youtubePublished( $object = array() ) {

    	// Podcast level
    	if( isSet( $object['publish_youtube'] ) )
        	return $object['publish_youtube'] == strtoupper( YES );
    	
		// Item level
    	if( isSet( $object['youtube_flag'] ) )
        	return $object['youtube_flag'] == strtoupper( YES );
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

	/*
	 * @name : getProcessedState
	 * @description : Translate the processed state of any media into 1 of 3 images to give an indication of status.
	 * @updated : 7th July 2011
	 * @by : Charles Jackson
	 */	
	function getProcessedState( $processed_state ) {
		
		if( isSet( $this->processed_state[$processed_state] ) ) {
			$html = '<img src="/img/'.$this->processed_state[$processed_state]['icon'].'" class="icon" alt="'.$this->processed_state[$processed_state]['message'].'" />';
			$html .= '<span class="tagline">( '.ucwords( $this->processed_state[$processed_state]['message'] ).' )</span>';
			
		} else { 
		
			$html = '<img src="/img/'.ERROR_IMAGE.'" alt="State unknown - '.$processed_state.' Investigate" class="icon" />';
			$html .= '<span class="tagline">State unknown : '.$processed_state.' Investigate!</span>';
			
		}
		
		return $html;
		
	}
}
