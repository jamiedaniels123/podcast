<?php
class PodcastItemsController extends AppController {

	var $name = 'PodcastItems';
	var $components = array( 'Upload' );

	private $errors = array();

	var $paginate = array( 'limit' => 50, 'page' => 1, 'order' => array( 'PodcastItem.publication_date' => 'desc' ) );

	function beforeFilter() {

		parent::beforeFilter();
	}

	/*
	 * @name : beforeRender
	 * @description : The beforeRender action is automatically called after the controller 
	* action has been executed and before the screen is rendered.
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
	 * @name : index
	 * @description : Displays a paginated list of all podcasts that are owned by the current user.
	 * @name : Charles Jackson
	 * @by : 16th May 2011
	 */
	function index( $id = null ) {

		$this->PodcastItems->Podcast->recursive = -1;
		$this->PodcastItems->recursive = -1;
		$this->data = $this->PodcastItem->Podcast->permissionData( $id );
		// BH 20120416 - added addional condition to NOT include deleted podcast_items, although they weren't showing the
		//               paginate code was not aware that we were skipping records and it would show confusing page numbers etc
		$this->data['PodcastItems'] = $this->paginate('PodcastItem', array( 'PodcastItem.podcast_id' => $id, 'PodcastItem.deleted' => 0 ) );
		$this->set('element', 'tracks' ); // Set the active element for the tab menu
		// Set the tabs for the menu
		$this->setTabs( $this->data['Podcast'] );
	}

	/*
	 * @name : add
	 * @description : Renders filechucker.cgi enabling a peep to upload item media.
	 * @todo : Move this code to the 'add' method. Change of functionality mid project.
	 * @updated : 13th May 2011
	 * @by : Charles Jackson
	 */
	function add( $podcast_id ) {

		if( (int)$podcast_id ) {

			$this->PodcastItem->Podcast->Behaviors->attach('Containable');
			$this->data = $this->PodcastItem->Podcast->edit( $podcast_id );

			// We cannot easily passed parameters into the filechucker.cgi script hence we store some basic information
			// in the session.
			$this->Session->write('Podcast.podcast_id', $podcast_id);
			$this->Session->write('Podcast.admin', false);
			$this->setTabs( $this->data['Podcast'] );
			$this->set('element', 'media');
		}

		if( empty( $this->data ) && $this->Permission->toUpdate( $this->data ) ) {

			$this->Session->setFlash('Could not identify the '.MEDIA.' you are trying to update. Please try again.', 'default', array( 'class' => 'error' ) );
			$this->cakeError('error404');
		}
	}
	
    /*
     * @name : edit
     * @description : Displays a form that enables a peep to edit an existing row on the podcast_items table.
     * @updated : 19th May 2011
     * @by : Charles Jackson
     */
	function edit( $id = null, $element = 'summary' ) {

		error_log("podcast_items_controller > edit | id = ".$id." | element = ".$element);

		$this->layout = 'ajax';
		if ( !empty( $this->data ) ) {

			$this->set('element',$this->data['PodcastItem']['element'] );
			
			$this->PodcastItem->set( $this->data );	
			if( $this->__updateImage() && $this->__updateTranscript() && $this->PodcastItem->validates( $this->data )  ) {
				
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
				
				$this->redirect( array( 'admin' => false, 'controller' => 'podcast_items', 'action' => 'edit', $this->data['PodcastItem']['id'], $element.'#'.$element ) );
				exit;
			}
			
			$this->set('edit_mode',true);
			$this->errors = $this->PodcastItem->invalidFields( $this->data );
			$this->Session->setFlash('Could not update your '.MEDIA.'. Please see issues listed below.', 'default', array( 'class' => 'error' ) );

		} else {
		
			$this->data = $this->PodcastItem->get( $id );
			$this->set('element', $element);
			
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
	 * @description : Will set the published_flag to 'Y' for any podcast_item meaning it will appear on RSS feeds and be
	 * available for upload to youtube.
	 * @updated : 26th August 2011
	 * @by : Charles Jackson
	 */
	function publish( $id = null ) {
		
		$this->PodcastItem->recursive = 1;
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
		
		
		$this->redirect( array( 'admin' => false, 'controller' => 'podcast_items', 'action' => 'index', $this->data['PodcastItem']['podcast_id'].'#tracks' ) );
	}

	/*
	 * @name : unpublish
	 * @description : Will set the published_flag to 'N' for any podcast_item, regenerate the RSS feeds and if appropriate
	 * refresh youtube.
	 * @NOTE : In the magic "beforeSave" podcast_item model method I set channel flags such as "youtube_flag" according
	 * to the value of the "published_flag". 
	 * @updated : 9th September 2011
	 * @by : Charles Jackson
	 */
	function unpublish( $id = null ) {
		
		$this->PodcastItem->recursive = 1;
		$status = true;
				
        if( $id )
            $this->data['PodcastItem']['Checkbox'][$id] = true;
		            
        foreach( $this->data['PodcastItem']['Checkbox'] as $key => $value ) {

			$this->data = $this->PodcastItem->findById( $key );			
			
			if( $this->data['PodcastItem']['published_flag'] == 'Y' ) {
				
				$this->data['PodcastItem']['published_flag'] = 'N';
				
				$this->PodcastItem->set( $this->data );
				$this->PodcastItem->save();

				// Generate the RSS Feeds
				$this->__generateRSSFeeds( $this->data['PodcastItem']['podcast_id'] );
				
				// If this track has been published on youtube update the privacy settings to private
				if( $this->data['PodcastItem']['youtube_flag'] == 'Y' ) {
					
					$this->data['PodcastItem']['youtube_privacy'] = 'Hidden';
					$this->Api->youtubeRefresh( $this->PodcastItem->buildYoutubeData( $this->data ) );					
				}

				$this->Session->setFlash( ucfirst( MEDIA ).'(s) has been successfully unpublished and all channels have been successfully updated.', 'default', array( 'class' => 'success' ) );

			}
		}

		$this->redirect( array( 'admin' => false, 'controller' => 'podcast_items', 'action' => 'index', $this->data['PodcastItem']['podcast_id'].'#tracks' ) );
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
							$this->data['PodcastItem']['published_flag'] = 'Y'; // Automatically publish the track if wanted on youtube.
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
						
						$this->Session->setFlash('Unable to publish '.MEDIA.' to youtube. Please ensure the track has a youtube title, description and a list of comma separated tags.', 'default', array( 'class' => 'error' ) );
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
		
		$this->redirect( array( 'youtube' => false,  'controller' => 'podcast_items', 'action' => 'index', $this->data['Podcast']['id'].'#tracks' ) );
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
			
				if( $this->PodcastItem->youtubeValidates( $this->data ) && $this->data['PodcastItem']['youtube_id'] != NULL && $this->data['PodcastItem']['youtube_id'] != '1') {

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
					
						$this->Session->setFlash('Unable to refresh '.MEDIA.' to youtube. Please ensure the '.MEDIA.' has a youtube title, description, tags and has been fully uploaded to YouTube.', 'default', array( 'class' => 'error' ) );
						break;
				}

			} else {
				
				$this->Session->setFlash( ucfirst( MEDIA ).' has not yet been published on youtube. Cannot refresh meta data.', 'default', array( 'class' => 'error' ) );
				break;
			}
		}
		
		$this->redirect( array( 'youtube' => false,  'controller' => 'podcast_items', 'action' => 'index', $this->data['Podcast']['id'].'#tracks' ) );
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

		$this->redirect( array( 'youtube' => false,  'controller' => 'podcast_items', 'action' => 'index', $this->data['Podcast']['id'].'#tracks' ) );
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

		$this->redirect( array( 'youtube' => false,  'controller' => 'podcast_items', 'action' => 'index', $this->data['Podcast']['id'].'#tracks' ) );
	}

		/*
		 * @name : filechucker
		 * @description : Called by the filechucker script directly after a successful upload. It is used by both
		 * users and administrators and will create a row on the podcast items table using parameters passed and session information.
		 * @updated : 26th May 2011
		 * @by : Charles Jackson
		 ��@updated : 24th Feb 2012
		 * @by : Ben Hawkridge
		 * 
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

					// Capture the new name by setting an updated filename appending the database ID number to the start of 
					// the filename to ensure it is unique.
					// BH 20120422	moved this before moving the uploaded file so that the derived 'filename' can be set to lowercase as this is the
					//							prefered format for filenames, and insures consistency between flavour generated files which the PcP part of the
					//							transcoding cluster generates as lower case.
					//							Also convert any additional periods (.) to underscores (_)
					$filename = strtolower($this->data['PodcastItem']['id'] . '_' . $this->data['PodcastItem']['original_filename']);
					$filename = str_replace(".", "_", pathinfo($filename, PATHINFO_FILENAME)).".".pathinfo($filename, PATHINFO_EXTENSION);
					$this->data['PodcastItem']['filename'] = $filename;

					// Move from the default file chucker upload folder into a specific custom_id folder and rename it
					// appending the database ID number to the start of the filename to ensure it is unique.
					if( $this->Folder->moveFileChuckerUpload( $this->data ) ) {

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

						$this->Session->setFlash($this->Workflow->getErrors(), 'default', array( 'class' => 'error' ) );

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
								'created' => time(),
									)
								)
							)
						{
							$this->Session->setFlash( MEDIA.' has been scheduled for transfer.', 'default', array( 'class' => 'success' ) );
							$this->PodcastItem->commit();

							$this->redirect( array( 'admin' => false,  'controller' => 'podcast_items', 'action' => 'index', $this->data['Podcast']['id'] ) );

						} else {

							$this->Session->setFlash('We were unable to transfer your '.MEDIA.' to the media server. Please try again', 'default', array( 'class' => 'error' ) );
						}

						// This media needs to be transcoded.
					} else {
						// BH 20120224 Need to set the permissions on the file to 664 so that it is easier to handle when it's SCP'd to remote transcoder
						
						chmod(FILE_REPOSITORY . $this->data['Podcast']['custom_id'] . '/' . $this->data['PodcastItem']['filename'], 0664);  // changed permissions to be 664
						
						// Transcode the media
						if( $this->Api->transcodeMediaAndDeliver( $this->data['Podcast']['custom_id'], $this->data['PodcastItem']['filename'], $this->Workflow->getWorkflow(), $this->data['PodcastItem']['id'], $this->data['PodcastItem']['podcast_id'] ) ) {

							// It's possible the workflow redefined the aspect ratio so update it here and resave the object before we commit.
							$this->data['PodcastItem']['aspect_ratio'] = $this->Workflow->getAspectRatioFloat();
							$this->PodcastItem->set( $this->data ); // Hydrate the object
							$this->PodcastItem->save();

							// Witwoo! Everything worked.						
							$this->PodcastItem->commit();
							$this->Session->setFlash('Your '.MEDIA.' has been successfully uploaded and scheduled with the transcoder.', 'default', array( 'class' => 'success' ) );

							$this->redirect( array( 'admin' => false,  'controller' => 'podcast_items', 'action' => 'index', $this->data['Podcast']['id'] ) );

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

			$this->redirect( array( 'youtube' => false,  'controller' => 'podcast_items', 'action' => 'index', $this->data['Podcast']['id'].'#tracks' ) );

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

			$this->data['PodcastItem']['transcript_filename'] = $this->Upload->getUploadedFilename();
			$this->data['PodcastItem']['transcript_upload_by'] = $this->Session->read('Auth.User.id');
			$this->data['PodcastItem']['transcript_upload_when'] = date('Y-m-d H:i:s');
			
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
		 * @description : Enables a user to delete an individual item of media assuming they have permission.
		 * @todo : Very inefficient, making an API call for every deletion. Should be refactored. 
		 * @todo : The 'isPublished' logic is not really right as the iTunes and YouTube flags are little used
		 *				 or even accessable by end users.  The use by the new podcast-admin needs to be checked prior
		 *				 prior to removal of this conditional test.
		 * @todo : Allow __generateRSSFeeds() to select 'player.xml' as a special 'flavour' as at present to refresh
		 *				 it one has to select the 'default' flavour.  This would save a little time in cases when deleting
		 *				 unpublished tracks, which would probably occur often when Collection has been upgraded to podcast.
		 * @todo : Does not (soft) delete poster images and most likely does not handle deleting transcripts correctly
		 *				 (the flavour maybe deleted but not the podcast_item entry).  Closed Caption files should be ok as
		 *				 they are treated as a flavour.
		 * @updated : 8th May 2012
		 * @by : Ben Hawkridge
		 */
		function delete( $id = null ) {
			
			$this->autoRender = false;
			
			// This method is used for individual deletes and deletions via the form posted checkbox selection. Hence
			// when somebody is deleting an individual podcast_item we pass into an array and loop through as is the data
			// was posted.
			if( $id )
				$this->data['PodcastItem']['Checkbox'][$id] = true;
			
			$update_default_rss = false;  // true = default (actually player.xml) flavour needs updating
			$update_all_rss = false; 			// true = all rss flavour feeds need updating as track was published
			
			foreach( $this->data['PodcastItem']['Checkbox'] as $key => $value ) {
				
				$this->data = $this->PodcastItem->get( $key );
						
				// If we did not find the podcast media then redirect to the referer.
				if( !empty( $this->data ) && $this->Permission->toUpdate( $this->data['Podcast'] ) ) {

					if( $this->Object->isPublished( $this->data['PodcastItem'] ) == false ) {
						// BH 20120508 'Object->isPublished' checks to see if the iTunes U (itunes_flag) or Youtube (youtube_flag)
						//						 flags are set for this track and stops deletion if they are.  These flags are not readily
						//						 changable in the current version of Podcast admin (compared to old) and it's possible they
						//						 will be depreciated in time due to not really been used other than by super-admins in a few
						//						 select instances.
						// error_log("podcast_items_controller > delete | this->data['PodcastItem']['published_flag'] = ".$this->data['PodcastItem']['published_flag']);
						if ($this->data['PodcastItem']['published_flag'] == 'Y') {
							// need to update all RSS feeds as track is published
							$update_all_rss = true;
						} else {
							// only player.xml needs updating, at present this can only only be done by requesting that the default
							// flavour be updated.
							$update_default_rss = true;						
						}
						// The listAssociatedMedia() method returns an array suitable for passing to API that lists
						// all flavours related to this track that need deleting, however these will be 'soft' deleted
						// by renaming the files with a period in the front thus making them 'invisible'.  To actually
						// delete the files this is done via the Super-admin method admin_delete().
						$media_for_deletion = $this->PodcastItem->listAssociatedMedia( $this->data, null, '.' );

						if( $media_for_deletion )
							$this->Api->renameFileMediaServer( $media_for_deletion );

						// Soft delete the podcast - record remains so could be restored as files are only 'hidden'.
						$this->data['PodcastItem']['deleted'] = true;
						$this->PodcastItem->set( $this->data );
						$this->PodcastItem->save();

					} else {
						// BH 20120508 As detailed above this restriction may change in future if the flags are depreciated unless
						//						 some other UI is invoked to allow users to set them, however their use is very minimal within
						//						 the old Podcast administration.
						$this->Session->setFlash('Cannot delete '.MEDIA.' that is published for either iTunes or YouTube.', 'default', array( 'class' => 'error' ) );
						break;
					}
				}
			}
			
			// BH 20120508 we only need to update RSS feeds if any tracks have actually been deleted.  If all tracks were unpublished then
			// 						 only 'player.xml' needs to be refreshed, which at present means the default flavour as well.
			if ($update_default_rss || $update_all_rss) {
				$flavour = ($update_all_rss == false) ? 'default' : null ;			
				// error_log("podcast_items_controller > delete | flavour = ".$flavour);
				if( $this->__generateRSSFeeds( $this->data['Podcast']['id'], $flavour ) == false ) {				
					$this->Session->setFlash( ucfirst( MEDIA ).'(s) has been deleted but we were unable to refresh the RSS feeds. If the problem persists please contact an administrator', 'default', array( 'class' => 'alert' ) );
				} else {						
					$this->Session->setFlash('We successfully deleted your '.MEDIA.'.', 'default', array( 'class' => 'success' ) );
				}
			}
			
			$this->redirect( array('admin' => false, 'controller' => 'podcast_items', 'action' => 'index', $this->data['Podcast']['id'].'#tracks' ) );
		}

    
		/*
		 * @name : delete_attachment
		 * @description : Enables a user to delete an associated image of a row on the podcast_items table.
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
							)) ) {
						
						$this->Session->setFlash('The '.MEDIA.' attachment has been deleted.', 'default', array( 'class' => 'success' ) );
						$this->redirect( array( 'action' => 'edit', $this->data['PodcastItem']['id'] ) );
						exit;	
					}
				}
			}
			
			$this->Session->setFlash('There has been a problem deleting the '.MEDIA.' attachment. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
			$this->redirect( array( 'action' => 'edit', $this->data['PodcastItem']['id'] ) );
		}

    /*
     * ADMIN FUNCTIONALITY
     * Below this line are the administration functionality that can only be reach if the flag 'administrator' is set to true on the
     * users profile. The URL for all admin routes is "admin/:controller:/:action:/*
     */

    /*
     * @name : admin_index
     * @description : Displays a paginated list of all podcasts that are owned by the current user.
     * @name : Charles Jackson
     * @by : 16th May 2011
     */
    function admin_index( $id = null ) {

			$this->PodcastItems->Podcast->recursive = -1;
			$this->PodcastItems->recursive = -1;
			$this->data = $this->PodcastItem->Podcast->findById( $id );		
			// BH 20120416 - added addional condition to NOT include permanently deleted podcast_items (deleted = 2), although they
			//                weren't showing the paginate code was not aware that we were skipping records and it would show
			//								confusing page numbers etc
			$this->data['PodcastItems'] = $this->paginate('PodcastItem', array( 'PodcastItem.podcast_id' => $id, 'PodcastItem.deleted <' => 2 ) );
			$this->set('element', 'tracks' ); // Set the active element for the tab menu
			// Set the tabs for the menu
			$this->setTabs( $this->data['Podcast'] );
    }

    /*
     * @name : admin_delete
     * @description : Enables an administrator to perform a hard delete on a podcast and the associated media.
     * @name : Charles Jackson
     * @by : 5th May 2011
     */
    function admin_delete( $id = null ) {

        $this->autoRender = false;

        if( $id )
            $this->data['PodcastItem']['Checkbox'][$id] = true;

        foreach( $this->data['PodcastItem']['Checkbox'] as $key => $value ) {
			
			$this->data = $this->PodcastItem->get( $key );
	
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
						
						$this->Session->setFlash('We could not schedule the '.MEDIA.'(s) for deletion. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
					}
					
				} else {
	
					$this->PodcastItem->delete( $key );				
					$this->Session->setFlash('We successfully deleted the '.MEDIA.'(s).', 'default', array( 'class' => 'success' ) );
				}
			}
		}
		
        $this->redirect( array( 'admin' => true, 'controller' => 'podcast_items', 'action' => 'index', $this->data['PodcastItem']['podcast_id'].'#tracks' ) );
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
		
        if( $id )
            $this->data['PodcastItem']['Checkbox'][$id] = true;

        foreach( $this->data['PodcastItem']['Checkbox'] as $key => $value ) {
			
			$this->data = $this->PodcastItem->findById( $key );
	
			if( empty( $this->data ) ) {
	
				$this->Session->setFlash('We could not identify one of more of the '.MEDIA.'s you are trying to restore.', 'default', array( 'class' => 'error' ) );
	
			} else {
	
				$associated_media = $this->PodcastItem->listAssociatedMedia( $this->data, '.' );
				
				if( is_array( $associated_media ) )
					$this->Api->renameFileMediaServer( $associated_media );
	
				// Soft delete the podcast
				$this->data['PodcastItem']['deleted'] = false;
				$this->PodcastItem->set( $this->data );
				$this->PodcastItem->save();

				if( $this->__generateRSSFeeds( $this->data['Podcast']['id'] ) == false ) {
					
					$this->Session->setFlash( ucfirst( MEDIA ).'(s) has been restored but we were unable to refresh the RSS feeds. If the problem persists please contact an administrator', 'default', array( 'class' => 'alert' ) );
				} else {
				
					$this->Session->setFlash('We successfully restored the '.MEDIA.'.', 'default', array( 'class' => 'success' ) );
				}
			}
		}
		
        $this->redirect( array( 'admin' => true, 'controller' => 'podcast_items', 'action' => 'index', $this->data['PodcastItem']['podcast_id'].'#tracks' ) );
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
