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

DEFINE('FEEDS_LOCATION', 'feeds/');
DEFINE('THUMBNAIL_EXTENSION', '_thm');
DEFINE('RESIZED_IMAGE_EXTENSION', '_std');
DEFINE('NO_IMAGE_AVAILABLE', '/img/noImageAvailable.jpg');
DEFINE('CORRECT_IMAGE', '/correct.gif');
DEFINE('INCORRECT_IMAGE', '/incorrect.gif');

if( isSet( $_SESSION['Auth.User.id'] ) == false ) {

    if( isSet( $_SERVER['LOCAL_SAMS_USER'] ) ) {

        DEFINE('SAMS_EMAIL', $_SERVER['LOCAL_SAMS_USER'].'@open.ac.uk' );
        DEFINE('SAMS_OUCU_ID', $_SERVER['LOCAL_SAMS_USER'] );
        DEFINE('SAMS_NAME', 'Charles Jackson' );

    } elseif( isSet( $_SERVER['REDIRECT_HTTP_SAMS_USER'] ) ) {

        DEFINE('SAMS_EMAIL', $_SERVER['REDIRECT_HTTP_SAMS_USER'].'@open.ac.uk' );
        DEFINE('SAMS_OUCU_ID', $_SERVER['REDIRECT_HTTP_SAMS_USER'] );
        DEFINE('SAMS_NAME', $_COOKIE['HS7BDF'] );

    } elseif( isSet( $_SERVER['HTTP_SAMS_USER'] ) ) {

        DEFINE('SAMS_EMAIL', $_SERVER['REDIRECT_HTTP_SAMS_USER'].'@open.ac.uk' );
        DEFINE('SAMS_OUCU_ID', $_SERVER['REDIRECT_HTTP_SAMS_USER'] );
        DEFINE('SAMS_NAME', $_COOKIE['HS7BDF'] );
    }
}

DEFINE('PUBLIC_ITUNEU_PODCAST', 1 );
DEFINE('PUBLISHED_ITUNEU_PODCAST', 2 );
DEFINE('UNPUBLISHED_ITUNEU_PODCAST', 3 );
DEFINE('OPENLEARN_PODCAST', 4 );
DEFINE('PRIVATE_ITUNEU_PODCAST', 5 );
DEFINE('DELETED_PODCAST', 6 );

DEFINE('FILE_REPOSITORY', WWW_ROOT.'upload/files/');
DEFINE('DEFAULT_MEDIA_URL', 'http://podcast.open.ac.uk/');
DEFINE('DEFAULT_ITUNES_MEDIA_URL', 'http://podcast.open.ac.uk/');
//DEFINE('DEFAULT_ITUNES_MEDIA_URL', 'http://media-podcast.open.ac.uk/');
DEFINE('FEEDS_FOLDER', 'feeds/');
DEFINE('DEFAULT_AUTHOR', 'The Open University');
DEFINE('DEFAULT_RSS_FILENAME','rss2.xml');
DEFINE('TRANSCRIPT_PREFIX', 'Transcript - ');

DEFINE('RSS_VIEW', 'http://'.$_SERVER['SERVER_NAME'].'/feeds/view/');
    
DEFINE('TRANSCRIPT', 'TRANSCRIPT');
DEFINE('YOUTUBE', 'YOUTUBE');
DEFINE('YES', 'Y');
DEFINE('NO', 'N');

