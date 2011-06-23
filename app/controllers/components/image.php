<?php
class ImageComponent extends Object {

    var $components = array( 'Api' );
    
   /*
    * @name : ImageComponent
    * @description : Used to upload images and will take the following parameters :-
    *  $data: CakePHP data array from the form
    *  $image_key: key in the $data array. If you used <?= $form->file('Podcast/image1'); ?> in your view, then $image_key = image1
    *  $imgscale: the maximum width or height that you want your picture to be resized to
    * @updated : 6th May 2011
    * @by : Charles Jackson
    */

    var $controller = null;
    public $allowed_file_types = array('jpeg','jpg','png');
    public $errors = array();
    private $data = null; // Contains the full array of data
    private $image_key = null; // The name of the array element
    private $folder = null; // Contains the folder with absolute path on the local server
    private $custom_id = null;  // The custom_id is used as the folder and is passed to the media server as a relative path
    private $temporary_file = null; // The name of the temporary file uploaded into TMP folder
    private $file_extension = null; // The file extension being uploaded.
    private $image_collection = null; // Used in error message to explain exactly which image collection is in error such as "logoless, podcast, wide" etc
    var $html = null;

    /*
     * @name : uploadPodcastImage
     * @description : Will create three versions of the image including the original, a cropped version and a thumbnail.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function uploadPodcastMediaImage( $data = array(), $image_key = null ) {

        // Have they tried uploading an image?
        if ( strlen( $this->data[$this->controller->modelClass][$this->image_key]['name'] ) == 0 )
            return false;

        // Has an image been uploaded and is it error free?
        if ( (int)$this->data[$this->controller->modelClass][$this->image_key]['error'] ) {

            $this->errors[] = 'There has been a problem uploading your podcast media images. Please try again.';
            return false;
        }

        $this->setImageCollection('Podcast Media');
        $this->setData( $data );
        $this->setCustomId( $this->data['Podcast']['custom_id'] );
        $this->setFolderName( FEEDS_LOCATION.$this->data['Podcast']['custom_id'] );
        $this->setImageKey( $image_key );
        $this->setFileName( $this->data[$this->controller->modelClass][$this->image_key]['name']['filename'].'_'.$this->data['Podcast']['id'].'_'.$this->data['PodcastItem']['id'] );

        if( $this->isValidImage() == false )
            return false;

        if( $this->createTemporaryFile() == false )
            return false;


        if( $this->createFolder() == false )
            return false;

        $this->createImages(); // Create 3 versions of the image

        // Now we need to call the Api and schedule the images for transfer to the media server.
        if( $this->__transferImagesToMediaServer() == false )
            return false;

        return $this->file_name.'.'.$this->file_extension;

    }


    /*
     * @name : uploadPodcastImage
     * @description : Will create three versions of the image including the original, a cropped version and a thumbnail.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function uploadPodcastImage( $data, $image_key ) {

        // Have they tried uploading an image?
        if ( strlen( $this->data[$this->controller->modelClass][$this->image_key]['name'] ) == 0 )
            return false;

        // Has an image been uploaded and is it error free?
        if ( (int)$this->data[$this->controller->modelClass][$this->image_key]['error'] ) {

            $this->errors[] = 'There has been a problem uploading your podcast images. Please try again.';
            return false;
        }

        $this->setImageCollection('Podcast');
        $this->setData( $data );
        $this->setCustomId( $this->data['Podcast']['custom_id'] );
        $this->setFolderName( FEEDS_LOCATION.$this->data['Podcast']['custom_id'] );
        $this->setImageKey( $image_key );
        $this->setFileName( $this->data[$this->controller->modelClass][$this->image_key]['name']['filename'].'_'.$this->data['Podcast']['id'] );

        if( $this->isValidImage() == false )
            return false;

        if( $this->createTemporaryFile() == false )
            return false;


        if( $this->createFolder() == false )
            return false;

        $this->createImages(); // Create 3 versions of the image

        // Now we need to call the Api and schedule the images for transfer to the media server.
        if( $this->__transferImagesToMediaServer() == false )
            return false;

        return $this->file_name.'.'.$this->file_extension;
    }

    /*
     * @name : uploadLogolessPodcastImage
     * @description : Will create three versions of the image including the original, a cropped version and a thumbnail.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function uploadLogolessPodcastImage( $data, $image_key ) {

        // Have they tried uploading an image?
        if ( strlen( $this->data[$this->controller->modelClass][$this->image_key]['name'] ) == 0 )
            return false;

        // Has an image been uploaded and is it error free?
        if ( (int)$this->data[$this->controller->modelClass][$this->image_key]['error'] ) {

            $this->errors[] = 'There has been a problem uploading your logoless images. Please try again.';
            return false;
        }

        $this->setImageCollection('Logoless');
        $this->setData( $data );
        $this->setCustomId( $this->data['Podcast']['custom_id'] );
        $this->setFolderName( FEEDS_LOCATION.$this->data['Podcast']['custom_id'] );
        $this->setImageKey( $image_key );
        $this->setFileName( 'LL_'.$this->data[$this->controller->modelClass][$image_key]['name']['filename'].'_'.$this->data['Podcast']['id'] );

        if( $this->isValidImage() == false )
            return false;

        if( $this->createTemporaryFile() == false )
            return false;


        if( $this->createFolder() == false )
            return false;

        $this->createImages(); // Create 3 versions of the image

        // Now we need to call the Api and schedule the images for transfer to the media server.
        if( $this->__transferImagesToMediaServer() == false )
            return false;

        return $this->file_name.'.'.$this->file_extension;
    }

    /*
     * @name : uploadWidePodcastImage
     * @description : Will create three versions of the image including the original, a cropped version and a thumbnail.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function uploadWidePodcastImage( $data, $image_key ) {

        // Have they tried uploading an image?
        if ( strlen( $this->data[$this->controller->modelClass][$this->image_key]['name'] ) == 0 )
            return false;

        // Has an image been uploaded and is it error free?
        if ( (int)$this->data[$this->controller->modelClass][$this->image_key]['error'] ) {

            $this->errors[] = 'There has been a problem uploading your widescreen images. Please try again.';
            return false;
        }

        $this->setImageCollection('Widescreen');
        $this->setData( $data );
        $this->setCustomId( $this->data['Podcast']['custom_id'] );
        $this->setFolderName( FEEDS_LOCATION.$this->data['Podcast']['custom_id'] );
        $this->setImageKey( $image_key );
        $this->setFileName( 'WS_'.$this->data[$this->controller->modelClass][$image_key]['name']['filename'].'_'.$this->data['Podcast']['id'] );

        if( $this->isValidImage() == false )
            return false;

        if( $this->createTemporaryFile() == false )
            return false;


        if( $this->createFolder() == false )
            return false;

        $this->createImages(); // Create 3 versions of the image

        // Now we need to call the Api and schedule the images for transfer to the media server.
        if( $this->__transferImagesToMediaServer() == false )
            return false;

        return $this->file_name.'.'.$this->file_extension;
    }

    /* NOTHING TO SEE HERE FOLKS!!!!!!!!!!!!!!
     * Below this line are the generic methods for uploading/resizing an image.
     */

    /*
     * @name : startup
     * @description : Grab the controller reference for later use.
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function startup( & $controller) {

       $this->controller = & $controller;
    }

    /*
     * @name : setImageCollection
     * @description : Standard setter
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function setImageCollection( $image_collection = null ) {

        $this->image_collection = $image_collection;
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

        $this->folder_name = $folder_name;
    }

    /*
     * @name : setImageKey
     * @description : Standard setter
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function setImageKey( $image_key = null ) {

        $this->image_key = $image_key;
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

        $this->setFileExtension( $this->data[$this->controller->modelClass][$this->image_key]['name'] );

        if ( !in_array($this->file_extension, $this->allowed_file_types ) ) {
            $this->errors[] = 'Your '.$this->image_collection.' image is not in a valid format.';
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
    function createTemporaryFile() {

        // Generate a unique name for the image (from the timestamp)
        $id_unic = str_replace( ".", "", strtotime ( "now" ) );
        $file_name = $id_unic;

        settype( $file_name, 'string' );
        $file_name.= '.';
        $file_name .= $this->file_extension;

        $this->temporary_file = TMP . '/'.$file_name;

        if ( is_uploaded_file( $this->data[$this->controller->modelClass][$this->image_key]['tmp_name'] ) ) {

            // Copy the image into the temporary directory
            if ( !copy( $this->data[$this->controller->modelClass][$this->image_key]['tmp_name'], "$this->temporary_file" ) ) {
                
                $this->errors[] = 'Could not copy your '.$this->image_collection.' image into a temporary location on server. If the problem persists please alert an administrator.';
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
        $new_folder_path = WWW_ROOT;

        foreach( $new_folders as $new_folder ) {

            $new_folder_path .= $new_folder.'/';

            if( !is_dir( $new_folder_path ) ) {

                if( mkdir( $new_folder_path, 0755, true ) == false ) {
                    $this->errors[] = 'Could not create the following folder structure for your '.$this->image_collection.' - '.$new_folder_path.'. If the problem persists please alert an administrator.';
                    return false;
                }
            }
        }
    }

    /*
     * @name : setFileExtension
     * @description : Return the file extension passed as a parameter
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
     * @name : createImages
     * @description : Will create 3 images using a common naming convention
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function __createImages() {

        // Create a copy of the original file.
        copy( $this->temporary_file, $this->folder.'/'.$this->file_name.'.'.$this->file_extension );
        // Create a resized copy of the file.
        $this->resizeImage($this->temporary_file, 300, $this->folder.'/'.$this->file_name.RESIZED_IMAGE_EXTENSION.'.'.$this->file_extension );
        // Generate a thumbnail square version of the image.
        $this->resizeImage( $this->temporary_file, 50, $this->folder.'/'.$this->file_name.THUMBNAIL_EXTENSION.'.'.$this->file_extension );

        // Delete the temporary image
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
                    'source_path' => $this->custom_id,
                    'destination_path' => $this->custom_id,
                    'filename' => $this->file_name.'.'.$this->file_extension
                ),
                array(
                    'source_path' => $this->custom_id,
                    'destination_path' => $this->custom_id,
                    'filename' => $this->file_name.RESIZED_IMAGE_EXTENSION.'.'.$this->file_extension
                ),
                array(
                    'source_path' => $this->custom_id,
                    'destination_path' => $this->custom_id,
                    'filename' => $this->file_name.THUMBNAIL_EXTENSION.'.'.$this->file_extension
                    )
                )
            )
        ) {

            return true;
        }

        $this->errors[] = 'Could not schedule movement of your '.$this->image_collection.' images to the media server. If the problem persists please alert an administrator.';
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
     * @name : getErrors
     * @description : Will create the image names from the parameters passed
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function getErrors() {

        return $this->errors;
    }

    /*
     * @name : hasErrors
     * @description : Will return a count of the number of elements in the array
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function hasErrors() {

        return count( $this->errors );
    }

}

?>
