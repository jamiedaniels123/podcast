<?php
class CallbacksController extends AppController {

	var $name = 'Callbacks';
	var $requires_local_deletion = array('transcode-media','transcode-media-and-deliver','transfer-file-to-media-server', 'transfer-folder-to-media-server');
	var $requires_meta_injection = array('transcode-media-and-deliver');
	var $processed_state_update = array('transcode-media-and-deliver');
	
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
		$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$this->Callback->data,'Callback ALERT');

		// Is it a valid command
		if ( $this->Callback->understand() ) {
			
			$this->set('status', json_encode( array('status'=>'ACK', 'data'=>'Message received', 'timestamp'=>time() ) ) );

			if( $this->Callback->hasErrors() )
				$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$row,'This callback has errors');
				
			// Does the API command signify a need to delete a local file structure?
			if( in_array( $this->Callback->data['command'], $this->requires_local_deletion ) ) {
				
				$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$row,'WE ARE GOING TO DELETEE STUFF');
				
				foreach( $this->Callback->data['data'] as $row ) {
					$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$row,'IN THE DELETE LOOP');
					// Delete the local file structure or error.
					if( $this->Folder->cleanUp( $row['source_path'],$row['filename'] ) == false ) {
						
						if( is_object( $user ) == false )
							$user = ClassRegistry::init('User');
							
						$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$row,'Failed to delete file');
					} else {
						$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$row,'Just Deleted');
					}
				}
			}
			
			// If we need to 'kick-off' some meta injection do it here.
			if( in_array( $this->Callback->data['command'], $this->requires_meta_injection ) ) {

				// Needed to retrieve the meta data.
				$podcastItem = ClassRegistry::init('PodcastItem');
				
				foreach( $this->Callback->data['data'] as $row ) {
					
					if( strtoupper( $row['status'] ) == YES ) {
				
						// Use the data passed to the callback plus the recently retrieved meta data and send a call to the Api. 
						$this->Api->MetaInjection( $this->data['target_path'], $this->data['filename'], $this->data['podcast_item_id'], $podcastItem->getMetaData( $this->data['podcast_item_id'] ) );
					}
				}
			}

			// Do we need to update the processed state
			if( in_array( $this->Callback->data['command'], $this->processed_state_update ) ) {

				// Save the processed state
				if( is_object( $podcastItem ) == false )
					$podcastItem = ClassRegistry::init('PodcastItem');
					
				$data = $podcastItem->findById( $this->Callback->data['podcast_item_id'] );
				// We only trancode media 1 at a time but it is still wrapped in a forloop to give a generic structure to all
				// API payloads.				 								
				foreach( $this->Callback->data['data'] as $row ) {
					
					if( strtoupper( $row['status'] ) == YES ) {
						
						$data['PodcastItem']['processed_state'] = 9; // Media available
						
					} else {
						
						$data['PodcastItem']['processed_state'] = -1; // Error in transcoding
					}
				}
				
				$podcastItem->set( $data );
				$podcastItem->save();
			}			
			

		} else {
			
			$user = ClassRegistry::init('User');
			$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$this->Callback->data,'Failed to understand command');
			$m_data = array( 'status'=>'NACK', 'data'=>'Message received but I dont understand what it means', 'timestamp'=>time());
			$jsonData = json_encode($m_data);
			$this->set('status',$jsonData);
		}

	}



	function post() {

	}
}
?>
