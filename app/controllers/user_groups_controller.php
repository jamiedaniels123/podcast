<?php

class UserGroupsController extends AppController {

    var $name = 'UserGroups';
    private $errors = array();

    var $paginate = array( 'limit' => 20, 'page' => 1, 'order' => array( 'UserGroup.group_title' => 'ASC' ) );

    /*
     * @name : beforeRender
     * @description : The beforeRender action is automatically called after the controller action has been executed and before the screen
     * is rendered. We are applying some global actions here. Not necessarily the most efficient but very simple.
     * @updated : 10th May 2011
     * @by : Charles Jackson
     */
    function beforeRender() {

        // If there are any errors assign them to the view
        if( count( $this->errors ) )
            $this->set('errors', $this->errors );


        $this->User = ClassRegistry::init('User');
        $this->users = $this->User->find('list', array( 'fields' => array('User.id', 'User.full_name' ), 'order' => 'User.full_name ASC' ) );
        $this->users = $this->User->removeDuplicates( $this->users, $this->data, 'Members' );
        $this->users = $this->User->removeDuplicates( $this->users, $this->data, 'Moderators' );
        $this->set('users', $this->users );
    }


    /*
     * @name : index
     * @desscription : Displays a paginated list of all usergroups the currently logged in user is associated with.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function index() {

        // We must unbind this relationship else we will get dupliate entries on the join.
        unset( $this->UserGroup->hasOne['UserUserGroup'] );
        $this->data['UserGroups'] = $this->paginate('UserGroup', array('UserGroup.id' => $this->UserGroup->getUserUserGroups( $this->Session->read('Auth.User.id') ) ) );
    }

    /*
     * @name : add
     * @description : Displays a form that enables a user to add a row to the user_groups table. If the form is
     * populated it will validate the data and save if possible. It will also add the current user to the list
     * of moderators.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function add() {

        if ( !empty( $this->data ) ) {

            // Add the current user as a moderator using a "hasMany GroupModerators" relationship saved to the same HBTM joining table
            // user_user_groups so we may set the "moderator" flag to true. Not possible to set the moderatr flag using HBTM.
            $this->data['GroupModerators'] = array();
            $this->data['GroupModerators'][0]['user_id'] = $this->Session->read('Auth.User.id');
            $this->data['GroupModerators'][0]['moderator'] = true;

            if( $this->UserGroup->set( $this->data ) && $this->UserGroup->validates( $this->data ) ) {

                $this->UserGroup->saveAll( $this->data );
                $this->Session->setFlash( 'The usergroup has been successfully created. You may now add members and moderators.', 'default', array( 'class' => 'success' ) );
                $this->redirect( array( 'action' => 'edit', $this->UserGroup->getLastInsertId() ) );

            } else {

                $this->errors = $this->UserGroup->invalidFields( $this->data );
                $this->Session->setFlash( 'Could not create the user group. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }
        }
    }

    /*
     * @name : edit
     * @desscription : Displays a form that enables peeps to edit an existing row on the user groups table if they are assigned
     * as a moderator.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function edit( $id = null ) {

        if ( !empty( $this->data ) ) {

            // Create the UserGroupModerators that are saved using a hasMany relationship
            $this->data = $this->UserGroup->createUserGroupModerators( $this->data );

            $this->UserGroup->set( $this->data );

            // We use the 'saveAll' as opposed to 'save' in order to capture all related hasMany and HBTM data.
            if( $this->UserGroup->saveAll( $this->data ) ) {

                $this->Session->setFlash( 'The user group has been successfully updated.', 'default', array( 'class' => 'success' ) );
                $this->redirect( array( 'action' => 'view', $this->data['UserGroup']['id'] ) );

            } else {

                $this->errors = $this->UserGroup->invalidFields( $this->data );

                // If they user has made a mistake we must rebuild the member/moderator select boxes using their most recently
                // chosen data else they will merely display the ID numbers of the previously chosen group members.
                $this->data['Members'] = $this->UserGroup->rebuildSelection( $this->data['Members'] );
                $this->data['Moderators'] = $this->UserGroup->rebuildSelection( $this->data['Moderators'] );

                $this->Session->setFlash( 'Could not update this user group. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }

        } else {

            // They are loading the page, get the data using the $id passed as a parameter.
            $this->data = $this->UserGroup->findById( $id );
            
            // We did not find the podcast, error and redirect.
            if( empty( $this->data ) || $this->Permission->toUpdate( $this->data ) == false ) {

                $this->Session->setFlash( 'Could not find your chosen user group. Please try again.', 'default', array( 'class' => 'error' ) );
                $this->redirect( $this->referer() );
            }
        }
    }

    /*
     * @name : view
     * @desscription : Enables a moderator or member to view details of an individual user group.
     * as a moderator.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function view( $id = null ) {

        // They are loading the page, get the data using the $id passed as a parameter.
        $this->data = $this->UserGroup->findById( $id );

        // We did not find the podcast, error and redirect.
        if( empty( $this->data ) || $this->Permission->toView( $this->data) == false ) {

            $this->Session->setFlash( 'Could not find your chosen user group. Please try again.', 'default', array( 'class' => 'error' ) );
            $this->redirect( array( 'action' => 'index' ) );
        }
    }

    /*
     * @name : delete
     * @desscription : Enables a user group moderator to perform a hard delete on a user group.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function delete( $id = null ) {

        $this->autoRender = false;
        $this->recursive = -1;

        // This method is used for individual deletes and deletions via the form posted checkbox selection. Hence
        // when somebody is deleting an individual podcast we pass into an array and loop through as is the data
        // was posted.
        if( $id )
            $this->data['UserGroup']['Checkbox'][$id] = 'On';

        foreach( $this->data['UserGroup']['Checkbox'] as $key => $value ) {

            $this->usergroup = $this->UserGroup->findById( $key );

        // If we did no find the UserGroup or they have no permission that redirect to the referer.
            if( !empty( $this->usergroup ) && $this->Permission->toUpdate( $this->usergroup ) == true ) {

                // Delete the usergroup
                $this->UserGroup->delete( $this->usergroup['UserGroup']['id'] );
                $this->Session->setFlash( 'We successfully deleted the user group.', 'default', array( 'class' => 'success' ) );
            }
        }

        $this->redirect( $this->referer() );
    }

    /*
     * @name : remove_podcast
     * @desscription : Enables a group moderator or administrator to delete a relationship between podcast and user_group by
     * instanitating a object of the magic model, retrieving a row using the parameters passed then deleting it.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function remove_podcast( $user_group_id, $podcast_id = null ) {

        $this->UserGroupPodcast = ClassRegistry::init('UserGroupPodcast');
        $this->data = $this->UserGroupPodcast->find('first', array('conditions' => array('UserGroupPodcast.user_group_id' => $user_group_id, 'UserGroupPodcast.podcast_id' => $podcast_id ) ) );

        if( empty($this->data ) || ( $this->Permission->toUpdate( $this->data ) == false && $this->Session->read('Auth.User.administrator') == false ) ) {

            $this->Session->setFlash( 'Could not identify the podcast relationship you are trying to delete. Please try again.', 'default', array( 'class' => 'error' ) );

        } else {

            $this->UserGroupPodcast->delete( $this->data['UserGroupPodcast']['id'] );
            $this->Session->setFlash( 'Podcast relationship has been successfully deleted.', 'default', array( 'class' => 'success' ) );
        }
        
        $this->redirect( $this->referer() );
    }

    /*
     * ADMIN FUNCTIONALITY
     * Below this line are the administration functionality that can only be reach if the flag 'administrator' is set to true on the
     * users profile. The URL for all admin routes is "admin/:controller:/:action:/*
     */
    
    /*
     * @name : admin_index
     * @desscription : Displays a paginated list of all podcasts currently on the system.
     * @name : Charles Jackson
     * @by : 4th May 2011
     */
    function admin_index() {

        unset( $this->UserGroup->hasOne['UserUserGroup'] );
        $this->data['UserGroups'] = $this->paginate('UserGroup');
    }

    /*
     * @name : admin_add
     * @description : Displays a form that enables administrators to add a row to the user_groups table. If the form is
     * populated it will validate the data and save if possible. It will also add the current user to the list
     * of moderators.
     * @name : Charles Jackson
     * @by : 10th May 2011
     */
    function admin_add() {

        if ( !empty( $this->data ) ) {

            // Add the moderators using a "hasMany GroupModerators" relationship saved to the same HBTM joining table
            // user_user_groups so we may set the "moderator" flag to true.
            $this->data['GroupModerators'] = array();
            
            $this->data['GroupModerators'][0]['user_id'] = $this->Session->read('Auth.User.id');
            $this->data['GroupModerators'][0]['moderator'] = true;

            if( $this->UserGroup->set( $this->data ) && $this->UserGroup->validates( $this->data ) ) {
                
                $this->UserGroup->saveAll( $this->data );
                $this->Session->setFlash( 'The usergroup has been successfully created. You may now add members and moderators.', 'default', array( 'class' => 'success' ) );
                $this->redirect( array( 'action' => 'admin_edit', $this->UserGroup->getLastInsertId() ) );

            } else {

                $this->errors = $this->UserGroup->invalidFields( $this->data );
                $this->Session->setFlash( 'Could not create the user group. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }
        }
    }

    /*
     * @name : view
     * @desscription : Enables an administrator to view details of an individual user group.
     * as a moderator.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function admin_view( $id = null ) {

        // They are loading the page, get the data using the $id passed as a parameter.
        $this->data = $this->UserGroup->findById( $id );

        // We did not find the podcast, error and redirect.
        if( empty( $this->data ) ) {

            $this->Session->setFlash( 'Could not find your chosen user group. Please try again.', 'default', array( 'class' => 'error' ) );
            $this->redirect( array( 'action' => 'admin_index' ) );
        }
    }

    /*
     * @name : admin_edit
     * @desscription : Displays a form that enables administrator to edit an existing row on the user groups table.
     * @name : Charles Jackson
     * @by : 4th May 2011
     */
    function admin_edit( $id = null ) {

        if ( !empty( $this->data ) ) {

            // Create the UserGroupModerators that are saved using a hasMany relationship
            $this->data = $this->UserGroup->createUserGroupModerators( $this->data );

            $this->UserGroup->set( $this->data );

            // We use the 'saveAll' as opposed to 'save' in order to capture all related hasMany and HBTM data.
            if( $this->UserGroup->saveAll( $this->data ) ) {
                
                $this->Session->setFlash( 'The user group has been successfully updated.', 'default', array( 'class' => 'success' ) );
                $this->redirect( array( 'action' => 'admin_view', $this->data['UserGroup']['id'] ) );

            } else {

                $this->errors = $this->UserGroup->invalidFields( $this->data );

                // If they user has made a mistake we must rebuild the member/moderator select boxes using their most recently
                // chosen data else they will merely display the ID numbers of the previously chosen group members.
                $this->data['Members'] = $this->UserGroup->rebuildSelection( $this->data['Members'] );
                $this->data['Moderators'] = $this->UserGroup->rebuildSelection( $this->data['Moderators'] );
                
                $this->Session->setFlash( 'Could not update this user group. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }

        } else {
            
            // They are loading the page, get the data using the $id passed as a parameter.
            $this->data = $this->UserGroup->findById( $id );
            
            // We did not find the podcast, error and redirect.
            if( empty( $this->data ) ) {

                $this->Session->setFlash( 'Could not find your chosen user group. Please try again.', 'default', array( 'class' => 'error' ) );
                $this->redirect( array( 'action' => 'admin_index' ) );
            }
        }
    }
 
    /*
     * @name : admin_delete
     * @desscription : Enables an administrator to perform a hard delete on a UserGroup.
     * @name : Charles Jackson
     * @by : 5th May 2011
     */
    function admin_delete( $id = null ) {

        $this->autoRender = false;
        $this->recursive = -1;

        // This method is used for individual deletes and deletions via the form posted checkbox selection. Hence
        // when somebody is deleting an individual podcast we pass into an array and loop through as is the data
        // was posted.
        if( $id )
            $this->data['UserGroup']['Checkbox'][$id] = 'On';

        foreach( $this->data['UserGroup']['Checkbox'] as $key => $value ) {

            $this->usergroup = $this->UserGroup->findById( $key );

            // If we did no find the UserGroup that redirect to the referer.
            if( !empty( $this->usergroup ) ) {
			
                // Delete the usergroup
                $this->UserGroup->delete( $this->usergroup['UserGroup']['id'] );
                $this->Session->setFlash( 'We successfully deleted the user group.', 'default', array( 'class' => 'success' ) );
            }
        }
        
        $this->redirect( $this->referer() );
    }
}
?>
