<?php
class AttachmentHelper extends AppHelper {

    private $html = null;
    
	
	
	/*
	 * @name : getMediaImageLink
	 * @description : Will return a string pointing to an image on the media box. If the image request does not exist
	 * it will return a default image string.
	 * @updated : 24th June 2011
	 * @by : Charles Jackson
	 */
	function getMediaImage( $path = null ) {
	
		// Make a head request to ensure it actually exists.
		if(	http_head( DEFAULT_MEDIA_URL.$path ) )
			return DEFAULT_MEDIA_URL.$path;
			
		return NO_IMAGE_AVAILABLE;
	}
	
	function getPodcastImage( $podcast = array(), $name_extension = null ) {
		
		$image_extension = $this->getFileExtension( $podcast['image'] );
		$file_name = $this->getFileName( $podcast['image'] );
		
		return DEFAULT_MEDIA_URL.FEEDS.$file_name.$name_extension.$image_extension;
	}


    /*
     * @name : getPodcastThumbnail
     * @description : Checks to see if a thumbnail exists and will return accordingly else it will return the default image.
     * The thumbnail and folder path can be built using a combination of static text and the ID or CUSTOM_ID field hence the
     * IF statements.
     * @returns : formatted HTML link
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function getPodcastThumbnail( $data = array() ) {

        if( empty( $data['Podcast']['image']) )
            return "<img src='".NO_IMAGE_AVAILABLE."' title='no image available' class='thumbnail' />";

        // Check to see if a thumbnail exists using the custom_id field
        if( file_exists( WWW_ROOT.FEEDS_LOCATION.$data['Podcast']['custom_id'].'/'.$data['Podcast']['custom_id'].THUMBNAIL_EXTENSION.'.'.$this->getFileExtension($data['Podcast']['image'] ) ) )
            return "<img src='/".FEEDS_LOCATION.$data['Podcast']['custom_id']."/".$data['Podcast']['custom_id'].THUMBNAIL_EXTENSION.".".$this->getFileExtension( $data['Podcast']['image'] )."' title='".$data['Podcast']['title']."' class='thumbnail' />";

        // Does the file exist if we use the unique ID field
        if( file_exists( WWW_ROOT.FEEDS_LOCATION.$data['Podcast']['id'].'/'.$data['Podcast']['id'].THUMBNAIL_EXTENSION.'.'.$this->getFileExtension($data['Podcast']['image']) ) )
            return "<img src='/".FEEDS_LOCATION.$data['Podcast']['id']."/".$data['Podcast']['id'].THUMBNAIL_EXTENSION.".".$this->getFileExtension( $data['Podcast']['image'] )."' title='".$data['Podcast']['title']."' class='thumbnail' />";
            
        // No thumbnail exists, return the default 'no image available alternative
        return "<img src='".NO_IMAGE_AVAILABLE."' title='no image available' class='thumbnail'/>";
    }

    /*
     * @name : getPodcastStandardImage
     * @description : Checks to see if an image exists and will return accordingly else it will return the default image.
     * The thumbnail and folder path can be built using a combination of static text and the ID or CUSTOM_ID field hence the
     * IF statements.
     * @returns : formatted HTML link
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function getPodcastStandardImage( $data = array() ) {

        if( empty( $data['Podcast']['image']) )
            return "<img src='".NO_IMAGE_AVAILABLE."' title='no image available' class='resized' />";

        if( file_exists( WWW_ROOT.FEEDS_LOCATION.$data['Podcast']['custom_id'].'/'.$data['Podcast']['custom_id'].RESIZED_IMAGE_EXTENSION.'.'.$this->getFileExtension($data['Podcast']['image'] ) ) )
            return "<img src='/".FEEDS_LOCATION.$data['Podcast']['custom_id']."/".$data['Podcast']['custom_id'].RESIZED_IMAGE_EXTENSION.".".$this->getFileExtension( $data['Podcast']['image'] )."' title='".$data['Podcast']['title']."' class='resized' />";

        // Does the file exist if we use the unique ID field
        if( file_exists( WWW_ROOT.FEEDS_LOCATION.$data['Podcast']['id'].'/'.$data['Podcast']['id'].RESIZED_IMAGE_EXTENSION.'.'.$this->getFileExtension($data['Podcast']['image']) ) )
            return "<img src='/".FEEDS_LOCATION.$data['Podcast']['id']."/".$data['Podcast']['id'].RESIZED_IMAGE_EXTENSION.".".$this->getFileExtension( $data['Podcast']['image'] )."' title='".$data['Podcast']['title']."' class='resized' />";

        // No thumbnail exists, return the default 'no image available alternative
        return "<img src='".NO_IMAGE_AVAILABLE."' title='no image available'  class='resized'/>";
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
     * @name : getTickByText
     * @description : Will return an image representing Yes/No by comparing the value of the parameter passed as a text literal 'Y' or 'N'.
     * @updated : 20th May 2011.
     * @by : Charles Jackson
     */
    function getTickByText( $status = 'N' ) {

        if( strtoupper($status) == 'Y' )
            return "<img src='/img".CORRECT_IMAGE."' title='Yes' class='correct' />";

        return "<img src='/img".INCORRECT_IMAGE."' title='No' class='incorrect' />";
    }

    /*
     * @name : getTickByBool
     * @description : Will return an image representing Yes/No by comparing the value of the parameter passed as a boolean value
     * @updated : 20th May 2011.
     * @by : Charles Jackson
     */
    function getTickByBool( $status = false ) {

        if( $status )
            return "<img src='/img".CORRECT_IMAGE."' title='Yes'  class='correct' />";

        return "<img src='/img".INCORRECT_IMAGE."' title='No' class='correct' />";

    }

    /*
     * @name : getPodcastMediaStandardImage
     * @description :
     * @todo - WRITE IT
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function getPodcastMediaStandardImage( $data = array() ) {

        return "<img src='".NO_IMAGE_AVAILABLE."' title='no image available' class='resized' />";
    }


}
?>
