<?php
class Workflow extends AppModel {

    var $name = 'Workflow';
    var $useTable = false;
	var $data = array();
	var $media_info = array();
	
	var $aspect_ratio = null;
	var $screencast  = null;
	var $shortcode = null;
	var $md5_shortcode = null;	
	var $workflow = null;
	
	const $MP3 = 'mp3';
	const $PDF = 'pdf';
	
	const $M4A = 'm4a';
	const $M4B = 'm4b';
	
	const $MP4 = 'mp4';
	const $M4V = 'm4v';
	const $MOV = 'mov';
	const $MPG = 'mpg';
	const $WMV = 'wmv';
	const $AVI = 'avi';
	const $FLV = 'flv';
	const $SWF = 'swf';
	const $3GP = '3gp';
	const $3G2 = '3g2';
	const $MKV = 'mkv';
	
	const $WAV = 'wav';
	const $OGG = 'ogg';
	const $AIF = 'aif';
	const $AIFF = 'aiff';

	/*
	 * @name : get
	 * @description : Return the appropriate workflow based on the information provided.
	 * @updated : 21st June 2011
	 * @by : Charles Jackson
	 */
	function determine() {
		
			$this->setShortcode( $this->data['PodcastItem']['original_filename'] );
			$this->setMD5Shortcode( $this->data['Podcast']['custom_id'], $this->data['PodcastItem']['original_filename'] );
		
	}
	
	
	function setData( $data = array() ) {
		
		$this->data = $data;
		
	}
	
	function setMediaInfo( $media_info = array() ) {
		
		$this->media_info = $media_info;
		
	}
	
	function setScreenCast( $screencase = 'N' ) {
	
			$this->screencast = $screencast
		
	}
	
	function setShortCode( $filename = null ) {
	
		if( !empty( $filename ) {
		
			$filename_less_extension = substr( $filename, 0, strrpos( $filename,'.' ) );
			$this->shortcode = substr( md5( $filename_less_extension ), 0, 10 );
			
		}
	}
	
	
	function setMD5Shortcode( $custom_id, $filename ) {

		  if ( !empty( $custom_id ) && !empty( $original_filename ) ) {
			  
			$this->md5_shortcode = md5( DEFAULT_MEDIA_URL . FEEDS . $custom_id . '/' . $filename );
		  }
	}
	
	function setAspectRatio( $aspect_ratio ) {
		
		$this->aspect_ratio = $aspect_ratio;
		
	}
	
}