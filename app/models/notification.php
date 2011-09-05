<?php
class Notification extends AppModel {
	
    var $name = 'Notification';
	var $order = 'Notification.id DESC';
    
    var $validate = array();

	var $belongsTo = array(
	
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
        )
	
	);
	
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
	
	/*
	 * @name : transcodeFailure
	 * @description : Called from the callback model when we receive a failure to transcode notice
	 * @updated : 26th August 2011
	 * @by : Charles Jackson
	 */
	function transcodeFailure( $user, $data ) {
		
		$this->create();
		$this->data['Notification']['user_id'] = 0;
		$this->data['Notification']['title'] = 'Error in transcoding';
		$this->data['Notification']['type'] = 'Error';
		$this->data['Notification']['admin_only'] = true;
		$this->data['Notification']['message'] = 'We received a notice of failure from the Admin API. Details can be seen below : <pre>'.print_r( $data ).'</pre>';
		$this->save( $this->data );
	}
	
	/*
	 * @name : malformedData
	 * @description : Called from the callback model when we receive a failure to transcode notice
	 * @updated : 26th August 2011
	 * @by : Charles Jackson
	 */
	function malformedData( $data ) {
		
		$this->create();
		$this->data['Notification']['user_id'] = 0;
		$this->data['Notification']['title'] = 'Malformed data from the API';
		$this->data['Notification']['type'] = 'Error';
		$this->data['Notification']['admin_only'] = true;
		$this->data['Notification']['message'] = 'The following callback from the Admin API could not be understood else has been indentified as malformed : <pre>'.print_r( $data ).'</pre>';
		$this->save( $this->data );
	}		

	/*
	 * @name : unableToDelete
	 * @description : Called from the callback model when we receive a failure to delete status
	 * @updated : 26th August 2011
	 * @by : Charles Jackson
	 */
	function unableToDelete( $data = array() ) {
		
		$this->create();
		$this->data['Notification']['user_id'] = 0;
		$this->data['Notification']['title'] = 'Unable to delete from media server';
		$this->data['Notification']['type'] = 'Error';
		$this->data['Notification']['admin_only'] = true;
		$this->data['Notification']['message'] = 'The Admin API has reported a failure to delete. Details below : <pre>'.$data.'</pre>';
		$this->save( $this->data );
	}	
	
	/*
	 * @name : unableSaveFlavour
	 * @description : Everytime a transcode-media callback is received we save the flavour in the item_media table. If it fails
	 * for any reason a row is created on the notifications table.
	 * @updated : 26th August 2011
	 * @by : Charles Jackson
	 */	
	function unableSaveFlavour( $data = array(), $api_data = array() ) {
		
		$this->create();
		$this->data['Notification']['user_id'] = 0;
		$this->data['Notification']['title'] = 'Unable to save media';
		$this->data['Notification']['type'] = 'Error';
		$this->data['Notification']['admin_only'] = true;
		$this->data['Notification']['message'] = 'We were unable to save a flavour of media. The specific details as received from the Admin API are as follows.<pre>'.print_r( $api_data, 1 ).'</pre> ... and the derived podcast_item_media we attempted to save was : <pre>'.print_r( $data, 1 ).'</pre>';
		$this->save( $this->data );		
	}

	/*
	 * @name : errorTranscoding
	 * @description : Everytime a transcode-media callback is received we check the status. If not equal to YES then we report an error
	 * by inserting a row into the notifications table.
	 * @updated : 5th September 2011
	 * @by : Charles Jackson
	 */		
	function errorTranscoding( $data = array() ) {
		
		$this->create();
		$this->data['Notification']['user_id'] = 0;
		$this->data['Notification']['title'] = 'Error in transcoding';
		$this->data['Notification']['type'] = 'Error';
		$this->data['Notification']['admin_only'] = true;
		$this->data['Notification']['message'] = 'The Admin API reported a transcoding error. Details taken from the appropriate row on the podcast_item_media table can been seen below : <pre>'.print_r( $data, 1 ).'</pre>';
		$this->save( $this->data );		
	}

	/*
	 * @name : unableToCleanFolder
	 * @description : If we are unable to clean a local folder structure upon receipt of a completed callback
	 * we insert a row into the notifications table.
	 * @updated : 5th September 2011
	 * @by : Charles Jackson
	 */		
	function unableToCleanFolder( $row = array(), $path = null ) {
		
		$this->create();
		$this->data['Notification']['user_id'] = 0;
		$this->data['Notification']['title'] = 'Problem deleting local folder/file structure';
		$this->data['Notification']['type'] = 'Warning';
		$this->data['Notification']['admin_only'] = true;
		$this->data['Notification']['message'] = 'There has been a problem deleting a local folder structure and or file <i>'.FILE_REPOSITORY.$path.' </i> on the Admin box. We have just completed the transaction transcribed below as passed by the Admin API : <pre>'.print_r( $row, 1 ).'</pre>';
		$this->save( $this->data );		
	}

	/*
	 * @name : unreadSystemNotifications
	 * @description : Called from users/dashboard for administrators only, it checks to see if there are any unread notifications
	 * on the system and returns a bool accordingly.
	 * @updated : 5th September 2011
	 * @by : Charles Jackson
	 */
	function unreadSystemNotifications() {
		
		$this->data = $this->find('first',array('conditions' => array(
			
			'Notification.unread' => 1,
			'Notification.admin_only' => 1
				)
			)
		);
		
		if( empty( $this->data ) )
			return false;
			
		return true;
	}
}
