<?php
class PodcastItemsController extends AppController {

    var $name = 'PodcastItems';
    var $components = array( 'Image' );
    private $errors = array();

    var $paginate = array( 'limit' => 5, 'page' => 1, 'order' => array( 'PodcastItem.id' => 'desc' ) );

    /*
     * @name : beforeRender
     * @description : The beforeRender action is automatically called after the controller action has been executed and before the screen
     * is rendered. We are applying some global actions here. Not necessarily the most efficient but very simple.
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function beforeRender() {

        // If there are any errors assign them to the view
        if( count( $this->errors ) )
            $this->set('errors', $this->errors );
    }

    /*
     * @name : index
     * @desscription : Displays a list of all available podcast media for the podcast passed as a parameter and
     * includes a partial _form element that renders filechucker.cgi that enables peeps to upload a media file
     * add a row to the podcast_items table.
     * @name : Charles Jackson
     * @by : 13thth May 2011
     */
    function index( $podcast_id ) {

        if( (int)$podcast_id )
            $this->data = $this->PodcastItem->Podcast->findById( $podcast_id );

        if( empty( $this->data ) ) {

            $this->Session->setFlash('Could not identify the podcast you are trying to update. Please try again.', 'default', array(), 'error');
            $this->redirect( array( 'url' => '/' ) );

        } else {

            $this->data['PodcastsItems'] = $this->paginate('PodcastItem', array('PodcastItem.podcast_id' => $podcast_id ) );
        }
    }
    
    /*
     * @name : add
     * @desscription : Displays a filechucker.cgi form that enables peeps to upload a media file
     * add a row to the podcast_items table. Also includes a list of all current media items associated with the
     * podcast ID passed as a parameter
     * @name : Charles Jackson
     * @by : 13thth May 2011
     */
    function add( $podcast_id ) {

        if ( isSet( $this->params['url']['complete_upload'] ) ) {

            $this->PodcastItem->create();
            $this->data = $this->PodcastItem->createFromUrlVariables( $podcast_id, $this->params['url'] );
            $this->PodcastItem->set( $this->data );

            if( $this->PodcastItem->save() ) {

                // We have successfully saved the URL, now redirect back onto itself but without the GET parameters passed
                // in the original URL else we will recreate a row on the database table if/everytime the user hits 'refresh'.
                $this->Session->setFlash('Your podcast media has been successfully uploaded.', 'default', array(), 'success');
                $this->redirect( array( 'controller' => 'podcast_items', 'action' => 'edit', $this->PodcastItem->getLastInsertId() ) );

            } else {

                $this->Session->setFlash('Could not upload your podcast media. Please try again.', 'default', array(), 'error');
            }
        }

        if( (int)$podcast_id )
            $this->data = $this->PodcastItem->Podcast->find( 'first', array( 'conditions' => array( 'Podcast.id' => $podcast_id, 'Podcast.user_id' => $this->Session->read('Auth.User.id') ) ) );

        if( empty( $this->data ) ) {

            $this->Session->setFlash('Could not identify the podcast you are trying to update. Please try again.', 'default', array(), 'error');
            $this->redirect( $this->referer() );

        } else {

            $this->data['PodcastsItems'] = $this->paginate('PodcastItem', array('PodcastItem.podcast_id' => $podcast_id ) );
        }
    }

    /*
     * @name : view
     * @desscription : Enables a moderator or member to view details of an individual media file.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function view( $id = null ) {

        // They are loading the page, get the data using the $id passed as a parameter.
        $this->data = $this->PodcastItem->findById( $id );

        // We did not find the podcast, error and redirect.
        if( empty( $this->data ) ) {

            $this->Session->setFlash( 'Could not find your chosen media. Please try again.', 'default', array( 'class' => 'error' ) );
            $this->redirect( $this->referer() );
        }
    }

    /*
     * @name : edit
     * @desscription : Displays a form that enables a podcast owner or administrator to edit an existing row on the podcast_items table.
     * @name : Charles Jackson
     * @by : 19th May 2011
     */
    function edit( $id = null ) {

        if ( !empty( $this->data ) ) {

            // Save this->data into a local array called data so we may unset the attachment array elements before
            // validating else it will fail because they contain arrays.
            $data = array();
            $data = $this->data;

            $this->data = $this->PodcastItem->unsetAttachments( $this->data );

            // Upload the attachments here...
            $this->PodcastItem->set( $this->data );

            if(  $this->PodcastItem->save()  ) {

                // Now copy back the original including array elements and
                // save again with attachment elements.
                $this->data = $data;

                $this->__update();
                $this->redirect( array( 'controller' => 'podcast_items', 'action' => 'view', $this->data['Podcast']['id'] ) );

            } else {

                $this->errors = $this->PodcastItem->invalidFields( $this->data );
                $this->Session->setFlash('Could not update your meta data. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }

        } else {

            $this->data = $this->PodcastItem->findById( $id );

            // We did not find the podcast, redirect.
            if( empty( $this->data ) ) {

                $this->Session->setFlash('Could not find your podcast media. Please try again.', 'default', array( 'class' => 'error' ) );
                $this->redirect( array( 'controller' => 'podcasts', 'action' => 'index', ) );
            }
        }
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
        $this->data['PodcastItem']['image'] = $this->Image->uploadPodcastMediaImage( $this->data, 'image' );

        // Check to see if the upload component created any errors.
        if( $this->Image->hasErrors() ) {

            // Ugly, if any errors are found we create formatted HTML unordered list and append to the flash message. We
            // cannot append to the $this->errors array because of the immediate redirect ( it will be lost ).
            // @todo - revisit this solution.
            $this->html = 'Your podcast media has been successfully updated but we were unable to upload your associated image.';
            $this->html .= '<ul>';

            foreach( $this->Image->getErrors() as $error ) {

                $this->html .= '<li>'.$error.'</li>';
            }
            $this->html .= '</ul>';

            $this->Session->setFlash($this->html, 'default', array( 'class' => 'alert' ) );

        } else {

            // Resave the object so we capture the names of the uploaded images.
            $this->PodcastItem->save( $this->data );
            $this->Session->setFlash('Your podcast media has been successfully updated.', 'default', array( 'class' => 'success' ) );
        }
    }

    /*
     * ADMIN FUNCTIONALITY
     * Below this line are the administration functionality that can only be reach if the flag 'administrator' is set to true on the
     * users profile. The URL for all admin routes is "admin/:controller:/:action:/*
     */

    /*
     * @name : admin_index
     * @desscription : Displays a list of all available podcast media for the podcast passed as a parameter and
     * includes a partial _form element that renders filechucker.cgi that enables peeps to upload a media file
     * add a row to the podcast_items table.
     * @name : Charles Jackson
     * @by : 13thth May 2011
     */
    function admin_index( $podcast_id ) {

        if( (int)$podcast_id )
            $this->data = $this->PodcastItem->Podcast->findById( $podcast_id );

        if( empty( $this->data ) ) {

            $this->Session->setFlash('Could not identify the podcast you are trying to update. Please try again.', 'default', array(), 'error');
            $this->redirect( array( 'url' => '/' ) );

        } else {

            $this->data['PodcastsItems'] = $this->paginate('PodcastItem', array('PodcastItem.podcast_id' => $podcast_id ) );
        }
    }

    /*
     * @name : admin_add
     * @desscription : Displays a filechucker.cgi form that enables administrators to upload a media file
     * add a row to the podcast_items table. Also includes a list of all current media items associated with the
     * podcast ID passed as a parameter
     * @name : Charles Jackson
     * @by : 13thth May 2011
     */
    function admin_add( $podcast_id ) {

        $this->autoRender = false;
        
        if ( isSet( $this->params['url']['complete_upload'] ) ) {

            $this->PodcastItem->create();
            $this->data = $this->PodcastItem->createFromUrlVariables( $podcast_id, $this->params['url'] );
            $this->PodcastItem->set( $this->data );

            if( $this->PodcastItem->save() ) {

                // We have successfully saved the URL, now redirect back onto itself but without the GET parameters passed
                // in the original URL else we will recreate a row on the database table if/everytime the user hits 'refresh'.
                $this->Session->setFlash('Your podcast media has been successfully uploaded.', 'default', array(), 'success');
                $this->redirect( array('admin' => true, 'controller' => 'podcast_items', 'action' => 'admin_edit', $this->PodcastItem->getLastInsertId() ) );

            }
        }
        
        $this->Session->setFlash('Could not upload your podcast media. Please try again.', 'default', array(), 'error');
        $this->redirect( array( 'url' => '/' ) );

    }

    /*
     * @name : admin_view
     * @desscription : Enables an administrator to view details of an individual media file.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function admin_view( $id = null ) {

        // They are loading the page, get the data using the $id passed as a parameter.
        $this->data = $this->PodcastItem->findById( $id );

        // We did not find the podcast, error and redirect.
        if( empty( $this->data ) ) {

            $this->Session->setFlash( 'Could not find your chosen media. Please try again.', 'default', array( 'class' => 'error' ) );
            $this->redirect( $this->referer() );
        }
    }

    /*
     * @name : admin_edit
     * @desscription : Displays a form that enables administrator to edit an existing row on the podcast_items table.
     * @name : Charles Jackson
     * @by : 19th May 2011
     */
    function admin_edit( $id = null ) {

        if ( !empty( $this->data ) ) {

            // Save this->data into a local array called data so we may unset the attachment array elements before
            // validating else it will fail because they contain arrays.
            $data = array();
            $data = $this->data;

            $this->data = $this->PodcastItem->unsetAttachments( $this->data );
            
            // Upload the attachments here...
            $this->PodcastItem->set( $this->data );

            if(  $this->PodcastItem->save()  ) {

                // Now copy back the original including array elements and
                // save again with attachment elements.
                $this->data = $data;

                $this->__update();
                $this->redirect( array( 'admin' => true, 'controller' => 'podcast_items', 'action' => 'admin_view', $this->data['Podcast']['id'] ) );

            } else {

                $this->errors = $this->PodcastItem->invalidFields( $this->data );
                $this->Session->setFlash('Could not update your meta data. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }

        } else {

            $this->data = $this->PodcastItem->findById( $id );

            // We did not find the podcast, redirect.
            if( empty( $this->data ) ) {

                $this->Session->setFlash('Could not find your podcast media. Please try again.', 'default', array( 'class' => 'error' ) );
                $this->redirect( array( 'admin' => true, 'controller' => 'podcasts', 'action' => 'index', ) );
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
            $this->data = $this->PodcastItem->findById( $id );

        // If we did not find the podcast media then redirect to the referer.
        if( empty( $this->data ) ) {

            $this->Session->setFlash('We could not find the podcast media you were looking for.', 'default', array( 'class' => 'error' ) );

        } else {

            // Delete the podcast
            $this->PodcastItem->delete( $id );

            //
            // @TODO : Remove podcast media.

            $this->Session->setFlash('We successfully deleted the podcast media.', 'default', array( 'class' => 'success' ) );
        }
        
        $this->redirect( $this->referer() );
    }
}