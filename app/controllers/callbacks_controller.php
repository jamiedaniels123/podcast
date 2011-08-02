<?php
class CallbacksController extends AppController {

	var $name = 'Callbacks';
	var $requires_local_deletion = array('transcode-media','transcode-media-and-deliver','transfer-file-to-media-server', 'transfer-folder-to-media-server','deliver-without-transcoding');
	var $requires_meta_injection = array('transcode-media-and-deliver','deliver-without-transcoding');
	var $processed_state_update = array('transcode-media-and-deliver','deliver-without-transcoding');
	var $deletion_request = array('delete-folder-on-media-server','delete-file-on-media-server');
	
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
		//$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),json_decode(file_get_contents("php://input")),'Callback Alert');
		// Is it a valid command
		if ( $this->Callback->understand() ) {
			
			$this->set('status', json_encode( array('status'=>'ACK', 'data'=>'Message received', 'timestamp'=>time() ) ) );

			if( $this->Callback->hasErrors() )
				$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$row,'This callback has errors');
				
			// Do we need to update the processed state
			if( in_array( $this->Callback->data['command'], $this->processed_state_update ) ) {

				// Save the processed state
				if( is_object( $podcastItem ) == false )
					$podcastItem = ClassRegistry::init('PodcastItem');
					
				// We only trancode media 1 at a time but it is still wrapped in a forloop to give a generic structure to all
				// API payloads.				 								
				foreach( $this->Callback->data['data'] as $row ) {

					$data = $podcastItem->findById( $row['data']['podcast_item_id'] );
															
					if( strtoupper( $row['status'] ) == YES ) {
						
						$data['PodcastItem']['processed_state'] = MEDIA_AVAILABLE; // Media available
						//$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$row,'Creating flavour of media');
						$podcastItem->PodcastMedia->create();
						$data['PodcastMedia']['filename'] = $row['filename'];
						$data['PodcastMedia']['original_filename'] = $row['original_filename'];
						$data['PodcastMedia']['media_type'] = $row['media_type'];
						$data['PodcastMedia']['podcast_item'] = $row['podcast_item_id'];
						$data['PodcastMedia']['duration'] = $row['duration'];
						$podcastItem->PodcastMedia->set( $data );
						//if( $podcastItem->PodcastMedia->save( $data ) == false )
							//$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$podcastItem->PodcastMedia->invalidFields( $data ),'Creating flavour of media');
						
					} else {
						
						$data['PodcastItem']['processed_state'] = -1; // Error in transcoding
					}
				}
				
				$podcastItem->set( $data );
				$podcastItem->save();
				
			} elseif( in_array( $this->Callback->data['command'], $this->processed_state_update ) ) {
				
				$this->Callback->processDeletions();				
			}			
				
			// Does the API command signify a need to delete a local file structure?
			if( in_array( $this->Callback->data['command'], $this->requires_local_deletion ) ) {

				foreach( $this->Callback->data['data'] as $row ) {
					
					// Delete the local file structure or error.
					$this->Folder->cleanUp( $row['data']['source_path'],$row['data']['filename'] );
				}
			}
			
			// If we need to 'kick-off' some meta injection do it here.
			if( in_array( $this->Callback->data['command'], $this->requires_meta_injection ) ) {
				
				// Needed to retrieve the meta data.
				if( is_object( $podcastItem ) == false )
					$podcastItem = ClassRegistry::init('PodcastItem');
				
				foreach( $this->Callback->data['data'] as $row ) {
					
					if( strtoupper( $row['status'] ) == YES ) {

						// Use the data passed to the callback plus the recently retrieved meta data and send a call to the Api.						
						//if( $this->Api->metaInjection( $podcastItem->buildInjectionFlavours( $row['data']['podcast_item_id'] ) ) == false )
							//$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$this->Callback->data,'Error injecting meta data');
 					}
				}
			}

		} else {
			
			$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$this->Callback->data,'Failed to understand command');
			$this->set('status', json_encode( array( 'status'=>'NACK', 'data'=>'Message received but I dont understand what it means', 'timestamp'=>time() ) ) );
		}
	}



	function post() {

	}
}
?>
