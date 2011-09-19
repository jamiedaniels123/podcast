<?php
class VleApiComponent extends Object {


    var $params = array();
    var $response = array();

    /*
     * @name : initialize
     * @description : Grab the controller reference for later use.
     * @updated : 7th May 2011
     * @by : Charles Jackson
     */
    function initialize( & $controller) {

       $this->controller = & $controller;
    }



	
	
	
    // NOTHING TO SEE HERE FOLKS
    // BELOW THIS LINE ARE THE GENERIC METHODS OF THE API THAT CAN ONLY BE CALLED INTERNALLY.

    /*
     * @name : sendMessage
     * @description : Called from the controller, formats parameters passed into a JSON encoded array
     * @updated : 7th June 2011
     * @by : Ian Newton / Charles Jackson
     */
    function __sendMessage( $command, $mediaUrl, $data, $number = 1 ){

        $postData = array( 'command' => $command ,'number' => $number ,'data' => $data,'timestamp' => time() );
        $postData = array( 'mess' => json_encode( $postData ) );
        return( $this->__restHelper( $mediaUrl, $postData, 'POST' ) );
    }

    /*
     * @name : __restHelper
     * @description : Sends the JSON encoded array and returns the response
     * @updated : 7th June 2011
     * @by : Ian Newton / Charles Jackson
     */
    function __restHelper( $url, $params = null, $verb = 'GET' ){

        $cparams = array( 'http' => array( 'method' => $verb, 'ignore_errors' => true ) );

        if ( $params !== null ) {

            $params = http_build_query($params);

            if ($verb == 'POST') {

              $cparams['http']['content'] = $params;
              $cparams['http']['header'] = 'Content-Type: application/x-www-form-urlencoded\r\n';

            } else {

              $url .= '?' . $params;
            }
        }
        $context = stream_context_create($cparams);
        $fp = fopen($url, 'rb', false, $context);

        if ( !$fp ) {

            $res = false;

        } else {

            // If you're trying to troubleshoot problems, try uncommenting the
            // next two lines; it will show you the HTTP response headers across
            // all the redirects:
            $res = stream_get_contents($fp);
        }

        if ($res === false) {

                throw new Exception("$verb $url failed: $php_errormsg");
        }
		
		return $res;
    }
	
	
	/*
	 * @name : getStatus
	 * @dfescription : Checks the "status" field for an ACK or NACK and returns a bool for ACK (acknowledged) or NACK
	 * (Knackered).
	 * @updated : 17th June 2011
	 * @by : Charles Jackson
	 */
	function getStatus( $response = array() ) {
		return strtoupper( $response['status'] ) == 'ACK' ? true : false;
	}
}