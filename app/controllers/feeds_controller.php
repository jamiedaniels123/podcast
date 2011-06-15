<?php

class FeedsController extends AppController {

    var $name = 'Feeds';
    var $helpers = array('BespokeRss');
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

            if( $this->RequestHandler->isRss() == false ) {

                $this->Session->setFlash('We could not build the RSS you were looking for.', 'default', array( 'class' => 'error' ) );
                $this->redirect( $this->referer() );
                exit();

            } else {

                return false;
            }


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
                $this->Feed->setPodcastItem( $podcast_item );

                // We only want to include this item in the RSS feed if there are a flavour of media to match the users request.
                if( $this->Feed->setPodcastMedia() ) {

                    $this->Feed->setPodcastItemMediaFolder(); // Set the name of the media specific folder under FEED/custom_id/
                    $this->Feed->setPodcastItemImageDetails(); // Set the value of the images ( original standard and thumbnail ) and grab the image extension.

                    $this->Feed->buildPodcastItem( $track_number ); // Build the item element that is appended onto an array and retrieved later using the getPodcastItems() method

                    // Do we want to interlace the associated transcript as next entry if exists?
                    if( $this->Feed->interlaceTranscript() ) {
                        
                        $this->Feed->setMediaType( strtolower( TRANSCRIPT ) );
                        $this->Feed->setPodcastItem( $this->Podcast->findById( $this->Feed->podcast_item['Transcript']['id'] ) );
                        
                        $this->Feed->buildPodcastItemTranscript( $track_number );
                    }
                }
            }

            $this->set( 'documentData', $this->Feed->getDocumentData() );
            $this->set( 'channelData', $this->Feed->getChannelData() );
            $podcast_items = $this->Feed->getPodcastItems();
            $this->set( compact( 'podcast_items' ) );


            if( $this->RequestHandler->isRss() == false ) {

                echo "<pre>";
                    //print_r( $this->Feed->getChannelData() );
                    //print_r( $this->Feed->getPodcastItems() );
                    print_r( $this->data );
                echo "</pre>";
                die('END');
            }
        }
    }
}