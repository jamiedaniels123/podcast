<?php
class Callback extends AppModel {

	var $name = 'Callback';
	var $validate = array();
	var $useTable = false;
	var $data = array();
	var $commands = array('transcode-media','transcode-media-and-deliver','transfer-file-to-media-server','transfer-folder-to-media-server','delete-file-on-media-server','delete-folder-on-media-server','update-file-metadata','update-folder-metadata','update-list-of-files-metadata','set-permissions-folder','check-file-exists','check-folder-exists','status-encoder','status-media');

	/*
	 * @name : setData
	 * @description : We json_decode the posted data and assign to the class variable data.
	 * @todo : Elaborate on this, checking is very very basic.
	 * @updated : 12th July 2011
	 * @by : Charles Jackson
	 */	
	function setData( $data ) {

		$dataMess=explode('=',urldecode($data));
		if( isSet( $dataMess[1] ) )
			$this->data=json_decode($dataMess[1],true);
	}

	/*
	 * @name : understand
	 * @description : Checks the command listed against the array of known commands
	 * @todo : Elaborate on this, checking is very very basic.
	 * @updated : 12th July 2011
	 * @by : Charles Jackson
	 */
	function understand(){

		if( isSet( $this->data['command'] ) && in_array( $this->data['command'], $this->commands ) ) {
			
			return true;
		} else {
			
			return false;
		}
	}
	
	/*
	 * @name : hasErrors
	 * @description : Reads through every element in the callback data array and checks the status is equal to YES (Y).
	 * @updated : 12th July 2011
	 * @by : Charles Jackson
	 */
	function hasErrors() {
		
		foreach( $this->data['data'] as $row ) {
			
			if( strtoupper( $row['status'] ) != YES )
				return true;
		}
		
		return false;
	}

	/*
	 * @name : processDeletions
	 * @description : We delete for various reasons but if we are deleting a collection or podcast_item
	 * the rows will still exist on the database with a "deleted" flag set to "2". Depending upon
	 * the "status" element of every row returned in the API array we will delete the rows from
	 * the database else reset their status to "1" so they reappear on the admin panel.
	 * @updated : 18th July 2011
	 * @by : Charles Jackson
	 */
	function processDeletions() {

		$podcast = null;
		$podcast_item_media = null;
		$podcast_item_id = null;
		$data = array();
		
		foreach( $this->data['data'] as $row ) {
			
			// We are deleting a collection
			if( isSet( $row['collection_deletion'] ) ) {
				
				if( !is_object( $podcast ) )
					$podcast = ClassRegistry::init('Podcast');
				
				// Did the deletion work?	
				if( (int)$row['status'] ) {
					
					// Deletion worked, delete the row from the DB
					$podcast->delete( $row['podcast_id'] );
					
				} else {
					
					// Deletion did not work, set the deleted status to "1" so it will reappear on the admin views
					$data = $podcast->findById( $row['podcast_id'] );
					$data['Podcast']['deleted'] = 1;
					$podcast->set( $data );
					$podcast->save();
				}
				
			// We are deleting a podcast_item.	
			} elseif( isSet( $row['podcast_item_deletion'] ) ) {
				
				$podcast_item_id = $row['podcast_item_id'];
				
				if( !is_object( $podcast_item_media ) )
					$podcast_item_media = ClassRegistry::init('PodcastItemMedia');
				
				// Did the deletion work?	
				if( (int)$row['status'] ) {
					
					// Deletion worked, delete the flavour from the podcast_item_media table
					$podcast->delete( $row['podcast_id'] );
				}
			}
		}
		
		// If we were deleting a podcast_item we need to check to see if any flavours are left,
		// If no flavours are left ( ie: rows on the media table ) then we can delete the record
		// else we need to update the status to "1" so it reappears on the admin panels		
		if( $podcast_item_id ) {
			
			$podcast_item = ClassRegistry::init( 'PodcastItem' );
			$data = $podcast_item->findById( $podcast_item_id );
			
			if( isSet( $data['PodcastMedia'] ) && is_array( $data['PodcastMedia'] ) && count( $data['PodcastMedia'] ) ) {
				
				$podcast_item['PodcastItem']['deleted'] = 1;
				$podcast_item->set( $data );
				$podcast_item->save();
				
			} else {
				
				$podcast_item->delete( $podcast_item_id );
			}
		}
		
		return true;
	}
}