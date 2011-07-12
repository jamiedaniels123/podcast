<?php
class Callback extends AppModel {

	var $name = 'Callback';
	var $validate = array();
	var $useTable = false;
	var $data = array();
	var $commands = array('transcode-media','transcode-media-and-deliver','transfer-file-to-media-server','transfer-folder-to-media-server','delete-file-on-media-server','delete-folder-on-media-server','update-file-metadata','update-folder-metadata','update-list-of-files-metadata','set-permissions-folder','check-file-exists','check-folder-exists','status-encoder','status-media');

	function setData($data=array()){
		$dataStream = file_get_contents("php://input");
		$dataMess = explode('=',urldecode($dataStream));
		if (isset($dataMess[1])) {
			$jsondata=json_decode($dataMess[1],true);
			$this->data=$jsondata;
			print_r($this->data);
		}
		else{
			$this->data=$data;
		}
	}

	function understand(){
			print_r($this->data);
		if(in_array($this->data['command'], $this->commands)){
			return(isset($this->data['command']) && isset($this->data['status']));
		}
		else{
			return false;
		}
	}
}