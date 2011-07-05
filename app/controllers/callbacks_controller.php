<?php
class CallbacksController extends AppController {

	var $name = 'Callbacks';

	/*
	 * @name : 7th June 2011
	 * @description :
	 * @updated :
	 * @by : Charles Jackson
	 */
	function add() {
		$this->layout='callback';
		$this->Callback->setData($this->data);
		if ($this->Callback->understand()){
			$this->set('status','ACK');
			if ($this->Callback->ok()){
				
				if($this->data['command']=='transfer-file-to-media-server'){
					if($this->Folder->cleanUp($this->data['source_path'],$this->data['filename'])==false){
						$user=ClassRegistry::init('User');
						$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$this->data,'Failed to delete file');
					}
				}
				
			}
			else{
				$user=ClassRegistry::init('User');
				$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$this->data,'Failed to understand command');
					
			}
		}else{
			$this->set('status','NACK');
		}

	}



	function post() {

	}
}
?>
