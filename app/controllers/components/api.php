<?php
class ApiComponent extends Object {


    var $params = array();
    var $response = array();

    const ADMIN_API = 'http://podcast-api-dev.open.ac.uk/';
    
    /*
     * @name : startup
     * @description : Grab the controller reference for later use.
     * @updated : 7th May 2011
     * @by : Charles Jackson
     */
    function startup( & $controller) {

       $this->controller = & $controller;
    }


    function deleteFolderOnMediaServer( $data = array() ) {

        $this->response = json_decode( $this->__sendMessage('delete-folder-on-media-server', self::ADMIN_API, $data, count( $data ) ), 1 );
        return $this->getStatus( $this->response );

    }

    /*
     * @name : deleteFileOnMediaServer
     * @description : Deletes a file on the media server.
     * @updated : 20th June 2011
     * @by : Ian Newton / Charles Jackson
     */
    function deleteFileOnMediaServer( $data = array() ) {

		
        $this->response = json_decode( $this->__sendMessage('delete-file-on-media-server', self::ADMIN_API, $data, count( $data ) ), 1 );
        return $this->getStatus( $this->response );
    }

    /*
     * @name : transferFileMediaServer
     * @description : Passes a list of files to be moved across to the media server.
     * @updated : 7th June 2011
     * @by : Ian Newton / Charles Jackson
     */
    function transferFileMediaServer( $data = array() ) {

        $this->response = json_decode( $this->__sendMessage('transfer-file-to-media-server', self::ADMIN_API, $data, count( $data ) ), 1 );
        return $this->getStatus( $this->response );
    }

    /*
     * @name : deliverWithoutTranscoding
     * @description : The method is identical to the "transferFileMediaServer" method. However we use a seperate
     * command so the callback URL knows the media will require meta data injection after a successful transfer 
     * @updated : 14th June 2011
     * @by : Charles Jackson
     */
    function deliverWithoutTranscoding( $data = array() ) {

		$this->params = array(  $data );
		
		
        $this->response = json_decode( $this->__sendMessage('deliver-without-transcoding', self::ADMIN_API, $this->params, count( $data ) ), 1 );
        return $this->getStatus( $this->response );
    }
        
    /*
     * @name : renameFileMediaServer
     * @description : Called from the controller, formats parameters passed into a JSON encoded array
     * @updated : 7th June 2011
     * @by : Ian Newton / Charles Jackson
     */
    function renameFileMediaServer( $data = array() ) {

        $this->response = json_decode( $this->__sendMessage('rename-file-on-media-server', self::ADMIN_API, $data ), 1 );
        return $this->getStatus( $this->response );
    }

    /*
     * @name : transcodeMedia
     * @description : Called from the controller, formats parameters passed into a JSON encoded array
     * @updated : 7th June 2011
     * @by : Ian Newton / Charles Jackson
     */
    function transcodeMedia( $path, $filename, $workflow ) {

        $this->params = array(
			array(
				'workflow' => $workflow,
				'source_path' => $path.'/',
				'filename' => $filename
			)
        );

        $this->response = json_decode( $this->__sendMessage('transcode-media', self::ADMIN_API, $this->params ), 1 );
        return $this->getStatus( $this->response );
    }

    /*
     * @name : metaInjection
     * @description : Initiates a meta injection of the files passed as a parameter. 
     * @updated : 12th July 2011
     * @by : Charles Jackson
     */
    function metaInjection( $data ) {
    	
        $this->response = json_decode( $this->__sendMessage('update-file-metadata', self::ADMIN_API, $data ), 1 );
    }
    
    /*
     * @name : transcodeMediaAndDeliver
     * @description : Called from the controller, formats parameters passed into a JSON encoded array
     * @updated : 7th June 2011
     * @by : Ian Newton / Charles Jackson
     */
    function transcodeMediaAndDeliver( $path, $filename, $workflow, $podcast_item_id ) {

        $this->params = array(
			array(
				'workflow' => $workflow,
				'source_path' => $path.'/',
				'destination_path' => $path.'/',
				'filename' => $filename,
				'podcast_item_id' => $podcast_item_id
			)
        );

        $this->response = json_decode( $this->__sendMessage('transcode-media-and-deliver', self::ADMIN_API, $this->params ), 1 );

		return $this->getStatus( $this->response );

    }
    
    /*
     * @name : fileExist
     * @description :  Not currently being used.
     * @updated : 4th July 2011
     * @by : Ian Newton / Charles Jackson
     */
    function fileExist( $path, $filename ) {

        $this->params = array(
            'data' => array(
                'source_path' => $path,
                'filename' => $filename
            )
        );

        $this->response = json_decode( $this->__sendMessage('checkFile', self::ADMIN_API, $this->params ), 1 );
        return (int)$this->response['data']['status'];
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