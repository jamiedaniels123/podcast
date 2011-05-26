<?php

class PodcastsController extends AppController {

    var $name = 'Podcasts';
    var $components = array( 'Image' );
    private $errors = array();

    var $paginate = array( 'limit' => 20, 'page' => 1, 'order' => 'Podcast.id DESC' );

    /*
     * @name : beforeRender
     * @description : The beforeRender action is automatically called after the controller action has been executed and before the screen
     * is rendered. We are applying some global actions here. Not necessarily the most efficient but very simple.
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function beforeRender() {

        // Get all the nodes
        $this->Node = ClassRegistry::init('Node');
        $this->nodes = $this->Node->find('list', array( 'order' => 'Node.title' ) );
        $this->nodes = $this->Node->removeDuplicates( $this->nodes, $this->data, 'Nodes' );
        $this->set('nodes', $this->nodes );

        // Get all the categories
        $this->Category = ClassRegistry::init('Category');
        $this->categories = $this->Category->find('list', array( 'fields' => array('Category.id', 'Category.category'), 'order' => array('Category.category') ) );
        $this->categories = $this->Category->removeDuplicates( $this->categories, $this->data, 'Categories' );
        $this->set('categories', $this->categories );

        // Get all the itunes categories
        $this->ItunesuCategory = ClassRegistry::init('ItunesuCategory');
        $this->itunesu_categories = $this->ItunesuCategory->find('list', array( 'fields' => array('ItunesuCategory.id', 'ItunesuCategory.code_title'), 'order' => array('ItunesuCategory.code_title') ) );
        $this->itunesu_categories = $this->ItunesuCategory->removeDuplicates( $this->itunesu_categories, $this->data, 'iTuneCategories' );
        $this->set('itunes_categories', $this->itunesu_categories );

        // Get all the languages
        $this->Language = ClassRegistry::init('Language');
        $this->set('languages', $this->Language->find('list', array( 'fields' => array('Language.lang_code', 'Language.language'), 'order' => 'Language.language' ) ) );

        // Get all the user groups
        $this->UserGroup = ClassRegistry::init('UserGroup');
        $this->user_groups = $this->UserGroup->find('list', array( 'fields' => array('UserGroup.id', 'UserGroup.group_title'), 'order' => array('UserGroup.group_title') ) );
        $this->user_groups = $this->UserGroup->removeDuplicates( $this->user_groups, $this->data, 'MemberGroups' );
        $this->user_groups = $this->UserGroup->removeDuplicates( $this->user_groups, $this->data, 'ModeratorGroups' );
        $this->set('user_groups', $this->user_groups );

        // Get all the user groups
        $this->User = ClassRegistry::init( 'User' );
        $this->users = $this->User->find( 'list', array( 'fields' => array( 'User.id', 'User.full_name' ), 'order' => 'User.full_name ASC' ) );
        $this->users = $this->User->removeDuplicates( $this->users, $this->data, 'Members' );
        $this->users = $this->User->removeDuplicates( $this->users, $this->data, 'Moderators' );
        $this->set('users', $this->users );

        $this->set('all_users', $this->User->find('list', array( 'fields' => array('User.id', 'User.full_name' ), 'order' => 'User.full_name ASC' ) ) );

        // Set the possible values of explicit
        $this->set( 'explicit', array( 'clean' => 'clean', 'no' => 'no', 'yes' => 'yes' ) );

        // If there are any errors assign them to the view
        if( count( $this->errors ) )
            $this->set('errors', $this->errors );
    }

    /*
     * @name : index
     * @desscription : Displays a paginated list of all podcasts that are owned by the current user.
     * @name : Charles Jackson
     * @by : 16th May 2011
     */
    function index() {

        unset( $this->Podcast->hasOne['UserPodcast'] );
        $this->Podcast->recursive = 2;
        $this->data['Podcasts'] = $this->paginate('Podcast', array('Podcast.id' => $this->Podcast->getUserPodcasts( $this->Session->read('Auth.User.id') ) ) );
    }

    /*
     * @name : add
     * @desscription : Displays a form that enables peeps to add a row to the podcasts table. If the form is populated
     * it will validate and save the data.
     * @name : Charles Jackson
     * @by : 4th May 2011
     */
    function add() {

        if ( !empty( $this->data ) ) {

            // Save this->data into a local array called data so we may unset the attachment array elements before
            // validating else it will fail because they contain arrays.
            $data = array();
            $data = $this->data;

            // Assign the podcast to the current user.
            $this->data['Podcast']['user_id'] = $this->Session->read('Auth.User.id');

            $this->data = $this->Podcast->unsetAttachments( $this->data );

            // Create the PodcastModerators that are saved using a hasMany relationship
            $this->data = $this->Podcast->createPodcastModerators( $this->data );

            $this->Podcast->set( $this->data );

            if( $this->Podcast->saveAll() ) {

                // Now copy back the original including array elements plus the newly inserted Podcast ID and
                // save again with attachment elements.
                $this->data = $data;
                $this->data['Podcast']['id'] = $this->Podcast->getLastInsertId();
                $this->data['Podcast']['custom_id'] = $this->Podcast->getLastInsertId().'_'.$this->Podcast->buildSafeFilename( $this->data['Podcast']['title'] );
                $this->__update();
                $this->redirect( array( 'action' => 'view', $this->Podcast->getLastInsertId() ) );

            } else {

                // Rebuild the dynamic select boxes according to the users current selections else they will merely display ID numbers.
                $this->data = $this->Podcast->rebuild( $this->data );

                $this->errors = $this->Podcast->invalidFields( $this->data );
                $this->Session->setFlash('Could not create your collection. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }
        }
    }

    /*
     * @name : view
     * @desscription : Enables a moderator or member to view details of an individual podcast.
     * as a moderator.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function view( $id = null ) {

        $this->Podcast->recursive = 2;
        // They are loading the page, get the data using the $id passed as a parameter.
        $this->data = $this->Podcast->findById( $id );

        // We did not find the podcast, error and redirect.
        if( empty( $this->data ) || $this->Permission->toView( $this->data ) == false ) {

            $this->Session->setFlash( 'Could not find your collection. Please try again.', 'default', array( 'class' => 'error' ) );
            $this->redirect( $this->referer() );
        }
    }
    
    /*
     * @name : edit
     * @desscription : Displays a form that enables peeps to edit an existing row on the podcasts table.
     * @name : Charles Jackson
     * @by : 4th May 2011
     */
    function edit( $id = null ) {

        $this->Podcast->recursive = 2;
        
        if ( !empty( $this->data ) ) {

            // Save this->data into a local array called data so we may unset the attachment array elements before
            // validating else it will fail because they contain arrays.
            $data = array();
            $data = $this->data;

            $this->data = $this->Podcast->unsetAttachments( $this->data );

            // Delete any existing hasMany moderators.
            $this->Podcast->deleteExistingModerators( $this->data['Podcast']['id'] );
            // Create the PodcastModerators that are saved using a hasMany relationship
            $this->data = $this->Podcast->createPodcastModerators( $this->data );
            // Create the ModeratorUserGroups that are saved using a hasMany relationship
            $this->data = $this->Podcast->createModeratorUserGroups( $this->data );

            $this->Podcast->set( $this->data );

            if( $this->Podcast->validates() ) {

                // OK, it validates but have they confirmed change of ownership.
                if( ( isSet( $this->data['Podcast']['confirmed'] ) && ( $this->data['Podcast']['confirmed'] == false ) ) && ( isSet( $this->data['Podcast']['current_owner_id'] ) && ( $this->data['Podcast']['current_owner_id'] != $this->data['Podcast']['user_id'] ) ) ) {

                    $this->data = $this->Podcast->rebuild( $this->data );
                    $this->data['Podcast']['confirmed'] = true;
                    $this->Session->setFlash('You are changing ownership of this podcast. Submit again to confirm the change.', 'default', array( 'class' => 'alert' ) );

                } else {

                    $this->Podcast->saveAll();

                    // Now copy back the original including array elements and
                    // save again with attachment elements.
                    $this->data = $data;

                    $this->__update();

                    // Will only be true if they have attempted to change ownership at some point.
                    if( isSet( $this->data['Podcast']['confirmed'] ) && $this->data['Podcast']['confirmed']  == true ) {

                        $this->data = $this->Podcast->findById( $this->data['Podcast']['id'] );
                    }

                    // They may no longer have permision to view this podcast if they have changed ownership, therefore double-check.
                    if( $this->Permission->toView( $this->data ) ) {

                        $this->redirect( array( 'action' => 'view', $this->data['Podcast']['id'] ) );

                    } else {
                        
                        $this->redirect( array( 'action' => 'index') );
                    }
                }

            } else {

                // Rebuild the dynamic select boxes according to the users current selections else they will merely display ID numbers.
                $this->data = $this->Podcast->rebuild( $this->data );
                $this->errors = $this->Podcast->invalidFields( $this->data );

                // We explicitly set confirmed to false incase they have confirmed/failed validation in a single post (silly billy).
                $this->data['Podcast']['confirmed'] == false;

                $this->Session->setFlash('Could not update your collection. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }

        } else {

            $this->data = $this->Podcast->findById( $id );

            // We did not find the podcast, redirect.
            if( empty( $this->data ) || $this->Permission->toUpdate( $this->data ) == false ) {

                $this->Session->setFlash('Could not find your collection. Please try again.', 'default', array( 'class' => 'error' ) );
                $this->redirect( $this->referer() );

            } else {
                // We need to track is the ownership changes so make a note here and the original owner with be passed as a
                // hidden form element.
                $this->data['Podcast']['current_owner_id'] = $this->data['Podcast']['user_id'];
            }
        }
    }

    /*
     * @name : delete
     * @desscription : Enables a user to perform a hard delete on a podcast and the associated media if they are the current owner.
     * @name : Charles Jackson
     * @by : 19th May 2011
     */
    function delete( $id = null ) {

        $this->autoRender = false;
        $this->recursive = -1;

        if( $id )
            $this->data = $this->Podcast->find('first', array( 'conditions' => array( 'Podcast.id' => $id, 'Podcast.user_id' => $this->Session->read('Auth.User.id' ) ) ) );

        // If we did no find the podcast that redirect to the referer.
        if( empty( $this->data ) || $this->Permission->toDelete( $this->data ) == false ) {

            $this->Session->setFlash('We could not find the collection you were looking for.', 'default', array( 'class' => 'error' ) );

        } else {

            // Delete the podcast
            $this->Podcast->delete( $id );

            // Remove any associated media.
            if( strlen( trim( $this->data['Podcast']['custom_id'] ) ) && is_dir( WWW_ROOT.FEEDS_LOCATION.$this->data['Podcast']['custom_id'] ) ) {
                $this->Image->recursiveRemoveFolder( WWW_ROOT.FEEDS_LOCATION.$this->data['Podcast']['custom_id'] );

            } elseif( strlen( trim( $this->data['Podcast']['id'] ) ) && is_dir( WWW_ROOT.FEEDS_LOCATION.$this->data['Podcast']['id'] ) ) {

                $this->Image->recursiveRemoveFolder( WWW_ROOT.FEEDS_LOCATION.$this->data['Podcast']['id'] );
            }

            $this->Session->setFlash('We successfully deleted the podcast and all associated media.', 'default', array( 'class' => 'success' ) );

        }
        $this->redirect( $this->referer() );
    }

    /*
     * @name : __updated
     * @description : Internal method called by the add and edit methods, both user and administrator.
     * @updated : 9th May 2011
     * @by : Charles Jackson
     */
    function __update() {
        // Try to upload the associated images. If successful the upload component will return the name of the uploaded file
        // else it will return false.
        $this->data['Podcast']['image'] = $this->Image->uploadPodcastImage( $this->data, 'image' );
        $this->data['Podcast']['image_logoless'] = $this->Image->uploadLogolessPodcastImage( $this->data, 'image_logoless' );
        $this->data['Podcast']['image_wide'] = $this->Image->uploadWidePodcastImage( $this->data, 'image_wide' );

        // Check to see if the upload component created any errors.
        if( $this->Image->hasErrors() ) {

            // Ugly, if any errors are found we create formatted HTML unordered list and append to the flash message. We
            // cannot append to the $this->errors array because of the immediate redirect ( it will be lost ).
            // @todo - revisit this solution.
            $this->html = 'Your podcast container has been successfully updated but we were unable to upload all your images.';
            $this->html .= '<ul>';

            foreach( $this->Image->getErrors()  as $error ) {

                $this->html .= '<li>'.$error.'</li>';
            }

            $this->html .= '</ul>';

            $this->Session->setFlash($this->html, 'default', array( 'class' => 'alert' ) );

        } else {

            // Resave the object so we capture the names of the uploaded images.
            $this->Podcast->save( $this->data['Podcast'] );
            $this->Session->setFlash('Your collection has been successfully updated.', 'default', array( 'class' => 'success' ) );
        }
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

        unset( $this->Podcast->hasOne['UserPodcast'] );
        $this->data['Podcasts'] = $this->paginate('Podcast');
    }


    /*
     * @name : admin_add
     * @description : Displays a form that enables administrators to add a row to the podcasts table. If the form is
     * populated it will validate the data and save if possible. It will also attempt to upload image attachments.
     * @name : Charles Jackson
     * @by : 5th May 2011
     */
    function admin_add() {

        if ( !empty( $this->data ) ) {

            // Save this->data into a local array called data so we may unset the attachment array elements before
            // validating else it will fail because they contain arrays.
            $data = array();
            $data = $this->data;

            $this->data = $this->Podcast->unsetAttachments( $this->data );

            // Create the PodcastModerators that are saved using a hasMany relationship
            $this->data = $this->Podcast->createPodcastModerators( $this->data );
            // Create the ModeratorUserGroups that are saved using a hasMany relationship
            $this->data = $this->Podcast->createModeratorUserGroups( $this->data );

            $this->Podcast->set( $this->data );

            if( $this->Podcast->saveAll() ) {
                
                // Now copy back the original including array elements plus the newly inserted Podcast ID and
                // save again with attachment elements.
                $this->data = $data;
                $this->data['Podcast']['id'] = $this->Podcast->getLastInsertId();
                
                $this->__update();
                $this->redirect( array( 'action' => 'admin_view', $this->Podcast->getLastInsertId() ) );

            } else {

                // Rebuild the dynamic select boxes according to the users current selections else they will merely display ID numbers.
                $this->data = $this->Podcast->rebuild( $this->data );

                $this->errors = $this->Podcast->invalidFields( $this->data );
                $this->Session->setFlash('Could not create your collection. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }
        }
    }

    /*
     * @name : admin_view
     * @desscription : Enables an adminitratorto view details of an individual podcast.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function admin_view( $id = null ) {

        // They are loading the page, get the data using the $id passed as a parameter.
        $this->data = $this->Podcast->findById( $id );

        // We did not find the podcast, error and redirect.
        if( empty( $this->data ) ) {

            $this->Session->setFlash( 'Could not find your collection. Please try again.', 'default', array( 'class' => 'error' ) );
            $this->redirect( $this->referer() );
        }
    }

    /*
     * @name : admin_edit
     * @desscription : Displays a form that enables administrator to edit an existing row on the podcasts table.
     * @name : Charles Jackson
     * @by : 4th May 2011
     */
    function admin_edit( $id = null ) {

        if ( !empty( $this->data ) ) {

            // Save this->data into a local array called data so we may unset the attachment array elements before
            // validating else it will fail because they contain arrays.
            $data = array();
            $data = $this->data;

            $this->data = $this->Podcast->unsetAttachments( $this->data );

            // Delete any existing hasMany moderators.
            $this->Podcast->deleteExistingModerators( $this->data['Podcast']['id'] );

            // Create the PodcastModerators that are saved using a hasMany relationship
            $this->data = $this->Podcast->createPodcastModerators( $this->data );
            // Create the ModeratorUserGroups that are saved using a hasMany relationship
            $this->data = $this->Podcast->createModeratorUserGroups( $this->data );

            $this->Podcast->set( $this->data );

            if(  $this->Podcast->saveAll()  ) {

                // Now copy back the original including array elements and
                // save again with attachment elements.
                $this->data = $data;

                $this->__update();
                $this->redirect( array( 'action' => 'admin_view', $this->data['Podcast']['id'] ) );

            } else {

                // Rebuild the dynamic select boxes according to the users current selections else they will merely display ID numbers.
                $this->data = $this->Podcast->rebuild( $this->data );

                $this->errors = $this->Podcast->invalidFields( $this->data );
                $this->Session->setFlash('Could not update your collection. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }

        } else {

            $this->data = $this->Podcast->findById( $id );
            
            // We did not find the podcast, redirect.
            if( empty( $this->data ) ) {

                $this->Session->setFlash('Could not find your collection. Please try again.', 'default', array( 'class' => 'error' ) );
                $this->redirect( $this->referer() );
            }
        }
    }
 
    /*
     * @name : admin_delete
     * @desscription : Enables an administrator to performa hard delete on a podcast and the associated media.
     * @name : Charles Jackson
     * @by : 5th May 2011
     */
    function admin_delete( $id = null ) {

        $this->autoRender = false;
        $this->recursive = -1;
        
        if( $id )
            $this->data = $this->Podcast->findById( $id );

        // If we did no find the podcast that redirect to the referer.
        if( empty( $this->data ) ) {
			
            $this->Session->setFlash('We could not find the collection you were looking for.', 'default', array( 'class' => 'error' ) );
            
        } else {

            // Delete the podcast
            $this->Podcast->delete( $id );
            
            // Remove any associated media.
            if( strlen( trim( $this->data['Podcast']['custom_id'] ) ) && is_dir( WWW_ROOT.FEEDS_LOCATION.$this->data['Podcast']['custom_id'] ) ) {
                $this->Image->recursiveRemoveFolder( WWW_ROOT.FEEDS_LOCATION.$this->data['Podcast']['custom_id'] );

            } elseif( strlen( trim( $this->data['Podcast']['id'] ) ) && is_dir( WWW_ROOT.FEEDS_LOCATION.$this->data['Podcast']['id'] ) ) {

                $this->Image->recursiveRemoveFolder( WWW_ROOT.FEEDS_LOCATION.$this->data['Podcast']['id'] );
            }

            $this->Session->setFlash('We successfully deleted the collection and all associated media.', 'default', array( 'class' => 'success' ) );
            
        }
        $this->redirect( $this->referer() );
    }
}
?>
