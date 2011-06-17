<?php
class UsersController extends AppController {

    var $name = 'Users';
    private $errors = array();

    var $paginate = array( 'limit' => 20, 'page' => 1, 'order' => array( 'User.full_name' => 'ASC' ) );

    /*
     * @name : beforeFilter
     * @description : The following methods can be accessed without logging in.
     * @updated : 2nd June 2010
     */
    function beforeFilter() {
        
        $this->Auth->allow( 'register', 'login', 'home' );
        parent::beforeFilter();
    }

    /*
     * @name : beforeRender
     * @description : Exists for ajax calls enabling the display of errors within a wizard dialog box.
     * @updated : 2nd June 2010
     */
    function beforeRender() {
        
        $this->errors = $this->User->invalidFields();
        $this->set('errors', $this->errors );
    }

    /*
     * @name : login
     * @description : 
     * @updated : 10th May 2011
     * @by : Charles Jackson
     */
    function login() {

        // Check to see if they are already logged in and redirect if true
        if( $this->Session->check('Auth.User.id') ) {
            $this->redirect( array( 'admin' => false, 'controller' => 'users', 'action' => 'dashboard' ) );
            exit;

        // Check they have logged in SAMS else redirect. SAMS details are picked up the bootstrap.php
        } elseif( SAMS_OUCU_ID == 'UNDEFINED')  {

            $this->redirect( SAMS_LOGIN_PAGE );
        }

        // If the user is logged into SAMS but not currently logged into the application attempt
        // to find them  using the apache environment varibles else redirect to the registration form.
        if( $this->Session->check('Auth.User.id') == false ) {

            $this->User->recursive = -1;
            $this->data = $this->User->findByOucu( SAMS_OUCU_ID );

            // They do not appear to be registered on the application, redirect them to the register action
            if( empty( $this->data ) ) {

                $this->redirect( array( 'admin' => false, 'controller' => 'users', 'action' => 'register' ) );
                exit;

            // We found the user but the terms and conditions have been updated since they last logged in.
            // Redirect them to the register action.
            } elseif( $this->data['User']['terms'] == false ) {

                $this->Session->setFlash('Please agree to our new terms and conditions.', 'default', array( 'class' => 'success' ) );
                $this->redirect( array( 'admin' => false, 'controller' => 'users', 'action' => 'register' ) );
                exit;

            // We found the user but the terms and conditions have been updated since they last logged in.
            // Redirect them to the register action.
            } elseif( $this->data['User']['status'] == false ) {

                $this->Session->setFlash('Your account is not currently active. Please contact an administrator.', 'default', array( 'class' => 'success' ) );
                $this->redirect( array( 'admin' => false, 'controller' => 'users', 'action' => 'home' ) );
                exit;

            } else {

                // We have found them on the application using their SAMS details. Create a session then redirect.
                $this->Auth->fields = array('username' => 'oucu', 'password' => 'oucu');
                if( $this->Auth->login( $this->data ) ) {

                    $this->Session->setFlash('You have successfully logged in.', 'default', array( 'class' => 'success' ) );
                    $this->redirect( array( 'admin' => false, 'controller' => 'users', 'action' => 'dashboard') );

                } else {

                    $this->Session->setFlash('We are sorry but something has gone wrong and we have been unable to log you in. Please contact an administrator.', 'default', array('class' => 'error' ) );
                    $this->cakeError( 'error404', array( array( 'url' => '/' ) ) );
                }
            }
        }
    }

    function home() {

    }
    
    function dashboard() {

        $this->data = $this->User->getDashboardData( $this->Session->read('Auth.User.id' ) );
    }

    /*
     * @name : logout
     * @description : Destroys and session variables and redirects to the home page
     * @updated : 20th March 2011
     * @by : Charles Jackson
     */
    function logout() {

        $this->Session->destroy('Auth');
        $this->redirect( array( 'url' => $_SESSION['REDIRECT_HTTP_SAMS_LOGOFF'] ) );
    }

    /*
     * @name : register
     * @description : Users are redirected to this page when they first register else when the terms and conditions
     * have been updated. If it is a new user it will build a row on the users table from SAMS data.
     * @updated : 10th May 2011
     * @by : Charles Jackson
     */
    function register() {

        // Redirect if already logged in.
        if( $this->Session->check('Auth.User.id') )
            $this->redirect( array( 'admin' => false, 'controller' => 'users', 'action' => 'login' ) );

        // They are posting data
        if ( !empty( $this->data ) ) {

            if( isSet( $this->data['User']['terms'] ) ) {

                // See if they are an existing user agreeing to revamped terms and conditions
                $this->data = $this->User->findByOucu( SAMS_OUCU_ID );

                // If empty, they are a new user and we must build their details from the SAMS data.
                if( empty( $this->data ) )
                    $this->data = $this->User->buildUserFromSamsData();

                // Update their profile to reflect their agreement to the terms and conditions.
                $this->data['User']['terms'] = true;

                if( $this->User->set( $this->data ) && ( $this->User->validates( $this->data ) ) ) {

                    $this->User->save($this->data);

                    // Create their basic profile information
                    //$this->emailTemplates->__sendNewUserMail( $this->data );

                    $this->redirect( array( 'action' => 'login' ) );
                    exit;

                } else {

                    $this->Session->setFlash('Something has gone wrong and we were unable to build your profile from SAMS data. Please alert an administrator.', 'default', array( 'class' => 'error' ) );
                }

            } else {

                $this->Session->setFlash( 'You must agree to our terms and conditions in order to continue.', 'default', array( 'class' => 'error' ) );
            }
        }
    }

    /*
     * ADMIN FUNCTIONALITY
     * Below this line are the administration functionality that can only be reach if the flag 'administrator' is set to true on the
     * users profile. The URL for all admin routes is "admin/:controller:/:action:/*
     */

    /*
     * @name : admin_index
     * @desscription : Displays a paginated list of all users on the system.
     * @name : Charles Jackson
     * @by : 4th May 2011
     */
    function admin_index() {

        $this->data['Users'] = $this->paginate('User');
    }

    /*
     * @name : admin_status
     * @desscription : Will toggle their status between active and deactive.
     * @name : Charles Jackson
     * @by : 10th May 2011
     */
    function admin_status( $id ) {

        $this->autoRender = false;
        $this->data = $this->User->findById( $id );

        if( empty( $this->data ) ) {

            $this->Session->setFlash('We have been unable to identify the user you wish to update. Please contact an administrator.', 'default', array('class' => 'error' ) );
            $this->redirect( $this->referer() );
            exit();
        }

        if( $this->data['User']['status'] == true ) {

            $this->Session->setFlash('The user account has been successfully deactivated.', 'default', array('class' => 'success' ) );
            $this->data['User']['status'] = false;

        } else {

            $this->Session->setFlash('The user account has been successfully activated.', 'default', array('class' => 'success' ) );
            $this->data['User']['status'] = true;
        }

        // Unset any validation rules incase it is an old profile that will not match revamped validation.
        unset( $this->User->validate );
        
        $this->User->save( $this->data );
        $this->redirect( $this->referer() );

    }

    /*
     * @name : admin_edit
     * @desscription : Displays a form that enables administrators to edit an existing row on the users table.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function admin_edit( $id = null ) {

        if ( !empty( $this->data ) ) {

            $this->User->set( $this->data );

            // We use the 'saveAll' as opposed to 'save' in order to capture all related hasMany and HBTM data.
            if( $this->User->save( $this->data ) ) {

                $this->Session->setFlash( 'The user profile has been successfully updated. Changes will take effect when they next login.', 'default', array( 'class' => 'success' ) );
                $this->redirect( array( 'admin' => true, 'action' => 'index' ) );

            } else {

                $this->errors = $this->User->invalidFields( $this->data );

                $this->Session->setFlash( 'Could not update this user profile. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }

        } else {

            // They are loading the page, get the data using the $id passed as a parameter.
            $this->data = $this->User->findById( $id );

            // We did not find the podcast, error and redirect.
            if( empty( $this->data ) ) {

                $this->Session->setFlash( 'Could not find your chosen user. Please try again.', 'default', array( 'class' => 'error' ) );
                $this->redirect( array( 'admin' => true, 'action' => 'index' ) );
            }
        }
    }

    /*
     * @name : admin_reset
     * @description : Enables an administrator to update the value of terms on the users table to
     * "false" forcing every user to agree to the terms and conditions when they next attempt to
     * login.
     * @updated : 1st June 2011
     * @by : Charles Jackson
     */
    function admin_reset() {

        $this->data = $this->User->find('all');

        foreach( $this->data as $user ) {

            $user['User']['terms'] = false;
            $this->User->set( $user );
            $this->User->save();
        }

        $this->Session->setFlash( 'Terms and conditions have been reset. Users willl be forced to agree next time they login.', 'default', array( 'class' => 'success' ) );
        $this->redirect( $this->referer() );
    }

}
?>
