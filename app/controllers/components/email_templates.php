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
     * @NAME : __sendNewRegistrationEmail
     * @DESCRIPTION : When a user registers with the site this email will be sent out.
     */
    function __sendNewRegistrationEmail( $data, $administrators = array() ) {

        $this->Email->to = $administrator['User']['email'];
        $this->Email->subject = "New Registration at ".$_SERVER['HTTP_HOST'];
        $this->Email->replyTo = $data['User']['email'];
        $this->Email->template = 'new_registration'; // note no '.ctp'

        $this->Email->sendAs = 'html'; // because we like to send pretty mail
        //Set view variables as normal
        $this->controller->set('data', $data);
        //Do not pass any args to send()
                	
        /* Set delivery method */
        foreach( $administrators as $administrator ) {

            $this->Email->send();
        }
    }

    /*
     * @name : __sendRegistrationApprovedEmail
     * @description : When an administrator approved a user registration this email will be sent out.
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
     * @description : 
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
        
        foreach( $recipients as $recipient ) {
        	
        	$this->Email->to = $recipient['User']['email'];
        	$this->Email->send();
        }
    }

    /*
     * @name : __sendCallbackErrorEmail
     * @description : 
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