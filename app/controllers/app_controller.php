<?php

App::import('Sanitize');

class AppController extends Controller {

    var $components = array( 'Auth', 'Session', 'Permission', 'RequestHandler', 'Folder', 'Api' );

    var $helpers = array('Html', 'Javascript','Form', 'Session', 'Attachment', 'Time', 'Permission', 'Text', 'Object' );

    function beforeFilter() {

        // If the current user is attempting to view an admin method ensure the "administrator" flag on their
        // profile is set to TRUE.
        if( isSet( $this->params['admin'] ) && ( $this->params['admin'] ) && ( $this->Session->read('Auth.User.administrator') == false ) ) {

            $this->Session->setFlash('You do not have permission to access this page.', 'default', array(), 'error');
            $this->redirect( array( 'admin' => false, 'controller' => 'users', 'action' => 'dashboard' ) );
        }
    }



}