<?php
/*
 * @NOTES ON VLE : The VLE solution is untested code and will require further modifications. In short, it receives a 
 * command from the API and acts upon it by sending, if necessary, further commands to the API using a seperate HTTP requests
 * plus the original request received back to the API with new elements, noteably a "status" element.
 
 * Lastly, for all commands received it will echo an ACK or a NACK. A NACK will only be posted if we are unable to match 
 * the command sent against the array held in the vle.php model.
 *
 * There are 'X' basic VLE commands, all lowercase, understood by the admin box as follows :
 * 
 * "CREATE-CONTAINER" : Upon receipt of this command we create a new row on the podcasts database table then
 * send the original commmand back to the API using a seperate http request with two new elements entitled "status" that equals "Y" or
 * "N" and "podcast_id".
 *
 * "DELETE-CONTAINER" : Delete a row from the podcasts database table, then send a command to the API removing it from the 
 * medias box, lastly send the original command back to the API with a "status" element that will be passed back to the VLE.
 *
 * "DELETE-MEDIA" : Will soft-delete media by posting a command to the API to rename the media file(s) by prefixing "." to the start
 * and it will then update the appropriate row on the podcast_items table setting the "deleted" flag to "1". Lastly, it returns the
 * original command back to the API with new "status" element.
 *
 * "SUBMIT-MEDIA" : Will insert a new row on the podcast_items table than make a call to the API to transcode the media. Note, the 
 * "transcode media" command passed to the API will contain an element called "provider" that will contain the value "vle" which enables
 * the API to pick the media from the VLE location as opposed to the default location on the admin media box. Lastly it will post the original
 * message back to the admin api with a status flag.
 * 
 * "METADATA-UPDATE" : Fires off a meta data injection request to the API and set a status flag accordingly.
 * 
 * "GET-MEDIA-ENDPOINT-URL" :
 *
 */
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
						
						$row['status'] = 'OK';
						$row['podcast_id'] = $id;
						
					// The creation of the podcast failed, bummer	
					} else {
						
						$row['status'] = 'NOK';
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
						$row['status'] = 'OK';
						
					} else {
					
					
						$row['status'] = 'NOK';
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
						$row['status'] = 'OK';
						
					} else {
					
						$row['status'] = 'NOK';
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
						
						$this->Api->transcodeMediaAndDeliver( $podcast['Podcast']['custom_id'], $row['filename'], $row['workflow'], $podcast['PodcastItem']['id'], $this->data['PodcastItem']['podcast_id'], 'vle' );
						$Podcast->PodcastItems->commit();
						$row['status'] = 'OK';
							
					} else {
							
						$Podcast->PodcastItems->rollback();
						$row['status'] = 'NOK';						
					}

					$data[] = $row;
				}				
				
			} elseif( strtolower( $this->Vle->data['command'] ) == 'metadata-update' ) {

				$PodcastItemMedia = ClassRegistry::init('PodcastItemMedia');
				
				foreach( $this->data['data'] as $row ) {

					if( $this->Api->metaInject( $podcastItemMedia->buildMetaData( 
						array( 
							'PodcastItemMedia.podcast_item' => $row['mediaID']
							) 
						)
					) ) {
						
						$row['status'] = 'OK';
						
					} else {
						
						$row['status'] = 'NOK';
					}
					
					$data[] = $row;
				}				
				
			} elseif( strtolower( $this->Vle->data['command'] ) == 'get-media-endpoint-url' ) {
				
				foreach( $this->data['data'] as $row ) {

					$podcast_item = array();
					$row['status'] = 'NOK';
					$podcast_item = $Podcast->PodcastItem->findById( $row['mediaID'] );
					
					foreach( $podcast_item['PodcastMedia'] as $media ) {
						
						
						if( $media['media_type'] == 'default' ) {
							$filename = $media['filename'];	
							$row['status'] = 'OK';
							break;
						}
					}
					
					$row['url'] = $podcast_item['Podcast']['custom_id'].'/'.$filename;
					$data[] = $row;
				}				
				
			} elseif( strtolower( $this->Vle->data['command'] ) == 'clone-container' ) {
				
				foreach( $this->data['data'] as $row ) {
					
					$podcast = array();
					$api_data = $Podcast->copy( $row['containerID'] );
					$row['status'] = 'NOK';
					
					if( $api_data ) {

						if( $this->Api->copyMediaFolder( $api_data ) ) {
					
							if( $this->__generateRSSFeeds( $api_data['podcast_id'] ) ) {
								
								$row['status'] = 'OK';
								$row['containerID'] = $api_data['podcast_id'];
								
								// Update the podcast with the new title 
								$podcast = $Podcast->findById( $api_data['podcast_id'] );
								$podcast['Podcast']['title'] = $row['title'];
								$Podcast->set( $podcast );
								$Podcast->save();
							}
						}
					}
					
					$data[] = $row;					
				} 
			}

			// Noe send the updated data back to the API using the shared API method "response". The API will pass this back to the
			// VLE. 
			$this->Api->response( $data, $this->Vle->data['command'] );

		} else {
			
			// We cannot understand the VLE command that has been sent.
			$Notification->malformedVleData( $this->Vle->json );
			$this->set('status', json_encode( array( 'status'=>'NACK', 'data'=>'Message received but I dont understand what it means', 'timestamp'=>time() ) ) );
			
		}
	}
}
?>
