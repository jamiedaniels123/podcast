<?php

App::import('Sanitize');

class AppController extends Controller {

	// NOTE: We are loading every component for every class. We should split this down further and only load each component as
	// needed. However, currently simples...
    var $components = array( 'Auth', 'Session', 'Permission', 'RequestHandler', 'Folder', 'Api', 'Getid3', 'emailTemplates', 'Object', 'Cookie' => array( 'name' => 'OpenUniversity' ) );

    var $helpers = array('Html', 'Javascript','Form', 'Session', 'Attachment', 'Time', 'Permission', 'Text', 'Object', 'Breadcrumb', 'Miscellaneous' );

    var $alert = false; // A flag used to determine if an alter has been set that overrides any defacto flash message.
    /*
     * @name : beforeFilter
     * @description : Called before the controller is executed. Currently using this to ensure only administrators 
	 * access the admin routing and for building the breadcrumbs
     * @updated : 20th June 2011
     * @by : Charles Jackson
     */
    function beforeFilter() {
    	
    	$this->alert = false;

    	
		if( $this->RequestHandler->isAjax() == false ) {
			
			// If the current user is attempting to view an admin, youtube or itunes specific method ensure they have permission else
			// redirect to a 404 page and create a row on the notifications table alerting admin to the attempt.
			if( ( $this->isAdminRouting() && $this->isAdministrator() == false ) || ( $this->isItunesRouting() && $this->isItunesUser() == false ) || ( $this->isYoutubeRouting() && $this->isYoutubeUser() == false ) ) {

				// It would appear the user has attempted to access a URL to which they have no permission.
				// Create a row on the notifications table
				$Notification = ClassRegistry::init('Notification');
				$Notification->unauthorisedAccess( $this->Session->read('Auth.User'), $this->params['url']['url'] );
				
				$this->Session->setFlash( 'Could not find the page you were looking for. Please try again', 'default', array( 'class' => 'error' ) );
				$this->cakeError('error404');
			}

			// Set the page title in the browser
			$this->set('title_for_layout', ucwords( $this->params['controller'].' &rarr; '.$this->params['action'] ) );
		}
		
		$this->set('params', $this->params );
    }
    
    function beforeRender() {
    	
    	if( $this->RequestHandler->isAjax() == false ) {
    		
			$Breadcrumb = ClassRegistry::init('Breadcrumb');
			$Breadcrumb->recursive = 0;
			$this->set('breadcrumbs', $Breadcrumb->build( $this->params, $this->data  ) );			
    	}
    }

	/*
	 * @name : getExtension
	 * @description : Return the extension of parameter passed	
	 * @updated : 28th June 2011
	 * @by : Charles Jackson
	 */
    function getExtension( $filename = null ) {

        return substr( $filename, ( strpos( $filename, '.' ) + 1 ), strlen( $filename ) );
    }

    /*
     * @name : cookie
     * @description :
     * @updated : 4th August 2011
     * @by : Charles Jackson
     */
    function cookie() {
    	
    	$this->autoRender = false;
    	$active_columns = array();
    	
    	foreach( $this->data['Podcast'] as $key => $value ) {
    		
    		$active_columns[] = $key;
    	}
    	
    	$this->Cookie->write('Podcasts',$active_columns, false );
    	return true;
    }
    
    /*
     * @name : cookieStanding
     * @description :
     * @updated : 5th August 2011 
     * @by : Charles Jackson
     */
    function cookieStanding( $cookie_name = null ) {
    	
    	$active_columns = array();
    	
		if( $this->Cookie->read($cookie_name) ) {
        
        	$active_columns = $this->Cookie->read($cookie_name);
        
        } else {

	        $active_columns = array('title','owner','created','thumbnail', 'media', 'publish_itunes_u','publish_youtube','podcast_flag');
			$this->Cookie->write($cookie_name,$active_columns, false );
       }
       
       return $active_columns;
    }    

    /*
     * @name : isItunesUser
     * @description : Returns a bool depending upon whether the user is an itunes user.
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function isItunesUser() {

        if( strtoupper( $this->Session->read('Auth.User.iTunesU') ) == 'Y' )
            return true;

        return false;
    }
	
    /*
     * @name : isYoutubeUser
     * @description : Returns a bool depending upon whether the user is a youtube user.
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function isYoutubeUser() {

        if( strtoupper( $this->Session->read('Auth.User.YouTube') ) == 'Y' )
            return true;

        return false;

    }	
	
    /*
     * @name : isAdministrator
     * @description : Returns a bool.
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function isAdministrator() {

		if( $this->Session->check('Auth.User.id') && $this->Session->read('Auth.User.administrator') == true )
			return true;
			
        return false;
    }	
	
	
	
    /*
     * @name : isAdminRouting
     * @description : Checks to see if the current URL is an admin page and returns a boolean.
     * @updated : 31st May 2011
     * @by : Charles Jackson
     */
    function isAdminRouting() {

        if( substr( $this->action, 0, 6 ) == 'admin_' )
            return true;
        
        return false;
    }
	
    /*
     * @name : isItunesRouting
     * @description : Checks to see if the current URL is an itunes specific page and returns a boolean.
     * @updated : 31st May 2011
     * @by : Charles Jackson
     */
    function isItunesRouting() {

        if( substr( $this->action, 0, 7 ) == 'itunes_' )
            return true;
        
        return false;
    }
    
    /*
     * @name : isYoutubeRouting
     * @description : Checks to see if the current URL is an itunes specific page and returns a boolean.
     * @updated : 31st May 2011
     * @by : Charles Jackson
     */
    function isYoutubeRouting() {
    	
        if( substr( $this->action, 0, 8 ) == 'youtube_' )
            return true;
        
        return false;
    }	
	
	
    /*
     * @name : __generateRSSFeeds
     * @description : Will retrieve the podcast passed as an ID and try to generate RSS feeds if needed. Returns a bool.
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    protected function __generateRSSFeeds( $id = null ) {

        $podcast = null;
		$Podcast = ClassRegistry::init('Podcast');
		
        $Podcast->recursive = -1; // Minimise the amount of data we retrieve.
        $podcast = $Podcast->findById( $id );

        if( empty( $podcast ) )
            return false;

		// Generate the RSS Feeds by calling the "/feeds/add/*ID*" URL.
		return $this->requestAction( array('controller' => 'feeds', 'action' => 'add'), array('id' => $podcast['Podcast']['id'] ) );
    }	
}
