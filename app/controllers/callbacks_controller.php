<?php
class CallbacksController extends AppController {

	var $name = 'Callbacks';
	var $requires_meta_injection = array('deliver-without-transcoding','transcode-media-and-deliver');
	var $process_transcode = array('transcode-media-and-deliver','deliver-without-transcoding');
	var $deletion_request = array('delete-folder-on-media-server','delete-file-on-media-server');
	var $rss_refresh = array('transcode-media-and-deliver','deliver-without-transcoding');
	var $youtube = array('youtube-file-upload');
	
    /*
     * @name : beforeFilter
     * @description : The following methods can be accessed without logging in.
     * @updated : 2nd June 2010
     */
    function beforeFilter() {
        
        $this->Auth->allow( 'add' );
        parent::beforeFilter();
    }

	/*
	 * @name : 1st July 2011
	 * @description : This is the URL called by the Admin API. It processes the JSON encoded commands it receives.
	 * @updated : 23rd August 2011
	 * @by : Charles Jackson
	 */
	function add() {
		
		Configure::write('debug', '0');
		$this->layout='callback';
		$this->Callback->setData( file_get_contents("php://input") );
		$user = ClassRegistry::init( 'User' );
		$notification = ClassRegistry::init('Notification');
		$this->emailTemplates->__sendCallbackErrorEmail( array(), $this->Callback->data, 'Callback Alert' );
		
		// Is it a valid command
		if ( $this->Callback->understand() ) {
			
			$this->set('status', json_encode( array( 'status' => 'ACK', 'data '=> 'Message received', 'timestamp' => time() ) ) );

			// If we have transcoded media then we need to save the flavour and possibly update the processed state 
			if( in_array( $this->Callback->data['command'], $this->process_transcode ) ) {
					
				// Save the processed state
				if( isSet( $podcastItemMedia ) == false || is_object( $podcastItemMedia ) == false )
					$podcastItemMedia = ClassRegistry::init( 'PodcastItemMedia' );
					
				// We only trancode media 1 at a time but it is still wrapped in a for loop to give a generic structure to all
				// API payloads.				 								
				foreach( $this->Callback->data['data'] as $row ) {

					if( $podcastItemMedia->saveFlavour( $row ) == false ) {
						
						$notification->unableSaveFlavour( $podcastItemMedia->data, $row );
					}
				}
			}
			
			// Called when we are HARD DELETING a podcast or podcast item we must remove them from the database.
			if( in_array( $this->Callback->data['command'], $this->deletion_request ) )
				$this->Callback->processDeletions();
				
			// If we need to kick-off some meta injection do it here.
			if( in_array( $this->Callback->data['command'], $this->requires_meta_injection ) ) {
				// Needed to retrieve the meta data.
				if( is_object( $podcastItem ) == false )
					$podcastItem = ClassRegistry::init('PodcastItem');

				// Needed to retrieve the meta data.
				if( is_object( $podcastItemMedia ) == false )
					$podcastItemMedia = ClassRegistry::init('PodcastItemMedia');
				
				foreach( $this->Callback->data['data'] as $row ) {
					$this->emailTemplates->__sendCallbackErrorEmail( array(), strtolower($this->getExtension($row['destination_filename'])), 'MP3 injection' );
					if( ( $row['status'] == YES ) && strtolower($this->getExtension($row['destination_filename'])) == 'mp3') {
						// Use the data passed to the callback plus the recently retrieved meta data and send a call to the Api.						
					//	if( $podcastItem->needsInjection( $row['podcast_item_id'] ) ) {
							
							$this->Api->metaInject( $podcastItemMedia->buildMetaData( array( 'PodcastItemMedia.podcast_item' => $row['podcast_item_id'], 'PodcastItemMedia.media_type' => $row['flavour'] ) ) );
							
					//	}
 					}
				}
			}
			
			// If we have just attempted to upload a video to youtube process the result here.
			if( in_array( $this->Callback->data['command'], $this->youtube ) ) {
				
				// Needed to retrieve the meta data.
				if( is_object( $podcastItem ) == false )
					$podcastItem = ClassRegistry::init('PodcastItem');

				$podcastItem->recursive = -1;
				
				foreach( $this->Callback->data['data'] as $row ) {
					
					$this->data = $podcastItem->findById( $row['podcast_item_id'] );
					
					if( ( $row['status'] ) == YES ) {
						
						$this->data['PodcastItem']['youtube_id'] = $row['youtube_id'];
						$this->data['PodcastItem']['youtube_flag'] = YES;
						
					} else {
						
						$this->data['PodcastItem']['youtube_id'] = 	null;
						$this->data['PodcastItem']['youtube_flag'] = NO;
					}
					
					$podcastItem->set( $this->data );
					$podcastItem->save();
				}
			}
			
			if( in_array( $this->Callback->data['command'], $this->rss_refresh ) ) {
				$podcast = ClassRegistry::init( 'Podcast' );
				
				foreach( $this->Callback->data['data'] as $row ) {
					
					// Check it has not been (soft)deleted since it was transcoded
					if( $podcast->isDeleted( $row['podcast_id'] ) ) {
						
						// It have been deleted, hard delete the new media regardless of whether the parent
						// has been soft or hard deleted. It has been deleted!
						$this->Api->deleteFileOnMediaServer( 
							array(
								'source_path' => $row['destination_path'],
								'source_filename' => $row['destination_filename'],  
								'destination_path' => $row['destination_path'],
								'destination_filename' => $row['destination_filename']
							)
						);
					
					} else {
						// We generate new RSS feeds by calling the URL in background ( redirecting all output to "/dev/null 2>&1" ).
						if( isSet( $row['flavour'] ) && !empty( $row['flavour'] ) ) {
	
							shell_exec("curl ".APPLICATION_URL.'/feeds/add/'.$row['podcast_id'].'/'.$row['flavour']." > /dev/null &");
	
						} else {
	
							shell_exec("curl ".APPLICATION_URL.'/feeds/add/'.$row['podcast_id']." > /dev/null &");
						}
					}
				}
			}

		} else {
			
			$notification->malformedData( $this->Callback->json );
			$this->set('status', json_encode( array( 'status'=>'NACK', 'data'=>'Message received but I dont understand what it means', 'timestamp'=>time() ) ) );
		}
	}
	
	/*
	 * @name : delete_folders
	 * @description : Will delete any folders older than 1 hour
	 * @updated : 22nd September 2011
	 * @name : Charles Jackson
	 */
	function delete_folders( $path = FILE_REPOSITORY, $level = 0 ) { 
	
		$this->autoRender = false;
		$this->Folder->cleanUp( $path, $level );
        $this->Session->setFlash('Folder has been successfully cleaned.', 'default', array( 'class' => 'success' ) );
		
		$this->redirect( array( 'admin' => false, 'controller' => 'users', 'action' => 'dashboard' ) );
	}
}
?>
