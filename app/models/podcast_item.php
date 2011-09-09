<?php
class PodcastItem extends AppModel {
	
	
    var $name = 'PodcastItem';
	var $order = 'PodcastItem.title ASC';
    var $validate = array(
        
        'podcast_id' => array(
            'Rule1' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => 'Cannot identify the podcast you are trying to associate with this track.'
            )
        ),
        'published_flag' => array(
			'Rule1' => array(
				'rule' => array('readyForPublication'),
				'message' => 'You cannot publish tracks that are unavailable or do not have a title.'
			)
        ),
        'target_url' => array(
            'Rule1' => array(
                'rule' => 'url',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid item link URL.'
            )
        ),
        'youtube_link_1' => array(
            'Rule1' => array(
                'rule' => 'url',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid youtube link (1) URL.'
            )
        ),
        'youtube_link_2' => array(
            'Rule1' => array(
                'rule' => 'url',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid youtube link (2) URL.'
            )
        ),
        'youtube_link_3' => array(
            'Rule1' => array(
                'rule' => 'url',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid youtube link (3) URL.'
            )
        )
		
    );

    var $belongsTo = array(

        'Podcast' => array(
            'className' => 'Podcast',
            'foreignKey' => 'podcast_id',
            'fields' => 'Podcast.id, Podcast.title, Podcast.summary, Podcast.custom_id, Podcast.private, Podcast.owner_id, Podcast.publish_itunes_u, Podcast.publish_youtube, Podcast.podcast_flag, Podcast.course_code, Podcast.intended_youtube_flag, Podcast.intended_itunesu_flag, youtube_series_playlist_link, youtube_series_playlist_text, Podcast.author', 'Podcast.shortcode',
            'dependent' => true
        )
    );

    var $hasOne = array(

        'Transcript' => array(
            'className' => 'PodcastItemMedia',
            'foreignKey' => 'podcast_item',
            'conditions' => 'Transcript.media_type = "transcript"'
        ),
        'YoutubeVideo' => array(
            'className' => 'PodcastItemMedia',
            'foreignKey' => 'podcast_item',
            'conditions' => 'YoutubeVideo.media_type = "youtube"'
        )		
    );

    var $hasMany = array(

        'PodcastMedia' => array(
            'className' => 'PodcastItemMedia',
            'foreignKey' => 'podcast_item'
        )
    );

    var $hasAndBelongsToMany = array(

        'YoutubeSubjectPlaylists' => array(
            'className' => 'YoutubeSubjectPlaylist',
            'joinTable' => 'podcasts_subject_playlists',
            'foreignKey' => 'podcast_id',
            'associationForeignKey' => 'youtube_subject_playlist_id',
            'unique' => true
        )
	);
	
    /*
     * @name : beforeSave
     * @description : Magic method automatically called after validation and before data is saved.
     * At time of publication I am using it to check to ensure all channels are unpublished if the item itself is
	 * unpublished.
     * @updated : 9th September 2011
     * @by : Charles Jackson
     */
    function beforeSave() {

        if( $this->data['PodcastItem']['published_flag'] == 'N' ) {
			
			$this->data['PodcastItem']['youtube_flag'] = 'N';
			$this->data['PodcastItem']['itunes_flag'] = 'N';
		}
		
        return true;
    }
		
    /*
     * @name : createFromUrlVariables
     * @description : Called from the ADD method directly after a successful filechucker upload
     * @updated : 25th May 2011
     * @by : Charles Jackson
     */
    function createFromUrlVariables( $params = array(), $podcast_id = null ) {

        $this->data['PodcastItem']['podcast_id'] = $podcast_id;
        $this->data['PodcastItem']['original_filename'] = $params['url']['f1name'];
        $this->data['PodcastItem']['title'] = substr( $params['url']['f1name'], 0, strpos( $params['url']['f1name'], '.' ) );		
        $this->data['PodcastItem']['published_flag'] = 'N';
        $this->data['PodcastItem']['processed_state'] = 2;
		
        if( strtoupper( $params['url']['ff01v'] ) == 'WIDE 16:9' )
            $this->data['PodcastItem']['aspect_ratio'] = WIDE_SCREEN;
        if( strtoupper( $params['url']['ff01v'] ) == 'STANDARD 4:3' )
            $this->data['PodcastItem']['aspect_ratio'] = STANDARD_SCREEN;
        if( strtoupper( $params['url']['ff01v'] ) == 'AUTO' )
            $this->data['PodcastItem']['aspect_ratio'] = null;

        return $this->data;
    }


    /*
     * @name : captureId3Information
     * @description : We use the getID3 component to extract various bits and pieces from the uploaded file and save to the database.
     * @updated : 21st June 2011
     * @by : Charles Jackson
     */
    function captureId3Information( $data = array(), $media_info = array() ) {

        if( is_array( $media_info ) ) {

            $data['PodcastItem']['duration'] = $media_info['length'];
            $data['PodcastItem']['fileformat'] = $media_info['fileformat']; 
            $data['PodcastItem']['original_filename'] = $media_info['filename']; 
			$data['PodcastItem']['shortcode'] = $this->buildShortcode( $media_info['filename'] );
			$data['PodcastItem']['fullMD5code'] = $this->buildMd5Code( $data['Podcast']['custom_id'], $media_info['filename'] );			 
			$data['PodcastItem']['processed_state'] = 2; // 2 signifies transcoding is in progress
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
        	
			if( strtolower( $media['media_type'] ) == 'default' ) {
				
				$media['media_type'] = null;
				
			} else {
				
				$media['media_type'] = $media['media_type'].'/';
			}
			
        	$media_files[] = array( 
				'source_path' => $data['Podcast']['custom_id'].'/'.$media['media_type'],
				'destination_path' => $data['Podcast']['custom_id'].'/'.$media['media_type'],
				'source_filename' => $media['filename'],
				'destination_filename' => '.'.$media['filename'],
        		'podcast_item_id' => '.'.$media['podcast_item'],
        		'podcast_item_media_id' => '.'.$media['id']
				);
        }
			
		// Grab the transcript if it exists and append to array
		if( is_array( $data['Transcript'] ) && !empty( $data['Transcript']['id'] ) ) {
			
			$media_files[] = array( 
				'source_path' => $data['Podcast']['custom_id'].'/'.$data['Transcript']['media_type'].'/',
				'destination_path' => $data['Podcast']['custom_id'].'/'.$data['Transcript']['media_type'].'/',
				'source_filename' => $data['Transcript']['filename'],
				'destination_filename' => '.'.$data['PodcastMedia']['filename'],
        		'podcast_item_id' => '.'.$media['podcast_item'],
        		'podcast_item_media_id' => '.'.$media['id'],
				'podcast_item_deletion' => 1
				);
		}
		
		if( count( $media_files ) )
			return $media_files;		
			
		return false;
	}
	
	/*
	 * @name : getMetaData
	 * @description : Will retrieve the meta data for a given ID passed as a parameter.
	 * @updated : 12th July 2011
	 * @by : Charles Jackson
	 */
	function getMetaData( $id ) {

		$this->data = $this->findById($id);
		
		return array(
			'title' => $data['PodcastItem']['title'],
			'genre' => 'Podcast',
			'artist' => $data['PodcastItem']['author'],
			'album' => $data['Podcast']['title'],
			'year' => date('Y'),
			'comments' => 'Item from '.$data['Podcast']['title']			
		);
	}
	
	/*
	 * @name : buildYoutubeData
	 * @description : Build an array that is passed to the API when uploading a new video to youtube or refreshing the data
	 * @updated : 11th August 2011
	 * @by : Charles Jackson
	 */
	function buildYoutubeData( $data = array() ) {

		$youtube_data = array();
				
		$this->data = $this->findById( $data['PodcastItem']['id'] );
		
		if( empty( $this->data ) )
			return false;
			
		$youtube_data = array(
		
			'podcast_item_id' => $this->data['PodcastItem']['id'],
			'youtube_id' => $this->data['PodcastItem']['youtube_id'],
			'destination_path' => $this->data['Podcast']['custom_id'].'/youtube/',
			'destination_filename' => $this->data['YoutubeVideo']['filename'],			
			'source_path' => $this->data['Podcast']['custom_id'].'/youtube/',
			'source_filename' => $this->data['YoutubeVideo']['filename'],			
			'meta_data' => $this->encode_meta_data(
				array(
				'title' => $this->data['PodcastItem']['youtube_title'],
				'description' => $this->data['PodcastItem']['youtube_description'],
				'series_playlist_link' => $this->data['Podcast']['youtube_series_playlist_link'],
				'series_playlist_text' => $this->data['Podcast']['youtube_series_playlist_text'],
				'channel' => $this->data['PodcastItem']['youtube_channel'],
				'tags' => $this->data['PodcastItem']['youtube_tags'],
				'privacy' => $this->data['PodcastItem']['youtube_privacy'],
				'license' => $this->data['PodcastItem']['youtube_license'],
				'comments' => $this->data['PodcastItem']['youtube_comments'],
				'voting' => $this->data['PodcastItem']['youtube_voting'],
				'video_response' => $this->data['PodcastItem']['youtube_video_response'],
				'ratings' => $this->data['PodcastItem']['youtube_ratings'],
				'embedding' => $this->data['PodcastItem']['youtube_embedding'],
				'syndication' => $this->data['PodcastItem']['youtube_syndication'],
				'shortcode' => $this->data['Podcast']['shortcode']
				)
			)
		);
		
		return $youtube_data;
	}

	/*
	 * @name : encode_meta_data
	 * @description : Due to the ftreeform nature of the description field we use a 'heavier' encoding method
	 * than the normal json encode.
	 * @updated : 25th August 2011
	 * @by : Charles Jackson
	 */	
	function encode_meta_data( $meta_data = array() ) {
		
		return strtr( base64_encode( addslashes( gzcompress( serialize( $meta_data ), 9 ) ) ), '+/=', '-_,');				
	}
	
	/*
	 * @name : hasYoutubeFlavour
	 * @description : Checks to see if a youtube flavour of media exists
	 * @updated : 11th August 2011
	 * @by : Charles Jackson
	 */
	function hasYoutubeFlavour( $object = array() ) {
		
		if( isSet( $object['YoutubeVideo']['filename'] ) && !empty( $object['YoutubeVideo']['filename'] ) )
			return true;
			
		return false;
	}
	
	/*
	 * @name : hasYoutubeFlavour
	 * @description : Checks to see if a youtube flavour of media exists
	 * @updated : 11th August 2011
	 * @by : Charles Jackson
	 */
	function youtubeValidates( $data = array() ) {
		
		if( empty( $data['PodcastItem']['youtube_title'] ) || empty( $data['PodcastItem']['youtube_description'] ) )
			return false;
			
		return true;
	}	


	/*
	 * @name : itunesMetaInjection
	 * @description : Takes a row from the callbacks controller and builds itunes meta data for injection
	 * @updated : 13th July 2011
	 * @by : Charles Jackson
	 */
	function itunesMetaInjection( $row ) {

		$inject = array();
		$data = $this->findById( $row['podcast_item_id'] );

		$inject['destination_path'] = $row['destination_path'];
		$inject['destination_filename'] = $row['destination_filename'];
		
		$inject['meta_data'] = $this->encode_meta_data ( 
		
			array( 
				'title' => $data['PodcastItem']['youtube_title'],
				'genre' => 'Podcast',
				'author' => $data['PodcastItem']['author'],
				'course_code' => $data['Podcast']['course_code'],
				'podcast_title' => $data['PodcastItem']['youtube_title'],
				'year' => date("Y"),
				'comments' => 'Item from '.$data['Podcast']['youtube_series_playlist_text'],
			)
		);
		
		return $inject;
	}
		
	/*
	 * @name : commonMetaInjection
	 * @description : Takes a row from the callbacks controller and build common meta data for injection
	 * @updated : 13th July 2011
	 * @by : Charles Jackson
	 */
	function commonMetaInjection( $row ) {

		$inject = array();
		$data = $this->findById( $row['podcast_item_id'] );

		$inject['destination_path'] = $row['destination_path'];
		$inject['destination_filename'] = $row['destination_filename'];
		$inject['meta_data'] = $this->encode_meta_data(
			array( 
				'title' => $data['Podcast']['title'],
				'genre' => 'Podcast',
				'author' => $data['Podcast']['author'],
				'course_code' => $data['Podcast']['course_code'],
				'podcast_title' => $data['Podcast']['title'],
				'year' => date("Y"),
				'comments' => 'Item from '.$data['Podcast']['title']
			)
		);
		
		return $inject;
	}		
	
	/*
	 * @name : needsInjection
	 * @description : Takes an ID as a parameter and determines if it needs meta injection. Returns a bool
	 * @NOTE : 9 = Available
	 * @updated : 18th August 2011
	 * @by : Charles Jackson
	 */
	function needsInjection( $id = null ) {
		
		$this->data = $this->findById( $id );
		
		if( empty( $this->data ) )
			return false;
			
		if( ( strtolower( $this->getExtension( $this->data['PodcastItem']['original_filename'] ) ) == 'mp3' ) )
			return true;
			
		return false;
	}

    /*
     * @name : readyForPublication
     * @description : Custom validation method called from the validation array. If the user has chosen to
     * publish this media ensure it has a title and is available.
     * NOTE: The $check array will contain an associative array eg: array( 'field-name' => field-value )
     * @updated : 26th August 2011
     * @by : Charles Jackson
     */
    function readyForPublication( $check = array() ) {
		
		// get the value of the field being passed
        $value = array_shift( $check );

		// They are publishing media
        if( $value == 'Y' ) {
			
			if( ( $this->data['PodcastItem']['processed_state'] != 9 ) || ( empty( $this->data['PodcastItem']['title'] ) ) )
                return false;
        }

        return true;
    }

	/*
	 * @name : get
	 * @description : Exploits the "containable" behaviour to limit the data being retrieved. It is called from the
	 * podcast_items controller on various methods.
	 * @updated : 6th September 2011
	 * @by : Charles Jackson
	 */
	function get( $id ) {
		
		$this->Behaviors->attach('Containable');
		
		return $this->find('first', array(
			'conditions' => array('PodcastItem.id' => $id ),
			'fields' => array(
				'PodcastItem.*'
			),
			'contain' => array(
				'PodcastMedia' => array(
					'fields' => array(
						'PodcastMedia.id',
						'PodcastMedia.media_type',
						'PodcastMedia.filename',
						'PodcastMedia.processed_state'
					)
				),
				'YoutubeSubjectPlaylists' => array(
					'fields' => array(
						'YoutubeSubjectPlaylists.*'
					)
				),
				'Transcript' => array(
					'fields' => array(
						'Transcript.*'
					)
				),
				'Podcast' => array(
					'fields' => array(
						'Podcast.id',
						'Podcast.custom_id',
						'Podcast.title',
						'Podcast.podcast_flag',
						'Podcast.course_code'
					),
					'Moderators' => array(
						'fields' => array(
							'Moderators.id'
						)
					),
					'Members' => array(
						'fields' => array(
							'Members.id'
						)
					),
					'ModeratorGroups' => array(
						'fields' => array(
							'ModeratorGroups.*'
						),
						'Users' => array(
							'fields' => array(
								'Users.id'
							)
						)				
					),
					'MemberGroups' => array(
						'fields' => array(
							'MemberGroups.*'
						),
						'Users' => array(
							'fields' => array(
								'Users.id'
							)
						)				
					),
					'Owner' => array(
						'fields' => array(
							'Owner.*'
						)
					)
				)
			)
		) );
	}
	
}

