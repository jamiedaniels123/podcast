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
        $this->Email->from = 'Podcast Admin Server <cj3998@openmail.open.ac.uk>';

    }

    /*
     * @NAME : __sendNewRegistrationEmail
     * @DESCRIPTION : When a user registers with the site this email will be sent out.
     */
    function __sendNewRegistrationEmail($data, $recipients = array() ) {

        /* Set delivery method */
        foreach( $recipients as $recipient ) {
            
            $this->Email->to = $recipient['User']['email'];
            $this->Email->subject = "New Registration at ".$_SERVER['HTTP_HOST'];
            $this->Email->replyTo = $recipient['User']['email'];
            $this->Email->template = 'new_registration'; // note no '.ctp'

            $this->Email->sendAs = 'html'; // because we like to send pretty mail
            //Set view variables as normal
            $this->controller->set('data', $data);
            //Do not pass any args to send()

            $this->Email->send();
        }
    }

    function getDomain() {

        $domain = preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']);
        return $domain;
    }
}

?>
