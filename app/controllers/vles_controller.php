<?php
class VlesController extends AppController {

	var $name = 'Vles';
	
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
	 * @name : add
	 * @description : Takes commands from the VLE that have been delivered by the API and gives an ACK or a NACK. It then 
	 * processes the commands by making several more calls to the API.
	 * @updated : 7th September 2011
	 * @by : Charles Jackson
	 */
	function add() {
		
		$data = array();
		$this->layout='vle';
		$this->Vle->setData(file_get_contents("php://input"));
		$Notification = ClassRegistry::init('Notification');
		$Podcast = ClassRegistry::init('Podcast');
		
		// Is it a valid command
		if ( $this->Vle->understand() ) {
			
			// It's a valid command, let the API know.
			$this->set('status', json_encode( array( 'status'=>'ACK', 'data'=>'Message received and understand.', 'timestamp'=>time() ) ) );
				
			if( strtolower( $this->Vle->data['command'] ) == 'create-container' ) {

				foreach( $this->data['data'] as $row ) {
					
					$id = $this->Vle->createCollection( $row );
					
					// If the variable podcast is populated then we were successful
					if( (int)$id  ) {
						
						$row['status'] = YES;
						$row['podcast_id'] = $id;
						
					// The creation of the podcast failed, bummer	
					} else {
						
						$row['status'] = NO;
						$row['podcast_id'] = null;
					}
					
					// Append to a new data array that will be included in the call we make to the API 
					// so the VLE will know the status of their requests.
					$data[] = $row;					
				}

			} elseif( strtolower( $this->Vle->data['command'] ) == 'delete-container' ) {
				
				// We are not deferring to the model so we can easily access to API component class.
				$podcasts = array();

				$Podcast->recursive = -1;
				
				foreach( $this->data['data'] as $row ) {
					
					$podcast = $Podcast->findById( $row['id'] );
					
					if( !empty( $podcast ) && ( $this->Api->deleteFolderOnMediaServer( array( 
							'source_path' => $data['Podcast']['custom_id'].'/',
							'destination_path' => $data['Podcast']['custom_id'].'/'
							)
						) 
					) ) {
					
						$Podcast->delete( $data['Podcast']['id'] );					
						$row['status'] = YES;
						
					} else {
					
					
						$row['status'] = NO;
					}
					
					$data[] = $row;
				}
				
			} elseif( strtolower( $this->Vle->data['command'] ) == 'delete-media' ) {
				
				// We are not deferring to the model so we can easily access to API component class.
				$podcast_item = array();

				$Podcast->PodcastItems->recursive = 1;
				
				foreach( $this->data['data'] as $row ) {
					
					$podcast_item = $Podcast->PodcastItems->findById( $row['id'] );
					
					if( $this->Api->renameFileMediaServer( $this->PodcastItem->listAssociatedMedia( $podcast_item ) ) ) {
						
						$podcast_item['PodcastItem']['deleted'] = 1;
						$Podcast->PodcastItems->set( $podcast_item );					
						$Podcast->PodcastItems->save();
						$row['status'] = YES;
						
					} else {
					
						$row['status'] = NO;
					}
					
					$data[] = $row;
				}

			} elseif( strtolower( $this->Vle->data['command'] ) == 'submit-media' ) {
				
				// We are not deferring to the model so we can easily access to API component class.
				$podcast = array();
				$data = array();
				
				foreach( $this->data['data'] as $row ) {

					$Podcast->PodcastItems->begin();
					
					$Podcast->PodcastItems->create();					
					$podcast['PodcastItem']['podcast_id'] = $row['containerID'];
					$podcast['PodcastItem']['title'] = $row['filename'];
					$podcast['PodcastItem']['original_filename'] = $row['filename'];
					$Podcast->PodcastItems->set( $podcast_item );
					
					if( $Podcast->PodcastItems->save() ) {
						
						$podcast = $Podcast->PodcastItems->findById( $Podcast->PodcastItems->getLastInsertId() );
						
						if( $this->Api->transcodeMediaAndDeliver( $podcast['Podcast']['custom_id'], $row['filename'], $row['workflow'], $podcast['PodcastItem']['id'], $this->data['PodcastItem']['podcast_id'], 'vle' ) ) {
						$Podcast->PodcastItems->commit();
						
						$row['status'] = YES;
						
					} else {
						
						$Podcast->PodcastItems->rollback();
						$row['status'] = NO;
					}
					
					$data[] = $row;
				}				
				
			} elseif( strtolower( $this->Vle->data['command'] ) == 'submit-media' ) {
				
				
			}

		} else {
			
			// We cannot understand the VLE command that has been sent.
			$Notification->malformedVleData( $this->Vle->json );
			$this->set('status', json_encode( array( 'status'=>'NACK', 'data'=>'Message received but I dont understand what it means', 'timestamp'=>time() ) ) );
		}
	}
}
?>
