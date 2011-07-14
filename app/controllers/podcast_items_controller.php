<?php
class PodcastItemsController extends AppController {

    var $name = 'PodcastItems';
    var $components = array( 'Upload' );

    private $errors = array();

    var $paginate = array( 'limit' => 5, 'page' => 1, 'order' => array( 'PodcastItem.id' => 'desc' ) );

    /*
     * @name : beforeRender
     * @description : The beforeRender action is automatically called after the controller action has been executed and before the screen
     * is rendered.
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
     * @desscription : Renders filechucker.cgi enabling a peep to upload item media.
     * @todo : Move this code to the 'add' method. Change of functionality mid project.
     * @updated : 13th May 2011
     * @by : Charles Jackson
     */
    function index( $podcast_id ) {

        $this->PodcastItem->Podcast->recursive = 3; // Raise the recursive level so we have enough information to check permissions.

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

            $this->data['PodcastsItems'] = $this->paginate('PodcastItem', array('PodcastItem.podcast_id' => $podcast_id, 'PodcastItem.deleted' => false ) );
        }
    }

    /*
     * @name : view
     * @desscription : Enables a moderator or member to view details of an individual media file.
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function view( $id = null ) {

        $this->PodcastItem->recursive = 3; // Raise the recursive level so we can check permissions.
        
        // They are loading the page, get the data using the $id passed as a parameter.
        $this->data = $this->PodcastItem->findById( $id );
        
        // We did not find the podcast, error and redirect.
        if( empty( $this->data )  || $this->Permission->toView( $this->data['Podcast'] ) == false ) {

            $this->Session->setFlash( 'Could not find your item media file. Please try again.', 'default', array( 'class' => 'error' ) );
            $this->redirect( $this->referer() );
        }
    }

    /*
     * @name : edit
     * @desscription : Displays a form that enables a peep to edit an existing row on the podcast_items table.
     * @updated : 19th May 2011
     * @by : Charles Jackson
     */
    function edit( $id = null ) {

           if ( !empty( $this->data ) ) {

        	// Unset this relationship so we can "saveAll" without touching the parent collection
        	//unset( $this->PodcastItem->belongsTo['Podcast'] );
        	
			$this->PodcastItem->begin(); // Begin a transaction so we can rollback if needed.
			
            if( $this->__updateImage() && $this->__updateTranscript() && $this->PodcastItem->validates()  ) {

            	
				$this->PodcastItem->set( $this->data );
            	$this->PodcastItem->saveAll();
				$this->PodcastItem->commit();
				
				// If the meta injection fails alert the user but do not roll back the database.
				if( $this->Api->metaInjection( $this->PodcastItem->buildInjectionFlavours( $this->data['PodcastItem']['id'] ) ) ) {
					
					$this->Session->setFlash('Your podcast item has been successfully updated.', 'default', array( 'class' => 'success' ) );
					
				} else {
					
					$this->Session->setFlash('Your podcast item has been successfully updated but the meta injection failed. Use the refresh button.', 'default', array( 'class' => 'alert' ) );
				}	
												
                $this->redirect( array( 'admin' => false, 'controller' => 'podcast_items', 'action' => 'view', $this->data['PodcastItem']['id'] ) );
				exit;
            }
			
            $this->errors = $this->PodcastItem->invalidFields( $this->data );
            $this->Session->setFlash('Could not update your media. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
			$this->PodcastItem->rollback();

        } else {

            $this->data = $this->PodcastItem->findById( $id );

            // We did not find the podcast, redirect.
            if( empty( $this->data ) ) {

                $this->Session->setFlash('Could not find your podcast media. Please try again.', 'default', array( 'class' => 'error' ) );
                $this->cakeError('error404');
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
	
        $this->autoRender = false; // We don't want to render a view
		$getId3_information = array();
		
        if ( $this->Session->check('Podcast.podcast_id') && isSet( $this->params['url'] ) ) {

            $this->PodcastItem->create();
			// Capture various bits and pieces including information needed to determine the workflow.
            $this->data = $this->PodcastItem->createFromUrlVariables( $this->params, $this->Session->read('Podcast.podcast_id') );
            $this->PodcastItem->set( $this->data );

            $this->PodcastItem->begin(); // Start a transaction

            if( $this->PodcastItem->save() ) { // Save the data here so we can use the unique ID created as part of the media filename.

                $this->data = $this->PodcastItem->findById( $this->PodcastItem->getLastInsertId() );

				// Move from the default file chucker upload folder into a specific custom_id folder and rename it
				// appending the database ID number to the start of the filename to ensure it is unique.
                if( $this->Folder->moveFileChuckerUpload( $this->data ) ) {

					// Capture the new name by setting an updated filename appending the database ID number to the start of 
					// the filename to ensure it is unique.
					$this->data['PodcastItem']['filename'] = $this->data['PodcastItem']['id'] . '_' . $this->data['PodcastItem']['original_filename'];
				
					// Capture the ID3 information
					$getId3_information = $this->Getid3->extract( FILE_REPOSITORY . $this->data['Podcast']['custom_id'] . '/' . $this->data['PodcastItem']['filename'] );
					
					// Capture aspects of the $getId3_information in the PodcastItem array
					$this->PodcastItem->captureId3Information( $this->data, $getId3_information );
					$this->PodcastItem->set( $this->data );
					$this->PodcastItem->save();
					
					// Instaniate the object and determine the workflow.
					$this->Workflow = ClassRegistry::init('Workflow');
					$this->Workflow->setData( $this->data );
					$this->Workflow->setId3Data( $getId3_information );
					$this->Workflow->setParams( $this->params );
					$this->Workflow->determine();

					// Do we have errors? If true, probably an invalid file type.
					if( $this->Workflow->hasErrors() ) {
						
						$this->errors = $this->Workflow->getErrors();
						$this->Session->setFlash('We were unable to determine a transcoding workflow for your media file.', 'default', array( 'class' => 'error' ) );
						
					// The media is not transcoded and we can transfer direct to the media box. We include an additional element
					// entitled "media" that we can recognise in the callback.
					} elseif( $this->Workflow->getWorkflow() == DELIVER_WITHOUT_TRANSCODING ) {
						
						if( $this->Api->deliverWithoutTranscoding( 
							array( 
								'source_path' => $this->data['Podcast']['custom_id'].'/',
								'target_path' => $this->data['Podcast']['custom_id'].'/', 
								'filename' => $this->data['PodcastItem']['filename'],
								'podcast_item_id' => $this->data['PodcastItem']['id'],
									)
								)
							)
						{
							$this->Session->setFlash('Media file has been scheduled for transfer.', 'default', array( 'class' => 'success' ) );
							$this->PodcastItem->commit();
							
							// Everything worked OK, redirect to view page
					        if( $this->Session->read('Podcast.admin') ) {
					
					            $this->redirect( array( 'admin' => true, 'controller' => 'podcast_items', 'action' => 'view', $this->PodcastItem->getLastInsertId() ) );
					
					        } else {
					
					            $this->redirect( array( 'controller' => 'podcast_items', 'action' => 'view', $this->PodcastItem->getLastInsertId() ) );
					        }
							
						} else {
							
							$this->Session->setFlash('We were unable to transfer your file to the media server. Please try again', 'default', array( 'class' => 'error' ) );
						}
						
					// This media needs to be transcoded.
					} else {
						
						// Transcode the media
						if( $this->Api->transcodeMediaAndDeliver( $this->data['Podcast']['custom_id'], $this->data['PodcastItem']['filename'], $this->Workflow->getWorkflow(), $this->data['PodcastItem']['id'] ) ) {
	
							// It's possible the workflow redefined the aspect ratio so update it here and resave the object before we commit.
							$this->data['PodcastItem']['aspect_ratio'] = $this->Workflow->getAspectRatio();
							$this->PodcastItem->set( $this->data ); // Hydrate the object
							$this->PodcastItem->save();
							
							// Witwoo! Everything worked.						
							$this->PodcastItem->commit();
							$this->Session->setFlash('Your podcast media has been successfully uploaded and scheduled with the transcoder.', 'default', array( 'class' => 'success' ) );

							// Everything worked OK, redirect to view page
					        if( $this->Session->read('Podcast.admin') ) {
					
					            $this->redirect( array( 'admin' => true, 'controller' => 'podcast_items', 'action' => 'view', $this->PodcastItem->getLastInsertId() ) );
					
					        } else {
					
					            $this->redirect( array( 'controller' => 'podcast_items', 'action' => 'view', $this->PodcastItem->getLastInsertId() ) );
					        }
							
						} else {
							
							// Could not schedule for transcoding.
							$this->Session->setFlash('Could not schedule your media for transcoding, please try again. If the problem persists contact an administrator.',  'default', array( 'class' => 'error' ) );						
						}
					}
					
                } else {
					
                    // Could not copy file from the default folder in the transcoding specific folder on the admin box.
					$this->Session->setFlash('Could not copy your uploaded media. If the problem persists contact an administrator.',  'default', array( 'class' => 'error' ) );						
				}
            }
			
        } else {

			// The file did not upload capture the errors.
			$this->errors = $this->PodcastItem->invalidFields( $this->data );
			$this->Session->setFlash('Could not save your media information, please try again. If the problem persists please contact an administrator.',  'default', array( 'class' => 'error' ) );
		}
		
		unlink( FILE_REPOSITORY . $this->data['Podcast']['custom_id'] . '/' . $this->data['PodcastItem']['filename'] );		
		$this->PodcastItem->rollback();
		
        $this->redirect( array( 'action' => 'index', $this->Session->read('Podcast.podcast_id') ) );

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
        if( $this->Upload->podcastMediaImage( $this->data, 'new_image_filename' ) ) {
			
			$this->data['PodcastItem']['image_filename'] = $this->Upload->getUploadedFileName();
			
		} else {
			
			unset( $this->data['PodcastItem']['new_image_filename'] );
		}
				
        // Check to see if the upload component created any errors.
        if( $this->Upload->hasError() ) {

            $this->PodcastItem->invalidate('image_filename', $this->Upload->getError() );
            return false;
			
        }

		return true;
    }

    /*
     * @name : __updateTranscript
     * @description : Internal method called by the edit methods, both user and administrator.
     * @updated : 9th May 2011
     * @by : Charles Jackson
     */
	function __updateTranscript() {
		
		if( $this->Upload->transcript( $this->data, 'new_filename' ) ) {

			$this->data['Transcript']['original_filename'] = $this->data['Transcript']['new_filename']['name'];
			$this->data['Transcript']['filename'] = $this->Upload->getUploadedFilename();
			$this->data['Transcript']['media_type'] = strtolower( TRANSCRIPT );
			$this->data['Transcript']['duration'] = 0;
			$this->data['Transcript']['podcast_item'] = $this->data['PodcastItem']['id'];
			$this->data['Transcript']['processed_state'] = 9; // Media available
			
		} else {
			
			unset( $this->data['Transcript']['filename'] );

		}
		
        // Check to see if the upload component created any errors.
        if( $this->Upload->hasError() ) {

            $this->PodcastItem->invalidate('filename', $this->Upload->getError() );
            return false;
        }
        			
		return true;
	}
	
    /*
     * @name : delete
     * @desscription : Enables a user to delete an individual item of media assuming they have permission
     * @name : Charles Jackson
     * @by : 5th May 2011
     */
    function delete( $id = null ) {

        $this->autoRender = false;
		$this->PodcastItem->recursive = 3; // Raise the recursive from the default so we have the necessary data to check permissions and listAssociatedMedia

        // This method is used for individual deletes and deletions via the form posted checkbox selection. Hence
        // when somebody is deleting an individual podcast_item we pass into an array and loop through as is the data
        // was posted.
        if( $id )
            $this->data['PodcastItem']['Checkbox'][$id] = true;

        foreach( $this->data['PodcastItem']['Checkbox'] as $key => $value ) {

        	$this->data = $this->PodcastItem->findById( $key );
        	        		
    	    // If we did not find the podcast media then redirect to the referer.
	        if( empty( $this->data ) || $this->Permission->toUpdate( $this->data['Podcast'] ) == false ) {

        	    $this->Session->setFlash('We could not find the media you were looking for.', 'default', array( 'class' => 'error' ) );
        	    break;

    	    } else {

				if( $this->Api->renameFileMediaServer( $this->PodcastItem->listAssociatedMedia( $this->data ) ) ) {

					// Soft delete the podcast
					$this->data['PodcastItem']['deleted'] = true;
					$this->PodcastItem->set( $this->data );
					$this->PodcastItem->save();
	
					$this->Session->setFlash('We successfully deleted the podcast media.', 'default', array( 'class' => 'success' ) );
				
				} else {
				
					$this->Session->setFlash('We could not delete the media. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
					break;
				}
	        }
        }

        $this->redirect( $this->referer() );
    }

    /*
     * @name : delete_attachment
     * @desscription : Enables a user to delete an associated image of a row on the podcast_items table.
     * @name : Charles Jackson
     * @by : 27th June 2011
     */
	function delete_attachment( $attachment, $id ) {
		
        $this->autoRender = false;
		$this->PodcastItem->recursive = 3; // Raise the recursive from the default so we have the necessary data to check permissions.
        $this->data = $this->PodcastItem->findById( $id );
		
        // If we did not find the podcast media then redirect to the referer.
        if( !empty( $this->data ) || $this->Permission->toUpdate( $this->data['Podcast'] ) ) {
			
			// We unset the publication date field because the default value of 0000-00-00 00:00:00 will a produce model validation error.
			unset( $this->data['PodcastItem']['publication_date'] ); 
			
			$this->data['PodcastItem'][$attachment.'_filename'] = null;
			$this->PodcastItem->set( $this->data );
			
			if( $this->PodcastItem->save() ) {
				
				if( $this->Api->deleteFileOnMediaServer( 
					array(
							'source_path' => $this->data['Podcast']['custom_id'].'/',  
							'filename' => $this->data['PodcastItem'][$attachment.'_filename'],  
						)
					) 
				) {

					$this->Session->setFlash('The media attachment has been deleted.', 'default', array( 'class' => 'success' ) );
			        $this->redirect( array( 'action' => 'view', $this->data['PodcastItem']['id'] ) );
			        exit;	
				}
			}
        }
        
		$this->Session->setFlash('There has been a problem deleting the media attachment. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );		
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
     * includes a partial _form element that renders filechucker.cgi.
     * @updated : 13th May 2011
     * @by : Charles Jackson
     */
    function admin_index( $podcast_id ) {

        $this->PodcastItem->Podcast->recursive = 3; // Raise the recursive level so we have enough information to check permissions.

        if( (int)$podcast_id ) {

            $this->data = $this->PodcastItem->Podcast->findById( $podcast_id );

            // We cannot easily passed parameters into the filechucker.cgi script hence we store some basic information
            // in the session.
            $this->Session->write('Podcast.podcast_id', $podcast_id);
            $this->Session->write('Podcast.admin', false);
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

        	// Unset this relationship so we can "saveAll" without touching the parent collection
        	unset( $this->PodcastItem->belongsTo['Podcast'] );
        	
			$this->PodcastItem->begin(); // Begin a transaction so we can rollback if needed.
			
            if( $this->__updateImage() && $this->__updateTranscript() && $this->PodcastItem->validates()  ) {

				$this->PodcastItem->set( $this->data );
            	$this->PodcastItem->saveAll();
				$this->PodcastItem->commit();
				$this->Session->setFlash('Your podcast item has been successfully updated.', 'default', array( 'class' => 'success' ) );									
                $this->redirect( array( 'admin' => true, 'controller' => 'podcast_items', 'action' => 'view', $this->data['PodcastItem']['id'] ) );
				exit;
            }
			
            $this->errors = $this->PodcastItem->invalidFields( $this->data );
            $this->Session->setFlash('Could not update your media. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
			$this->PodcastItem->rollback();

        } else {

            $this->data = $this->PodcastItem->findById( $id );

            // We did not find the podcast, redirect.
            if( empty( $this->data ) ) {

                $this->Session->setFlash('Could not find your podcast media. Please try again.', 'default', array( 'class' => 'error' ) );
                $this->cakeError('error404');
            }
        }
    }

    /*
     * @name : admin_delete
     * @desscription : Enables an administrator to perform a hard delete on a podcast and the associated media.
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
	
    /*
     * @name : admin_restore
     * @description : Will update the value of the 'deleted' column of any podcast_item to 0 therefore restoring the
     * media.
     * @updated : 30th June 2011
     * @by : Charles Jackson
     */
    function admin_restore( $id = null ) {

        $this->autoRender = false;
		$this->PodcastItem->recursive = 3; // Raise the recursive from the default so we have the necessary data to listAssociatedMedia
        $this->data = $this->PodcastItem->findById( $id );

        if( empty( $this->data ) ) {

            $this->Session->setFlash('We could not identify the media you are trying to restore.', 'default', array( 'class' => 'error' ) );

        } else {

			if( $this->Api->renameFileMediaServer( $this->PodcastItem->listAssociatedMedia( $this->data ) ) ) {

				// Soft delete the podcast
				$this->data['PodcastItem']['deleted'] = false;
				$this->PodcastItem->set( $this->data );
				$this->PodcastItem->save();
                
                $this->Session->setFlash('We successfully restored the media.', 'default', array( 'class' => 'success' ) );

            } else {

                $this->Session->setFlash('We were unable to restore the media, please try again.', 'default', array( 'class' => 'error' ) );
            }

        }

        $this->redirect( $this->referer() );
    }
	
}
