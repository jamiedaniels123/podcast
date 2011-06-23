<?php
class ApiComponent extends Object {


    var $params = array();
    var $response = array();

    const MEDIA_URL = 'http://137.108.130.70';
    
    /*
     * @name : startup
     * @description : Grab the controller reference for later use.
     * @updated : 7th May 2011
     * @by : Charles Jackson
     */
    function startup( & $controller) {

       $this->controller = & $controller;
    }


    function deleteFolderFromMediaServer( $folders = array() ) {

        $this->params = array(
            'data' => $folders
        );

        $this->response = json_decode( $this->__sendMessage('delete-folder-on-media-server', self::MEDIA_URL, $this->params ), 1 );
        return $this->getStatus( $this->response );

    }

    /*
     * @name : deleteFileOnMediaServer
     * @description : Deletes a file on the media server.
     * @updated : 20th June 2011
     * @by : Ian Newton / Charles Jackson
     */
    function deleteFileOnMediaServer( $source = null, $filename = null ) {

		// If we wish to delete a individual file we pass individual elements.
		if( is_array( $source ) == false ) {
			
			$this->params = array(
				'data' => array(
					array(
						'source_path' => $source,
						'filename' => $filename
					)
				)
			);
					
		} else {
			
			// We wish to delete multiple file hence $source is a preformatted array.
			$this->params = array(
				'data' => $source
				);
		}

        $this->response = json_decode( $this->__sendMessage('delete-file-on-media-server', self::MEDIA_URL, $this->params ), 1 );
        return $this->getStatus( $this->response );
    }

    /*
     * @name : transferFileMediaServer
     * @description : Passes a list of files to be moved across to the media server.
     * @updated : 7th June 2011
     * @by : Ian Newton / Charles Jackson
     */
    function transferFileMediaServer( $source = null, $filename = null, $target = null ) {

        // If we wish to transfer a individual file we pass individual elements.
        if( is_array( $source ) == false ) {

            // If target is NULL the destination path mirrors the source path.
            if( $target == null )
                $target = $source;


            $this->params = array(
                'data' => array(
                    array(
                        'source_path' => $source,
                        'destination_path' => $target,
                        'filename' => $filename
                    )
                )
            );

        } else {

            // We wish to delete multiple file hence $source is a preformatted array.
            $this->params = array(
                'data' => $source
                );
        }
		
        $this->response = json_decode( $this->__sendMessage('transfer-file-to-media-server', self::MEDIA_URL, $this->params ), 1 );
        return $this->getStatus( $this->response );
    }

    /*
     * @name : sendMessage
     * @description : Called from the controller, formats parameters passed into a JSON encoded array
     * @updated : 7th June 2011
     * @by : Ian Newton / Charles Jackson
     */
    function transcodeMedia( $path, $filename ) {

        $this->params = array(
            'data' => array(
                'source_path' => $path,
                'filename' => $filename
            )
        );

        $this->response = json_decode( $this->__sendMessage('transcode-media', self::MEDIA_URL, $this->params ), 1 );
        return $this->getStatus( $this->response );
    }
    
    // returns a bool
    function fileExist( $path, $filename ) {

        $this->params = array(
            'data' => array(
                'source_path' => $path,
                'filename' => $filename
            )
        );

        $this->response = json_decode( $this->__sendMessage('checkFile', self::MEDIA_URL, $this->params ), 1 );
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
        $response = $this->__restHelper( $mediaUrl, $postData, 'POST', 'json');

        return $response;
    }

    /*
     * @name : __restHelper
     * @description : Sends the JSON encoded array and returns the response
     * @updated : 7th June 2011
     * @by : Ian Newton / Charles Jackson
     */
    function __restHelper( $url, $params = null, $verb = 'GET', $format = 'json' ){

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
            // $meta = stream_get_meta_data($fp);
            // var_dump($meta['wrapper_data']);
            $res = stream_get_contents($fp);
        }

        if ($res === false) {

                throw new Exception("$verb $url failed: $php_errormsg");
        }

        switch ($format) {
            
            case 'json':
                $r=$res;

                if ( $r === null )
                    throw new Exception("failed to decode $res as json");

                return $r;

            case 'xml':
                $r = simplexml_load_string($res);

                if ($r === null) {
                    throw new Exception("failed to decode $res as xml");
                }

              return $r;
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

		return strtoupper( $response[0]['status'] ) == 'ACK' ? true : false;
		
	}
}