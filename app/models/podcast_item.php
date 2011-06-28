<?php
class PodcastItem extends AppModel {

    var $name = 'PodcastItem';
    var $validate = array(
        
        'podcast_id' => array(
            'Rule1' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => 'Cannot identify the podcast you are trying to associate with this media.'
            )
        ),
        'target_url' => array(
            'Rule1' => array(
                'rule' => 'url',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid item link URL.'
            )
        ),
        'publication_date' => array(
            'Rule1' => array(
                'rule' => 'date',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD.'
            )
        )
    );

    var $belongsTo = array(

        'Podcast' => array(
            'className' => 'Podcast',
            'foreignKey' => 'podcast_id',
            'fields' => 'Podcast.id, Podcast.title, Podcast.summary, Podcast.custom_id, Podcast.private, Podcast.owner_id'
        )
    );

    var $hasOne = array(

        'Transcript' => array(
            'className' => 'PodcastItemMedia',
            'foreignKey' => 'podcast_item',
            'conditions' => 'Transcript.media_type = "transcript"'
        )
    );

    var $hasMany = array(

        'PodcastMedia' => array(
            'className' => 'PodcastItemMedia',
            'foreignKey' => 'podcast_item',
            'conditions' => 'PodcastMedia.media_type != "transcript"'
        )
    );

    /*
     * @name : createFromUrlVariables
     * @description : Called from the ADD method directly after a successful filechucker upload
     * @updated : 25th May 2011
     * @by : Charles Jackson
     */
    function createFromUrlVariables( $params = array(), $podcast_id = null ) {

        $this->data['PodcastItem']['podcast_id'] = $podcast_id;
        $this->data['PodcastItem']['filename'] = $params['url']['f1name'];
        $this->data['PodcastItem']['published_flag'] = 'Y';
        $this->data['PodcastItem']['processed_state'] = 2;

        if( strtoupper( $params['url']['ff01v'] ) == 'WIDE 16:9' )
            $this->data['PodcastItem']['aspect_ratio'] = 0.5625;
        if( strtoupper( $params['url']['ff01v'] ) == 'STANDARD 4:3' )
            $this->data['PodcastItem']['aspect_ratio'] = 0.75;
        
        return $this->data;
    }


    /*
     * @name : getMediaInfo
     * @description : We use the getID3 component to extract various bits and pieces from the uploaded file and save to the database
     * else store in $this->data and so we may create a workflow that can be passed to the Api.
     * @updated : 21st June 2011
     * @by : Charles Jackson
     */
    function getMediaInfo( $data = array(), $media_info = array() ) {

        if( !is_array( $media_info ) ) {

            $data['PodcastItem']['duration'] = $info['length']; // Stored in the database
            $data['PodcastItem']['fileformat'] = $info['fileformat']; // Stored in the database
            $data['PodcastItem']['original_filename'] = $info['filename']; // Stored in the database
        }

		$this->Workflow = ClassRegistry::init('Workflow');
		
		$data['workflow'] = $this->Workflow->get( $data, $media_info );

    }


	/*
	 * @name : listAssociatedMedia
	 * @description : Build an array of media files that can by passed to the API.
	 * @updated : 21st June 2011
	 * @by : Charles Jackson
	 */
	function listAssociatedMedia( $data = array() ) {
	
		$media_files = array();
		
		// Loop through the media and append to an array
        foreach( $data['PodcastMedia'] as $media ) {

        	$media_files[] = array( 
				'source_path' => $data['Podcast']['custom_id'].'/'.$media['PodcastMedia']['media_type'].'/',
				'target_path' => $data['Podcast']['custom_id'].'/'.$media['PodcastMedia']['media_type'].'/',				
				'filename' => $media['PodcastMedia']['filename']
				);
        }
		
		// Grab the transcript if it exists and append to array
		if( is_array( $data['Transcript'] ) && count( $data['Transcript'] ) ) {
			
			$media_files[] = array( 
				'source_path' => $data['Podcast']['custom_id'].'/'.$data['Transcript']['media_type'].'/',
				'target_path' => $data['Podcast']['custom_id'].'/'.$data['Transcript']['media_type'].'/',
				'filename' => $data['Transcript']['filename']
				);
		}
		
		return $media_files;		
	}
}