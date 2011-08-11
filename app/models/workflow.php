<?php
class Workflow extends AppModel {

    var $name = 'Workflow';
    var $useTable = 'workflow_map';
	var $errors = array();
	
	var $data = array();
	var $id3_data = array();
	var $params = array();
	
	var $file_format = null;
	var $file_extension = null;
	var $screencast  = false;
	var $video_width = null;
	var $video_height = null;
	var $aspect_ratio = null;
	
	public $workflow = null; // Holds the determined workflow.

	var $not_for_transcoding = array('mp3','pdf','m4a','m4b');
	var $video_transcoding = array('mp4','m4v','mov','mpg','wmv','avi','flv','swf','3gp','3g2','mkv');
	var $audio_transcoding = array('wav','ogg','amr','aif','aiff');

	/*
	 * @name : get
	 * @description : Determines the appropriate workflow based on the information provided and sets the class attribute.
	 * @updated : 21st June 2011
	 * @by : Charles Jackson
	 */
	function determine() {
		

		$this->setFileFormat( $this->id3_data['fileformat'] );
		$this->setFileExtension( strtolower( $this->getExtension( $this->id3_data['filename'] ) ) );
		
		if( in_array( $this->file_extension, $this->not_for_transcoding ) ) {

			$this->setWorkflow( DELIVER_WITHOUT_TRANSCODING );
			
		} elseif( in_array( $this->file_extension, $this->video_transcoding ) ) {

			$this->setScreencast( strtoupper( $this->params['url']['ff02v'] ) == 'YES' ? true : false );
			$this->setVideoWidth( isSet( $this->params['video']['resolution_x'] ) ? $this->params['video']['resolution_x'] : 0 );
			$this->setVideoHeight( isSet( $this->params['video']['resolution_y'] ) ? $this->params['video']['resolution_y'] : 0 );
			$this->setAspectRatio( $this->data['PodcastItem']['aspect_ratio'] );
			$this->setWorkflow( $this->__select() );			

			
		} elseif( in_array( $this->file_extension, $this->audio_transcoding ) ) {

			$this->setWorkflow( AUDIO );

		} else {

			// If we reached this point the user has uploaded an unsupported file type. Should never happen because validation
			// also exists in the file chucker upload.
			$this->errors[] = 'We cannot recognise this media file. It cannot be transcoded.';
		}
		
		return count( $this->errors );
		
	}

	/*
	 * @name : setData
	 * @description : Called from the podcast_items controller, the data array contains Podcast and PodcastItem details.
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */	
	function setData( $data = array() ) {
		
		$this->data = $data;
	}
	
	/*
	 * @name : setId3Data
	 * @description : Contain all the information retrieved from the getId3->analyse function called in the podcast_items controller.
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */
	function setId3Data( $id3_data = array() ) {
		
		$this->id3_data = $id3_data;
	}
	
	/*
	 * @name : setParams
	 * @description : Contains all the data passed in the URL by the file chucker script.
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */
	function setParams( $params = array() ) {
		
		$this->params = $params;
	}

	/* 
	 * @name : setFileFormat
	 * @description : Standard setter
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */
	function setFileFormat( $file_format = null ) {
		
		$this->file_format = $file_format;
	}
	
	/* 
	 * @name : setFileExtension
	 * @description : Standard setter
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */
	function setFileExtension( $file_extension = null ) {
		
		$this->file_extension = $file_extension;
	}

	/* 
	 * @name : setScreenCast
	 * @description : Standard setter
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */		
	function setScreenCast( $screencast = false ) {
	
		$this->screencast = $screencast;
	}

	/* 
	 * @name : setVideoWidth
	 * @description : Standard setter
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */		
	function setVideoWidth( $video_width = 0 ) {
		
		$this->video_width = $video_width;
	}

	/* 
	 * @name : setVideoHeight
	 * @description : Standard setter
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */		
	function setVideoHeight( $video_height = 0 ) {
		
		$this->video_height = $video_height;
	}
	
	/* 
	 * @name : setAspectRatio
	 * @description : Standard setter
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */		
	function setAspectRatio( $aspect_ratio = null ) {
		
		// If the user chose an aspect ratio on upload, use it.
		if( $aspect_ratio ) {
			
			$this->aspect_ratio = $aspect_ratio;
		
		// The user did not specify an aspect ratio on upload, figure it out.
		} else {
			
			if( $this->video_width == 0 ) {
				
				$this->aspect_ratio = STANDARD_SCREEN;
				
			} else {
				
				$this->aspect_ratio = ( $this->video_height / $this->video_width );
				
				if( $this->aspect_ratio < 0.6 ) {
					
					$this->aspect_ratio = WIDE_SCREEN;
					
				} else {
					
					$this->aspect_ratio = STANDARD_SCREEN;
				}
			}
		}
		
	}

	/* 
	 * @name : setWorkflow
	 * @description : Standard setter
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */		
	function setWorkflow( $workflow = null ) {
		
		$this->workflow = $workflow;
	}
	
	/* 
	 * @name : getWorkflow
	 * @description : Standard getter
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */			
	function getWorkflow() {
		
		return $this->workflow;	
	}

	/* 
	 * @name : getAspectRatio
	 * @description : Standard getter
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */			
	function getAspectRatio() {
		
		return $this->aspect_ratio;
	}
	
	/*
	 * @name : exists
	 * @description : Called from the controller to determine if the current media file has a workflow
	 * else it will be transferred direct to the media box.
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */
	function exists() {
		
		if( empty( $this->workflow ) )
			return false;
			
		return true;	
	}

	/*
	 * @name : __select
	 * @description : 
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */
	protected function __select() {

		if( $this->screencast ) {

			if( $this->aspect_ratio == WIDE_SCREEN ) {

				return SCREENCAST_WIDE;
				
			} else {

				return SCREENCAST;
			}
			
		} else {

			if( $this->aspect_ratio == WIDE_SCREEN ) {
				
				return VIDEO_WIDE;
				
			} else {
				
				return VIDEO;
			}
		}
	}
	
	/*
	 * @name : hasErrors
	 * @description : Returns a count of the elements in class attribute "errors"
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */	
	function hasErrors() {
	
		if( empty( $this->errors ) )	
			return false;
		
		return true;
	}

	/*
	 * @name : getErrors
	 * @description : Returns the "errors" array.
	 * @updated : 29th June 2011
	 * @by : Charles Jackson
	 */		
	function getErrors() {
		
		return $this->errors;	
	}
}
