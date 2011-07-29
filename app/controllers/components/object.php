<?php
class ObjectComponent extends Object {

   /*
    * @name : ObjectComponent
    * @description : Used to detrmine the status of the object passed as a parameter
    * @updated : 24th May 2011
    * @by : Charles Jackson
    */

    var $components = array('Session');

    var $controller = null;

    /*
     * @name : initialize
     * @description : Grab the controller reference for later use.
     * @updated : 28th July 2011
     * @by : Charles Jackson
     */
    function initialize( & $controller) {
		
       $this->controller = & $controller;
    }
    
    /*
     * @name : itunesPublished
     * @description : Retruns a bool depending up the value of the flag set (Y or N)
     * @updated : 20th June 2011
     * @by : Charles Jackson
     */
    function itunesPublished( $object = array() ) {
    	
    	// Podcast level
    	if( isSet( $object['publish_itunes_u'] ) )
        	return $object['publish_itunes_u'] == strtoupper( YES );

        // PodcastItem level
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
    	
		// PodcastItem level
    	if( isSet( $object['youtube_flag'] ) )
        	return $object['youtube_flag'] == strtoupper( YES );
    }
    
    function isPublished( $object = array() ) {
    	
    	if( $this->youtubePublished( $object ) )
    		return true;
    		
    	if( $this->itunesPublished( $object ) )
    		return true;
    		
    	return false;
    		
    }    
    
}

?>