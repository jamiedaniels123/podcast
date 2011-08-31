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
        
        $this->Auth->allow( 'view' );
        parent::beforeFilter();
    }

    /*
     * @name : add
     * @description : Creates the various flavours of RSS feed. It then captures the output and writes
     * content to a flat file ready to be moved across to the media server.
     * @updated : 16th June 2011
     * @by : Charles Jackson
     */
    function add( $id = null ) {

        $this->autoRender = false;

        $this->Podcast = ClassRegistry::init('Podcast');
        $this->Podcast->recursive = -1;
		
        // If we are calling this method using "requestAction" as opposed to a redirect then we must take the
        // ID from $this->params array. See model function for indepth explanation.
        if( $this->Feed->beingCalledAsMethod( $this->params ) )
            $id = $this->params['id'];

        // This method is used for individual rss generation and via the form posted checkbox selection. Hence
        // when somebody is generating an individual rss feed we pass into an array and loop through as is the data
        // was posted.
        if( $id )
            $this->data['Podcast']['Checkbox'][$id] = true;


        foreach( $this->data['Podcast']['Checkbox'] as $key => $value ) {

			// First lets try and retrieve the podcast we wish to create RSS feeds for.
			$podcast = $this->Podcast->findById( $key );
			$rss_array = array();
			$player_rss_array = array();			

			// If we found a podcast, create the RSS feeds.
			if( !empty( $podcast ) ) {
				
				foreach( $this->Feed->rss_flavours as $flavour ) {
					
					//if( $flavour['media_type'] == 'default' ) {
					// We do everything twice, first time through we create the genuine RSS feeds that only contains
					// published podcast items. Second time through we create a top-secret RSS feed that can only be read by the
					// media player and contains all available podcast items regardless of whether they are published.

					// FIRST TIME THROUGH
					$this->data = file_get_contents( RSS_VIEW . $this->Feed->buildParameters( $key, $flavour ) );
					$this->Folder->create( $this->Feed->buildRssPath( $podcast, $flavour ) );
					$this->Feed->writeRssFile( FILE_REPOSITORY . $this->Feed->buildRssPath( $podcast, $flavour ) . $flavour['rss_filename'], $this->data );
					$rss_array[] = $this->Feed->buildApiEntry( $podcast['Podcast']['custom_id'], $flavour['media_type'] , $flavour['rss_filename'] );

					// SECOND TIME THROUGH : Top-secret RSS feed for media player, shhh don't tell anyone! :-)
					//die( RSS_VIEW . $this->Feed->buildParameters( $key, $flavour, true ) );
					$this->data = file_get_contents( RSS_VIEW . $this->Feed->buildParameters( $key, $flavour, true ) );

					$this->Folder->create( $this->Feed->buildRssPath( $podcast, $flavour ) );
					$this->Feed->writeRssFile( FILE_REPOSITORY . $this->Feed->buildRssPath( $podcast, $flavour ) . 'player.xml', $this->data );
					$player_rss_array[] = $this->Feed->buildApiEntry( $podcast['Podcast']['custom_id'], $flavour['media_type'] , 'player.xml' );
					//}
				}

				if( $this->Api->transferFileMediaServer( $rss_array ) == false ) {

					if( $this->Feed->beingCalledAsMethod( $this->params ) )
						return false;

						$this->Session->setFlash('We were unable to generate one or more RSS feeds. If the problem persists please contact an administrator', 'default', array( 'class' => 'error' ) );
						break;
						
				} elseif( $this->Api->transferFileMediaServer( $player_rss_array ) == false ) {
					
					if( $this->Feed->beingCalledAsMethod( $this->params ) )
						return false;

						$this->Session->setFlash('We were unable to generate one or more media player RSS feeds. If the problem persists please contact an administrator', 'default', array( 'class' => 'error' ) );
						break;
				}
			}
		}
		
        if( $this->Feed->beingCalledAsMethod( $this->params ) )
            return true;
		
			$this->Session->setFlash('Your RSS feeds have been successfully generated and scheduled for transfer to the media server.', 'default', array( 'class' => 'success' ) );

        $this->redirect( $this->referer() );
    }
    
    /*
     * @name : view
     * @description : Generate an RSS feed that is echoed out to screen and captured by the calling routine
     * so it can be written to a flat file.
     * @updated : 26th May 2011
     * @by : Charles Jackson
     */
    function view( $id = null, $media_type = null, $rss_filename = null, $itunes_complete = false, $interlace = true, $key = null ) {

        $podcast_items = array();
        
        $Podcast = ClassRegistry::init('Podcast');
        $Podcast->recursive = 2;

		// We need to dynamically bind a model for the media player that contains all tracks not just those that have been published.
		$Podcast->bindModel( array(
			'hasMany' => array ("PlayerItems" => array (
				'className' => 'PodcastItem',
            	'foreignKey' => 'podcast_id',
				'conditions' => array ("PlayerItems.deleted = 0"),
				'order' => array( 'PlayerItems.publication_date' => 'DESC' )))));

		// Make sure the podcast has not been soft-deleted.
        $this->data = $Podcast->find( 'first', array(
		
            'conditions' => array(
				'Podcast.id' => $id,
				'Podcast.deleted' => false
                )
            )
        );

        // We could not find a podcast using the ID passed as a parameter
        if( empty( $this->data ) ) {

            return false;

        } else {

            $this->Feed->setData( $this->data ); // Set the data first, some of the Setters below will perform comparison logic.
            $this->Feed->setMediaType( $media_type );
            $this->Feed->setMediaServer();
            $this->Feed->setRssFilename( $rss_filename );
            $this->Feed->setItunesComplete( $itunes_complete );
            $this->Feed->setInterlace( $interlace );
            $this->Feed->setTitleSuffix(); // Uses information from the this->data array passed earlier.
            $this->Feed->setPodcastImage(); // Uses information from the this->data array passed earlier.
            
            $track_number = 0; // used in iTunes to determine tracking ordering and incremented within the followiing foreach loop.

            foreach ( $this->data[$key] as $podcast_item ) {
				
				// Has the item been soft deleted.
				if( (int)$podcast_item['deleted'] )
					continue;
					
                $track_number++;

                $this->Feed->setMediaType( $media_type ); // We must reset the media type in every loop incase the RSS is interlaced and has been changed to TRANSCRIPT
                $this->Feed->setPodcastItem( $podcast_item );

                // We only want to include this item in the RSS feed if there is a flavour of media to match the users request.
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
            $this->data['Podcasts'] = $this->Podcast->find('all', array('conditions' => array('Podcast.deleted' => 0), 'order' => 'Podcast.title ASC' ) );
            //$this->data['MediaTypes'] = $this->Feed->itunes_title_suffix;
			$this->data['MediaTypes'] = $this->Feed->rss_flavours;

        } else {

            $this->data = file_get_contents( RSS_VIEW . $this->Feed->buildParameters( $this->data['Podcast']['id'], $this->data['Podcast'] ) );

            // Create a filename prefixed with the current users ID so as not to overwrite another users preview file.
            $this->Feed->writeRssFile( WWW_ROOT .'rss/'.$this->Session->read('Auth.User.id').'_debug.xml', $this->data );
            $this->redirect( APPLICATION_URL.'/rss/'.$this->Session->read('Auth.User.id').'_debug.xml' );
        }
    }
}
