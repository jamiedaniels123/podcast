<?php
class Callback extends AppModel {

	var $name = 'Callback';
	var $validate = array();
	var $useTable = false;
	var $data = array();
	var $commands = array('transcode-media','transcode-media-and-deliver','transfer-file-to-media-server','transfer-folder-to-media-server','delete-file-on-media-server','delete-folder-on-media-server','update-file-metadata','update-folder-metadata','update-list-of-files-metadata','set-permissions-folder','check-file-exists','check-folder-exists','status-encoder','status-media');

	function setData( $data ) {

		$this->data = json_decode( $data );
	}

	function understand(){

		if(in_array($this->data['command'], $this->commands)){
			
			return true;
		} else {
			
			return false;
		}
	}
}