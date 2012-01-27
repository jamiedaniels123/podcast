<?php
class MiscellaneousHelper extends AppHelper {

	function columnActive( $active_columns = array(), $column ) {
		
		$checked = null;
		
		if( in_array($column, $active_columns ) )
			$checked = 'checked="true"';
		
		return $checked;
		
	}
	
	function columnVisible( $active_columns = array(), $column ) {
		
		$style = null;
		
		if( in_array($column, $active_columns ) == false )
			$style = 'style="display:none;"';
		
		return $style;
		
	}
	
	function yesNo( $bool = false ) {
		
		if( $bool )
			return 'Yes';
			
		return 'No';
	}
}
