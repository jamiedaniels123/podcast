<?php
class Vle extends AppModel {

	var $name = 'Vle';
	var $validate = array();
	var $useTable = false;
	var $data = array();

	function setData( $data ) {

		$this->data = $data;
	}

}