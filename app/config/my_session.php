<?php

 /*
  * @name : session.php
  * @description : Added to alter the default behavour of Sessions, in particular changing the session to end when browser closed.
  *								 Code is copied from 'http://book.cakephp.org/1.3/en/view/1310/Sessions' and requires the addition of some code
  *								 to 'app/config/core.php' (see former link for details).
  * @updated : 8th May 2012
  * @by : Ben Hawkridge
  */

	// app/config/my_session.php
	//
	// Revert value and get rid of the referrer check even when,
	// Security.level is medium
	ini_restore('session.referer_check');
	
	ini_set('session.use_trans_sid', 0);
	ini_set('session.name', Configure::read('Session.cookie'));
	
	// Cookie is now destroyed when browser is closed, doesn't 
	// persist for days as it does by default for security
	// low and medium
	ini_set('session.cookie_lifetime', 0);
	
	// Cookie path is now '/' even if you app is within a sub 
	// directory on the domain
	$this->path = '/';
	ini_set('session.cookie_path', $this->path);
	
	// Session cookie now persists across all subdomains
	ini_set('session.cookie_domain', env('HTTP_BASE'));
?>