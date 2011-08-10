<?php
class PodcastItemMedia extends AppModel {

    var $name = 'PodcastItemMedia';
    var $useTable = 'podcast_item_media';
    var $validate = array();

    var $belongsTo = array(

        'PodcastItem' => array(
            'className' => 'PodcastItem',
            'foreignKey' => 'podcast_item',
            'dependent' => true
         )
    );
	
	/*
	 * @name : saveFlavours
	 * @description : Called from the callbacks controller, will save a flavour of media
	 * and update the status accordingly.
	 * @updated : 3rd August 2011
	 * @by : Charles Jackson
	 */
	function saveFlavour( $row = array() ) {
		
		$data = array();
		$this->create();
		
		if( strtoupper( $row['status'] ) == YES ) {
						
			$data['PodcastItemMedia']['processed_state'] = MEDIA_AVAILABLE; // Media available
			
		} else {
			
			$data['PodcastItemMedia']['processed_state'] = -1; // Error in transcoding
		}

		if( $row['flavour'] == 'default' ) {
			$data['PodcastItem']['id'] = $row['podcast_item_id'];
			$data['PodcastItem']['processed_state'] = MEDIA_AVAILABLE;
		}
			
		$data['PodcastItemMedia']['filename'] = str_replace('//','/',$row['destination_filename'] ); // Quick fudge to fix minor API issue;
		$data['PodcastItemMedia']['original_filename'] = $row['original_filename'];
		$data['PodcastItemMedia']['media_type'] = $row['flavour'];
		$data['PodcastItemMedia']['podcast_item'] = $row['podcast_item_id'];
		$data['PodcastItemMedia']['duration'] = $row['duration'];
		$data['PodcastItemMedia']['uploaded_when'] = date("Y-m-d H:i:s");

		$this->set( $data );
		return $this->saveAll();
	}	
}