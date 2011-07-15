<?php
class VlesController extends AppController {

	var $name = 'Vles';
	
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
		
		$this->layout='vle';
		$this->Vle->setData(file_get_contents("php://input"));
		$user = ClassRegistry::init('User');

		// Is it a valid command
		if ( $this->Vle->understand() ) {
			$this->emailTemplates->__sendVleErrorEmail($user->getAdministrators(),$this->Vle->data,'I UNDERSTAND VLE POST');
			$this->set('status', json_encode( array('status'=>'ACK', 'data'=>'Message received', 'timestamp'=>time() ) ) );

			if( $this->Vle->hasErrors() )
				$this->emailTemplates->__sendVleErrorEmail($user->getAdministrators(),$row,'This Vle call has errors');
				

		} else {
			
			$this->emailTemplates->__sendVleErrorEmail($user->getAdministrators(),$this->Vle->data,'Failed to understand VLE command');
			$this->set('status', json_encode( array( 'status'=>'NACK', 'data'=>'Message received but I dont understand what it means', 'timestamp'=>time() ) ) );
		}
	}



	function post() {

	}
}
?>
