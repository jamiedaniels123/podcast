<?php
class AttachmentHelper extends AppHelper {

	/*
	 * @name : getMediaImage
	 * @description : Returns a version of the image for the parameters passed.
	 * @updated : 27th June 2011
	 * @by : Charles Jackson
	 */
	function getMediaImage( $image_name = null, $custom_id = null, $extension = null ) {

		$image_name = $this->buildImageName( $image_name, $extension );
		return $this->__getImage( $custom_id.'/'.$image_name );
	}

    /*
     * @name : getTickByText
     * @description : Will return an image representing Yes/No by comparing the value of the parameter passed as a text literal 'Y' or 'N'.
     * @updated : 20th May 2011.
     * @by : Charles Jackson
     */
    function getStatusImage( $status = 'N' ) {

        if( strtoupper($status) == 'Y' or (int)$status )
            return CORRECT_IMAGE;

        return INCORRECT_IMAGE;
    }
			
	/*
	 * @name : getMediaImageLink
	 * @description : Will return a string pointing to an image on the media box. If the image request does not exist
	 * it will return a default image string.
	 * @updated : 24th June 2011
	 * @by : Charles Jackson
	 */
	function __getImage( $path = null ) {

		// Check to see if there is a local image on the admin box first as that will be more topical.
		if(	file_exists( FILE_REPOSITORY.$path ) )
			return LOCAL_FILE_REPOSITORY_URL.$path;
		
		if ( @GetImageSize( DEFAULT_MEDIA_URL.FEEDS.$path ) )
			return DEFAULT_MEDIA_URL.FEEDS.$path;
			
		// No image, return a default.
		return NO_IMAGE_AVAILABLE;
	}

	/*
	 * @name : buildImageName
	 * @description :
	 * @updated : 27th June 2011
	 * @by : Charles Jackson
	 */
	function buildImageName( $image_name, $extension ) {
		
		$image_extension = $this->getFileExtension( $image_name );
		$file_name = $this->getFileName( $image_name );
		
		return $file_name.$extension.'.'.$image_extension;
	}

    /*
     * @name : getFileExtension
     * @description : Return the file extension passed as a parameter
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function getFileExtension( $file_name ) {

        $i = strrpos( $file_name, "." );

        if ( !$i ) { return ""; }

        $l = strlen( $file_name ) - $i;
        return substr( $file_name, $i+1, $l );

    }

    /*
     * @name : getFileExtension
     * @description : Return the file extension passed as a parameter
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function getFileName( $file_name ) {
		
        $i = strrpos( $file_name, "." );

        if ( !$i ) { return $file_name; }

        return substr( $file_name, 0, $i );

    }
	
	/*
	 * @name : getTranscriptLink
	 * @description : Returns a link to a transcript
	 * @updated : 1st July 2011
	 * @by : Charles Jackson
	 */
	 
	function getTranscriptLink( $path = null, $filename = null ) {

		if( empty( $filename ) )
			return('None');
		
		
		
		// Check to see if the file is there
		if(	file_exists( DEFAULT_MEDIA_URL.$path.'/transcript/'.$filename ) )
			return '<a href="'.DEFAULT_MEDIA_URL.$path.'/transcript/'.$filename.'" title="Link to transcript">'.$filename.'</a>';


		if(	file_exists( FILE_REPOSITORY.$path.'/transcript/'.$filename ) )
			return '<a href="'.LOCAL_FILE_REPOSITORY_URL.$path.'/transcript/'.$filename.'" title="Link to transcript">'.$filename.'</a>';
					
		return 'Transcript missing on media server.';
	}
	


}
?>
