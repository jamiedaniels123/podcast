<?php
class PodcastItemsController extends AppController {

    var $name = 'PodcastItems';
    var $components = array( 'Upload' );

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

        $this->PodcastItem->Podcast->recursive = 3;

        if( (int)$podcast_id ) {

            $this->data = $this->PodcastItem->Podcast->findById( $podcast_id );

            // We cannot easily passed parameters into the filechucker.cgi script hence we store some basic information
            // in the session.
            $this->Session->write('Podcast.podcast_id', $podcast_id);
            $this->Session->write('Podcast.admin', false);
        }

        if( empty( $this->data ) || $this->Permission->toUpdate( $this->data ) == false ) {

            $this->Session->setFlash('Could not identify the podcast you are trying to update. Please try again.', 'default', array( 'class' => 'error' ) );
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

        $this->PodcastItem->recursive = 3;
        
        // They are loading the page, get the data using the $id passed as a parameter.
        $this->data = $this->PodcastItem->findById( $id );

        // We did not find the podcast, error and redirect.
        if( empty( $this->data )  || $this->Permission->toView( $this->data['Podcast'] ) == false ) {

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

			$this->PodcastItem->begin();
			
            // Save this->data into a local array called data so we may unset the attachment array elements before
            // validating else it will fail because they contain arrays.
            $data = array();
            $data = $this->data;

            $this->data = $this->PodcastItem->unsetAttachments( $this->data );

            $this->PodcastItem->set( $this->data );

            if(  $this->PodcastItem->save()  ) {

                // Now copy back the original including array elements and
                // save again with attachment elements.
                $this->data = $data;

                if( ( $this->__updateImage() == false ) || ( $this->__updateTranscript() == false ) ) {

					$this->PodcastItem->rollback();
	                $this->redirect( array( 'controller' => 'podcast_items', 'action' => 'view', $this->data['PodcastItem']['id'] ) );
					exit;
					
				} else {

					$this->PodcastItem->commit();
					$this->Session->setFlash('Your podcast item has been successfully updated.', 'default', array( 'class' => 'error' ) );									
	                $this->redirect( array( 'controller' => 'podcast_items', 'action' => 'view', $this->data['PodcastItem']['id'] ) );
					exit;
				}

            } else {

                $this->errors = $this->PodcastItem->invalidFields( $this->data );
                $this->Session->setFlash('Could not update your meta data. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }
			
			$this->PodcastItem->rollback(); // If we get here something did not work on the save, rollback changes.

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
     * @name : add
     * @description : Called by the filechucker script directly after a successful upload. It is used by both
     * users and administrators and will create a row on the podcast items table using parameters passed and session information.
     * @updated : 26th May 2011
     * @by : Charles Jackson
     */
    function add() {

        $this->autoRender = false;

        if ( $this->Session->check('Podcast.podcast_id') && isSet( $this->params['url'] ) ) {

            $this->PodcastItem->create();
            $this->data = $this->PodcastItem->createFromUrlVariables( $this->params, $this->Session->read('Podcast.podcast_id') );
            $this->PodcastItem->set( $this->data );

            $this->PodcastItem->begin();

            if( $this->PodcastItem->save() ) {

                $this->data = $this->PodcastItem->findById( $this->PodcastItem->getLastInsertId() );
				                
                if( $this->Folder->moveFileChuckerUpload( $this->data ) ) {

					// Save an updated record appending the database ID number to the start of the filename to ensure it is unique.
					$this->data['PodcastItem']['filename'] = $this->data['PodcastItem']['id'] . '_' . $this->data['PodcastItem']['filename'];
					$this->PodcastItem->set( $this->data );
					$this->PodcastItem->save();

                    // Now we have the file in it's correct location we must capture various details and store in this->data
                    // so we may save to the database and create a workflow for the transcoder.
                    $this->data = $this->PodcastItem->getMediaInfo( $this->data, $this->Getid3->extract( FILE_REPOSITORY . $this->data['Podcast']['custom_id'] . '/' . $this->data['PodcastItem']['filename'] ) );

                    if( $this->Api->transcodeMedia( $this->data['Podcast']['custom_id'], $this->data['PodcastItem']['filename'], $this->data['workflow'] ) ) {
						
                        $this->PodcastItem->commit();

                        // We have successfully saved the URL, now redirect back onto itself but without the GET parameters passed
                        // in the original URL else we will recreate a row on the database table if/everytime the user hits 'refresh'.
                        $this->Session->setFlash('Your podcast media has been successfully uploaded and scheduled with the transcoder.', 'default', array( 'class' => 'success' ) );

                        // We need to redirect based on session information that is set within the index and admin_index methods.
                        if( $this->Session->read('Podcast.admin') ) {

                            $this->redirect( array('admin' => true, 'controller' => 'podcast_items', 'action' => 'edit', $this->PodcastItem->getLastInsertId() ) );

                        } else {

                            $this->redirect( array( 'controller' => 'podcast_items', 'action' => 'edit', $this->PodcastItem->getLastInsertId() ) );
                        }
                        exit();
						
                    } else {
						
                        // The file did not transcode, delete the file.
                        unlink( FILE_REPOSITORY . $this->data['Podcast']['custom_id'] . '/' . $this->data['PodcastItem']['filename'] );
						$this->PodcastItem->rollback();						
						$this->Session->setFlash('Could not schedule your media for transcoding, please try again. If the problem persists contact an administrator.',  'default', array( 'class' => 'error' ) );						
                    }
					
                } else {
					
                        // The file did not transcode, delete the file.
                        unlink( FILE_REPOSITORY . $this->data['Podcast']['custom_id'] . '/' . $this->data['PodcastItem']['filename'] );
						$this->PodcastItem->rollback();						
						$this->Session->setFlash('Could not copy your uploaded media. If the problem persists contact an administrator.',  'default', array( 'class' => 'error' ) );						
				}
            }
			
        } else {

			// The file did not upload and/or transcode, capture the errors and roll back DB changes.
			$this->errors = $this->PodcastItem->invalidFields( $this->data );
			$this->PodcastItem->rollback();
			$this->Session->setFlash('Could not save your media information, please try again. If the problem persists please contact an administrator.',  'default', array( 'class' => 'error' ) );
		}

        // We need to redirect based on session information that is set within the index and admin_index methods.
        if( $this->Session->read('Podcast.admin') ) {

            $this->redirect( array( 'admin' => true, 'controller' => 'podcast_items', 'action' => 'index', $this->Session->read('Podcast.podcast_id') ) );

        } else {

            $this->redirect( array( 'controller' => 'podcasts', 'action' => 'index', $this->Session->read('Podcast.podcast_id') ) );
        }
        exit();
    }

    /*
     * @name : __updateImage
     * @description : Internal method called by the edit methods, both user and administrator.
     * @updated : 9th May 2011
     * @by : Charles Jackson
     */
    function __updateImage() {
	
        // Try to upload the associated images. If successful the upload component will return the name of the uploaded file
        // else it will return false.
        if( $this->Upload->podcastMediaImage( $this->data, 'image' ) ) {
			
			$this->data['Podcast']['image_filename'] = $this->Upload->getUploadedFileName();
			
		} else {
			
			unset( $this->data['Podcast']['image_filename'] );
		}
				
        // Check to see if the upload component created any errors.
        if( $this->Upload->hasErrors() ) {

            $this->errors = $this->Upload->getErrors();
            return false;
			
        } else {

            // Resave the object so we capture the names of the uploaded images.
            $this->PodcastItem->save( $this->data );
            $this->Session->setFlash('Your podcast media has been successfully updated.', 'default', array( 'class' => 'success' ) );
        }
    }

    /*
     * @name : __updateTranscript
     * @description : Internal method called by the edit methods, both user and administrator.
     * @updated : 9th May 2011
     * @by : Charles Jackson
     */
	function __updateTranscript() {
		
		$this->data['PodcastItemMedia']['filename'] = $this->Upload->transcript( $this->data, 'transcript' );
		
		if( $this->Upload->hasErrors() ) {
			
			
		} else {
		
			$this->data['PodcastItemMedia']['media_type'] = strtolower( TRANSCRIPT );
			$this->data['PodcastItemMedia']['duration'] = null;
			$this->data['PodcastItemMedia']['processed_state'] = 9; // Media available
		}
		
	}
	
    /*
     * @name : delete
     * @desscription : Enables a user to delete an individual item of media assuming they have permission
     * @name : Charles Jackson
     * @by : 5th May 2011
     */
    function delete( $id = null ) {

        $this->autoRender = false;
		$this->PodcastItem->recursive = 3; // Raise the recursive from the default so we have the necessary data to check permissions.
        $this->data = $this->PodcastItem->findById( $id );
		
        // If we did not find the podcast media then redirect to the referer.
        if( empty( $this->data ) || $this->Permission->toUpdate( $this->data['Podcast'] ) == false ) {

            $this->Session->setFlash('We could not find the podcast media you were looking for.', 'default', array( 'class' => 'error' ) );

        } else {

			if( $this->Api->deleteFileOnMediaServer( $this->PodcastItem->listAssociatedMedia( $this->data ) ) ) {

				// Delete the podcast
				$this->PodcastItem->delete( $id );
			   
	
				$this->Session->setFlash('We successfully deleted the podcast media.', 'default', array( 'class' => 'success' ) );
				
			} else {
				
				$this->Session->setFlash('We could not schedule the media file for deletion. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
			}
        }
        
        $this->redirect( $this->referer() );
    }

    /*
     * @name : delete_image
     * @desscription : Enables a user to delete an image associated with a piece of media on the podcast_items table.
     * @name : Charles Jackson
     * @by : 27th June 2011
     */
	function delete_image( $id ) {
		
        $this->autoRender = false;
		$this->PodcastItem->recursive = 3; // Raise the recursive from the default so we have the necessary data to check permissions.
        $this->data = $this->PodcastItem->findById( $id );
		
        // If we did not find the podcast media then redirect to the referer.
        if( empty( $this->data ) || $this->Permission->toUpdate( $this->data['Podcast'] ) == false ) {

            $this->Session->setFlash('We could not find the media image you were looking for.', 'default', array( 'class' => 'error' ) );

        } else {
			
			// We unset the publication date field because the default value of 0000-00-00 00:00:00 will produce model validation error.
			unset( $this->data['PodcastItem']['publication_date'] ); 
			
			$this->data['PodcastItem']['image_filename'] = null;
			$this->PodcastItem->set( $this->data );
			
			if( $this->PodcastItem->save() ) {
				
				if( $this->Api->deleteFileOnMediaServer( 
					array(
							'source_path' => $this->data['Podcast']['custom_id'].'/',  
							'filename' => $this->data['PodcastItem']['image_filename'],  
						)
					) 
				) {

					$this->Session->setFlash('The media has been deleted.', 'default', array( 'class' => 'success' ) );
			        $this->redirect( array( 'action' => 'view', $this->data['Podcast']['id'] ) );	
								
				} else {
				
					$this->Session->setFlash('We could not schedule the image file for deletion. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
				}
				
			} else {

				$this->Session->setFlash('There has been a problem deleting the media. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
			}
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
     * @desscription : Displays a list of all available podcast media for the podcast passed as a parameter and
     * includes a partial _form element that renders filechucker.cgi that enables peeps to upload a media file
     * add a row to the podcast_items table.
     * @name : Charles Jackson
     * @by : 13thth May 2011
     */
    function admin_index( $podcast_id ) {

        $this->PodcastItem->Podcast->recursive = 3;
        
        if( (int)$podcast_id ) {

            $this->data = $this->PodcastItem->Podcast->findById( $podcast_id );
            
            // We cannot easily passed parameters into the filechucker.cgi script hence we store some basic information
            // in the session.
            $this->Session->write('Podcast.podcast_id', $podcast_id);
            $this->Session->write('Podcast.admin', true);
        }

        if( empty( $this->data ) ) {

            $this->Session->setFlash('Could not identify the podcast you are trying to update. Please try again.', 'default', array( 'class' => 'error' ) );
            $this->redirect( $this->referer() );

        } else {

            $this->data['PodcastsItems'] = $this->paginate('PodcastItem', array('PodcastItem.podcast_id' => $podcast_id ) );
        }
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

                if( ( $this->__updateImage() == false ) || ( $this->__updateTranscript() == false ) ) {

					$this->PodcastItem->rollback();
	                $this->redirect( array( 'controller' => 'podcast_items', 'action' => 'view', $this->data['PodcastItem']['id'] ) );
					exit;
					
				} else {

					$this->PodcastItem->commit();
					$this->Session->setFlash('Your podcast item has been successfully updated.', 'default', array( 'class' => 'error' ) );									
	                $this->redirect( array( 'controller' => 'podcast_items', 'action' => 'view', $this->data['PodcastItem']['id'] ) );
					exit;
				}

            } else {

                $this->errors = $this->PodcastItem->invalidFields( $this->data );
                $this->Session->setFlash('Could not update your meta data. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }
			
			$this->PodcastItem->rollback(); // If we get here something did not work on the save, rollback changes.

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

        $this->data = $this->PodcastItem->findById( $id );

        // If we did not find the podcast media then redirect to the referer.
        if( empty( $this->data ) ) {

            $this->Session->setFlash('We could not find the podcast media you were looking for.', 'default', array( 'class' => 'error' ) );
        } else {

			if( $this->Api->deleteFileOnMediaServer( $this->PodcastItem->listAssociatedMedia( $this->data ) ) ) {

				// Delete the podcast
				$this->PodcastItem->delete( $id );
				
				$this->Session->setFlash('We successfully deleted the podcast media.', 'default', array( 'class' => 'success' ) );
				
			} else {
				
				$this->Session->setFlash('We could not schedule the media file for deletion. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
			}
        }
        
        $this->redirect( $this->referer() );
    }
}
