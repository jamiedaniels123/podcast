<?php
class NotificationsController extends AppController {

	var $name = 'Notifications';
	var $paginate = array('limit' => 50);	
	
    /*
     * @name : beforeFilter
     * @description : Called before any other method.
     * @updated : 2nd June 2010
	 * @by : Charles Jackson
     */
    function beforeFilter() {
        
        parent::beforeFilter();

    }

    /*
     * @name : index
     * @description : Displays a paginated list of all notifications
     * @updated : 23rd August 2011
	 * @by : Charles Jackson
     */
	function index() {
		
	   $this->data['Notifications'] = $this->paginate('Notification', array('Notification.user_id' => $this->Session->read('Auth.User.id') ) );
	}
	
    /*
     * @name : view
     * @description : Displays details of an individual notification using the ID passed as a parameter.
     * @updated : 23rd August 2011
	 * @by : Charles Jackson
     */	
	function view( $id ) {
		
		
		
	}
	
    /*
     * @name : delete
     * @description : Delete a row on the notifications table.
     * @updated : 23rd August 2011
	 * @by : Charles Jackson
     */		
	function delete( $id ) {
		
		
	}
	
    /*
     * @name : admin_index
     * @description : Displays a paginated list of all notifications
     * @updated : 23rd August 2011
	 * @by : Charles Jackson
     */
	function admin_index() {
		
	   $this->data['Notifications'] = $this->paginate('Notification');
	}
	
    /*
     * @name : admin_view
     * @description : Displays details of an individual notification using the ID passed as a parameter.
     * @updated : 23rd August 2011
	 * @by : Charles Jackson
     */	
	function admin_view( $id ) {
		
		$this->data = $this->Notification->findById( $id );
		
		if( empty( $this->data ) ) {
			
			$this->cakeError('error404');
			
		} else {
			
			$this->data['Notification']['unread'] = 0;
			$this->Notification->set( $this->data );
			$this->Notification->save();
		}
	}
			
	/*
     * @name : admin_delete
     * @description : Enables an administrator to delete a row on the notifications table.
     * @updated : 23rd August 2011
	 * @by : Charles Jackson
     */		
	function admin_delete( $id ) {
		
        if( $id )
            $this->data['Notification']['Checkbox'][$id] = true;

        foreach( $this->data['Notification']['Checkbox'] as $key => $value ) {

            $notification = $this->Notification->findById( $key );
            
            if( !empty( $notification ) ) {
				
				$this->Notification->delete( $key );
				$this->Session->setFlash('Successfully deleted.', 'default', array( 'class' => 'success' ) );
				
				
			} else {
				
					$this->Session->setFlash('Cannot find the notification you are looking for. Please try again.', 'default', array( 'class' => 'error' ) );
					break; // Break out of the loop				
			}
		}
		
		$this->redirect( array( 'admin' => true, 'action' => 'index' ) );		
	}	
}
?>
