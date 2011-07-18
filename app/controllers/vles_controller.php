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
			

			if( $this->Vle->hasErrors() )
				$this->emailTemplates->__sendVleErrorEmail($user->getAdministrators(),$row,'This Vle call has errors');
				
			if( strtolower( $this->Vle->data['command'] ) = 'create-container' ) {

				$this->set('status', json_encode( array( 'status' => 'ACK', 'data' => $this->Vle->createCollection(), 'timestamp' => time() ) ) );
				
			} elseif( strtolower( $this->Vle->data['command'] ) = 'delete-container' ) {
				
				// We are not deferring to the model so we can easily access to API component class.
				$podcasts = array();
				$podcast = ClassRegistry('Podcast');
				$podcast->recursive = -1;
				$podcast->begin();
				
				foreach( $this->data['data'] as $row ) {
					
					$data = $podcast->findById( $row['id'] );
					
					if( !empty( $data ) ) {
						
						$podcast->delete( $data['Podcast']['id'] );
						$podcasts[] = array( 
							'source_path' => $data['Podcast']['custom_id'].'/',
						);
					}
				}
				
				if( $this->Api->deleteFolderOnMediaServer( $podcasts ) ) {
					
					$this->Vle->data['status'] = 'ACK';
					$this->set('status', json_encode( $this->Vle->data ) );
					$podcast->commit();
					
				} else {
					
					$this->Vle->data['status'] = 'NACK';
					$this->set('status', json_encode( $this->Vle->data ) );
					$podcast->rollback();
				}
			}

		} else {
			
			$this->emailTemplates->__sendVleErrorEmail($user->getAdministrators(),$this->Vle->data,'Failed to understand VLE command');
			$this->set('status', json_encode( array( 'status'=>'NACK', 'data'=>'Message received but I dont understand what it means', 'timestamp'=>time() ) ) );
		}
	}



	function post() {

	}
}
?>
