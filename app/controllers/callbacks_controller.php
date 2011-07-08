<?php
class CallbacksController extends AppController {

	var $name = 'Callbacks';
	var $requires_local_deletion = array('transcode-media','transcode-media-and-deliver','transfer-file-to-media-server', 'transfer-folder-to-media-server');
	
    /*
     * @name : beforeFilter
     * @description : The following methods can be accessed without logging in.
     * @updated : 2nd June 2010
     */
    function beforeFilter() {
        
        $this->Auth->allow( 'add' );
        parent::beforeFilter();
    }

	/*
	 * @name : 1st July 2011
	 * @description :
	 * @updated :
	 * @by : Charles Jackson and Jamie Daniels
	 */
	function add() {
		$this->layout='callback';
		$this->Callback->setData($this->data);
		$user=ClassRegistry::init('User');
		$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$this->data,'Callback ALERT');

		// Is it a valid command
		if ($this->Callback->understand()){
			$m_data = array('status'=>'ACK', 'data'=>'Message recieved', 'timestamp'=>time());
			$jsonData = json_encode($m_data);
			$this->set('status',$jsonData);



			// Does the API command signify a need to delete a local file structure?
			if( in_array( $this->data['command'], $this->requires_local_deletion ) ) {
				
				// Delete the local file structure or error.
				if( $this->Folder->cleanUp( $this->data['source_path'],$this->data['filename'] ) == false ) {
					
					$user=ClassRegistry::init('User');
					$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$this->data,'Failed to delete file');
				}
				
			}

		}else{
			
			$user=ClassRegistry::init('User');
			$this->emailTemplates->__sendCallbackErrorEmail($user->getAdministrators(),$this->data,'Failed to understand command');
			$m_data = array('status'=>'NACK', 'data'=>'Message recieved but i dont understand what it means', 'timestamp'=>time());
			$jsonData = json_encode($m_data);
			$this->set('status',$jsonData);
		}

	}



	function post() {

	}
}
?>
