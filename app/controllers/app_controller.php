<?php

App::import('Sanitize');

class AppController extends Controller {

    var $components = array( 'Auth', 'Session', 'Permission', 'RequestHandler', 'Folder', 'Api', 'Getid3', 'emailTemplates' );

    var $helpers = array('Html', 'Javascript','Form', 'Session', 'Attachment', 'Time', 'Permission', 'Text', 'Object', 'Breadcrumb' );

    function beforeFilter() {

        // If the current user is attempting to view an admin method ensure the "administrator" flag on their
        // profile is set to TRUE.
        if( isSet( $this->params['admin'] ) && ( $this->params['admin'] ) && ( $this->Session->read('Auth.User.administrator') == false ) ) {

            $this->Session->setFlash('You do not have permission to access this page.', 'default', array(), 'error');
            $this->redirect( array( 'admin' => false, 'controller' => 'users', 'action' => 'dashboard' ) );
        }

        $this->get_breadcrumbs();

    }

    function getExtension( $filename = null ) {

        return substr( $filename, ( strpos( $filename, '.' ) + 1 ), strlen( $filename ) );
    }


    /*
     * @name : get_breadcrumbs
     * @description : Build the breadcrumbs
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

    function callback( $data = array() ) {

        die('we are in the callback');
        
    }

}