<?php

class emailTemplatesComponent extends Object {

    var $components = array( 'Email', 'Session' );

    //called before Controller::beforeFilter()
    function initialize(&$controller) {

        // saving the controller reference for later use
        $this->controller =& $controller;

        /* SMTP Options */
        $this->Email->smtpOptions = array(
            'port' => 25,
            'host' => 'smtpmail.open.ac.uk'
        );

        $this->Email->delivery = 'smtp';
        $this->Email->date_create = date('Y-m-d H:i:s');
        $this->Email->from = DEFAULT_EMAIL_ADDRESS;

    }

    /*
     * @name : __sendNewRegistrationEmail
     * @description : When a user registers with the site this email will be sent out.
	 * @NOTE: This is only used with the "alternative" registration when we are not using SAMS data.
	 * @updated : 19th August 2011
	 * @by : Charles Jackson
     */
    function __sendNewRegistrationEmail( $data, $administrators = array() ) {
			
		$this->Email->subject = "New Registration at ".$_SERVER['HTTP_HOST'];
		$this->Email->replyTo = $data['User']['email'];
		$this->Email->template = 'new_registration'; // note no '.ctp'

		$this->Email->sendAs = 'html'; // because we like to send pretty mail
		//Set view variables as normal
		$this->controller->set('data', $data);

        foreach( $administrators as $administrator ) {
			$this->Email->to = $administrator['User']['email'];			
            $this->Email->send();
        }
    }

    /*
     * @name : __sendRegistrationApprovedEmail
     * @description : When an administrator approved a user registration this email will be sent out.
	 * @NOTE: This is only used on the "alternative" registration method, not when we are using SAMS data.
     */
    function __sendRegistrationApprovedEmail( $recipient ) {

        /* Set delivery method */
        $this->Email->to = $recipient['User']['email'];
        $this->Email->subject = "Registration confirmed at ".$_SERVER['HTTP_HOST'];
        $this->Email->replyTo = DEFAULT_EMAIL_ADDRESS;
        $this->Email->template = 'registration_approved'; // note no '.ctp'

        $this->Email->sendAs = 'html'; // because we like to send pretty mail
        //Set view variables as normal
        $this->controller->set('data', $recipient);
        //Do not pass any args to send()

        $this->Email->send();
    }

    /*
     * @name : __sendCallbackErrorEmail
     * @description : Called from the /callbacks/add method, usually to alert administrators to a problem.
     */
    function __sendCallbackErrorEmail( $recipients=array(),$data ,$errormessage) {

        /* Set delivery details */
        $this->Email->subject = "Podcast Admin Issue - Notification ".$_SERVER['HTTP_HOST'];
        $this->Email->replyTo = DEFAULT_EMAIL_ADDRESS;
        $this->Email->template = 'callback_error'; // note no '.ctp'

        $this->Email->sendAs = 'html'; // because we like to send pretty mail
        //Set view variables as normal
        $this->controller->set('data', $data);
        $this->controller->set('errormessage', $errormessage);
        //Do not pass any args to send()
        $this->Email->to = 'jdd7@openmail.open.ac.uk';
        //foreach( $recipients as $recipient ) {

        	//$this->Email->to = $recipient['User']['email'];
        	$this->Email->send();
        //}
    }

    /*
     * @name : __sendVleErrorEmail
     * @description : Sent from the VLE callback URL when there is an issue.
	 * @updated : 19th August 2011
	 * @by : Charles Jackson
     */
    function __sendVleErrorEmail( $recipients=array(),$data ,$errormessage) {

        /* Set delivery details */
        $this->Email->subject = "Podcast Admin VLE Issue - Notification ".$_SERVER['HTTP_HOST'];
        $this->Email->replyTo = DEFAULT_EMAIL_ADDRESS;
        $this->Email->template = 'callback_error'; // note no '.ctp'

        $this->Email->sendAs = 'html'; // because we like to send pretty mail
        //Set view variables as normal
        $this->controller->set('data', $data);
        $this->controller->set('errormessage', $errormessage);
        //Do not pass any args to send()
        
        foreach( $recipients as $recipient ) {
        	
        	$this->Email->to = $recipient['User']['email'];
        	$this->Email->send();
        }
    }

    /*
     * @name : _sendYoutubeConsiderEmail
     * @description : An email is sent when a user submits a video for consideration to the youtube team
	 * @updated : 19th August 2011
	 * @by : Charles Jackson
     */
	function _sendYoutubeConsiderEmail( $data, $youtube_users ) {
		
        $this->Email->subject = "Podcast for Youtube consideration";
        $this->Email->replyTo = $this->Session->read('Auth.User.email');
        $this->Email->sendAs = 'html'; // because we like to send pretty mail
        $this->Email->template = 'youtube_consider'; // note no '.ctp'		
        //Set view variables as normal
        $this->controller->set('data', $data);
		$this->controller->set('user', $this->Session->read('Auth.User') );

        foreach( $youtube_users as $youtube_user ) {
			
			$this->Email->to = $youtube_user['User']['email'];	
            $this->Email->send();
        }
	}

    /*
     * @name : _sendItunesConsiderEmail
     * @description : An email is sent when a user submits a video for consideration to the iTunes team
	 * @updated : 19th August 2011
	 * @by : Charles Jackson
     */
	function _sendItunesConsiderEmail( $data, $itunes_users ) {
		
        $this->Email->to = $data['Owner']['email'];
        $this->Email->subject = "Podcast for iTunes consideration";
        $this->Email->replyTo = $this->Session->read('Auth.User.email');
        $this->Email->sendAs = 'html'; // because we like to send pretty mail
        $this->Email->template = 'itunes_consider'; // note no '.ctp'		
        //Set view variables as normal
        $this->controller->set('data', $data);
		$this->controller->set('user', $this->Session->read('Auth.User') );

        foreach( $itunes_users as $itunes_user ) {
			
			$this->Email->to = $itunes_user['User']['email'];			
            $this->Email->send();
        }

	}
		        
    /*
     * @name : __sendPodcastRejectionEmail
     * @description : Called when a podcast is rejected for either itunes ot youtube
     */
	function __sendPodcastRejectionEmail( $media_type, $data, $justification ) {
		
        $this->Email->to = $data['Owner']['email'];
        $this->Email->subject = "Podcast Rejection from Admin Server";
        $this->Email->replyTo = $this->Session->read('Auth.User.email');
        $this->Email->sendAs = 'html'; // because we like to send pretty mail
        $this->Email->template = 'podcast_rejection'; // note no '.ctp'		
        //Set view variables as normal
        $this->controller->set('data', $data);
        $this->controller->set('media_type', $media_type);
        $this->controller->set('justification', $justification);		
        //Do not pass any args to send()

        $this->Email->send();
	}

    /*
     * @name : __sendPodcastApprovalEmail
     * @description : Called when a podcast is rejected for either itunes ot youtube
     */
	function __sendPodcastApprovalEmail( $media_type, $data ) {
		
        $this->Email->to = $data['Owner']['email'];
        $this->Email->subject = "Podcast Approval from Admin Server";
        $this->Email->replyTo = $this->Session->read('Auth.User.email');
        $this->Email->sendAs = 'html'; // because we like to send pretty mail
        $this->Email->template = 'podcast_approval'; // note no '.ctp'		
        //Set view variables as normal
        $this->controller->set('data', $data);
        $this->controller->set('media_type', $media_type);
        //Do not pass any args to send()

        $this->Email->send();
		
	}
	
	
	
    function getDomain() {

        $domain = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']);
        return $domain;
    }
}

?>
