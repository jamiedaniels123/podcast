<?php
class CallbacksController extends AppController {

	var $name = 'Callbacks';
	var $requires_local_deletion = array('transcode-media','transfer-file-to-media-server', 'transfer-folder-to-media-server','deliver-without-transcoding');
	var $requires_meta_injection = array('deliver-without-transcoding');
	var $process_transcode = array('transcode-media-and-deliver','deliver-without-transcoding');
	var $deletion_request = array('delete-folder-on-media-server','delete-file-on-media-server');
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
	 * @description :
	 * @updated :
	 * @by : Charles Jackson and Jamie Daniels
	 */
	function add() {
		
		$this->layout='callback';
		$this->Callback->setData(file_get_contents("php://input"));
		$user = ClassRegistry::init('User');
		$this->emailTemplates->__sendCallbackErrorEmail( $user->getAdministrators(), $this->Callback->data, 'Callback Alert' );
		
		// Is it a valid command
		if ( $this->Callback->understand() ) {
			
			$this->set('status', json_encode( array( 'status'=>'ACK', 'data'=>'Message received', 'timestamp' => time() ) ) );

			if( $this->Callback->hasErrors() )
				$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$this->Callback->data,'This callback has errors, see information below as received from the Admin API');
				
			// If we have transcoded media then we need to save the flavour and possibly update the processed state 
			if( in_array( $this->Callback->data['command'], $this->process_transcode ) ) {
					
				// Save the processed state
				if( is_object( $podcastItemMedia ) == false )
					$podcastItemMedia = ClassRegistry::init('PodcastItemMedia');
					
				// We only trancode media 1 at a time but it is still wrapped in a for loop to give a generic structure to all
				// API payloads.				 								
				foreach( $this->Callback->data['data'] as $row ) {
					
					// A function created during the development stages to ernssure the API is giving a valid response
					if( $this->Callback->malformed($row, 'transcode' ) ) {
						
						$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$row,'The Admin API has returned malformed data row. See row below :');
						
					} else {
						
						if( $podcastItemMedia->saveFlavour( $row ) == false )
							$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$podcastItemMedia->data,'Could not save a newly transcoded flavour of media, see debug information from the Podcast Admin Server');
							
					}
					
					$this->Folder->cleanUp( $row['source_path'],$row['original_filename'] );
				}
			}
			
			// Called when we are HARD DELETING a podcast or podcast item we must remove them from the database.
			if( in_array( $this->Callback->data['command'], $this->deletion_request ) ) {
				
				$this->Callback->processDeletions();
			}			
				
			// Does the API command signify a need to delete a local file structure?
			if( in_array( $this->Callback->data['command'], $this->requires_local_deletion ) ) {

				foreach( $this->Callback->data['data'] as $row ) {

					$this->Folder->cleanUp( $row['source_path'],$row['source_filename'] );
				}
			}
			
			// If we need to kick-off some meta injection do it here.
			if( in_array( $this->Callback->data['command'], $this->requires_meta_injection ) ) {

				// Needed to retrieve the meta data.
				if( is_object( $podcastItem ) == false )
					$podcastItem = ClassRegistry::init('PodcastItem');

				// Needed to retrieve the meta data.
				if( is_object( $podcastItemMedia ) == false )
					$podcastItemMedia = ClassRegistry::init('PodcastItemMedia');
				
				foreach( $this->Callback->data['data'] as $row ) {
					
					if( ( $row['status'] == YES ) ) {

						// Use the data passed to the callback plus the recently retrieved meta data and send a call to the Api.						
						if( $podcastItem->needsInjection( $row['podcast_item_id'] ) ) {
							
							$this->emailTemplates->__sendCallbackErrorEmail( $user->getAdministrators(), $row,'Injecting meta data');							
							
							if( $this->Api->metaInject( $podcastItemMedia->buildMetaData( array( 'PodcastItemMedia.podcast_item' => $row['podcast_item_id'], 'PodcastItemMedia.media_type' => $row['flavour'] ) ) ) == false )
								$this->emailTemplates->__sendCallbackErrorEmail( $user->getAdministrators(), $row,'Error injecting meta data');
						}
 					}
				}
			}
			
			// If we have just attempted to upload a video to youtube process the result here.
			if( in_array( $this->Callback->data['command'], $this->youtube ) ) {
				
				// Needed to retrieve the meta data.
				if( is_object( $podcastItem ) == false )
					$podcastItem = ClassRegistry::init('PodcastItem');

				$this->data = $podcastItem->findById( $this->Callback->data['data'][0]['podcast_item_id'] );
				if( ( $this->Callback->data['data'][0]['status'] ) == YES ) {
					
					$this->data['PodcastItem']['youtube_id'] = $this->Callback->data['data'][0]['youtube_id'];
					
				} else {
					
					$this->data['PodcastItem']['youtube_id'] = 	null;
					$this->data['PodcastItem']['youtube_flag'] = NO;
					$this->emailTemplates->__sendCallbackErrorEmail( $user->getAdministrators(), $row,'Error youtube upload/refresh. Please see data from Admin API bellow.');					
				}
				
				$podcastItem->set( $this->data );
				$podcastItem->save();
			}

		} else {
			
			$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$this->Callback->data,'Failed to understand command');
			$this->set('status', json_encode( array( 'status'=>'NACK', 'data'=>'Message received but I dont understand what it means', 'timestamp'=>time() ) ) );
		}
	}
}
?>
