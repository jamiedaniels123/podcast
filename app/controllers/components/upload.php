<?php
class UploadComponent extends Object {

    var $components = array( 'Api' );
    
   /*
    * @name : UploadComponent
    * @description : Used to upload media accessories such as images and transcripts and will take the following parameters :-
    * @updated : 6th May 2011
    * @by : Charles Jackson
    */

    var $controller = null;
    public $allowed_file_types = array('jpeg','jpg');
    public $error = null;
    private $data = null; // Contains the full array of data
    private $data_key = null; // The name of the array element
    private $folder = null; // Contains the folder with absolute path on the local server
    private $custom_id = null;  // The custom_id is used as the folder and is passed to the media server as a relative path
    private $temporary_file = null; // The name of the temporary file uploaded into TMP folder
    private $file_extension = null; // The file extension being uploaded.
    private $data_collection = null; // Used in error message to explain exactly which image collection is in error such as "logoless, podcast, wide" etc
	private $uploaded_file_name = null; // Holds the name of the file that was uploaded.
    var $html = null;

    /*
     * @name : podcastMediaImage
     * @description : Will create three versions of the image including the original, a cropped version and a thumbnail.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function podcastMediaImage( $data = array(), $data_key = null ) {
		
    	$this->error = null;
    	
        // Have they tried uploading an image?
		if( $this->attemptedUpload( $data, $data_key ) == false )
			return false;

        // Has an image been uploaded and is it error free?
        if ( (int)$data[$this->controller->modelClass][$data_key]['error'] ) {

            $this->error = 'There has been a problem uploading your podcast media images. Please try again.';
            return false;
        }

        $this->setDataCollection('Podcast Media');
        $this->setData( $data );
        $this->setCustomId( $this->data['Podcast']['custom_id'] );
        $this->setFolderName( $this->data['Podcast']['custom_id'] );
        $this->setDataKey( $data_key );
        $this->setFileName( 'MEDIA_'.$this->data['PodcastItem']['id'].'_'.$this->data['Podcast']['custom_id'] );

        if( $this->isValidImage() == false ) // Will set the file_extension if valid.
            return false;

        if( $this->createTemporaryFile() == false )
            return false;


        if( $this->createFolder() == false )
            return false;

        $this->__createImages(); // Create 3 versions of the image

        // Now we need to call the Api and schedule the images for transfer to the media server.
        if( $this->__transferImagesToMediaServer() == false )
            return false;

		// The legacy system stores the image at podcast item level name without an extension. We are obliged to follow this convention.
		$this->setUploadedFileName( $this->file_name );
		
        return true;
    }


    /*
     * @name : podcastImage
     * @description : Will create three versions of the image including the original, a cropped version and a thumbnail.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function podcastImage( $data, $data_key ) {

		$this->error = null;
		
        // Have they tried uploading an image?
		if( $this->attemptedUpload( $data, $data_key ) == false )
			return false;


        // Has an image been uploaded and is it error free?
        if ( (int)$data['Podcast'][$data_key]['error'] ) {

            $this->error = 'There has been a problem uploading your podcast images. Please try again.';
            return false;
        }
		
        $this->setDataCollection('Podcast');
        $this->setData( $data );
        $this->setCustomId( $this->data['Podcast']['custom_id'] );
        $this->setFolderName( $this->data['Podcast']['custom_id'] );
        $this->setDataKey( $data_key );
        $this->setFileName( $this->data['Podcast']['custom_id'] );

        if( $this->isValidImage() == false )
            return false;

        if( $this->createTemporaryFile() == false )
            return false;


        if( $this->createFolder() == false )
            return false;

        $this->__createImages(); // Create 3 versions of the image

        // Now we need to call the Api and schedule the images for transfer to the media server.
        if( $this->__transferImagesToMediaServer() == false )
            return false;

		$this->setUploadedFileName( $this->file_name.'.jpg' );
	
        return true;
    }

    /*
     * @name : logolessPodcastImage
     * @description : Will create three versions of the image including the original, a cropped version and a thumbnail.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function logolessPodcastImage( $data, $data_key ) {

    	$this->error = null;
    	
        // Have they tried uploading an image?
		if( $this->attemptedUpload( $data, $data_key ) == false )
			return false;

        // Has an image been uploaded and is it error free?
        if ( (int)$data[$this->controller->modelClass][$data_key]['error'] ) {

            $this->error = 'There has been a problem uploading your logoless images. Please try again.';
            return false;
        }

        $this->setDataCollection('Logoless');
        $this->setData( $data );
        $this->setCustomId( $this->data['Podcast']['custom_id'] );
        $this->setFolderName( $this->data['Podcast']['custom_id'] );
        $this->setDataKey( $data_key );
        $this->setFileName( 'LL_'.$this->data['Podcast']['custom_id'] );

        if( $this->isValidImage() == false )
            return false;

        if( $this->createTemporaryFile() == false )
            return false;


        if( $this->createFolder() == false )
            return false;

        $this->__createImages(); // Create 3 versions of the image

        // Now we need to call the Api and schedule the images for transfer to the media server.
        if( $this->__transferImagesToMediaServer() == false )
            return false;


		$this->setUploadedFileName( $this->file_name.'.jpg' );
	
        return true;

    }

    /*
     * @name : widePodcastImage
     * @description : Will create three versions of the image including the original, a cropped version and a thumbnail.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function widePodcastImage( $data, $data_key ) {

    	$this->error = null;
    	
        // Have they tried uploading an image?
		if( $this->attemptedUpload( $data, $data_key ) == false )
			return false;

        // Has an image been uploaded and is it error free?
        if ( (int)$data[$this->controller->modelClass][$data_key]['error'] ) {

            $this->error = 'There has been a problem uploading your widescreen images. Please try again.';
            return false;
        }

        $this->setDataCollection('Widescreen');
        $this->setData( $data );
        $this->setCustomId( $this->data['Podcast']['custom_id'] );
        $this->setFolderName( $this->data['Podcast']['custom_id'] );
        $this->setDataKey( $data_key );
        $this->setFileName( 'WS_'.$this->data['Podcast']['custom_id'] );

        if( $this->isValidImage() == false )
            return false;

        if( $this->createTemporaryFile() == false )
            return false;


        if( $this->createFolder() == false )
            return false;

        $this->__createImages(); // Create 3 versions of the image

        // Now we need to call the Api and schedule the images for transfer to the media server.
        if( $this->__transferImagesToMediaServer() == false )
            return false;

		$this->setUploadedFileName( $this->file_name.'.jpg' );
	
        return true;

    }
	
	/*
	 * @name : artwork
	 * @description :
	 * @updated : 16th August 2011
	 * @by : Charles Jackson
	 */
	function artwork( $data = array(), $data_key ) {
		
    	$this->error = null;
    	
        // Have they tried uploading an image?
		if( $this->attemptedUpload( $data, $data_key ) == false )
			return false;

        // Has an image been uploaded and is it error free?
        if ( (int)$data[$this->controller->modelClass][$data_key]['error'] ) {

            $this->error = 'There has been a problem uploading the artwork file. Please try again.';
            return false;
        }

        $this->setDataCollection('iTunes artwork');
        $this->setData( $data );
        $this->setCustomId( $this->data['Podcast']['custom_id'] );
        $this->setFolderName( $this->data['Podcast']['custom_id'] );
        $this->setDataKey( $data_key );
        $this->setFileName( 'ARTWORK_'.$this->data['Podcast']['custom_id'].'.zip' );
		$this->setFileExtension( $this->data['Podcast'][$this->data_key]['name'] );
		
        if( $this->isZip() == false )
            return false;

        if( $this->createTemporaryFile() == false )
            return false;


        if( $this->createFolder() == false )
            return false;

		if ( copy( $this->temporary_file, FILE_REPOSITORY.$this->folder.'/'.$this->file_name ) ) {
		
			// Now we need to call the Api and schedule the artwork file for transfer to the media server.
			if(
				$this->Api->transferFileMediaServer(
				array(
					array(
						'source_path' => $this->custom_id.'/',
						'destination_path' => $this->custom_id.'/',
						'source_filename' => $this->file_name,
						'destination_filename' => $this->file_name
						)
					)
				)
			) {
	
				$this->setUploadedFileName( $this->file_name );
				return true;
			}
		}
		
        $this->error = 'Could not upload and/or schedule movement of your ' . $this->data_collection . ' to the media server. If the problem persists please alert an administrator.';
        return false;
	}
	
    /*
     * @name : transcript
     * @description : Will upload a transcript
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function transcript( $data = array(), $data_key ) {

    	$this->error = null;
    	
        // Have they tried uploading a transcript?
        if ( ( isSet( $data['Transcript'][$data_key] ) == false ) || ( strlen( $data['Transcript'][$data_key]['name'] ) == 0 ) )
			return false;

        // Has an image been uploaded and is it error free?
        if ( (int)$data['Transcript'][$data_key]['error'] ) {

            $this->error = 'There has been a problem uploading your transcript. Error code : '.(int)$data['Transcript'][$data_key]['error'].' Please try again.';
            return false;
        }
        
		$this->setDataCollection('Podcast Media Transcript');
        $this->setData( $data );
		$this->setCustomId( $this->data['Podcast']['custom_id'] );
        $this->setFolderName( $this->data['Podcast']['custom_id'].'/'.strtolower( TRANSCRIPT ) );
        $this->setDataKey( $data_key );
        $this->setFileName( $this->data['Podcast']['custom_id'].'.pdf' );
        $this->setFileExtension( $this->data['Transcript'][$this->data_key]['name'] );
		
        if( $this->isPDF() == false )
            return false;

        if( $this->createTemporaryFile( 'Transcript' ) == false )
            return false;

        if( $this->createFolder() == false )
            return false;

		if ( copy( $this->temporary_file, FILE_REPOSITORY.$this->folder.'/'.$this->file_name ) ) {
		
			// Now we need to call the Api and schedule the images for transfer to the media server.
			if(
				$this->Api->transferFileMediaServer(
				array(
					array(
						'source_path' => $this->custom_id.'/transcript/',
						'destination_path' => $this->custom_id.'/transcript/',
						'source_filename' => $this->file_name,
						'destination_filename' => $this->file_name
						)
					)
				)
			) {
	
				$this->setUploadedFileName( $this->file_name );
				return true;
			}
		}

        $this->error = 'Could not upload and/or schedule movement of your ' . $this->data_collection . ' document to the media server. If the problem persists please alert an administrator.';
        return false;
    }
	

    /* NOTHING TO SEE HERE FOLKS!!!!!!!!!!!!!!
     * Below this line are the generic methods for uploading/resizing an image.
     */

    /*
     * @name : initialize
     * @description : Grab the controller reference for later use.
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function initialize( & $controller) {

       $this->controller = & $controller;
    }

    /*
     * @name : setDataCollection
     * @description : Standard setter
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function setDataCollection( $data_collection = null ) {

        $this->data_collection = $data_collection;
    }

    /*
     * @name : setCustomId
     * @description : Standard setter
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function setCustomId( $custom_id = null ) {

        $this->custom_id = $custom_id;
    }

    /*
     * @name : setFolderName
     * @description : Standard setter
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function setFolderName( $folder_name = null ) {
		
        $this->folder = $folder_name;
    }

    /*
     * @name : setDataKey
     * @description : Standard setter
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function setDataKey( $data_key = null ) {

        $this->data_key = $data_key;
    }

    /*
     * @name : setData
     * @description : Standard setter
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function setData( $data = array() ) {

        $this->data = $data;
    }

    /*
     * @name : setFilename
     * @description : Standard setter
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function setFilename( $file_name = null ) {

        $this->file_name = $file_name;
    }

    /*
     * @name : isValidImage
     * @description : Will check the file extension against a list of allowed file types and return a boolean.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function isValidImage() {

        $this->setFileExtension( $this->data[$this->controller->modelClass][$this->data_key]['name'] );

        if ( in_array($this->file_extension, $this->allowed_file_types ) == false ) {
            $this->error = 'Your '.$this->data_collection.' image is not in a valid format.';
            return false;
        }

        return true;
    }

    /*
     * @name : isPDF
     * @description : Will check the file extension as being PDF and set the file extension
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function isPDF() {

        if ( strtolower( $this->file_extension ) != 'pdf' ) {

            $this->error = 'Your '.$this->data_collection.' is not in a valid PDF format.';
            return false;
        }

        return true;
    }

    /*
     * @name : isZip
     * @description : Will check the file extension as being ZIP and set the file extension property
     * @updated : 16th August 2011
     * @by : Charles Jackson
     */
    function isZip() {

        if ( strtolower( $this->file_extension ) != 'zip' ) {

            $this->error = 'Your '.$this->data_collection.' must be contained in a ZIP file.';
            return false;
        }

        return true;
    }

    /*
     * @name : createTemporaryFile
     * @description : Will upload the image into a temporary location
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function createTemporaryFile( $model_class = null ) {

		if( $model_class == null ) // Captured images are stored within the Model class data array however transcripts are an exception
			$model_class = $this->controller->modelClass;
			
        // Generate a unique name for the image (from the timestamp)
        $id_unic = str_replace( ".", "", strtotime ( "now" ) );
        $file_name = $id_unic;

        settype( $file_name, 'string' );
        $file_name.= '.';
        $file_name .= $this->file_extension;

        $this->temporary_file = TMP .$file_name;

        if ( is_uploaded_file( $this->data[$model_class][$this->data_key]['tmp_name'] ) ) {

            // Copy the image into the temporary directory
            if ( !copy( $this->data[$model_class][$this->data_key]['tmp_name'], $this->temporary_file ) ) {
                
                $this->error = 'Could not copy your '.$this->data_collection.' image into a temporary location on server. If the problem persists please alert an administrator.';
                return false;
            }

            return true;
        }

        return false;
    }


    /*
     * @name : createFolder
     * @description : Will check to see if the proposed folder already exists for the asset being uploaded, if not it will
     * create one.
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function createFolder() {

        $new_folders = explode( '/', $this->folder );
        $new_folder_path = FILE_REPOSITORY;

        foreach( $new_folders as $new_folder ) {

            $new_folder_path .= $new_folder.'/';

            if( !is_dir( $new_folder_path ) ) {

                if( mkdir( $new_folder_path, 0755, true ) == false ) {
                    $this->error = 'Could not create the following folder structure for your '.$this->data_collection.' - '.$new_folder_path.'. If the problem persists please alert an administrator.';
                    return false;
                }
            }
        }
		
		return true;
    }

    /*
     * @name : setFileExtension
     * @description : Sets the name of the file extension.
	 * @NOTE: The legacy system renames every image with a "jpg" extension (doh!) and it is a convention we are obliged to follow... 
	 * Therefore I have written a proper solution and a workaround
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function setFileExtension( $file_name ) {

		$i = strrpos( $file_name, "." );

		if ( !$i ) { return ""; }

		$l = strlen( $file_name ) - $i;
		$this->file_extension = substr( $file_name, $i+1, $l );
    }
	
    /*
     * @name : setUploadedFileName
     * @description : Sets the name of the uploaded file
     * @updated : 28th June 2011
     * @by : Charles Jackson
     */
	function setUploadedFileName( $file_name = null ) {
		
		$this->uploaded_file_name = $file_name;
	}
	
    /*
     * @name : __createImages
     * @description : Will create 3 images using a common naming convention
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function __createImages() {
		
        // Create a copy of the original file.
        copy( $this->temporary_file, FILE_REPOSITORY.$this->folder.'/'.$this->file_name.'.jpg' );
        // Create a resized copy of the file.
        $this->resizeImage($this->temporary_file, 300, FILE_REPOSITORY.$this->folder.'/'.$this->file_name.RESIZED_IMAGE_EXTENSION.'.jpg' );
        // Generate a thumbnail square version of the image.
        $this->resizeImage( $this->temporary_file, 50, FILE_REPOSITORY.$this->folder.'/'.$this->file_name.THUMBNAIL_EXTENSION.'.jpg' );
		
		unlink( $this->temporary_file );
    }

    /*
     * @name : __transferImagesToMediaServer
     * @destination : Using the API it will transfer uploaded images to the media server. Worth noting, it assumes
     * the images come in three standard formats. Will return a bool.
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function __transferImagesToMediaServer() {

        if(
            $this->Api->transferFileMediaServer(
            array(
                array(
                    'source_path' => $this->custom_id.'/',
                	'source_filename' => $this->file_name.'.'.$this->file_extension,
                    'destination_path' => $this->custom_id.'/',
                    'destination_filename' => $this->file_name.'.'.$this->file_extension
                ),
                array(
                    'source_path' => $this->custom_id.'/',
                	'source_filename' => $this->file_name.RESIZED_IMAGE_EXTENSION.'.'.$this->file_extension,
                    'destination_path' => $this->custom_id.'/',
                    'destination_filename' => $this->file_name.RESIZED_IMAGE_EXTENSION.'.'.$this->file_extension
                ),
                array(
                    'source_path' => $this->custom_id.'/',
                	'destination_filename' => $this->file_name.THUMBNAIL_EXTENSION.'.'.$this->file_extension,
                    'destination_path' => $this->custom_id.'/',
                    'source_filename' => $this->file_name.THUMBNAIL_EXTENSION.'.'.$this->file_extension
                    )
                )
            )
        ) {

            return true;
        }

        $this->error = 'Could not schedule movement of your '.$this->data_collection.' images to the media server. If the problem persists please alert an administrator.';
        return false;
    }

    /*
     * @name : resizeImage
     * @description : Resize an image according to the parameters passed.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function resizeImage( $imgname, $size, $filename ) {

        switch( $this->file_extension ) {
            case 'jpeg':
            case 'jpg':
            $img_src = imageCreateFromjpeg ($imgname);
            break;
            case 'gif':
            $img_src = imagecreatefromgif ($imgname);
            break;
            case 'png':
            $img_src = imagecreatefrompng ($imgname);
            break;
        }

        $true_width = imagesx( $img_src );
        $true_height = imagesy( $img_src );

        if ( $true_width >= $true_height )
        {
            $width = $size;
            $height = ( $width / $true_width ) * $true_height;
        }
        else
        {
            $width = $size;
            $height = ( $width / $true_width ) * $true_height;
        }
        $img_des = ImageCreateTrueColor( $width, $height );
        imagecopyresampled ( $img_des, $img_src, 0, 0, 0, 0, $width, $height, $true_width, $true_height );

        // Save the resized image
        switch( $this->file_extension ) {

            case 'jpeg':
            case 'jpg':
            imagejpeg($img_des,$filename,80);
            break;
            case 'gif':
            imagegif($img_des,$filename,80);
            break;
            case 'png':
            imagepng($img_des,$filename,80);
            break;
        }
    }

    /*
     * @name : recursiveRemoveFolder
     * @description : This method will remove a folder and its content else, if empty
     * is set to TRUE it will recursively empty the folder specific but leave the folder
     * itself intact.
     * @updated : 5th may 2011
     * @by : Charles Jackson
     */
    function recursiveRemoveFolder( $directory, $empty = false ) {

        // if the path has a slash at the end we remove it here
        if( substr( $directory,-1 ) == '/' ) {

            $directory = substr( $directory, 0, -1 );
        }

        // if the path is not valid or is not a directory ...
        if( !file_exists( $directory ) || !is_dir( $directory ) ) {

            // ... we return false and exit the function
            return false;

        // ... if the path is not readable
        } elseif( !is_readable( $directory ) ) {

            // ... we return false and exit the function
            return false;

        // ... else if the path is readable
        } else {

            // we open the directory
            $handle = opendir($directory);

            // and scan through the items inside
            while( false !== ( $item = readdir( $handle ) ) ) {

                // if the filepointer is not the current directory
                // or the parent directory
                if( $item != '.' && $item != '..') {

                    // we build the new path to delete
                    $path = $directory.'/'.$item;

                    // if the new path is a directory
                    if( is_dir( $path ) ) {

                        // we call this function with the new path
                        $this->recursiveRemoveFolder( $path );
                        // if the new path is a file

                    } else {

                        // we remove the file
                        unlink( $path );
                    }
                }
            }

            // close the directory
            closedir( $handle );

            // if the option to empty is not set to true
            if( $empty == false ) {

                // try to delete the now empty directory
                if( !rmdir( $directory ) ) {

                    // return false if not possible
                    return false;
                }
            }
            // return success
            return false;
        }
    }

    /*
     * @name : getError
     * @description : Will create the image names from the parameters passed
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function getError() {

        return $this->error;
    }

    /*
     * @name : hasError
     * @description : Will return a count of the number of elements in the array
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function hasError() {

    	if( empty( $this->error ) )
    		return false;
    		
   		return true;
    }
	
	
	function getUploadedFileName() {
		
		return $this->uploaded_file_name;
	}

	/*
	 * @name : attemptedUpload
	 * @description : Checks to see if the user attempted to upload a specific attachment on form submission.
	 * @updated : 28th June 2011
	 * @by : Charles Jackson
	 */
	function attemptedUpload( $data = array(), $data_key ) {
		
        if ( ( isSet( $data[$this->controller->modelClass][$data_key] ) == false ) || ( strlen( $data[$this->controller->modelClass][$data_key]['name'] ) == 0 ) )
			return false;
			
		return true;
		
	}

}

?>
