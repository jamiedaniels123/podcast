<?php

class emailTemplatesComponent extends Object {

    var $components = array( 'Email' );

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

        /* Set delivery method */
        foreach( $administrators as $administrator ) {
            
            $this->Email->to = $administrator['User']['email'];
            $this->Email->subject = "New Registration at ".$_SERVER['HTTP_HOST'];
            $this->Email->replyTo = $data['User']['email'];
            $this->Email->template = 'new_registration'; // note no '.ctp'

            $this->Email->sendAs = 'html'; // because we like to send pretty mail
            //Set view variables as normal
            $this->controller->set('data', $data);
            //Do not pass any args to send()

            $this->Email->send();
        }
    }

    /*
     * @NAME : __sendRegistrationApprovedEmail
     * @DESCRIPTION : When an administrator approved a user registration this email will be sent out.
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


    function __sendCallbackErrorEmail( $recipients=array(),$data ,$errormessage) {

        /* Set delivery method */
        $this->Email->to = 'j.d.daniels@open.ac.uk';
        $this->Email->subject = "callback error at ".$_SERVER['HTTP_HOST'];
        $this->Email->replyTo = DEFAULT_EMAIL_ADDRESS;
        $this->Email->template = 'callback_error'; // note no '.ctp'

        $this->Email->sendAs = 'html'; // because we like to send pretty mail
        //Set view variables as normal
        $this->controller->set('data', $data);
        $this->controller->set('errormessage', $errormessage);
        //Do not pass any args to send()

        $this->Email->send();
    }


    function getDomain() {

        $domain = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']);
        return $domain;
    }
}

?>
