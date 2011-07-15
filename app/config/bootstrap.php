<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

DEFINE('APPLICATION_URL', 'http://'.$_SERVER['SERVER_NAME']);
DEFINE('SECURE_APPLICATION_URL', 'https://'.$_SERVER['SERVER_NAME']);

// Capture the SAMS details here.
if( isSet( $_SESSION['Auth.User.id'] ) == false ) {

    if( isSet( $_SERVER['LOCAL_SAMS_USER'] ) ) {

        DEFINE('SAMS_EMAIL', $_SERVER['LOCAL_SAMS_USER'].'@open.ac.uk' );
        DEFINE('SAMS_OUCU_ID', $_SERVER['LOCAL_SAMS_USER'] );
        DEFINE('SAMS_NAME', 'Charles Jackson' );

	} elseif( isSet( $_SERVER['PETES_SAMS_USER'] ) ) {

        DEFINE('SAMS_EMAIL', $_SERVER['PETES_SAMS_USER'].'@open.ac.uk' );
        DEFINE('SAMS_OUCU_ID', $_SERVER['PETES_SAMS_USER'] );
        DEFINE('SAMS_NAME', 'Peter Devine' );

    } elseif( isSet( $_SERVER['REMOTE_USER'] ) ) {

        DEFINE('SAMS_EMAIL', $_SERVER['REMOTE_USER'].'@open.ac.uk' );
        DEFINE('SAMS_OUCU_ID', $_SERVER['REMOTE_USER'] );
		
		if( !empty( $_COOKIE['HS7BDF'] ) ) {
			
        	DEFINE('SAMS_NAME', $_COOKIE['HS7BDF'] );
			
		} else {
			
			DEFINE('SAMS_NAME','Unknown User');
		}

    }
}
DEFINE('SAMS_LOGOUT_PAGE', 'https://msds.open.ac.uk/signon/samsoff.aspx');
DEFINE('PUBLIC_ITUNEU_PODCAST', 1 );
DEFINE('PUBLISHED_ITUNEU_PODCAST', 2 );
DEFINE('UNPUBLISHED_ITUNEU_PODCAST', 3 );
DEFINE('OPENLEARN_PODCAST', 4 );
DEFINE('PRIVATE_ITUNEU_PODCAST', 5 );
DEFINE('DELETED_PODCAST', 6 );

DEFINE('FILE_REPOSITORY', WWW_ROOT.'upload/files/');
DEFINE('LOCAL_FILE_REPOSITORY_URL', APPLICATION_URL.'/upload/files/');
DEFINE('DEFAULT_MEDIA_URL', 'http://media-podcast-dev.open.ac.uk/');
DEFINE('AMAZON_S3_SERVER', 'http://media-podcast.open.ac.uk.s3.amazonaws.com');
DEFINE('DEFAULT_ITUNES_MEDIA_URL', 'http://podcast.open.ac.uk/');

DEFINE('DEFAULT_AUTHOR', 'The Open University');
DEFINE('DEFAULT_RSS_FILENAME','rss2.xml');
DEFINE('TRANSCRIPT_PREFIX', 'Transcript - ');
DEFINE('FEEDS','feeds/');
DEFINE('FEEDS_LOCATION', 'feeds/');
DEFINE('THUMBNAIL_EXTENSION', '_thm');
DEFINE('RESIZED_IMAGE_EXTENSION', '_std');
DEFINE('NO_IMAGE_AVAILABLE', '/img/default-project-thumbnail.png');
DEFINE('CORRECT_IMAGE', '/correct.png');
DEFINE('INCORRECT_IMAGE', '/incorrect.png');
DEFINE('ERROR_IMAGE', '/error.png');

DEFINE('RSS_VIEW', 'http://'.$_SERVER['SERVER_NAME'].'/feeds/view/');
    
DEFINE('TRANSCRIPT', 'TRANSCRIPT');
DEFINE('YOUTUBE', 'YOUTUBE');
DEFINE('YES', 'Y');
DEFINE('NO', 'N');

DEFINE('REGISTER_BY_OUCU', true );
DEFINE('DEFAULT_EMAIL_ADDRESS', 'Podcast Admin Server <cj3998@openmail.open.ac.uk>' );

DEFINE('WIDE_SCREEN', '0.5625');
DEFINE('STANDARD_SCREEN', '0.75');

// The columns on the podcast table database that indicate itunes status 
DEFINE('ITUNES_CONSIDERATION', 'consider_for_itunesu');
DEFINE('ITUNES_INTENDED', 'intended_youtube_flag');
DEFINE('ITUNES_PUBLISHED', 'publish_itunes_u');

// The columns on the podcast table database that indicate itunes status
DEFINE('YOUTUBE_CONSIDERATION', 'consider_for_youtube');
DEFINE('YOUTUBE_INTENDED', 'intended_youtube_flag');
DEFINE('YOUTUBE_PUBLISHED', 'publish_youtube');

// Workflows
DEFINE('NONE', NULL);
DEFINE('DELIVER_WITHOUT_TRANSCODING', 'deliver-without-transcoding');
DEFINE('AUDIO', 'audio');
DEFINE('SCREENCAST','screencast');
DEFINE('SCREENCAST_WIDE', 'screencast-wide');
DEFINE('VIDEO', 'video');
DEFINE('VIDEO_WIDE', 'video-wide');
DEFINE('MULTI_VIDEO', 'multi-video');
DEFINE('MULTI_VIDEO_WIDE', 'multi-video-wide');

// processed state of media
DEFINE('MEDIA_AVAILABLE',9);
DEFINE('ADMIN_API', 'http://podcast-api-dev.open.ac.uk/');