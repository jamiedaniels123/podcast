<?php

class PodcastsController extends AppController {

    var $name = 'Podcasts';
    var $components = array( 'Upload' );
    private $errors = array();
    var $html = null; // Used to store errors created by the images component.
    
    var $paginate = array( 'limit' => 20, 'page' => 1, 'order' => 'Podcast.id DESC' );

    function beforeFilter() {
    	
    	$this->Podcast->stripJoinsByAction( $this->action );
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
     * @name : index
     * @desscription : Displays a paginated list of all podcasts that are owned by the current user.
     * @name : Charles Jackson
     * @by : 16th May 2011
     */
    function index() {

        $id_numbers = array();
        

        // Have they posted the filter form?
        if( isSet( $this->data['Podcast']['filter'] ) ) {
        	
	        $this->set('search_criteria', $this->data['Podcast']['search'] );
	        $this->set('filter', $this->data['Podcast']['filter'] );
        	
        } else {
        	
	        $this->set('search_criteria', null );
	        $this->set('filter', null );
        }
            
        $id_numbers = $this->Podcast->getUserPodcasts( $this->Session->read('Auth.User.id'), $this->data['Podcast'] );

		$this->Podcast->recursive = 1;
        $this->data['Podcasts'] = $this->paginate('Podcast', array('Podcast.id' => $id_numbers ) );

    }

    /*
     * @name : itunes_index
     * @desscription : Displays a paginated list of all podcasts that are itunes related.
     * @name : Charles Jackson
     * @by : 8th July 2011
     */
    function itunes_index() {

		$this->Podcast->recursive = 2;
		
		if( !isSet( $this->data['Podcast']['filter'] ) || empty( $this->data['Podcast']['filter'] ) ) {
			
			$this->data['Podcast']['filter'] = 'published';
		}	
		
		$this->set('filter',$this->data['Podcast']['filter'] );
		$this->data['Podcasts'] = $this->paginate('Podcast', $this->Podcast->buildiTunesFilters( $this->data['Podcast']['filter'] ) );
    }

    /*
     * @name : youtube_index
     * @desscription : Displays a paginated list of all podcasts that are youtube related.
     * @name : Charles Jackson
     * @by : 8th July 2011
     */
    function youtube_index() {

		$this->Podcast->recursive = 2;
		
		if( !isSet( $this->data['Podcast']['filter'] ) || empty( $this->data['Podcast']['filter'] ) ) {

			$this->data['Podcast']['filter'] = 'published';
		}	
		
		// Grab the filter and assign to the view so the select box retains the current selection
		$this->set('filter', $this->data['Podcast']['filter'] );

		// We are looking for "intended" or "published" therefore paginate as listing will be very long
		$this->data['Podcasts'] = $this->paginate('Podcast', $this->Podcast->buildYoutubeFilters( $this->data['Podcast']['filter'] ) );
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

			$data = array();
			$data = $this->data;
			
            // Assign the podcast to the current user is they have not chosen one.
            if( empty( $this->data['Podcast']['owner_id'] ) )
				$this->data['Podcast']['owner_id'] = $this->Session->read('Auth.User.id');
				
            $this->data['Podcast']['private'] = YES;
			
            $this->Podcast->set( $this->data['Podcast'] );

            if( $this->Podcast->save() ) {

				$data['Podcast']['custom_id'] = $this->Podcast->getLastInsertId() . '_' . $this->Podcast->buildSafeFilename( $data['Podcast']['title'] );

				$data['Podcast']['id'] = $this->Podcast->getLastInsertId();
				
				$this->Podcast->data = $data;
				
				// Create the PodcastModerators that are saved using a hasMany relationship.
				$this->Podcast->createPodcastModerators();
				// Create the ModeratorUserGroups that are saved using a hasMany relationship.
				$this->Podcast->createModeratorUserGroups();

				$this->Podcast->saveAll();

                $this->redirect( array( 'action' => 'view', $this->Podcast->getLastInsertId() ) );

            } else {

                // Rebuild the dynamic select boxes according to the users current selections else they will merely display ID numbers.
                $this->data = $this->Podcast->rebuild( $this->data );

                $this->errors = $this->Podcast->invalidFields( $this->data );
                $this->Session->setFlash('Could not create your collection. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }
        }
        
        // Need to retrieve form options such as additional users and catagories etc... on the system.
        $this->__setPodcastFormOptions();
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

            $this->Podcast->begin(); // begin a transaction so we may rollbaack if anything fails.
            
            $this->Podcast->data = $this->data;

            // Delete any existing relationships
            $this->Podcast->deleteExistingAssociations();

            // Create the PodcastModerators that are saved using a hasMany relationship.
            $this->Podcast->createPodcastModerators();
            // Create the ModeratorUserGroups that are saved using a hasMany relationship.
            $this->Podcast->createModeratorUserGroups();
            // Set the preferred node to equal the first node chosen.
            $this->Podcast->setPreferredNode();
            // Set the preferred category to equal the first node chosen.
            $this->Podcast->setPreferredCategory();
            // Set the preferred itunesu category to equal the first node chosen.
            $this->Podcast->setPreferredItunesuCategory();

            if(  $this->__updateImages() && $this->Podcast->validates( $this->Podcast->data ) ) {

                // OK, it validates but have they changed/confirmed ownership.
                if( $this->Podcast->unconfirmedChangeOfOwnership() ) {

                    $this->data['Podcast']['confirmed'] = true;
                    $this->Session->setFlash('You are changing ownership of this podcast. Submit again to confirm the change.', 'default', array( 'class' => 'alert' ) );

                } else {

                    // Generate the RSS Feeds.
                    if( $this->__generateRSSFeeds( $this->Podcast->data['Podcast']['id'] )  == false ) {
                        
                        $this->Session->setFlash('We were unable to generate the RSS feeds. If the problem continues please alert an administrator', 'default', array( 'class' => 'error' ) );
						
					} elseif( ( $this->Folder->buildHtaccessFile( $this->Podcast->data ) == false ) || ( $this->Api->transferFileMediaServer( 
					
						array( 
							'source_path' => $this->Podcast->data['Podcast']['custom_id'].'/',
							'destination_path' => $this->Podcast->data['Podcast']['custom_id'].'/', 
							'filename' => '.htaccess' 
							)
						) ) == false ) {		
						
							$this->Session->setFlash('We were unable to generate the associated permissions. If the problem persists please alert an administrator', 'default', array( 'class' => 'error' ) );
						
					} else {
						
						$this->Podcast->set( $this->Podcast->data );

						$this->Podcast->saveAll();

						$this->Podcast->commit(); // Everything hunky dory, commit the changes.
						$this->Session->setFlash('Your collection has been successfully updated.', 'default', array( 'class' => 'success' ) );

						$this->Podcast->recursive = 2; // Increase the recursive level so we retrieve enough information to check permissions.
						$this->data = $this->Podcast->findById( $this->Podcast->id );
						
						// They may no longer have permision to view this podcast if they have changed ownership, therefore double-check.
						if( $this->Permission->toView( $this->data ) ) {

							$this->redirect( array( 'action' => 'view', $this->data['Podcast']['id'] ) );
							exit;

						} else {

							$this->redirect( array( 'action' => 'index') );
							exit;
						}
					}
                }
                
            } else {
            	
				$this->Session->setFlash('Could not update your collection. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }

            $this->Podcast->rollback();
            // Rebuild the dynamic select boxes according to the users current selections else they will merely display ID numbers.
            $this->data = $this->Podcast->rebuild();
            $this->errors = $this->Podcast->invalidFields( $this->data );
            // We explicitly set confirmed to false incase they have confirmed/failed validation in a single post (silly billy).
            $this->data['Podcast']['confirmed'] == false;


        } else {

            $this->data = $this->Podcast->findById( $id );

            // We did not find the podcast, redirect.
            if( empty( $this->data ) || $this->Permission->toUpdate( $this->data ) == false ) {

                $this->Session->setFlash('Could not find your collection. Please try again.', 'default', array( 'class' => 'error' ) );
                $this->cakeError('error404');

            } else {
                
                // We need to track is the ownership changes so make a note here and the original owner with be passed as a
                // hidden form element.
                $this->data['Podcast']['current_owner_id'] = $this->data['Podcast']['owner_id'];
            }
        }
		
        // Need to retrieve form options such as additional users and catagories etc... on the system.
        $this->__setPodcastFormOptions();
    }

    /*
     * @name : delete
     * @desscription : Enables a user to perform a soft delete on a podcast and the associated media if they are the current owner.
     * @todo : Very inefficient, making a call for every deletion. Should be refactored.
     * @name : Charles Jackson
     * @by : 19th May 2011
     */
    function delete( $id = null ) {

        $this->autoRender = false;
        $this->recursive = -1;
		$data = array();
		
        // This method is used for individual deletes and deletions via the form posted checkbox selection. Hence
        // when somebody is deleting an individual podcast we pass into an array and loop through as is the data
        // was posted.
        if( $id )
            $this->data['Podcast']['Checkbox'][$id] = true;

        foreach( $this->data['Podcast']['Checkbox'] as $key => $value ) {

            $podcast = $this->Podcast->find('first', array( 'conditions' => array( 'Podcast.id' => $key ) ) );
            
            if( !empty( $podcast ) ) {

				if( ( $this->Object->intendedForPublication( $podcast['Podcast'] ) == false ) && $this->Permission->isOwner( $podcast['Podcast']['owner_id'] ) ) {
					
					// We only perform a soft delete hence we write a .htaccess file that will produce a "404 - Not Found" and transfer to media server.
					if( $this->Folder->buildHtaccessFile( $podcast ) && $this->Api->transferFileMediaServer( $this->Podcast->softDelete( $podcast ) ) ) { 
					
						// Delete the podcast
						$podcast['Podcast']['deleted'] = true;
						$this->Podcast->set( $podcast ); // Hydrate the object
						$this->Podcast->save();
							
						$this->Session->setFlash('We successfully deleted the podcast and all associated media.', 'default', array( 'class' => 'success' ) );

					} else {
						
						$this->Folder->cleanup( $podcast['Podcast']['custom_id'].'/','.htaccess' );
						$this->Session->setFlash('We could not delete all associated media. If the problem persists please alert an administrator.', 'default', array( 'class' => 'error' ) );
						break; // Break out of the loop
					}
					
				} else {
					
					$this->Session->setFlash('Cannot delete collections that are intended for publication on iTunes or Youtube or that you do not own.', 'default', array( 'class' => 'alert' ) );
					break; // Break out of the loop
				}
			}
        }
        
        $this->redirect( array( 'controller' => 'podcasts', 'action' => 'index' ) );
    }

    /*
     * @name : status
     * @description : Enables a user to set the status of a collection for any channel. The options include
     * "consider for channel", "intended on channel" and "published on channel".
     * @updated : 1st August 2011
     * @by : Charles Jackson
     */
    function status( $media = null, $consider = 0, $intended = 'N', $publish = 'N', $id = null ) {

    	$this->Podcast->recursive = -1;
    	$this->data = $this->Podcast->findById( $id );
    	
    	if( !empty( $this->data ) && $this->Permission->statusUpdate( $media, $consider, $intended, $publish ) ) {
    	
    		if( strtoupper( $media ) == 'ITUNES' ) {
				
    			$this->data['Podcast']['consider_for_itunesu'] = $consider;
    			$this->data['Podcast']['intended_itunesu_flag'] = $intended;
    			$this->data['Podcast']['publish_itunes_u'] = $publish;
    			
    			if( strtoupper( $publish ) == YES ) {
					
					$this->data['Podcast']['publish_itunes_date'] = date('Y-m-d');
					
				} else {
					
					$this->data['Podcast']['publish_itunes_date'] = null;
				}
    			
    			$this->Session->setFlash('You have successfully updated this collection.', 'default', array( 'class' => 'success' ) );	
    			
    		} elseif( strtoupper( $media ) == 'YOUTUBE' ) {


    			$this->data['Podcast']['consider_for_youtube'] = $consider;
    			$this->data['Podcast']['intended_youtube_flag'] = $intended;
    			$this->data['Podcast']['publish_youtube'] = $publish;
    			
    			if( strtoupper( $publish ) == YES ) {
					
					$this->data['Podcast']['publish_youtube_date'] = date('Y-m-d');
					
				} else {
					
					$this->data['Podcast']['publish_youtube_date'] = null;
				}

				$this->Session->setFlash('You have successfully updated this collection.', 'default', array( 'class' => 'success' ) );	
				
    		} else {
    		
				$this->Session->setFlash('We could not identify the channel status you are attempting to update. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );	
			}
			
    		$this->Podcast->set( $this->data );
    		$this->Podcast->save();
    		
    	} else {
    		
    		$this->Session->setFlash('We could not update this collection. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );	
    	}
    	
    	$this->redirect( array( 'action' => 'view', $id ) );
    }

    /*
     * @name : copy
     * @description : Will make a copy of a podcast and all associated media and if successfull send a request to the API.
     * @updated : 26th July 2011
     * @by : Charles Jackson
     */ 
    function copy( $id = null ) {
		
		$this->data = $this->Podcast->findById( $id ) ;
		
		if( !empty( $this->data ) ) {
			
			$this->Podcast->data = $this->data;
			
			if( $this->Podcast->copy() ) {
				
				$this->__generateRSSFeeds( $this->Podcast->data['Podcast']['id'] );
				$this->Session->setFlash('The collection has been successfully copied.', 'default', array( 'class' => 'success' ) );
				$this->redirect( array( 'action' => 'view', $this->Podcast->data['Podcast']['id'] ) );
			}
		}
		
		$this->Session->setFlash('We could not copy your chosen collection. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
		$this->redirect( $this->referer() );
	}

    /*
     * ADMIN FUNCTIONALITY
     * Below this line are the administration functionality that can only be reach if the flag 'administrator' is set to true on the
     * users profile (see app_controller). The URL for all admin routes is "admin/:controller:/:action:/*
     */
    
    /*
     * @name : admin_index
     * @desscription : Displays a paginated list of all podcasts currently on the system.
     * @name : Charles Jackson
     * @by : 4th May 2011
     */
    function admin_index() {

        unset( $this->Podcast->hasOne['UserPodcast'] );

        // Have they posted the filter form?
        if( isSet( $this->data['Podcast']['filter'] ) ) {

            $conditions = $this->Podcast->buildFilters( $this->data['Podcast'] );
            $this->data['Podcasts'] = $this->paginate('Podcast', $conditions );
	        $this->set('search_criteria', $this->data['Podcast']['search'] );
	        $this->set('filter', $this->data['Podcast']['filter'] );

        } else {

            // Create a null PodcastFilter to prevent an unwanted notice in the view
	        $this->set('search_criteria', null );
	        $this->set('filter', null );
            $this->data['Podcasts'] = $this->paginate('Podcast', array( 'Podcast.deleted !=' => 2 ) );
        }
    }


    /*
     * @name : admin_add
     * @description : Displays a form that enables administrators to add a row to the podcasts table. If the form is
     * populated it will validate the data and save if possible.
     * @name : Charles Jackson
     * @by : 5th May 2011
     */
    function admin_add() {

        if ( !empty( $this->data ) ) {

            // Assign the podcast to the current user.
            $this->data['Podcast']['owner_id'] = $this->Session->read('Auth.User.id');
            $this->data['Podcast']['private'] = YES; // Default to private.

            $this->Podcast->set( $this->data ); // Hydrate the object.

            if( $this->Podcast->save() ) { 

				$this->data['Podcast']['custom_id'] = $this->Podcast->getLastInsertId().'_'.$this->Podcast->buildSafeFilename( $this->data['Podcast']['title'] );
	            $this->Podcast->save( $this->data );
                
                $this->redirect( array( 'action' => 'admin_view', $this->Podcast->getLastInsertId() ) );

            } else {

                // Rebuild the dynamic select boxes according to the users current selections else they will merely display ID numbers.
                $this->data = $this->Podcast->rebuild( $this->data );

                $this->errors = $this->Podcast->invalidFields( $this->data );
                $this->Session->setFlash('Could not create your collection. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }
        }
        
        // Need to retrieve form options such as additional users and catagories etc... on the system.
        $this->__setPodcastFormOptions();
        
    }

    /*
     * @name : admin_view
     * @desscription : Enables an adminitrator to view details of an individual podcast.
     * @name : Charles Jackson
     * @by : 20th May 2011
     */
    function admin_view( $id = null ) {
		
    	$this->Podcast->recursive = 2;
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

        $this->Podcast->recursive = 2;
        
        if ( !empty( $this->data ) ) {

            $this->Podcast->begin(); // begin a transaction so we may rollbaack if anything fails.
            
            $this->Podcast->data = $this->data;

            // Delete any existing associations
            $this->Podcast->deleteExistingAssociations();
            // Create the PodcastModerators that are saved using a hasMany relationship.
            $this->Podcast->createPodcastModerators();
            // Create the ModeratorUserGroups that are saved using a hasMany relationship.
            $this->Podcast->createModeratorUserGroups();
            // Set the preferred node to equal the first node chosen.
            $this->Podcast->setPreferredNode();
            // Set the preferred category to equal the first node chosen.
            $this->Podcast->setPreferredCategory();
            // Set the preferred itunesu category to equal the first node chosen.
            $this->Podcast->setPreferredItunesuCategory();

            if(  $this->__updateImages() && $this->Podcast->validates( $this->Podcast->data ) ) {

                // OK, it validates but have they changed/confirmed ownership.
                if( $this->Podcast->unconfirmedChangeOfOwnership() ) {

                    $this->data['Podcast']['confirmed'] = true;
                    $this->Session->setFlash('You are changing ownership of this podcast. Submit again to confirm the change.', 'default', array( 'class' => 'alert' ) );

                } else {

                    // Generate the RSS Feeds.
                    if( $this->__generateRSSFeeds( $this->data['Podcast']['id'] )  == false ) {
                        
                        $this->Session->setFlash('We were unable to generate the RSS feeds. If the problem continues please alert an administrator', 'default', array( 'class' => 'error' ) );
						
					} elseif( ( $this->Folder->buildHtaccessFile( $this->Podcast->data ) == false ) || ( $this->Api->transferFileMediaServer( 
					
						array( 
							'source_path' => $this->Podcast->data['Podcast']['custom_id'].'/',
							'destination_path' => $this->Podcast->data['Podcast']['custom_id'].'/', 
							'filename' => '.htaccess' 
							)
						) ) == false ) {		
						
							$this->Session->setFlash('We were unable to generate the necessary .htaccess permissions. If the problem persists please alert an administrator', 'default', array( 'class' => 'error' ) );
						
					} else {
						
						$this->Podcast->set( $this->Podcast->data );
						$this->Podcast->saveAll();
						$this->Podcast->commit(); // Everything hunky dory, commit the changes.
						$this->Session->setFlash('Your collection has been successfully updated.', 'default', array( 'class' => 'success' ) );

						$this->Podcast->recursive = 2; // Increase the recursive level so we retrieve enough information to check permissions.
						$this->data = $this->Podcast->findById( $this->Podcast->id );
						
						$this->redirect( array( 'action' => 'view', $this->data['Podcast']['id'] ) );
						exit;
					}
                }
                
            } else {
            	
				$this->Session->setFlash('Could not update your collection. Please see issues listed below.', 'default', array( 'class' => 'error' ) );
            }

            $this->Podcast->rollback();
            // Rebuild the dynamic select boxes according to the users current selections else they will merely display ID numbers.
            $this->data = $this->Podcast->rebuild();
            $this->errors = $this->Podcast->invalidFields( $this->data );
            // We explicitly set confirmed to false incase they have confirmed/failed validation in a single post (silly billy).
            $this->data['Podcast']['confirmed'] == false;


        } else {

            $this->data = $this->Podcast->findById( $id );

            // We did not find the podcast, redirect.
            if( empty( $this->data ) ) {

                $this->Session->setFlash('Could not find your collection. Please try again.', 'default', array( 'class' => 'error' ) );
                $this->cakeError('error404');

            } else {
                
                // We need to track is the ownership changes so make a note here and the original owner with be passed as a
                // hidden form element.
                $this->data['Podcast']['current_owner_id'] = $this->data['Podcast']['owner_id'];
            }
        }
		
        // Need to retrieve form options such as additional users and catagories etc... on the system.
        $this->__setPodcastFormOptions();
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
        $podcasts_for_deletion = array();

        // This method is used for individual deletes and deletions via the form posted checkbox selection. Hence
        // when somebody is deleting an individual podcast we pass into an array and loop through as if the data
        // was posted via a form.
        if( $id )
            $this->data['Podcast']['Checkbox'][$id] = true;

        foreach( $this->data['Podcast']['Checkbox'] as $key => $value ) {

            $podcast = $this->Podcast->findById( $key );
        
            // Did we find the podcast else, ignore.
            if( !empty( $podcast ) ) {

            	$podcasts_for_deletion[] = array( 
					'source_path' => $podcast['Podcast']['custom_id'].'/',
            		'collection_deletion' => 1
				);
            	
                // Set the podcast deleted flag to "2" signifying scheduled with Api
                $podcast['Podcast']['deleted'] = 2;
                $this->Podcast->set( $podcast );
                $this->Podcast->save();
			}
        }
        
		// Schedule a hard delete of these podcasts
		if( $this->Api->deleteFolderOnMediaServer( $podcasts_for_deletion ) ) {
			
			$this->Session->setFlash('We have successfully scheduled these collections for deletion.', 'default', array( 'class' => 'success' ) );
			$this->Podcast->commit();
			
		} else {
			
			$this->Session->setFlash('We have been unable to schedule these collections for deletion. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
			$this->Podcast->rollback();
		}
		
        $this->redirect( array( 'admin' => true, 'controller' => 'podcasts', 'action' => 'index' ) );
    }

    /*
     * @name : admin_restore
     * @description : Will update the value of the 'deleted' column on any podcast to zero therefore restoring the
     * collection.
     * @updated : 1st June 2011
     * @by : Charles Jackson
     */
    function admin_restore( $id = null ) {

        $this->autoRender = false;
        $this->data = $this->Podcast->findById( $id );

        if( empty( $this->data ) ) {

            $this->Session->setFlash('We could not identify the collection you are trying to restore.', 'default', array( 'class' => 'error' ) );

        } else {


			$this->data['Podcast']['deleted'] = false;
			$this->Podcast->set( $this->data ); // Hydrate the object
			$this->Podcast->save();

			// The file has only been 'soft' deleted by writing a .htaccess file. To retrore the file we merely delete the .htaccess
            // We only perform a soft delete hence we write a .htaccess file that will produce a "404 - Not Found" and transfer to media server.
            if( $this->Folder->buildHtaccessFile( $this->data ) && $this->Api->transferFileMediaServer( $this->Podcast->softDelete( $this->data ) ) ) {
				
                $this->Session->setFlash('We successfully restored the collection and all associated media.', 'default', array( 'class' => 'success' ) );

            } else {

                $this->Session->setFlash('We were unable to restore the collection. Please try again.', 'default', array( 'class' => 'error' ) );
            }
        }

        $this->redirect( $this->referer() );
    }
	
	/*
	 * @name : delete_image
	 * @description : Enables peeps to delete a podcast image from the media server.
	 * @updated : 28th June 2011
	 * @by : Charles Jackson
	 */
	function delete_image( $image_type, $id ) {
		
		$this->data = $this->Podcast->findById( $id );
		
		if( empty( $this->data ) || empty( $this->data['Podcast'][$image_type] ) ) {
			
			$this->Session->setFlash('We were unable to identify the image you are trying to delete. Please try again.', 'default', array( 'class' => 'error' ) );
			
		} else { 
		
			// Now we must delete the images from the media server.
			if( $this->Api->deleteFileOnMediaServer( $this->Podcast->deleteImages( $this->data['Podcast'], $image_type ) ) ) {
				
				// We have successfully scheduled the image for deletion, now update the row on the podcasts table.
				$this->data['Podcast'][$image_type] = null;
				$this->Podcast->set( $this->data );
				$this->Podcast->save();
				$this->Session->setFlash('Podcast image successfully deleted.', 'default', array( 'class' => 'success' ) );
				
			} else {

				$this->Session->setFlash('We were unable to schedule deletion of the file with the media server. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
				
			}
		}
			
		$this->redirect( $this->referer() );		
	}

    // PRIVATE METHODS
    // Below this line are methods that can only be called by another controller method "__". They exploit various components 
	// that are more elegantly accessed via the controller hence I have left them here. Not a perfect world!

    /*
     * @name : __updateImages
     * @description : Internal method called by the add and edit methods, both user and administrator.
     * @updated : 9th May 2011
     * @by : Charles Jackson
     */
    protected function __updateImages() {
    	
    	$statusOK = true;
    	
        // Try to upload the associated images and transfer to the media server. If successful the upload component will return the name
        // of the uploaded file else it will return false.
        if( $this->Upload->podcastImage( $this->Podcast->data, 'new_image' ) ) {
			
			$this->Podcast->data['Podcast']['image'] = $this->Upload->getUploadedFileName();
			
		} else {
			
			unset( $this->Podcast->data['Podcast']['new_image'] );
			
        	if( $this->Upload->hasError() ) {
        		$this->Podcast->invalidate('image', $this->Upload->getError() );
        		$statusOK = false;
        	}
		}

        if( $this->Upload->logolessPodcastImage( $this->Podcast->data, 'new_image_logoless' ) ) {
			
			$this->Podcast->data['Podcast']['image_logoless'] = $this->Upload->getUploadedFileName();
			
		} else {
			
			unset( $this->Podcast->data['Podcast']['new_image_logoless'] );
			
        	if( $this->Upload->hasError() ) {
        		$this->Podcast->invalidate('image_logoless', $this->Upload->getError() );
        		$statusOK = false;
        	}
		}
		
        if( $this->Upload->widePodcastImage( $this->Podcast->data, 'new_image_wide' ) ) {
			
			$this->Podcast->data['Podcast']['image_wide'] = $this->Upload->getUploadedFileName();
			
		} else {
			
			unset( $this->Podcast->data['Podcast']['new_image_wide'] );
			
        	if( $this->Upload->hasError() ) {
        		$this->Podcast->invalidate('image_wide', $this->Upload->getError() );
        		$statusOK = false;
        	}
		}
    	
        return $statusOK;
    }

    /*
     * @name : __generateRSSFeeds
     * @description : Will retrieve the podcast passed as an ID and try to generate RSS feeds if needed. Returns a bool.
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    protected function __generateRSSFeeds( $id = null ) {

        $podcast = null;

        $this->Podcast->recursive = -1; // Minimise the amount of data we retrieve.
        $podcast = $this->Podcast->findById( $id );

        if( empty( $podcast ) )
            return false;

        if( $podcast['Podcast']['podcast_flag'] == true ) {

            // Generate the RSS Feeds by calling the "/feeds/add/*ID*" URL.
            $this->requestAction( array('controller' => 'feeds', 'action' => 'add'), array('id' => $podcast['Podcast']['id'] ) );
        }

        return true; // No RSS Feed needed so return a default of true to signify everything OK.
    }

    /*
     * @name : __setPodcastFormOptions
     * @description : Called prior to various methods when the user can update a podcast. This method will sanatize data prior to being
     * shown on a form such as retrieving all users on the system as a list for possible membership of a podcast then removing any people
     * that are already members of the aforementioned podcast.
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    protected function __setPodcastFormOptions() {

        // Get all the nodes
        $Node = ClassRegistry::init('Node');
        $nodes = $Node->find('list', array( 'order' => 'Node.title' ) );
        $nodes = $Node->removeDuplicates( $nodes, $this->data, 'Nodes' );
        $this->set('nodes', $nodes );

        // Get all the categories
        $Category = ClassRegistry::init('Category');
        $categories = $Category->find('list', array( 'fields' => array('Category.id', 'Category.category'), 'order' => array('Category.category') ) );
        $categories = $Category->removeDuplicates( $categories, $this->data, 'Categories' );
        $this->set('categories', $categories );

        // Get all the itunes categories
        $ItunesuCategory = ClassRegistry::init('ItunesuCategory');
        $itunesu_categories = $ItunesuCategory->find('list', array( 'fields' => array('ItunesuCategory.id', 'ItunesuCategory.code_title'), 'order' => array('ItunesuCategory.code_title') ) );
        $itunesu_categories = $ItunesuCategory->removeDuplicates( $itunesu_categories, $this->data, 'iTuneCategories' );
        $this->set('itunes_categories', $itunesu_categories );

        // Get all the languages
        $Language = ClassRegistry::init('Language');
        $this->set('languages', $Language->find('list', array( 'fields' => array('Language.lang_code', 'Language.language'), 'order' => 'Language.language' ) ) );

        // Get all the user groups
        $UserGroup = ClassRegistry::init('UserGroup');
        $user_groups = $UserGroup->find('list', array( 'fields' => array('UserGroup.id', 'UserGroup.group_title'), 'order' => array('UserGroup.group_title') ) );
        $user_groups = $UserGroup->removeDuplicates( $user_groups, $this->data, 'MemberGroups' );

        $user_groups = $UserGroup->removeDuplicates( $user_groups, $this->data, 'ModeratorGroups' );

        $this->set('user_groups', $user_groups );

        // Get all the users
        $User = ClassRegistry::init( 'User' );
        $users = $User->find( 'list', array( 'fields' => array( 'User.id', 'User.full_name' ), 'order' => 'User.full_name ASC' ) );
        $users = $User->removeDuplicates( $users, $this->data, 'Members' );
        $users = $User->removeDuplicates( $users, $this->data, 'Moderators' );
        $users = $User->removeDuplicates( $users, $this->data, 'Owner' );

        $this->set('users', $users );
		// Used to generate a list of possible users that can be assigned ownership.
        $this->set('all_users', $User->find('list', array( 'fields' => array('User.id', 'User.full_name' ), 'order' => 'User.full_name ASC' ) ) );
        
        $YoutubeChannel = ClassRegistry::init('YoutubeChannel');
        $youtube_channels = $YoutubeChannel->find( 'list', array( 'fields' => array( 'YoutubeChannel.id', 'YoutubeChannel.title' ) ) );
        $this->set('youtube_channels', $youtube_channels );

        // Set the possible values of explicit
        $this->set( 'explicit', array( 'clean' => 'clean', 'no' => 'no', 'yes' => 'yes' ) );
    }
}
