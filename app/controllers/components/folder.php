<?php
class FolderComponent extends Object {


    function createHtaccess( $data = array() ) {

        $this->create( $data['Podcast']['custom_id'] );
        $text = 'ErrorDocument 404 /notfound.html';

        if( $this->writeFile( $text, $data['Podcast']['custom_id'],'.htaccess' ) )
            return true;

        return false;
    }

    /*
     * @name : moveFileChuckerUpload
     * @description : Move a file uploaded via fileChucker into the specified folder.
     * @updated : 1st June 2011
     * @by : Charles Jackson
     */
    function moveFileChuckerUpload( $data = array() ) {
        
        $this->create( $data['Podcast']['custom_id'] );
        
        if( $this->moveFile( $data['PodcastItem']['filename'], $data['Podcast']['custom_id'].'/'.$data['PodcastItem']['filename'] ) ) {

            unlink( FILE_REPOSITORY.$data['PodcastItem']['filename'] );
            return true;
        }

        return false;
    }


    /*
     * @name : move
     * @description : Copy a file.
     * @updated : 1st June 2011
     * @by : Charles Jackson
     */
    function moveFile( $resource, $target ) {

        if( !is_file( FILE_REPOSITORY.$resource ) || is_readable( FILE_REPOSITORY.$target ) )
            return false;

        copy( FILE_REPOSITORY.$resource, FILE_REPOSITORY.$target );
        return true;

    }

    /*
     * @name : create
     * @description : Will create a folder path specified relative to the FILE_REPOSITORY
     * @updated : 1st June 2011
     * @by : Charles Jackson
     */
    function create( $target_path ) {

        $newfolders = explode('/',$target_path );
        $newfolderPath = FILE_REPOSITORY;

        foreach( $newfolders as $newfolder ) {

            if( !empty( $newfolder ) ) {

                $newfolderPath .= $newfolder.'/';

                if( !is_dir( $newfolderPath ) ) {

                    if(! mkdir($newfolderPath,0755,true) )
                            die($newfolderPath);
                }
            }
        }
    }

    /*
     * @name : delete
     * @description : Will recursively delete a folder relative to the FILE_REPOSITORY
     * @updated : 1st June 2011
     * @by : Charles Jackson
     */
    function delete( $directory ) {

        // if the path has a slash at the end we remove it here
        if( substr( $directory, -1 ) == '/' ) {

            $directory = substr( $directory, 0, -1 );
        }

        // if the path is not valid or is not a directory ...
        if( !is_dir( $directory ) ) {

            // ... we return false and exit the function
            return false;

        // ... if the path is not readable
        } elseif( !is_readable( $directory ) ) {

            // ... we return false and exit the function
            return false;

        } else {

            // we open the directory
            $handle = opendir( $directory );

            // and scan through the items inside
            while ( false !== ( $item = readdir( $handle ) ) ) {

                // if the filepointer is not the current directory
                  // or the parent directory
                if( $item != '.' && $item != '..' ) {

                    // we build the new path to delete
                    $path = $directory.'/'.$item;

                    // if the new path is a directory
                    if( is_dir( $path ) ) {

                        // we call this function with the new path
                        $this->recursive_remove_directory( $path );
                        // if the new path is a file

                    } else {

                        // we remove the file
                        unlink( $path );
                    }
                }
            }

            // close the directory
            closedir( $handle );

            // try to delete the now empty directory
            if( !rmdir( $directory ) ) {

                // return false if not possible
                return false;
            }

            // return success
            return true;
        }
    }

    /*
     * @name : writeFile
     * @description :
     * @updated : 1st June 2001
     * @by : Charles Jackson
     */
    function writeFile( $text, $path, $filename ) {

        $file = new File( FILE_REPOSITORY.$path.'/'.$filename, true );
        
        if( $file->write( $text ) == false )
            return false;

        $file->close();
        return true;
    }


    
}