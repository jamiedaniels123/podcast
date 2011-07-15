<?php
class Vle extends AppModel {

	var $name = 'Vle';
	var $validate = array();
	var $useTable = false;
	var $data = array();

	/*
	 * @name : setData
	 * @description : We json_decode the posted data and assign to the class variable data.
	 * @todo : Elaborate on this, checking is very very basic.
	 * @updated : 15th July 2011
	 * @by : Charles Jackson
	 */	
	function setData( $data ) {

		$dataMess=explode('=',urldecode($data));
		if( isSet( $dataMess[1] ) )
			$this->data=json_decode($dataMess[1],true);
	}

	/*
	 * @name : understand
	 * @description : ???
	 * @updated : 12th July 2011
	 * @by : Charles Jackson
	 */
	function understand(){

		if( isSet( $this->data['command'] ) && in_array( $this->data['command'], $this->commands ) ) {
			
			return true;
			
		} else {
			
			return false;
		}
	}
	
	/*
	 * @name : hasErrors
	 * @description : Reads through every element in the callback data array and checks the status is equal to YES (Y).
	 * @updated : 12th July 2011
	 * @by : Charles Jackson
	 */
	function hasErrors() {
		
		foreach( $this->data['data'] as $row ) {
			
			if( strtoupper( $row['status'] ) != YES )
				return true;
		}
		
		return false;
	}
}