<?php

App::import('Sanitize');

class AppController extends Controller {

	// NOTE: We are loading every component for every class. We should split this down further and only load each component as
	// needed. However, currently simples...
    var $components = array( 'Auth', 'Session', 'Permission', 'RequestHandler', 'Folder', 'Api', 'Getid3', 'emailTemplates', 'Object', 'Cookie' => array( 'name' => 'OpenUniversity' ) );

    var $helpers = array('Html', 'Javascript','Form', 'Session', 'Attachment', 'Time', 'Permission', 'Text', 'Object', 'Breadcrumb', 'Miscellaneous' );

    /*
     * @name : beforeFilter
     * @description : Called before the controller is executed. Currently using this to ensure only administrators 
	 * access the admin routing and for building the breadcrumbs
     * @updated : 20th June 2011
     * @by : Charles Jackson
     */
    function beforeFilter() {
    	
		if( $this->RequestHandler->isAjax() == false ) {
			
			// If the current user is attempting to view an admin method ensure the "administrator" flag on their
			// profile is set to TRUE.
			if( $this->Permission->isAdminRouting() && $this->Permission->isAdministrator() == false ) {
	
				$this->Session->setFlash('You do not have permission to access this page.', 'default', array(), 'error');
				$this->redirect( array( 'admin' => false, 'controller' => 'users', 'action' => 'dashboard' ) );
				
			} 
			
			if( $this->Permission->isItunesRouting() && $this->Permission->isItunesUser() == false ) {
				
				$this->Session->setFlash('You do not have permission to access this page.', 'default', array(), 'error');
				$this->redirect( array( 'admin' => false, 'controller' => 'users', 'action' => 'dashboard' ) );
			
			} elseif( $this->Permission->isYoutubeRouting() && $this->Permission->isYoutubeUser() == false ) {
	
				$this->Session->setFlash('You do not have permission to access this page.', 'default', array(), 'error');
				$this->redirect( array( 'admin' => false, 'controller' => 'users', 'action' => 'dashboard' ) );
			}
			
			

			// Set the page title in the browser
			$this->set('title_for_layout', ucwords( $this->params['controller'].' &rarr; '.$this->params['action'] ) );
		}
		
		$this->set('params', $this->params );
    }
    
    function beforeRender() {
    	
    	if( $this->RequestHandler->isAjax() == false ) {
    		
    		$this->get_breadcrumbs();
    	}
    }

    /*
     * @name : get_breadcrumbs
     * @description : Build the breadcrumbs, loaded on every page except when it's an ajax call.
     * @updated : 20th June 2011
     * @by : Charles Jackson
     */
    function get_breadcrumbs() {

    	$current_breadcrumb = array(); // Holds details of the currently loaded page
        $breadcrumb = array();
        $breadcrumbs = array(); // Holds the final array of breadcrumbs

        $this->Breadcrumb = ClassRegistry::init('Breadcrumb');
        $this->Breadcrumb->recursive = -1;

        if( isSet( $this->params['url']['url'] ) ) {
            
            $current_breadcrumb =

            $this->Breadcrumb->find('first', array(
                'conditions' => array(
                    'OR' => array (
                        array(
                            'Breadcrumb.controller' => $this->params['controller'],
                            'Breadcrumb.action' => $this->params['action']
                            ),
                        array( 'Breadcrumb.url' => $this->params['url']['url'] )
						)
                    ),
                    'order' => 'Breadcrumb.id DESC'
                )
            );
			
            $parent_id = $current_breadcrumb['Breadcrumb']['parent_id'];
            $breadcrumbs[] = $current_breadcrumb;
            while( (int)$parent_id ) {
	                            	
                $breadcrumb =

	                $this->Breadcrumb->find('first', array(
	                    'conditions' => array(
	                        'Breadcrumb.id' => $parent_id,
	                        )
	                    )
	                );

					if( $current_breadcrumb['Breadcrumb']['controller'] == 'podcast_items' && $breadcrumb['Breadcrumb']['controller'] == 'podcasts' ) {

	                	 if( in_array( $current_breadcrumb['Breadcrumb']['action'], array( 'add', 'admin_add' ) ) && !in_array( $breadcrumb['Breadcrumb']['action'], array( 'index', 'admin_index' ) ) ) {

							$breadcrumb['Breadcrumb']['url'] .= '/'.substr( $this->params['url']['url'], ( mb_strrpos( $this->params['url']['url'],'/' ) +1 ) );
							
	                	 } elseif( !in_array( $breadcrumb['Breadcrumb']['action'], array( 'index','admin_index' ) ) ) {

	                	 	$breadcrumb['Breadcrumb']['url'] .= '/'.$this->data['PodcastItem']['podcast_id'];
	                	 	
	                	 }
	                }
	                
	                $breadcrumbs[] = $breadcrumb;
	                $parent_id = $breadcrumb['Breadcrumb']['parent_id'];
            }

            $this->set('breadcrumbs', array_reverse( $breadcrumbs ) );
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

}
