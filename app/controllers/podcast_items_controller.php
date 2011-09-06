<?php
class PodcastItemsController extends AppController {

    var $name = 'PodcastItems';
    var $components = array( 'Upload' );

    private $errors = array();

    var $paginate = array( 'limit' => 5, 'page' => 1, 'order' => array( 'PodcastItem.id' => 'desc' ) );

    function beforeFilter() {
    	
    	$this->PodcastItem->stripJoinsByAction( $this->action );
    	parent::beforeFilter();
    }
        
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
            
		parent::beforeRender();
    }

    /*
     * @name : add
     * @desscription : Renders filechucker.cgi enabling a peep to upload item media.
     * @todo : Move this code to the 'add' method. Change of functionality mid project.
     * @updated : 13th May 2011
     * @by : Charles Jackson
     */
    function add( $podcast_id ) {

        $this->PodcastItem->Podcast->recursive = 2; // Raise the recursive level so we have enough information to check permissions.

        if( (int)$podcast_id ) {

			$this->PodcastItem->Podcast->Behaviors->attach('Containable');
            $this->data = $this->PodcastItem->Podcast->edit( $podcast_id );

            // We cannot easily passed parameters into the filechucker.cgi script hence we store some basic information
            // in the session.
            $this->Session->write('Podcast.podcast_id', $podcast_id);
            $this->Session->write('Podcast.admin', false);
        }

        if( empty( $this->data ) && $this->Permission->toUpdate( $this->data ) ) {

            $this->Session->setFlash('Could not identify the '.MEDIA.' you are trying to update. Please try again.', 'default', array( 'class' => 'error' ) );
            $this->redirect( $this->referer() );

        }
    }
	
    /*
     * @name : view
     * @desscription : Enables owners, moderators and members to view details of an individual media file.
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function view( $id = null ) {

        // They are loading the page, get the data using the $id passed as a parameter.
        $this->data = $this->PodcastItem->get( $id );

        // We did not find the podcast, error and redirect.
        if( empty( $this->data )  || $this->Permission->toView( $this->data['Podcast'] ) == false ) {

            $this->Session->setFlash( 'Could not find your '.MEDIA.'. Please try again.', 'default', array( 'class' => 'error' ) );
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
           	
			$this->PodcastItem->set( $this->data );	
            if( $this->__updateImage() && $this->__updateTranscript() && $this->PodcastItem->validates()  ) {
			
				$this->PodcastItem->set( $this->data );	
            	$this->PodcastItem->save();

				// May not need meta injection
				if( $this->_metaInjectWhenNeeded() ) {
					
                    if( $this->__generateRSSFeeds( $this->data['Podcast']['id'] ) ) {
						
						$this->Session->setFlash('Your '.MEDIA.' has been successfully updated.', 'default', array( 'class' => 'success' ) );
						
					} else {
						
						// Attempted to meta injection but failed. Alert the user but do not roll back the database.
						$this->Session->setFlash('Your '.MEDIA.' has been successfully updated we were unable to refresh to RSS feeds. If the problem persists please alert an administrator.', 'default', array( 'class' => 'alert' ) );
					}
					
				} else {
					
					// Attempted to meta injection but failed. Alert the user but do not roll back the database.
					$this->Session->setFlash('Your '.MEDIA.' has been successfully updated but the meta injection failed. If the problem persists please alert an administrator.', 'default', array( 'class' => 'alert' ) );
				}	
												
                $this->redirect( array( 'admin' => false, 'controller' => 'podcasts', 'action' => 'view', $this->data['PodcastItem']['podcast_id'] ) );
				exit;
            }
			
            $this->errors = $this->PodcastItem->invalidFields( $this->data );
            $this->Session->setFlash('Could not update your '.MEDIA.'. Please see issues listed below.', 'default', array( 'class' => 'error' ) );

        } else {

            $this->data = $this->PodcastItem->get( $id );
			
            // We did not find the podcast, redirect.
            if( empty( $this->data ) && $this->Permission->toUpdate( $this->data['Podcast'] ) ) {

                $this->Session->setFlash('Could not find your '.MEDIA.'. Please try again.', 'default', array( 'class' => 'error' ) );
                $this->cakeError('error404');
			}
        }

		$this->_setYoutubeOptions();        
    }

	/*
	 * @name : publish
	 * @description : Will set the published_flag to 'Y' for any podcast_item meaning it will appear on RSS feeds.
	 * @updated : 26th August 2011
	 * @by : Charles Jackson
	 */
	function publish( $id = null ) {
		
		$this->PodcastItem->recursive = -1;
		$status = true;
				
        if( $id )
            $this->data['PodcastItem']['Checkbox'][$id] = true;
		            
        foreach( $this->data['PodcastItem']['Checkbox'] as $key => $value ) {

			$this->data = $this->PodcastItem->findById( $key );			
			
			if( $this->Object->readyForPublication( $this->data['PodcastItem'] ) ) {
				
				$this->data['PodcastItem']['published_flag'] = 'Y';
				$this->PodcastItem->set( $this->data );
				$this->PodcastItem->save();
				$this->Session->setFlash( ucfirst( MEDIA ).'(s) has been successfully published.', 'default', array( 'class' => 'success' ) );

			} else {
				
				$status = false;
				$this->Session->setFlash('Cannot publish '. MEDIA.'(s) that are unavailable or have no title.', 'default', array( 'class' => 'alert' ) );
				break;
			}
		}

		if( $status ) {
			
			if( $this->__generateRSSFeeds( $this->data['Podcast']['id'] ) == false ) {
				
				$this->Session->setFlash( ucfirst( MEDIA ).'(s) has been published but we were unable to refresh to RSS feeds. If the problem persists please contact an administrator', 'default', array( 'class' => 'alert' ) );
			}
		}
		
		
		$this->redirect( array( 'admin' => false, 'controller' => 'podcasts', 'action' => 'view', $this->data['PodcastItem']['podcast_id'] ) );
	}
	
	/*
	 * @name : youtube_upload
	 * @description : Upload a new video to youtube.
	 * @updated : 9th August 2011
	 * @by : Charles Jackson
	 */
	 function youtube_upload( $id = null ) {
	
        if( $id )
            $this->data['PodcastItem']['Checkbox'][$id] = true;
		            
        foreach( $this->data['PodcastItem']['Checkbox'] as $key => $value ) {
				
			$this->data = $this->PodcastItem->findById( $key );

			if( $this->Object->youtubePublished( $this->data['PodcastItem'] ) == false ) {
			
				if( $this->PodcastItem->hasYoutubeFlavour( $this->data ) ) {
				
					if( $this->PodcastItem->youtubeValidates( $this->data ) ) {
						
						if( $this->Api->youtubeUpload( $this->PodcastItem->buildYoutubeData( $this->data ) ) ) {
							$this->data['PodcastItem']['youtube_flag'] = 'Y';
							$this->data['PodcastItem']['consider_for_youtube'] = true; // NB: Should already be set to true but set again as an attempt to cleanup the DB moving forward
							$this->data['PodcastItem']['youtube_id'] = 1;
							$this->PodcastItem->set( $this->data );
							$this->PodcastItem->save();
							$this->Session->setFlash( MEDIA.' has been successfully scheduled for upload to youtube.', 'default', array( 'class' => 'success' ) );
						} else {
							
							$this->Session->setFlash('Unable to publish '.MEDIA.' to youtube. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
							break;
						}
						
					} else {
						
							$this->Session->setFlash('Unable to publish '.MEDIA.' to youtube. Please ensure the track has a youtube title & description.', 'default', array( 'class' => 'error' ) );
							break;
					}

				} else {
					
					$this->Session->setFlash('Cannot publish '.MEDIA.' that does not have a Youtube flavour.', 'default', array( 'class' => 'error' ) );
					break;
				}
			
			} else {
				
				$this->Session->setFlash( ucfirst( MEDIA ).' has already been published on Youtube.', 'default', array( 'class' => 'error' ) );
				break;
			}
		}
		
		$this->redirect( array( 'youtube' => false,  'controller' => 'podcasts', 'action' => 'view', $this->data['Podcast']['id'] ) );
	 }
	 
	/*
	 * @name : youtube_refresh
	 * @description : Refresh the meta data for a youtube video.
	 * @updated : 9th August 2011
	 * @by : Charles Jackson
	 */
	 function youtube_refresh( $id = null ) {
	
        if( $id )
            $this->data['PodcastItem']['Checkbox'][$id] = true;
		            
        foreach( $this->data['PodcastItem']['Checkbox'] as $key => $value ) {
				
			$this->data = $this->PodcastItem->findById( $key );

			if( $this->Object->youtubePublished( $this->data['PodcastItem'] ) ) {
			
				if( $this->PodcastItem->youtubeValidates( $this->data ) ) {
					
					if( $this->Api->youtubeRefresh( $this->PodcastItem->buildYoutubeData( $this->data ) ) ) {
						$this->data['PodcastItem']['youtube_flag'] = 'Y';
						$this->data['PodcastItem']['consider_for_youtube'] = true; // NB: Should already be set to true but set again as an attempt to cleanup the DB moving forward
						$this->PodcastItem->set( $this->data );
						$this->PodcastItem->save();
						$this->Session->setFlash( MEDIA.' has been successfully scheduled for a youtube meta data refresh.', 'default', array( 'class' => 'success' ) );
					} else {
						
						$this->Session->setFlash('Unable to refresh '.MEDIA.' on Youtube. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
						break;
					}
					
				} else {
					
						$this->Session->setFlash('Unable to refresh '.MEDIA.' to youtube. Please ensure the '.MEDIA.' has a youtube title & description.', 'default', array( 'class' => 'error' ) );
						break;
				}

			} else {
				
				$this->Session->setFlash( ucfirst( MEDIA ).' has not yet been published on youtube. Cannot refresh meta data.', 'default', array( 'class' => 'error' ) );
				break;
			}
		}
		
		$this->redirect( array( 'youtube' => false,  'controller' => 'podcasts', 'action' => 'view', $this->data['Podcast']['id'] ) );
	 }	 	 

   /*
     * @name : itunes_approve
     * @description : Enables an itunes user to approve an item of media for publication on
     * itunes.
     * @updated : 21st July 2011
     * @by : Charles Jackson
     */
	function itunes_approve( $id = null ) {
    	
        if( $id )
            $this->data['PodcastItem']['Checkbox'][$id] = true;

		if( isSet( $this->data['PodcastItem']['Checkbox'] ) ) {
			
			foreach( $this->data['PodcastItem']['Checkbox'] as $key => $value ) {

				$this->data = $this->PodcastItem->findById( $key );
			
				// Make sure it has already been converted into a podcast if they want to publish it.
				if( !empty( $this->data ) && $this->data['Podcast']['podcast_flag'] == true ) {
					
					$this->data['PodcastItem']['itunes_flag'] = 'Y';
					$this->data['PodcastItem']['published_flag'] = 'Y'; // Automatically publish the track if wanted on itunes.
					$this->data['PodcastItem']['consider_for_itunesu'] = true; // NB: Should already be set to true but set again as an attempt to cleanup the DB moving forward
					
					$this->PodcastItem->set( $this->data );
					$this->PodcastItem->save();
				}
				
			}
			
			if( $this->__generateRSSFeeds( $this->data['Podcast']['id'] ) == false ) {
				
				$this->Session->setFlash( ucfirst( MEDIA ).'(s) has been approved but we were unable to refresh to RSS feeds. If the problem persists please contact an administrator', 'default', array( 'class' => 'alert' ) );
			} else {
			
				$this->Session->setFlash('Your '.MEDIA.' has been successfully approved for publication on iTunes.', 'default', array( 'class' => 'success' ) );
			}
				
		} else {
				
			$this->Session->setFlash('You must select at least one '.MEDIA.' item to publish in iTunes.', 'default', array( 'class' => 'error' ) );
		}

        $this->redirect( array('itunes' => false, 'controller' => 'podcasts','action' => 'view', $this->data['PodcastItem']['podcast_id'] ) );	
    }
    
   /*
     * @name : itunes_reject
     * @description : Enables an itunes user to reject an item of media for publication on
     * itunes.
     * @updated : 21st July 2011
     * @by : Charles Jackson
     */
	function itunes_reject( $id = null ) {
    	
        if( $id )
            $this->data['PodcastItem']['Checkbox'][$id] = true;
		            
		if( isSet( $this->data['PodcastItem']['Checkbox'] ) ) {
			
			foreach( $this->data['PodcastItem']['Checkbox'] as $key => $value ) {

				$this->data = $this->PodcastItem->findById( $key );
			
				// Make sure it has already been converted into a podcast if they want to publish it.
				if( !empty( $this->data ) ) {
					
					$this->data['PodcastItem']['itunes_flag'] = 'N';
					$this->data['PodcastItem']['consider_for_itunesu'] = false;
					
					$this->PodcastItem->set( $this->data );
					$this->PodcastItem->save();
				}
			}

			if( $this->__generateRSSFeeds( $this->data['Podcast']['id'] ) == false ) {
				
				$this->Session->setFlash( ucfirst( MEDIA ).'(s) has been removed but we were unable to refresh to RSS feeds. If the problem persists please contact an administrator', 'default', array( 'class' => 'alert' ) );
			} else {
			
				$this->Session->setFlash('Your '.MEDIA.' has been successfully scheduled for removal from iTunes.', 'default', array( 'class' => 'success' ) );
			}
			
		} else {
			
			$this->Session->setFlash('You must select at least one '.MEDIA.' item.', 'default', array( 'class' => 'error' ) );
		}
		
        $this->redirect( array('itunes' => false, 'controller' => 'podcasts','action' => 'view', $this->data['PodcastItem']['podcast_id'] ) );	
    }
    
    /*
     * @name : filechucker
     * @description : Called by the filechucker script directly after a successful upload. It is used by both
     * users and administrators and will create a row on the podcast items table using parameters passed and session information.
     * @updated : 26th May 2011
     * @by : Charles Jackson
     */
    function filechucker() {
	
        $this->autoRender = false; // We don't want to render a view
		$getId3_information = array();
		
        if ( $this->Session->check('Podcast.podcast_id') && isSet( $this->params['url'] ) ) {

            $this->PodcastItem->create();
			// Capture various bits and pieces including information needed to determine the workflow.
            $this->data = $this->PodcastItem->createFromUrlVariables( $this->params, $this->Session->read('Podcast.podcast_id') );
            $this->PodcastItem->set( $this->data );

            $this->PodcastItem->begin(); // Start a transaction

            if( $this->PodcastItem->save() ) { // Save the data here so we can use the unique ID created as part of the media filename.

                $this->data = $this->PodcastItem->get( $this->PodcastItem->getLastInsertId() );

				// Move from the default file chucker upload folder into a specific custom_id folder and rename it
				// appending the database ID number to the start of the filename to ensure it is unique.
                if( $this->Folder->moveFileChuckerUpload( $this->data ) ) {

					// Capture the new name by setting an updated filename appending the database ID number to the start of 
					// the filename to ensure it is unique.
					$this->data['PodcastItem']['filename'] = $this->data['PodcastItem']['id'] . '_' . $this->data['PodcastItem']['original_filename'];
				
					// Capture the ID3 information
					$getId3_information = $this->Getid3->extract( FILE_REPOSITORY . $this->data['Podcast']['custom_id'] . '/' . $this->data['PodcastItem']['filename'] );
					
					// Capture aspects of the $getId3_information in the PodcastItem array
					$this->data = $this->PodcastItem->captureId3Information( $this->data, $getId3_information );
					$this->PodcastItem->set( $this->data );
					$this->PodcastItem->save();
					
					// Instaniate the object and determine the workflow.
					$this->Workflow = ClassRegistry::init('Workflow');
					$this->Workflow->setData( $this->data );
					$this->Workflow->setId3Data( $getId3_information );

					$this->Workflow->setParams( $this->params ); // Parameters passed in the URL from the filechucker upload script.
					$this->Workflow->determine();

					// Do we have errors? If true, probably an invalid file type.
					if( $this->Workflow->hasErrors() ) {
						
						$this->errors = $this->Workflow->getErrors();
						$this->Session->setFlash('We were unable to determine a transcoding workflow for your media file.', 'default', array( 'class' => 'error' ) );
						
					// The media is not transcoded and we can transfer direct to the media box. We include an additional element
					// entitled "media" that we can recognise in the callback.
					} elseif( $this->Workflow->getTranscode() == false ) {
						
						if( $this->Api->deliverWithoutTranscoding( 
							array( 
								'source_path' => $this->data['Podcast']['custom_id'].'/',
								'destination_path' => $this->data['Podcast']['custom_id'].'/', 
								'source_filename' => $this->data['PodcastItem']['filename'],
								'destination_filename' => $this->data['PodcastItem']['filename'],
								'podcast_item_id' => $this->data['PodcastItem']['id'],
								'podcast_id' => $this->data['PodcastItem']['podcast_id'],
								'workflow' => $this->Workflow->getWorkflow(),
								'created' => time()
									)
								)
							)
						{
							$this->Session->setFlash( MEDIA.' has been scheduled for transfer.', 'default', array( 'class' => 'success' ) );
							$this->PodcastItem->commit();
							
				            $this->redirect( array( 'controller' => 'podcasts', 'action' => 'view', $this->data['Podcast']['id'] ) );
							
						} else {
							
							$this->Session->setFlash('We were unable to transfer your '.MEDIA.' to the media server. Please try again', 'default', array( 'class' => 'error' ) );
						}
						
					// This media needs to be transcoded.
					} else {
						
						// Transcode the media
						if( $this->Api->transcodeMediaAndDeliver( $this->data['Podcast']['custom_id'], $this->data['PodcastItem']['filename'], $this->Workflow->getWorkflow(), $this->data['PodcastItem']['id'], $this->data['PodcastItem']['podcast_id'] ) ) {
	
							// It's possible the workflow redefined the aspect ratio so update it here and resave the object before we commit.
							$this->data['PodcastItem']['aspect_ratio'] = $this->Workflow->getAspectRatioFloat();
							$this->PodcastItem->set( $this->data ); // Hydrate the object
							$this->PodcastItem->save();
							
							// Witwoo! Everything worked.						
							$this->PodcastItem->commit();
							$this->Session->setFlash('Your '.MEDIA.' has been successfully uploaded and scheduled with the transcoder.', 'default', array( 'class' => 'success' ) );

				            $this->redirect( array( 'controller' => 'podcasts', 'action' => 'view', $this->data['Podcast']['id'] ) );
							
						} else {
							
							// Could not schedule for transcoding.
							$this->Session->setFlash('Could not schedule your '.MEDIA.' for transcoding, please try again. If the problem persists contact an administrator.',  'default', array( 'class' => 'error' ) );						
						}
					}
					
                } else {
					
                    // Could not copy file from the default folder in the transcoding specific folder on the admin box.
					$this->Session->setFlash('Could not copy your '.MEDIA.'. If the problem persists contact an administrator.',  'default', array( 'class' => 'error' ) );						
				}
            }
			
        } else {

			// The file did not upload capture the errors.
			$this->errors = $this->PodcastItem->invalidFields( $this->data );
			$this->Session->setFlash('Could not save your '.MEDIA.' information, please try again. If the problem persists please contact an administrator.',  'default', array( 'class' => 'error' ) );
		}
		
		unlink( FILE_REPOSITORY . $this->data['Podcast']['custom_id'] . '/' . $this->data['PodcastItem']['original_filename'] );		
		$this->PodcastItem->rollback();
		
        $this->redirect( array( 'action' => 'add', $this->Session->read('Podcast.podcast_id') ) );

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
			
			unset( $this->data['Transcript'] );

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
     * @desscription : Enables a user to delete an individual item of media assuming they have permission.
     * @todo : Very inefficient, making an API call for every deletion. Should be refactored. 
     * @name : Charles Jackson
     * @by : 5th May 2011
     */
    function delete( $id = null ) {

        $this->autoRender = false;

        // This method is used for individual deletes and deletions via the form posted checkbox selection. Hence
        // when somebody is deleting an individual podcast_item we pass into an array and loop through as is the data
        // was posted.
        if( $id )
            $this->data['PodcastItem']['Checkbox'][$id] = true;

        foreach( $this->data['PodcastItem']['Checkbox'] as $key => $value ) {

        	$this->data = $this->PodcastItem->get( $key );
        	        		
    	    // If we did not find the podcast media then redirect to the referer.
	        if( !empty( $this->data ) && $this->Permission->toUpdate( $this->data['Podcast'] ) ) {
				
				if( $this->Object->isPublished( $this->data['PodcastItem'] ) == false && $this->Object->isAvailable( $this->data['PodcastItem'] ) ) {

					if( $this->Api->renameFileMediaServer( $this->PodcastItem->listAssociatedMedia( $this->data ) ) ) {
	
						// Soft delete the podcast
						$this->data['PodcastItem']['deleted'] = true;
						$this->PodcastItem->set( $this->data );
						$this->PodcastItem->save();
		

						if( $this->__generateRSSFeeds( $this->data['Podcast']['id'] ) == false ) {
							
							$this->Session->setFlash( ucfirst( MEDIA ).'(s) has been deleted but we were unable to refresh the RSS feeds. If the problem persists please contact an administrator', 'default', array( 'class' => 'alert' ) );
						} else {

							$this->Session->setFlash('We successfully deleted your '.MEDIA.'.', 'default', array( 'class' => 'success' ) );
						}
						
					} else {
					
						$this->Session->setFlash('We could not delete '.MEDIA.'. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
						break;
					}
					
		        } else {
				
					$this->Session->setFlash('Cannot delete '.MEDIA.' that is published or not yet available.', 'default', array( 'class' => 'error' ) );
					break;
				}
			}
        }

        $this->redirect( array('admin' => false, 'controller' => 'podcasts', 'action' => 'view', $this->data['Podcast']['id'] ) );
    }

    /*
     * @name : delete_attachment
     * @desscription : Enables a user to delete an associated image of a row on the podcast_items table.
     * @name : Charles Jackson
     * @by : 27th June 2011
     */
	function delete_attachment( $attachment, $id ) {
		
        $this->autoRender = false;

        $this->data = $this->PodcastItem->get( $id );
		
        // If we did not find the podcast media then redirect to the referer.
        if( !empty( $this->data ) || $this->Permission->toUpdate( $this->data['Podcast'] ) ) {
			
			// We unset the publication date field because the default value of 0000-00-00 00:00:00 will a produce model validation error.
			unset( $this->data['PodcastItem']['publication_date'] ); 
			
			$this->data['PodcastItem'][$attachment.'_filename'] = null;
			$this->PodcastItem->set( $this->data );
			
			if( $this->PodcastItem->save() ) {
				
				if( $this->Api->deleteFileOnMediaServer( 
					array(
							'destination_path' => $this->data['Podcast']['custom_id'].'/',  
							'destination_filename' => $this->data['PodcastItem'][$attachment.'_filename'],  
						)
					) 
				) {

					$this->Session->setFlash('The '.MEDIA.' attachment has been deleted.', 'default', array( 'class' => 'success' ) );
			        $this->redirect( array( 'action' => 'edit', $this->data['PodcastItem']['id'] ) );
			        exit;	
				}
			}
        }
        
		$this->Session->setFlash('There has been a problem deleting the '.MEDIA.' attachment. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );		
	    $this->redirect( array( 'action' => 'view', $this->data['PodcastItem']['id'] ) );
    }

    /*
     * ADMIN FUNCTIONALITY
     * Below this line are the administration functionality that can only be reach if the flag 'administrator' is set to true on the
     * users profile. The URL for all admin routes is "admin/:controller:/:action:/*
     */

    /*
     * @name : admin_view
     * @desscription : Enables an administrator to view details of an individual media file.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function admin_view( $id = null ) {

        // They are loading the page, get the data using the $id passed as a parameter.
        $this->data = $this->PodcastItem->get( $id );

        // We did not find the podcast, error and redirect.
        if( empty( $this->data ) ) {

            $this->Session->setFlash( 'Could not find your chosen '.MEDIA.'. Please try again.', 'default', array( 'class' => 'error' ) );
            $this->cakeError('error404');
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

        $this->data = $this->PodcastItem->get( $id );

        // If we did not find the podcast media then redirect to the referer.
        if( empty( $this->data ) ) {

            $this->Session->setFlash('We could not find the '.MEDIA.' you were looking for.', 'default', array( 'class' => 'error' ) );
            
        } else {
			
			// Check to see if any flavours of media exist and if true, delete them
			if( $this->PodcastItem->listAssociatedMedia( $this->data )  ) {
				
				if(  $this->Api->deleteFileOnMediaServer( $this->PodcastItem->listAssociatedMedia( $this->data ) ) ) {
	
					// Set the deleted status to "2", scheduled for deletion.
					$this->data['PodcastItem']['deleted'] = 2;
					$this->PodcastItem->set( $this->data );
					$this->PodcastItem->save();
					
					$this->Session->setFlash('We successfully scheduled the '.MEDIA.' for deletion.', 'default', array( 'class' => 'success' ) );
					
				} else {
					
					$this->Session->setFlash('We could not schedule the '.MEDIA.' for deletion. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
				}
				
			} else {

				$this->PodcastItem->delete( $id );				
				$this->Session->setFlash('We successfully deleted the '.MEDIA.'.', 'default', array( 'class' => 'success' ) );
			}
        }
        
        $this->redirect( array( 'admin' => true, 'controller' => 'podcasts', 'action' => 'view', $this->data['PodcastItem']['podcast_id'] ) );
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

            $this->Session->setFlash('We could not identify the '.MEDIA.' you are trying to restore.', 'default', array( 'class' => 'error' ) );

        } else {

			if( $this->Api->renameFileMediaServer( $this->PodcastItem->listAssociatedMedia( $this->data ) ) ) {

				// Soft delete the podcast
				$this->data['PodcastItem']['deleted'] = false;
				$this->PodcastItem->set( $this->data );
				$this->PodcastItem->save();

				if( $this->__generateRSSFeeds( $this->data['Podcast']['id'] ) == false ) {
					
					$this->Session->setFlash( ucfirst( MEDIA ).'(s) has been restored but we were unable to refresh the RSS feeds. If the problem persists please contact an administrator', 'default', array( 'class' => 'alert' ) );
				} else {
                
	                $this->Session->setFlash('We successfully restored the '.MEDIA.'.', 'default', array( 'class' => 'success' ) );
				}

            } else {

                $this->Session->setFlash('We were unable to restore the '.MEDIA.', please try again.', 'default', array( 'class' => 'error' ) );
            }

        }

        $this->redirect( $this->referer() );
    }
    
	/*
	 * @name : _setYoutubeOptions
	 * @description : Sets the various options used on the youtube form
	 * @udpated : 18th August 2011
	 * @by : Charles Jackson
	 */
    function _setYoutubeOptions() {
    	
        // Get the pricavy settings
        $this->set('youtube_privacy', array('Public','Hidden','Private') );
        $this->set('youtube_licenses', array('Standard Youtube License','Creative Commons Attribution License') );
        $this->set('youtube_comments', array('Allow','Friends and Approval','Approval Only','Disallow') );
        $this->set('youtube_video_responses', array('Yes','Approval','No') );

		// Get the possible playlists for youtube.
        $YoutubeSubjectPlaylist = ClassRegistry::init('YoutubeSubjectPlaylist');
        $youtube_subject_playlist = $YoutubeSubjectPlaylist->find( 'list', array( 'fields' => array( 'YoutubeSubjectPlaylist.id', 'YoutubeSubjectPlaylist.title' ) ) );
        $this->set('youtube_subject_playlist', $youtube_subject_playlist );
    }
	
	/*
	 * @name : _metaInjectWhenNeeded
	 * @description : Checks to see if a file needs meta injection (at time of writing MP3's only, then builds an array that is passed 
	 * to the API.
	 * @note : 9 = 'available'
	 * @updated : 18th August 2011
	 * @by : Charles Jackson
	 */
	function _metaInjectWhenNeeded() {
		
		$podcastItemMedia = ClassRegistry::init('PodcastItemMedia');
		
		if( $this->PodcastItem->needsInjection( $this->data['PodcastItem']['id'] ) && $this->data['PodcastItem']['processed_state'] == 9 )
			return $this->Api->metaInject( $podcastItemMedia->buildMetaData( 
				array( 
					'PodcastItemMedia.podcast_item' => $this->data['PodcastItem']['id']
					) 
				)
			);
			
		return true;
	}
	
}
