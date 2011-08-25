<?php
class NotificationsController extends AppController {

	var $name = 'Notifications';
	
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
}
?>
