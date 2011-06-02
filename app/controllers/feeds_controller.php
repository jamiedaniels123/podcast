<?php

class FeedsController extends AppController {

    var $name = 'Feeds';

    /*
     * @name : itunes
     * @description : Generate a very simple RSS feed that is echoed out to screen and catpured by the calling routine
     * and written to a flat file.
     * @updated : 26th May 2011
     * @by : Charles Jackson
     */
    function itunes( $id = null, $media_type = null, $reverse_order = null, $rss_filename, $itunes_complete = false, $interlace = true ) {

        $podcasts = null;

       if( (int)$id == false || empty($media_type ) ) {

            $this->Session->setFlash('We could not build the RSS you were looking for.', 'default', array( 'class' => 'error' ) );
            $this->redirect( array( 'controller' => 'users', 'action' => 'dashboard' ) );

        } elseif( $this->RequestHandler->isRss() ) {

            $this->Podcast = ClassRegistry::init('Podcast');
            $this->Podcast->recursive = 2;
            $podcast = $this->Podcast->findById( $id );

            $podcast = $this->Feed->sanitizeForRSS( $podcast );
            
            $this->set('media_type', $media_type );
            return $this->set( compact('podcast') );
       }
    }
}