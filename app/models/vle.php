<?php
class Vle extends AppModel {

	var $name = 'Vle';
	var $validate = array();
	var $useTable = false;
	var $data = array();
	var $json = null;	
	var $commands = array('create-container','delete-container','submit-media','delete-media','get-media-endpoint-url','metadata-update');
	
	/*
	 * @name : setData
	 * @description : We json_decode the posted data and assign to the class variable data.
	 * @todo : Elaborate on this, checking is very very basic.
	 * @updated : 15th July 2011
	 * @by : Charles Jackson
	 */	
	function setData( $data ) {

		$dataMess=explode('=',urldecode($data));
		
		if( isSet( $dataMess[1] ) ) {
			$this->json = $dataMess[1];
			$this->data=json_decode($dataMess[1],true);
		}
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
	
	/*
	 * @name : createCollection
	 * @description : Will create a row on the podcasts table. Returns a boolean.
	 * @updated : 15th July 2011
	 * @by : Charles Jackson
	 */
	function createCollection( $row = array() ) {
		
		$podcasts = array();
		$podcast = ClassRegistry('Podcast');
		$podcast->create();
		$podcast->recursive = -1;
		
		$this->data['Podcast']['title'] = $row['title'];
		$this->data['Podcast']['summary'] = $row['description'];
		$this->data['Podcast']['link'] = $row['weburl']; // AM I POPULATING THE CORRECT COLUMN FOR VLE PURPOSES???
		
		$podcast->set( $this->data );
	
		if( $podcast->save() )
			return $podcast->getLastInsertId();

		return false;
	}

	/*
	 * @name : deleteCollection
	 * @description : Will delete a row on the podcasts table for every row in the data array passed as a parameter to
	 * the VLE ADD action. Will also make an API call scheduling deletion of the data.
	 * @updated : 15th July 2011
	 * @by : Charles Jackson
	 */
	function deleteCollection() {
		
		$podcasts = array();
		$podcast = ClassRegistry('Podcast');
		$podcast->recursive = -1;

		
		foreach( $this->data['data'] as $row ) {
			
			$data = $podcast->findById( $row['id'] );
			if( !empty( $data ) ) {
				
				$podcasts[] = array( 'id' => $podcast->getLastInsertId(), 'title' => $row['title'], 'status' => 1 );
			}
			$this->data['Podcast']['title'] = $row['title'];
			$podcast->set( $this->data );
		
				
		}
		
		return $podcasts;
	}	
}