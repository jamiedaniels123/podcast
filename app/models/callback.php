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
}