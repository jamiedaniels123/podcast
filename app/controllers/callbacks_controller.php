<?php
class CallbacksController extends AppController {

	var $name = 'Callbacks';

	/*
	 * @name : 1st July 2011
	 * @description :
	 * @updated :
	 * @by : Charles Jackson and Jamie Daniels
	 */
	function add() {
		$this->layout='callback';
		$this->Callback->setData($this->data);
		// Is it a valid command
		if ($this->Callback->understand()){
			$m_data = array('status'=>'ACK', 'data'=>'Message recieved', 'timestamp'=>time());
			$jsonData = json_encode($m_data);
			$this->set('status',$jsonData);



			// Perform action for each command
			if($this->data['command']=='transfer-file-to-media-server'){
				if($this->Folder->cleanUp($this->data['source_path'],$this->data['filename'])==false){
					$user=ClassRegistry::init('User');
					//$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$this->data,'Failed to delete file');
				}
			}

		}else{
			$user=ClassRegistry::init('User');
			//$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$this->data,'Failed to understand command');
			$m_data = array('status'=>'NACK', 'data'=>'Message recieved but i dont understand what it means', 'timestamp'=>time());
			$jsonData = json_encode($m_data);
			$this->set('status',$jsonData);
		}

	}



	function post() {

	}
}
?>
