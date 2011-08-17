<?php
class PodcastItemMedia extends AppModel {

    var $name = 'PodcastItemMedia';
    var $useTable = 'podcast_item_media';
    var $validate = array();
	var $order = 'PodcastItemMedia.id ASC';

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
		
		// When media has been trancoded the original filename will exist within
		// the array element "original_filename" else it will exist within "destination_filename" 
		// for non transcoded media such as MP3 files.
		if( isSet( $row['original_filename'] ) ) {
			$data['PodcastItemMedia']['original_filename'] = $row['original_filename'];
		} else {
			$data['PodcastItemMedia']['original_filename'] = $row['destination_filename'];
		}
		
		$data['PodcastItemMedia']['media_type'] = $row['flavour'];
		$data['PodcastItemMedia']['podcast_item'] = $row['podcast_item_id'];
		
		$data['PodcastItemMedia']['duration'] = 0; //$row['duration'];
		$data['PodcastItemMedia']['uploaded_when'] = date("Y-m-d H:i:s");

		$this->set( $data );
		return $this->saveAll();
	}	
	
	/*
	 * @name : youtubeMetaInjection
	 * @description : Takes a row from the callbacks controller and build youtube meta data for injection
	 * @updated : 13th July 2011
	 * @by : Charles Jackson
	 */
	function youtubeMetaInjection( $row ) {

		$meta_data = array();
		$data = $this->findById( $row['podcast_item_id'] );
		
		$meta_data['destination_path'] = $row['destination_path'];
		$meta_data['destination_filename'] = $row['destination_filename'];
		$meta_data['meta_data']['title'] = $data['PodcastItem']['youtube_title'];
		$meta_data['meta_data']['genre'] = 'Podcast';
		$meta_data['meta_data']['author'] = $data['PodcastItem']['author'];
		$meta_data['meta_data']['course_code'] = $data['Podcast']['course_code'];
		$meta_data['meta_data']['podcast_title'] = $data['PodcastItem']['youtube_title'];
		$meta_data['meta_data']['year'] = date("Y");
		$meta_data['meta_data']['comments'] = 'Item from '.$data['Podcast']['series_playlist'];
		
		return $meta_data;
	}

	/*
	 * @name : itunesMetaInjection
	 * @description : Takes a row from the callbacks controller and builds itunes meta data for injection
	 * @updated : 13th July 2011
	 * @by : Charles Jackson
	 */
	function itunesMetaInjection( $row ) {

		$meta_data = array();
		$data = $this->findById( $row['podcast_item_id'] );

		$meta_data['destination_path'] = $row['destination_path'];
		$meta_data['destination_filename'] = $row['destination_filename'];
		$meta_data['meta_data']['title'] = $data['PodcastItem']['youtube_title'];
		$meta_data['meta_data']['genre'] = 'Podcast';
		$meta_data['meta_data']['author'] = $data['PodcastItem']['author'];
		$meta_data['meta_data']['course_code'] = $data['Podcast']['course_code'];
		$meta_data['meta_data']['podcast_title'] = $data['PodcastItem']['youtube_title'];
		$meta_data['meta_data']['year'] = date("Y");
		$meta_data['meta_data']['comments'] = 'Item from '.$data['Podcast']['series_playlist'];
		
		return $meta_data;
	}
		
	/*
	 * @name : commonMetaInjection
	 * @description : Takes a row from the callbacks controller and build common meta data for injection
	 * @updated : 13th July 2011
	 * @by : Charles Jackson
	 */
	function commonMetaInjection( $row ) {

		$meta_data = array();
		$data = $this->findById( $row['podcast_item_id'] );

		$meta_data['destination_path'] = $row['destination_path'];
		$meta_data['destination_filename'] = $row['destination_filename'];
		$meta_data['meta_data']['title'] = $this->data['title'];
		$meta_data['meta_data']['genre'] = 'Podcast';
		$meta_data['meta_data']['author'] = $data['Podcast']['author'];
		$meta_data['meta_data']['course_code'] = $data['Podcast']['course_code'];
		$meta_data['meta_data']['podcast_title'] = $data['Podcast']['title'];
		$meta_data['meta_data']['year'] = date("Y");
		$meta_data['meta_data']['comments'] = 'Item from '.$data['Podcast']['title'];
		
		return $meta_data;
	}		
}