<?php

App::import('Sanitize');

class AppController extends Controller {

	// NOTE: We are loading every component for every class. We should split this down further and only load each component as
	// needed. However, currently simples...
    var $components = array( 'Auth', 'Session', 'Permission', 'RequestHandler', 'Folder', 'Api', 'Getid3', 'emailTemplates' );

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

        $breadcrumb = array();
        $breadcrumbs = array();

        $this->Breadcrumb = ClassRegistry::init('Breadcrumb');
        $this->Breadcrumb->recursive = -1;

        if( isSet( $this->params['url']['url'] ) ) {
            
            $breadcrumb =

            $this->Breadcrumb->find('first', array(
                'conditions' => array(
                    'OR' => array (
                        array( 'Breadcrumb.url' => $this->params['url']['url'] ),
                        array(
                            'Breadcrumb.controller' => $this->params['controller'],
                            'Breadcrumb.action' => $this->params['action'],
                            )
                        )
                    )
                )
            );

            $parent_id = $breadcrumb['Breadcrumb']['parent_id'];
            $breadcrumbs[] = $breadcrumb;

            while( (int)$breadcrumb['Breadcrumb']['parent_id'] ) {

                $breadcrumb =

                $this->Breadcrumb->find('first', array(
                    'conditions' => array(
                        'Breadcrumb.id' => $parent_id,
                        )
                    )
                );

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
	 * @name : callback
	 * @description : The API callback URL, will echo out a json encoded array to screen.
	 * @updated : 28th June 2011
	 * @by : Charles Jackson
	 */
	function callback( $data = array() ) {

		$this->layout = 'none';

		$data = array(
			'command' => 'whatever',
			'status' => 'ACK',
			'mqIndex' => 1,
			'timestamp' => date('Y-m-d H:i:s')
		);
		
		echo json_encode( $data );
		die();        
    }

}
