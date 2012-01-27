<?php
class LogsController extends AppController {

	var $name = 'Logs';
	var	$paginate = array('limit' => 100);

    /*
     * @name : beforeFilter
     * @description : Called before any other method.
     * @updated : 2nd June 2010
	 * @by : Charles Jackson
     */
    function beforeFilter() {
        
        parent::beforeFilter();
    }

	function admin_index() {
		
		$this->data['Logs'] = $this->paginate('Log');
	}
	
    /*
     * @name : admin_view
     * @desscription : Enables an administrator to view the log files
     * @name : Charles Jackson
     * @by : 17th August 2011
     */
    function admin_view( $id = null ) {

        // They are loading the page, get the data using the $id passed as a parameter.
        $this->data = $this->Log->findById( $id );

        // We did not find the podcast, error and redirect.
        if( empty( $this->data ) ) {

            $this->Session->setFlash( 'Could not find your collection. Please try again.', 'default', array( 'class' => 'error' ) );
			$this->cakeError('error404');
        }
    }	
}
?>
