<?php
class AppModel extends Model {

	var $errors = array();
	
    /*
     * @name : removeDuplicates
     * @description : Compares two arrays and removes any duplicate elements from the first parameter
     * passed $array. This is used for the dynamic select boxes to ensure for example, a user does not exist
     * in the list of "All Users" if they have already been added to the 'Members' list.
     * @updated : 12th May 2011
     * @by : Charles Jackson
     */
    function removeDuplicates( $array = array(), $subset_array = array(), $data_key = null  ) {

        // Does the subset array element exist
        if( isSet( $subset_array[$data_key] ) ) {

            $list = array();
            $subset_list = array();


            // Rebuild the users list into an acceptable array
            foreach( $array as $key => $element ) {

                $list[] = $key;
            }
			
			// If we are matching against the 'owner' it will not be a multi dimensional array
			if( isSet( $subset_array[$data_key]['id'] ) ) {
				
				$subset_list[] = $subset_array[$data_key]['id'];
				
			} else {
				
				// We are matching against moderators (for example) hence we need to loop through a multi-dimensional array.
				foreach( $subset_array[$data_key] as $row ) {
	
					$subset_list[] = $row['id'];
				}
			}

            // Read through the main array and remove any elements from
            // the list (passed as a parameter) that exist in the
            // members/moderator arrays.
            foreach( $list as $element ) {

                if( in_array( $element, $subset_list ) ) {
                    if( isSet( $array[$element] ) ) {
                        unset($array[$element]);
                    }
                }
            }
        }

        // Return the trimmed array.
        return $array;
    }

    /*
     * @name : unsetAttachments
     * @description : This unique method will unset the array elements from the file uploads before saving then return the
     * last_insert_id that 'maybe' used as part of the folder structure when saving associated assets.
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function unsetAttachments() {

		$possible_attachments = array('image','image_logoless','image_wide','transcript','image_filename');
		
        foreach( $possible_attachments as $attachment ) {

	        unset( $this->data[$this->name][$attachment] );
        }
    }

    /*
     * @name : buildSafeFilename
     * @description : Will replace various characters with underscores so they maybe safely used as a folder
     * name on the server.
     * @updated : 24th May 2011
     * @by : Charles Jackson
     */
    function buildSafeFilename( $string, $force_lowercase = true, $anal = true ) {

        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
                       "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
                       "Ã¢â‚¬â€�", "Ã¢â‚¬â€œ", ",", "<", ".", ">", "/", "?");

        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean ;
        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }


    /*
     * @name : clean
     * @description : Cleans all characters not supported by UTF-8 on RSS. Taken
     * directly from the original implementation.
     * @updated : 3rd June 2011
     * @by : Charles Jackson
     */
    function clean( $string = null ) {

        # entities
        $string = str_replace("&", "&amp;", $string );
        $string = str_replace("'", "&apos;", $string ); # single quote
        $string = str_replace('"', '&quot;', $string ); # double quote
        $string = str_replace("<", "&lt;", $string );
        $string = str_replace(">", "&gt;", $string );
        return $string;
    }

    /*
     * @name : cleanAttribute
     * @description : Cleans all characters not supported by UTF-8 on RSS. Differs
     * slightly from the method aboce in that it also cleans the ":" that is needed in
     * attributes only. Not to be used on plain data.
     * @updated : 3rd June 2011
     * @by : Charles Jackson
     */
    function cleanAttribute( $string = null ) {

        # entities
        $string = str_replace("&", "&amp;", $string );
        $string = str_replace("'", "&apos;", $string ); # single quote
        $string = str_replace('"', '&quot;', $string ); # double quote
        $string = str_replace("<", "&lt;", $string );
        $string = str_replace(">", "&gt;", $string );
        $string = str_replace(":", "%3A", $string );
        return $string;
    }

    function isPdf( $filename ) {

        $ext = substr( strtolower( strrchr( $filename,'.' ) ), 1 ); # filename extension without the dot

        return ( $ext == 'pdf' );
    }

    function getExtension( $filename = null ) {

        return substr( $filename, ( strrpos( $filename, '.' ) + 1 ), strlen( $filename ) );
    }

	
    function getStandardImageName( $image_filename = null ) {

		$standard_filename = null;
		$image_filename = trim( $image_filename );
				
		// Does the filename have an extension?
		if( strrpos( $image_filename, '.' ) ) {
			
	        $standard_filename = substr( $image_filename, 0, strrpos( $image_filename, '.' ) );
	        $standard_filename = $standard_filename.RESIZED_IMAGE_EXTENSION . '.' . $this->getExtension( $image_filename );
			
		} elseif( strlen( $image_filename ) ) {
			
			$standard_filename = $image_filename.RESIZED_IMAGE_EXTENSION;
		}
		
        return $standard_filename;
    }

    function getThumbnailImageName( $image_filename = null ) {

		$thumbnail_filename = null;
		$image_filename = trim( $image_filename );
		
		// Does the filename have an extension?
		if( strrpos( $image_filename, '.' ) ) {
			
	        $thumbnail_filename = substr( $image_filename, 0, strrpos( $image_filename, '.' ) );
	        $thumbnail_filename = $thumbnail_filename.THUMBNAIL_EXTENSION . '.' . $this->getExtension( $image_filename );
			
		} elseif( !empty( $image_filename ) ) {
			
			$thumbnail_filename = $image_filename.THUMBNAIL_EXTENSION;
		}
		
        return $thumbnail_filename;
    }

    /*
     * @name : mediaFileExist
     * @description : Checks to see if a remote  file exists
     * @updated : 9th June 2011
     * @by : Charles Jackson
     */
    function mediaFileExist( $url ) {

        $header_response = get_headers($url, 1);
        
        if ( strpos( $header_response[0], "404" ) !== false )
            return false;

        return true;
    }
	
	
	function getErrors() {
	
		return $this->errors;	
	}
	
    /*
     * @name : getAdministrators
     * @description : Returns an array of all administrators on the system.
     * @updated : 22nd June 2011
     * @by : Charles Jackson
     */
    function getAdministrators() {

		$user = ClassRegistry::init('User');
		
        return $user->find('all', array(

            'conditions' => array(
                'User.administrator' => true
                )
            )
        );
    }

    /*
     * @name : getYoutubeUsers
     * @description : Returns an array of all youtube users on the system.
     * @updated : 22nd June 2011
     * @by : Charles Jackson
     */
    function getYoutubeUsers() {

		$user = ClassRegistry::init('User');
		
        return $user->find('all', array(

            'conditions' => array(
                'User.YouTube' => 'Y'
                )
            )
        );
    }
	
    /*
     * @name : getItunesUsers
     * @description : Returns an array of all iTunes users on the system.
     * @updated : 22nd June 2011
     * @by : Charles Jackson
     */
    function getItunesUsers() {

		$user = ClassRegistry::init('User');
		
        return $user->find('all', array(

            'conditions' => array(
                'User.iTunesU' => 'Y'
                )
            )
        );
    }

	/*
	 * @name : getEnumValues
	 * @description : Gets the enum values from the database for the column passed using the current model/table.
	 * @updated : 19th August 2011
	 * @by : Charles Jackson
	 */
    function getEnumValues( $columnName = null ) {

        if ($columnName==null) { return array(); } //no field specified 


        //Get the name of the table 
        $db =& ConnectionManager::getDataSource($this->useDbConfig); 
        $tableName = $db->fullTableName($this, false); 


        //Get the values for the specified column (database and version specific, needs testing) 
        $result = $this->query("SHOW COLUMNS FROM {$tableName} LIKE '{$columnName}'"); 

        //figure out where in the result our Types are (this varies between mysql versions) 
        $types = null; 
        if     ( isset( $result[0]['COLUMNS']['Type'] ) ) { $types = $result[0]['COLUMNS']['Type']; } //MySQL 5 
        elseif ( isset( $result[0][0]['Type'] ) )         { $types = $result[0][0]['Type'];         } //MySQL 4 
        else   { return array(); } //types return not accounted for 

        //Get the values 
        $values = explode("','", preg_replace("/(enum)\('(.+?)'\)/","\\2", $types) ); 

        //explode doesn't do assoc arrays, but cake needs an assoc to assign values 
        $assoc_values = array(); 
        foreach ( $values as $value ) { 
            //leave the call to humanize if you want it to look pretty 
            $assoc_values[$value] = Inflector::humanize($value); 
        } 

        return $assoc_values; 

    } //end getEnumValues 	
}