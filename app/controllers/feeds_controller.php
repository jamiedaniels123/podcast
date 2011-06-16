<?php

class FeedsController extends AppController {

    var $name = 'Feeds';
    
    /*
     * @name : beforeFilter
     * @description : The following methods can be accessed without logging in.
     * @updated : 2nd June 2010
     */
    function beforeFilter() {

        if( $this->RequestHandler->isRss() )
            $this->helpers = array('BespokeRss');
        
        $this->Auth->allow( 'add' );
        parent::beforeFilter();
    }

    /*
     * @name : add
     * @description : Creates the various flavours of RSS feed by calling the 'add' method with various parameters. It then
     * captures the output and writes content to a flat file ready to be moved across to the media server
     * @updated : 16th June 2011
     * @by : Charles Jackson
     */
    function add( $id = null ) {

        $this->autoRender = false;

        // First lets try and retrieve the podcast we wish to create RSS feeds for.
        $this->Podcast = ClassRegistry::init('Podcast');
        $this->Podcast->recursive = -1;
        $podcast = $this->Podcast->findById( $id );

        // If we found a podcast, create the RSS feeds
        if( !empty( $podcast ) ) {

            foreach( $this->Feed->rss_flavours as $flavour ) {

                $this->data = file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/feeds/view/'.$id.'/'.$flavour['media_type'].'/'.$flavour['rss_filename'].'/'.$flavour['itunes_complete'].'.rss');

                // The media_type can be empty but if not, append a slash '/' for the purposes of creating the path line.
                if( !empty( $flavour['media_type'] ) )
                    $flavour['media_type'] .= '/';

                $this->Folder->create( $podcast['Podcast']['custom_id'].'/'.$flavour['media_type'] );
                $this->Feed->writeRssFile( FILE_REPOSITORY.$podcast['Podcast']['custom_id'].'/'.$flavour['media_type'].$flavour['rss_filename'], $this->data );
            }

            $this->Session->setFlash('Your RSS feeds have been successfully generated and scheduled for transfer to the media server.', 'default', array( 'class' => 'success' ) );

        } else {

            $this->Session->setFlash('We were unable to generate the RSS feeds.', 'default', array( 'class' => 'error' ) );
        }

        $this->redirect( $this->referer() );
    }
    
    /*
     * @name : view
     * @description : Generate a very simple RSS feed that is echoed out to screen and catpured by the calling routine
     * so it can be written to a flat file.
     * @updated : 26th May 2011
     * @by : Charles Jackson
     */
    function view( $id = null, $media_type = null, $rss_filename = null, $itunes_complete = false, $interlace = true ) {

        $podcast_items = array();
        
        $this->Podcast = ClassRegistry::init('Podcast');
        $this->Podcast->recursive = 2;

        $this->data = $this->Podcast->findById( $id, array(
            'conditions' => array(

                )
            )
        );

        if( empty( $this->data ) ) {

            return false;

        } else {
            
            $this->Feed->setData( $this->data ); // Set the data first, some of the Setter below will perform comparison logic.
            $this->Feed->setMediaType( $media_type );
            $this->Feed->setMediaServer();
            $this->Feed->setRssFilename( $rss_filename );
            $this->Feed->setItunesComplete( $itunes_complete );
            $this->Feed->setInterlace( $interlace );
            $this->Feed->setTitleSuffix(); // Uses information from the this->data array passed earlier.
            $this->Feed->setPodcastImage(); // Uses information from the this->data array passed earlier.
            
            $track_number = 0; // used in iTunes to determine tracking ordering and incremented within the followiing foreach loop.
            
            foreach ( $this->data['PublishedPodcastItems'] as $podcast_item ) {

                $track_number++;

                $this->Feed->setMediaType( $media_type ); // We must reset the media type in every loop incase the RSS is interlaced and has been changed to TRANSCRIPT
                $this->Feed->setPodcastItem( $podcast_item );

                // We only want to include this item in the RSS feed if there are a flavour of media to match the users request.
                if( $this->Feed->setPodcastMedia() ) {

                    $this->Feed->setPodcastItemMediaFolder(); // Set the name of the media specific folder under FEED/custom_id/
                    $this->Feed->setPodcastItemImageDetails(); // Set the value of the images ( original standard and thumbnail ) and grab the image extension.

                    $this->Feed->buildPodcastItem( $track_number ); // Build the item element that is appended onto an array and retrieved later using the getPodcastItems() method

                    // Do we want to interlace the associated transcript as next entry if exists?
                    if( $this->Feed->setTranscript() ) {

                        $this->Feed->setMediaType( strtolower( TRANSCRIPT ) );
                        $this->Feed->buildPodcastItemTranscript( $track_number );
                    }
                }
            }

            $this->set( 'documentData', $this->Feed->getDocumentData() );
            $this->set( 'channelData', $this->Feed->getChannelData() );
            $podcast_items = $this->Feed->getPodcastItems();
            $this->set( compact( 'podcast_items' ) );
        }
    }



    /*
     * @name : view
     * @description : Display a form that enables peeps to view the RSS feed generated by passing various parameters.
     * @updated : 16th June 2011
     * @by : Charles Jackson
     */
    function admin_preview() {

        if( empty( $this->data ) ) {

            $this->Podcast = ClassRegistry::init('Podcast');
            $this->Podcast->recursive = -1;
            $this->data['Podcasts'] = $this->Podcast->find('all', array('order' => 'Podcast.title ASC' ) );
            $this->data['MediaTypes'] = $this->Feed->itunes_title_suffix;

        } else {

            $this->data = file_get_contents('http://'.$_SERVER['SERVER_NAME'].'/feeds/add/'.$this->data['Podcast']['id'].'/desktop-all.rss');

            // Create a filename prefixed with the current users ID so as not to overwrite another preview file.
            $this->Feed->writeRssFile('rss/'.$this->Session->read('Auth.id').'_debug.rss', $this->data );
            
            $this->redirect('rss/'.$this->Session->read('Auth.id').'_debug.rss');
        }
    }
}