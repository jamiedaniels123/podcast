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
        $this->data['PodcastItem']['original_filename'] = $params['url']['f1name'];
        $this->data['PodcastItem']['published_flag'] = 'N';
        $this->data['PodcastItem']['processed_state'] = 1;
		
        if( strtoupper( $params['url']['ff01v'] ) == 'WIDE 16:9' )
            $this->data['PodcastItem']['aspect_ratio'] = WIDE_SCREEN;
        if( strtoupper( $params['url']['ff01v'] ) == 'STANDARD 4:3' )
            $this->data['PodcastItem']['aspect_ratio'] = STANDARD_SCREEN;
        if( strtoupper( $params['url']['ff01v'] ) == 'AUTO' )
            $this->data['PodcastItem']['aspect_ratio'] = null;

		// None of this information is stored in the DB but it is used in the Workflow->determine() model/method so we capture it here.
		$this->data['PodcastItem']['screencast'] = ( strtoupper( $params['url']['ff02v'] ) == 'YES' ? true : false ); 
		$this->data['PodcastItem']['video_width'] = ( isSet( $params['video']['resolution_x'] ) ? $params['video']['resolution_x'] : 0 );
		$this->data['PodcastItem']['video_height'] = ( isSet( $params['video']['resolution_y'] ) ? $params['video']['resolution_y'] : 0 );

        return $this->data;
    }


    /*
     * @name : captureId3Information
     * @description : We use the getID3 component to extract various bits and pieces from the uploaded file and save to the database
     * else store in $this->data and so we may create a workflow that can be passed to the Api.
     * @updated : 21st June 2011
     * @by : Charles Jackson
     */
    function captureId3Information( $data = array(), $media_info = array() ) {

        if( !is_array( $media_info ) ) {

            $data['PodcastItem']['duration'] = $info['length'];
            $data['PodcastItem']['fileformat'] = $info['fileformat']; 
            $data['PodcastItem']['original_filename'] = $info['filename']; 
			$data['PodcastItem']['shortcode'] = $this->buildShortcode( $info['filename'] );
			$data['PodcastItem']['fullMD5code'] = $this->buildMd5Code( $data['Podcast']['custom_id'], $info['filename'] );			 
			$data['PodcastItem']['processed_state'] = 1; // 1 signifies it has been uploaded.
        }
		
		return $data;
    }

	/*
	 * @name : buildShortCode
	 * @description : Taken straight from the original implementation, build an MD5 hash for storing in the database
	 * as "shortcode".
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */
	function buildShortCode( $filename = null ) {
	
		if( !empty( $filename ) ) {
		
			$filename_less_extension = substr( $filename, 0, strrpos( $filename,'.' ) );
			return substr( md5( $filename_less_extension ), 0, 10 );
		}
		
		return false;
	}

	/*
	 * @name : buildMd5Code
	 * @description : Taken straight from the original implementation, build an MD5 hash for storing in the database
	 * as "fullMD5code".
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */
	function buildMd5Code( $custom_id, $filename ) {

		if ( !empty( $custom_id ) && !empty( $filename ) ) {
			  
			return md5( DEFAULT_MEDIA_URL . FEEDS . $custom_id . '/' . $filename );
		}
		  
		return false;
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