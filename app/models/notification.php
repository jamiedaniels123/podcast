<?php
class Notification extends AppModel {
	
    var $name = 'Notification';
	var $order = 'Notification.id DESC';
    
    var $validate = array();


	/*
	 * @name : unauthorisedAccess
	 * @description : Called from the app_controller when a user attempts to access a page to which they are not authorised
	 * so it maybe investigated by admin.
	 * @updated : 26th August 2011
	 * @by : Charles Jackson
	 */
	function unauthorisedAccess( $user, $url ) {
		
		$this->create();
		$this->data['Notification']['user_id'] = $user['id'];
		$this->data['Notification']['title'] = 'Unauthorised Access';
		$this->data['Notification']['type'] = 'Warning';
		$this->data['Notification']['admin_only'] = true;
		$this->data['Notification']['message'] = 'Attempted to access the following URL : '.$url;
		$this->save( $this->data );
	}
	
	


}
