<?php

class FeedsController extends AppController {

    var $name = 'Feeds';

    /*
     * @name : view
     * @description : Generate a very simple RSS feed that is echoed out to screen and catpured by the calling routine
     * and written to a flat file.
     * @updated : 26th May 2011
     * @by : Charles Jackson
     */
    function view( $id = null, $media_type = null, $rss_filename = null, $itunes_complete = false, $interlace = true ) {

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

            if( $this->RequestHandler->isRss() ) {
                
                $this->Feed->captureParameters( $this->data, $id, $media_type, $rss_filename, $itunes_complete, $interlace );
                $this->Feed->defineDataDefaults();
                
                $this->set( 'documentData', $this->Feed->getDocumentData() );
                $this->set( 'channelData', $this->Feed->getChannelData() );

                
                $this->set('podcast_items', $this->Feed->buildItemData() );

            }
        }
    }
}