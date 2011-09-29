<?php
class PodcastItemMedia extends AppModel {

    var $name = 'PodcastItemMedia';
    var $useTable = 'podcast_item_media';
    var $validate = array();
	var $common_meta_injection = array('default' => '' ); 
	var $itunes_meta_injection = array('ipod-all' => 'ipod-all/','desktop-all' => 'desktop-all/','hd' => 'hd/','hd-1080' => 'hd-1080/' );
	var $meta_injection = array();
    var $belongsTo = array(

        'PodcastItem' => array(
            'className' => 'PodcastItem',
            'foreignKey' => 'podcast_item',
            'dependent' => true
         )
    );
	
	/*
	 * @name : updateExistingFlavour
	 * @description : Called from the "saveFlavour" method. We check to see if a flavour of media already exists
	 * and if true we update the contents using information passed through from callbacks/add. Returns a bool.
	 * @updated : 2nd September 2011
	 * @by : Charles Jackson
	 */
	 function updateExistingFlavour( $row = array() ) {
		 
		$this->data = $this->find('first', array( 'conditions' => 
		 
		 	array(
		 		'PodcastItemMedia.podcast_item' => $row['podcast_item_id'],
				'PodcastItemMedia.media_type' => $row['flavour']
				)
			)
		);
			
		if( empty( $this->data ) )
			return false;

		$this->hydrate( $row );			
		
		$this->set( $this->data );
		$this->saveAll();
			
		return true;
	 }
	 
	
	/*
	 * @name : saveFlavours
	 * @description : Called from "callbacks/add". Will save a flavour of media
	 * by updating an existing row or by inserting a new row on the media table. 
	 * @updated : 3rd August 2011
	 * @by : Charles Jackson
	 */
	function saveFlavour( $row = array() ) {
		
		if( $this->updateExistingFlavour( $row ) ) {
			
			return true;
			
		} else {
			
			$this->create();
			$this->hydrate( $row );
			$this->set( $this->data );
			$this->saveAll();

		}
	}	


	/*
	 * @name : createDefaultFlavour
	 * @description :
	 * @updated : 27th September 2011
	 * @by : Charles Jackson
	 */
	 function createDefaultFlavour( $row = array() ) {
		 
		$this->data = $this->PodcastItemMedia->find('first', array( 'conditions' => array(
		
			'PodcastItemMedia.media_type' => 'default',
			'PodcastItemMedia.podcast_item_id' => $row['podcast_item_id'],
				)
			)
		);
		
		if( ( $row['flavour'] == DEFAULT_FLAVOUR ) || empty( $this->data ) ) {
			
			$this->data['PodcastItemMedia']['podcast_item_id'] = $row['podcast_item_id'];
			$this->data['PodcastItemMedia']['media_type'] = $row['flavour'];
			$this->data['PodcastItemMedia']['original_filename'] = $row['original_filename'];
			$this->data['PodcastItemMedia']['filename'] = $row['destination_filename'];			
			$this->data['PodcastItemMedia']['processed_state'] = 9; // Where 9 equals available.
		}
		 
	 }
	 
	/*
	 * @name : hydrate
	 * @description : When updating an existing row or creating a new row this common routine
	 * will populate this->data with elements of the array passed as a parameter. It is called
	 * by the saaveFlavour & updateExistingFlavour methods.
	 * @updated : 2nd September 2011
	 * @by : Charles Jackson
	 */
	function hydrate( $row = array() ) {
		
		$this->data['PodcastItemMedia']['filename'] = str_replace('//','/',$row['destination_filename'] ); // Quick fudge to fix minor API issue;
		
		// When media has been trancoded the original filename will exist within
		// the array element "original_filename" else it will exist within "destination_filename" 
		// for non transcoded media such as MP3 files.
		if( isSet( $row['original_filename'] ) ) {
			
			$this->data['PodcastItemMedia']['original_filename'] = $row['original_filename'];
			
		} else {
			
			$this->data['PodcastItemMedia']['original_filename'] = $row['destination_filename'];
		}
		
		// If we are processing the default flavour take the newly transcoded filename which may have 
		// changed for example. .flv will become .mov and update the track level record. 
		if( strtolower( $row['flavour'] ) == 'default' ) {
			
			$this->data['PodcastItem']['filename'] == $row['destination_filename'];
			
			if( !isSet( $this->data['PodcastItem'] ) || empty( $this->data['PodcastItem'] ) )
				$this->data['PodcastItem']['filename'] = $row['destination_filename'];
		}

		$this->data['PodcastItemMedia']['media_type'] = $row['flavour'];
		$this->data['PodcastItemMedia']['podcast_item'] = $row['podcast_item_id'];
		
		$this->data['PodcastItemMedia']['duration'] = $row['duration'];
		$this->data['PodcastItemMedia']['uploaded_when'] = date("Y-m-d H:i:s");

		$this->data['PodcastItem']['id'] = $row['podcast_item_id'];
		
		if( strtoupper( $row['status'] ) == YES ) {
						
			$this->data['PodcastItemMedia']['processed_state'] = MEDIA_AVAILABLE; // Media available

			if( $row['flavour'] == 'default' ) {
				
				$this->data['PodcastItem']['processed_state'] = MEDIA_AVAILABLE;
			}
			
		} else {
			
			$this->data['PodcastItemMedia']['processed_state'] = -1; // Error in transcoding
			
			if( $row['flavour'] == 'default' || $row['flavour'] == 'transcript' ) {
				
				$this->data['PodcastItem']['processed_state'] = -1; // Error in transcoding
			}


			// We have an error in transcoding, create a notification.
			$notification = ClassRegistry::init('Notification');
			$notification->errorTranscoding( $this->data['PodcastItemMedia'], $row );
		}
	}
	
	
	/*
	 * @name : metaInject
	 * @description : Reads through every flavour of item media and build an array on meta data for injection.
	 * @updated : 18th August 2011
	 * @by : Charles Jackson
	 */	
	function buildMetaData( $conditions ) {
		
		$data = array();
		$this->recursive = 2;
		$data = $this->find('all', array('conditions' => $conditions ) );
		
		if( empty( $data ) )
			return false;
			
		foreach( $data as $row ) {
			
			if( isSet( $this->common_meta_injection[$row['PodcastItemMedia']['media_type']] ) ) {
				
				$inject['podcast_item_id'] = $row['PodcastItemMedia']['podcast_item'];
				$inject['destination_path'] = $row['PodcastItem']['Podcast']['custom_id'].'/'.$this->common_meta_injection[$row['PodcastItemMedia']['media_type']];

				$inject['destination_filename'] = $row['PodcastItem']['filename'];
				$this->meta_injection[] = $this->PodcastItem->commonMetaInjection( $inject );
				
			} elseif( isSet( $this->itunes_meta_injection[$row['PodcastItemMedia']['media_type']] ) ) {
				
				$inject['podcast_item_id'] = $row['PodcastItemMedia']['podcast_item'];
				$inject['destination_path'] = $row['PodcastItem']['Podcast']['custom_id'].'/'.$this->itunes_meta_injection[$row['PodcastItemMedia']['media_type']];
				$inject['destination_filename'] = $row['PodcastItemMedia']['filename'];
				$this->meta_injection[] = $this->PodcastItem->itunesMetaInjection( $inject );
			}
		}
		
		return $this->meta_injection;
	}	
	
}