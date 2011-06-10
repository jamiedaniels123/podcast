<?php

class FeedsController extends AppController {

    var $name = 'Feeds';

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

            $this->Session->setFlash('We could not build the RSS you were looking for.', 'default', array( 'class' => 'error' ) );
            $this->redirect( array( 'controller' => 'users', 'action' => 'dashboard' ) );
            exit();

        } else {
                
            $this->Feed->captureParameters( $this->data, $id, $media_type, $rss_filename, $itunes_complete, $interlace );
            $this->Feed->defineDataDefaults();

            foreach ($this->data['PublishedPodcastItems'] as $podcast_item) {
                
                $this->Feed->buildItemData( $podcast_item );

                // Do we want to interlace the associated transcript as next entry if exists?
                if( $this->Feed->interlaceTranscript() ) {
                    
                    $this->Feed->media_type = strtolower( TRANSCRIPT );
                    $this->Feed->buildTranscriptData( $this->data['Transcript']['id'] );
                }
            }

            $this->set( 'documentData', $this->Feed->getDocumentData() );
            $this->set( 'channelData', $this->Feed->getChannelData() );
            $podcast_items = $this->Feed->getPodcastItems();
            $this->set( compact( 'podcast_items' ) );


            if( $this->RequestHandler->isRss() == false ) {

                echo "<pre>";
                    print_r( $this->Feed->getPodcastItems() );
                    //print_r( $this->data );
                echo "</pre>";
                die('podcast items!');
            }
        }
    }
}