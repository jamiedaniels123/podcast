<?php
class FolderComponent extends Object {

    
	
	/*
	 * @name : buildHtaccessFile
	 * @description : Builds a htaccess file using the podcast values passed as a parameter.
	 * @updated : 5th July 2011
	 * @by : Charles Jackson
	 */
	function buildHtaccessFile( $data = array() ) {

		$text = "RewriteEngine on\n";
		$text .= "RewriteCond %{REQUEST_FILENAME} !-f\n";
		$text .= "RewriteRule ^feeds/.*\.jpg$ /feeds/default-project-thumbnail.png [L]\n";
		
		if( $data['Podcast']['deleted']	 ) {
			
			$text .= "#Podcast has been soft deleted\n";
			$text .= "ErrorDocument 404 /notfound.html\n";
		}
		
		// If this is an intranet only podcast we check the IP address they came from
		if( $data['Podcast']['intranet_only'] == 'Y' ) {
			
			$text .= "#Restrict access to the OU Intranet only\n";
			$text .= "RewriteCond %{REMOTE_ADDR} !^137\.108\.[0-9]+\.[0-9]+$\n";
			$text .= "RewriteCond %{REMOTE_ADDR} !^194\.66\.1[234][0-9]\.[0-9]+$\n";
			$text .= "RewriteCond %{ENV:SAMS} !^PASSED\n";
			$text .= "RewriteRule ^(.*)$ /feeds-sams/validate.php?file=/feeds/vc-on-itunes/$1 [L]\n";
		}
		
		// Redirect all non-ou traffic to our amazon S3 account
		if( $data['Podcast']['media_location'] == 's3nonOU' ) { 
		
			$text .= "#non-OU media requests diverted to S3 service\n";
			$text .= "RewriteCond %{REMOTE_ADDR} !^137\.108\.[0-9]+\.[0-9]+$\n";
			$text .= "RewriteCond %{REMOTE_ADDR} !^194\.66\.[0-9]\.[0-9]+$\n";
			$text .= "RewriteCond %{REQUEST_FILENAME} !.*(xml|jpg)$\n";
			$text .= "RewriteCond %{HTTP_USER_AGENT} !^Jakarta.*$\n";
			$text .= "RewriteRule ^(.*)$ ".AMAZON_S3_SERVER."/feeds/".$data['Podcast']['custom_id']."/$1 [R=302,NC]\n";
			
		// Redirect all traffic to our amazon s3 account
		} elseif( $data['Podcast']['media_location'] == 's3all' ) {
			
			$text .= "#OU media requests diverted to S3 service\n";
			$text .= "RewriteCond %{REQUEST_FILENAME} !.*(xml|jpg)$\n";
			$text .= "RewriteCond %{HTTP_USER_AGENT} !^Jakarta.*$\n";
			$text .= "RewriteRule ^(.*)$ ".AMAZON_S3_SERVER."/feeds/".$data['Podcast']['custom_id']."/$1 [R=302,NC]\n";
		}

        if( $this->writeFile( $text, $data['Podcast']['custom_id'],'htaccess' ) )
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
        
        if( $this->moveFile( $data['PodcastItem']['original_filename'], $data['Podcast']['custom_id'].'/'.$data['PodcastItem']['id'].'_'.$data['PodcastItem']['original_filename'] ) ) {

            unlink( FILE_REPOSITORY.$data['PodcastItem']['original_filename'] );
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
     * @name : is_empty_dir
     * @description : Checks to see if a folder is empty.
     * @updated : 7th July 2001
     * @by : Charles Jackson
     */
	function is_empty_dir( $dir ) {
	
		if ( ( $files = @scandir( $dir ) ) && count( $files ) <= 2 )
			return true;

		return false;
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

    /*
     * @name : cleanUp
     * @description : Will delete the file specified and recursively delete the folder(s) if empty.
     * @updated : 1st June 2001
     * @by : Charles Jackson
     */
	function cleanUp( $path, $filename, $date_time_stamp = null ) {

		$folders = array();
		$path = str_replace('//','/',$path); // Quick fudge to fix minor API issue
		if( file_exists( FILE_REPOSITORY.$path.$filename ) == false )
			return false;
		
		// We only want to delete files if they were created prior to the date_time stamp on the current API
		// call else we may delete files that have been refreshed since this API call was made and a.n.other
		// more recent API call may still be waiting in the queue.
		
		unlink( FILE_REPOSITORY.$path.$filename );
			
		if( $this->is_empty_dir( FILE_REPOSITORY.$path ) )
			rmdir( FILE_REPOSITORY.$path );
			
		$folders = explode('/',$path );
		$custom_id = $folders[0];
		if( !empty( $custom_id ) && $this->is_empty_dir( FILE_REPOSITORY . $custom_id ) )
			return ( rmdir( FILE_REPOSITORY.$custom_id ) );
		
		return true;
			
	}
    
}