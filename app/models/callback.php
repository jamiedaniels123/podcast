<?php
class Callback extends AppModel {

	var $name = 'Callback';
	var $validate = array();
	var $useTable = false;
	var $data = array();
	var $commands = array('transcode-media','transcode-media-and-deliver','transfer-file-to-media-server','transfer-folder-to-media-server','delete-file-on-media-server','delete-folder-on-media-server','update-file-metadata','update-folder-metadata','update-list-of-files-metadata','set-permissions-folder','check_file_exists','check_list_of_files_exists','check_folder_exists');

	function setData($data=array()){
		$this->data=$data;
	}

	function understand(){
		return(isset($this->data['command']) && isset($this->data['status']));
	}

	function ok(){
		return false;
		return($this->data['status']=='ACK');
	}

}

