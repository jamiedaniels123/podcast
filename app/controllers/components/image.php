<?php
class ImageComponent extends Object {

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
    private $temporary_file = null; // The name of the temporary file uploaded into TMP folder
    private $file_extension = null; // The file extension being uploaded.

    /*
     * @name : uploadPodcastImage
     * @description : Will create three versions of the image including the original, a cropped version and a thumbnail.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function uploadPodcastMediaImage( $data, $image_key ) {

        $folder_name = null;
        $file_name = null;

        // Have they attempted to upload an image?
        if ( isSet( $data[$this->controller->modelClass][$image_key]['name'] ) && strlen( $data[$this->controller->modelClass][$image_key]['name'] ) ) {

            // If the podcast container has a custom_id field we use it for the folder name and
            // as a naming convention for the file else we use the unique ID of the database row.
            if( strlen( $data['Podcast']['custom_id'] ) ) {

                $folder_name = FEEDS_LOCATION.$data['Podcast']['custom_id'];

            } else {

                $folder_name = FEEDS_LOCATION.$data['Podcast']['id'];
            }

            $info = pathinfo( $data[$this->controller->modelClass][$image_key]['name'] );
            $file_name = $info['filename'].'_'.$data['Podcast']['id'].'_'.$data['PodcastItem']['id'];

            $this->assignClassVariables( $data, $image_key, $folder_name );

            // Has an image been uploaded and is it error free?
            if ( (int)$this->data[$this->controller->modelClass][$this->image_key]['error'] == 0 ) {

                if( $this->isValidImage() ) {

                    if( $this->createTemporaryFile() ) {

                        // Create the folder structure if it does not already exist
                        $this->createFolder();

                        // Create a copy of the original file.
                        copy( $this->temporary_file, $this->folder.'/'.$file_name.'.'.$this->file_extension );
                        // Create a resized copy of the file.
                        $this->resizeImage($this->temporary_file, 300, $this->folder.'/'.$file_name.RESIZED_IMAGE_EXTENSION.'.'.$this->file_extension );
                        // Generate a thumbnail square version of the image.
                        $this->createThumbnail( $this->temporary_file, 50, $this->folder.'/'.$file_name.THUMBNAIL_EXTENSION.'.'.$this->file_extension );

                        // Delete the temporary image
                        unlink( $this->temporary_file );

                        return $file_name.'.'.$this->file_extension;

                    } else {

                        $this->errors[] = 'Could not copy your podcast media image into a temporary location. Please alert an administrator.';
                    }

                } else {

                    $this->errors[] = 'Your podcast media image is not in a valid format.';
                }
            }
        }

        return false;
    }


    /*
     * @name : uploadPodcastImage
     * @description : Will create three versions of the image including the original, a cropped version and a thumbnail.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function uploadPodcastImage( $data, $image_key ) {

        $folder_name = null;
        $file_name = null;
        
        // Have they attempted to upload an image?
        if ( isSet( $data[$this->controller->modelClass][$image_key]['name'] ) && strlen( $data[$this->controller->modelClass][$image_key]['name'] ) ) {
            
            // If the podcast container has a custom_id field we use it for the folder name and
            // as a naming convention for the file else we use the unique ID of the database row.
            if( strlen( $data[$this->controller->modelClass]['custom_id'] ) ) {

                $folder_name = FEEDS_LOCATION.$data[$this->controller->modelClass]['custom_id'];

            } else {

                $folder_name = FEEDS_LOCATION.$data[$this->controller->modelClass]['id'];
            }

            $info = pathinfo( $data[$this->controller->modelClass][$image_key]['name'] );
            $file_name = $info['filename'].'_'.$data['Podcast']['id'];

            $this->assignClassVariables( $data, $image_key, $folder_name );

            // Has an image been uploaded and is it error free?
            if ( (int)$this->data[$this->controller->modelClass][$this->image_key]['error'] == 0 ) {

                if( $this->isValidImage() ) {

                    if( $this->createTemporaryFile() ) {

                        // Create the folder structure if it does not already exist
                        $this->createFolder();

                        // Create a copy of the original file.
                        copy( $this->temporary_file, $this->folder.'/'.$file_name.'.'.$this->file_extension );
                        // Create a resized copy of the file.
                        $this->resizeImage($this->temporary_file, 300, $this->folder.'/'.$file_name.RESIZED_IMAGE_EXTENSION.'.'.$this->file_extension );
                        // Generate a thumbnail square version of the image.
                        $this->createThumbnail( $this->temporary_file, 50, $this->folder.'/'.$file_name.THUMBNAIL_EXTENSION.'.'.$this->file_extension );

                        // Delete the temporary image
                        unlink( $this->temporary_file );

                        return $file_name.'.'.$this->file_extension;

                    } else {

                        $this->errors[] = 'Could not copy your podcast image into a temporary location. Please alert an administrator.';
                    }

                } else {

                    $this->errors[] = 'Your podcast image is not in a valid format.';
                }
            }
        }
        
        return false;
    }

    /*
     * @name : uploadLogolessPodcastImage
     * @description : Will create three versions of the image including the original, a cropped version and a thumbnail.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function uploadLogolessPodcastImage( $data, $image_key ) {

        $folder_name = null;
        $file_name = null;

        if ( isSet( $data[$this->controller->modelClass][$image_key]['name'] ) && strlen( $data[$this->controller->modelClass][$image_key]['name'] ) ) {

            // If the podcast container has a custom_id field we use it for the folder name and
            // as a naming convention for the file else we use the unique ID of the database row.
            if( strlen( $data[$this->controller->modelClass]['custom_id'] ) ) {

                $folder_name = FEEDS_LOCATION.$data[$this->controller->modelClass]['custom_id'];

            } else {

                $folder_name = FEEDS_LOCATION.$data[$this->controller->modelClass]['id'];
            }

            // Get the filename with the extension so we can append extensions for rezied image and thumbnail
            $info = pathinfo( $data[$this->controller->modelClass][$image_key]['name'] );
            $file_name = 'LL_'.$info['filename'].'_'.$data['Podcast']['id'];


            $this->assignClassVariables( $data, $image_key, $folder_name );

            // Do we have any errors?
            if ( (int)$this->data[$this->controller->modelClass][$this->image_key]['error'] == 0 ) {

                if( $this->isValidImage() ) {

                    if( $this->createTemporaryFile() ) {

                        // Create the folder structure if it does not already exist
                        $this->createFolder();

                        // Create a copy of the original file.
                        copy( $this->temporary_file, $this->folder.'/'.$file_name.'.'.$this->file_extension );
                        // Create a resized copy of the file.
                        $this->resizeImage($this->temporary_file, 300, $this->folder.'/'.$file_name.RESIZED_IMAGE_EXTENSION.'.'.$this->file_extension );
                        // Generate a thumbnail square version of the image.
                        $this->createThumbnail( $this->temporary_file, 50, $this->folder.'/'.$file_name.THUMBNAIL_EXTENSION.'.'.$this->file_extension );

                        // Delete the temporary image
                        unlink( $this->temporary_file );

                        return $info['filename'];

                    } else {

                        $this->errors[] = 'Could not copy your logoless podcast image into a temporary location. Please alert an administrator.';

                    }

                } else {

                    $this->errors[] = 'Your logoless podcast image is not in a valid format.';
                }

            }
        }
        return false;
    }

    /*
     * @name : uploadWidePodcastImage
     * @description : Will create three versions of the image including the original, a cropped version and a thumbnail.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function uploadWidePodcastImage( $data, $image_key ) {

        $folder_name = null;
        $file_name = null;

        if ( isSet( $data[$this->controller->modelClass][$image_key]['name'] ) && strlen( $data[$this->controller->modelClass][$image_key]['name'] ) ) {

            // If the podcast container has a custom_id field we use it for the folder name and
            // as a naming convention for the file else we use the unique ID of the database row.
            if( strlen( $data[$this->controller->modelClass]['custom_id'] ) ) {

                $folder_name = FEEDS_LOCATION.$data[$this->controller->modelClass]['custom_id'];

            } else {

                $folder_name = FEEDS_LOCATION.$data[$this->controller->modelClass]['id'];
            }

            // Get the filename with the extension so we can append extensions for rezied image and thumbnail
            $info = pathinfo( $data[$this->controller->modelClass][$image_key]['name'] );
            $file_name = 'WS_'.$info['filename'].'_'.$data['Podcast']['id'];

            $this->assignClassVariables( $data, $image_key, $folder_name );

            // Do we have any errors?
            if ( (int)$this->data[$this->controller->modelClass][$this->image_key]['error'] == 0 ) {

                if( $this->isValidImage() ) {

                    if( $this->createTemporaryFile() ) {

                        // Create the folder structure if it does not already exist
                        $this->createFolder();

                        // Create a copy of the original file.
                        copy( $this->temporary_file, $this->folder.'/'.$file_name.'.'.$this->file_extension );
                        // Create a resized copy of the file.
                        $this->resizeImage($this->temporary_file, 300, $this->folder.'/'.$file_name.RESIZED_IMAGE_EXTENSION.'.'.$this->file_extension );
                        // Generate a thumbnail square version of the image.
                        $this->createThumbnail( $this->temporary_file, 50, $this->folder.'/'.$file_name.THUMBNAIL_EXTENSION.'.'.$this->file_extension );

                        // Delete the temporary image
                        unlink( $this->temporary_file );

                        return $info['basename'];

                    } else {

                        $this->errors[] = 'Could not copy your logoless podcast image into a temporary location. Please alert an administrator.';

                    }

                } else {

                    $this->errors[] = 'Your logoless podcast image is not in a valid format.';
                }

            }
        }
        return false;
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
     * @name : assignClassVariables
     * @description : Assign variables passed as a parameter.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function assignClassVariables( $data, $image_key, $folder ) {

        $this->data = $data;
        $this->image_key = $image_key;
        $this->folder = $folder;
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
        $id_unic = str_replace(".", "", strtotime ("now"));
        $file_name = $id_unic;

        settype( $file_name, 'string' );
        $file_name.= '.';
        $file_name .= $this->file_extension;

        $this->temporary_file = TMP . '/'.$file_name;

        if ( is_uploaded_file( $this->data[$this->controller->modelClass][$this->image_key]['tmp_name'] ) ) {

            // Copy the image into the temporary directory
            if ( !copy( $this->data[$this->controller->modelClass][$this->image_key]['tmp_name'], "$this->temporary_file" ) ) {

                return false;

            } else {

                return true;
            }

        } else {

            return false;
        }
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

                mkdir( $new_folder_path, 0755, true );
            }
        }
    }

    /*
     * @name : createThumbnail
     * @description : Creates a cropped verion of the image according to the scale passed as a parameter.
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function createThumbnail($imgname, $scale, $filename) {

        switch( $this->file_extension ){
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

        $width = imagesx($img_src);
        $height = imagesy($img_src);
        $ratiox = $width / $height * $scale;
        $ratioy = $height / $width * $scale;

        //-- Calculate resampling
        $newheight = ($width <= $height) ? $ratioy : $scale;
        $newwidth = ($width <= $height) ? $scale : $ratiox;

        //-- Calculate cropping (division by zero)
        $cropx = ($newwidth - $scale != 0) ? ($newwidth - $scale) / 2 : 0;
        $cropy = ($newheight - $scale != 0) ? ($newheight - $scale) / 2 : 0;

        //-- Setup Resample & Crop buffers
        $resampled = imagecreatetruecolor($newwidth, $newheight);
        $cropped = imagecreatetruecolor($scale, $scale);

        //-- Resample
        imagecopyresampled($resampled, $img_src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        //-- Crop
        imagecopy($cropped, $resampled, 0, 0, $cropx, $cropy, $newwidth, $newheight);

        // Save the cropped image
        switch( $this->file_extension ) {
			
            case 'jpeg':
            case 'jpg':
             imagejpeg($cropped,$filename,80);
             break;
             case 'gif':
             imagegif($cropped,$filename,80);
             break;
             case 'png':
             imagepng($cropped,$filename,80);
             break;
        }

    }

    /*
     * @name : resizeImage
     * @description :
     * @updated : 6th May 2011
     * @by : Charles Jackson
     */
    function resizeImage($imgname, $size, $filename)    {

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

        $true_width = imagesx($img_src);
        $true_height = imagesy($img_src);

        if ($true_width>=$true_height)
        {
            $width=$size;
            $height = ($width/$true_width)*$true_height;
        }
        else
        {
            $width=$size;
            $height = ($width/$true_width)*$true_height;
        }
        $img_des = ImageCreateTrueColor($width,$height);
        imagecopyresampled ($img_des, $img_src, 0, 0, 0, 0, $width, $height, $true_width, $true_height);

        // Save the resized image
        switch( $this->file_extension )
        {
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
    * @name : delete_image
    * @description : Will delete each image passed as a parameter. Each filename must contain a path relative from
    * the web_root folder.
    * @updated : 5th May 2011
    * @by : Charles Jackson
    */
    function delete_image( $file_names = array() ) {

        foreach( $file_names as $file_name ) {

            if( file_exists( www_ROOT.$file_name ) )
                unlink( WWW_ROOT.$file_name );
        }

        return true;
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
