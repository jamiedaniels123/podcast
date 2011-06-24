<?php

class Feed extends AppModel {

    var $name = 'Feed';
    var $useTable = false;
    var $validate = array();

    // The following array defines the flavours of RSS we will attempt to create if available.
    var $rss_flavours = array(

        '3gp' => array('media_type' => '3gp', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => true ),
        'audio' => array('media_type' => 'audio', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => true ),
        'desktop' => array('media_type' => 'desktop', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => true ),
        'hd' => array('media_type' => 'hd', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => true ),
        'iphone' => array('media_type' => 'iphone', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => true ),
        'ipod' => array('media_type' => 'ipod', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => true ),
        'large' => array('media_type' => 'large', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => true ),
        'transcript' => array('media_type' => 'transcript', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => true ),
        'youtube' => array('media_type' => 'youtube', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => false ),
        'extra' => array('media_type' => 'extra', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => true ),
        'default' => array('media_type' => '', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => false ),
        'high' => array('media_type' => 'high', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => false ),
        'ipod-all' => array('media_type' => 'ipod-all', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => true ),
        'desktop-all' => array('media_type' => 'desktop-all', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => true ),
        'epub' => array('media_type' => 'epub', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => true )
    );

    var $itunes_title_suffix = array(
        '3gp' => 'Mobile Video',
        'audio-mp3' => 'Audio',
        'audio' => 'Audio',
        'audio-m4a' => 'Audio',
        'audio-m4b' => 'Audio Book',
        'desktop' => 'iPad/Mac/PC Video',
        'hd' => 'HD Video',
        'iphone' => 'iPhone Video',
        'iphonecellular' => 'iPhone (Edge) Video',
        'ipod' => 'iPod/iPhone Video',
        'large' => 'HQ Video',
        'transcript' => 'Transcript',
        'youtube' => 'YouTube Video',
        'extra' => 'Extras',
        'high' => 'HQ Video',
        'ipod-all' => 'iPod/iPhone',
        'desktop-all' => 'iPod/Mac/PC',
        'epub' => ''
    );
    var $media_folder = array(
        '3gp' => '3gp/', // iTunes U - 3gp video only
        'audio-mp3' => 'audio/', // iTunes U - audio only (contains both MP3 and AAC - both m4a and m4b - latter audiobooks)
        'audio-m4a' => 'audio/', // iTunes U - audio only (contains both MP3 and AAC - both m4a and m4b - latter audiobooks)
        'audio-m4b' => 'audio/', // iTunes U - audio only (contains both MP3 and AAC - both m4a and m4b - latter audiobooks)
        'desktop' => 'desktop/', // iTunes U - desktop quality (640 wide) video only
        'desktop-all' => 'desktop-all/',
        'hd' => 'hd/', // iTunes U - real HD video only
        'iphone' => 'iphone/', // iTunes U - iPhone (wifi) video only (H264 baseline encoded)
        'iphonecellular' => 'iphone/', // iTunes U - iPhone 3gp (Edge) video only (H264 encoding)
        'ipod' => 'ipod/', // iTunes U - iPod video only (H264 baseline encoded)
        'large' => 'large/', // iTunes U - video only (native video dimensions)
        'transcript' => 'transcript/', // transcripts of corresponding track entry (for audio and video tracks only)
        'youtube' => 'youtube/', // YouTube - encoded for uploading to YouTube, has different trailer
        'extra' => 'extra/'
    );

    var $mime_types = array(
        'mp3' => 'audio/mpeg',
        'm4a' => 'audio/x-m4a',
        'm4b' => 'audio/x-m4b',
        '3gp' => 'video/x-m4v',
        'mp4' => 'video/mp4',
        'm4v' => 'video/x-m4v',
        'mov' => 'video/quicktime',
        'pdf' => 'application/pdf',
        'epub' => 'application/epub+zip'
    );

    var $data; // Passed as a parameter into the controller and set accordingly
    var $media_type; // Passed as a parameter into the controller and set accordingly
    var $rss_filename; // Passed as a parameter into the controller and set accordingly
    var $itunes_complete; // Passed as a parameter into the controller and set accordingly
    var $interlace; // Passed as a parameter into the controller and set accordingly

    var $media_server; // Defined with the setMediaServer method.
    var $podcast_path_and_image; // Defined within the SetPodcastImage method
    var $podcast_item = array(); // used in the build data method and set by the controller
    var $podcast_items = array(); // The collection passed back to the controller for use in the view.
    
    var $title_suffix; // Set within the setTitleSuffix method and called from the controller.

    var $podcast_title = null;
    var $podcast_image = null;
    var $podcast_standard_image = null;
    var $podcast_thumbnail_image = null;
    var $podcast_image_extension = null;
    var $xml_file_name = null;

    // Item level class variables
    var $podcast_item_media_folder = null; // The name of the media specific folder that exists under FEEDS/custom_id/

    var $podcast_item_image = null; // set within the method setPodcastItemImage
    var $podcast_item_standard_image = null; // set within the method setPodcastItemImage
    var $podcast_item_thumbnail_image = null; // set within the method setPodcastItemImage
    var $podcast_item_image_extension = null; // set within the method setPodcastItemImage

    var $atom_string = null;

    // The current flavour of media for the podcast item
    var $podcast_media = array();
    var $podcast_transcript= array();


    /*
     * @name : defineDataDefaults
     * @description : Define the value of various parameters referenced in the RSS feed primarily at channel level but
     * also item level.
     * @updated : 3rd June 2011
     * @by : Charles Jackson
     */

    function defineDataDefaults() {

        // Append the suffix to the poodcast title.
        $this->data['Podcast']['title'] .= " " . $this->title_suffix;

        if (!empty($this->data['Podcast']['image'])) {

            $this->podcast_image = $this->data['Podcast']['image'];
            $this->podcast_standard_image = parent::getStandardImageName($this->data['Podcast']['image']);
            $this->podcast_thumbnail_image = parent::getThumbnailImageName($this->data['Podcast']['image']);
            $this->podcast_image_extension = parent::getExtension($this->data['Podcast']['image']);
        }


        // If the feed is for iTunes check we have an author else
        // set the default author text string as defined in the bootstrap.
        if ( ( strtoupper( $this->data['Podcast']['intended_itunesu_flag'] ) == YES ) && ( empty($this->data['Podcast']['author'] ) ) )
            $this->data['Podcast']['author'] = DEFAULT_AUTHOR;

        // Interlacing determines if media transcripts are included at the end of a podcast
        // listing or they are listed directly after their media equivalent. We NEVER
        // interlace a podcast listed as private and this method will override any passed parameter.
        if ( $this->data['Podcast']['itunesu_site'] == strtoupper('PRIVATE') && ( strtoupper( $this->data['Podcast']['intended_itunesu_flag']) == 'Y' ) )
            $this->setInterlace(false);
    }

    /*
     * @name : getDocumentData
     * @description : Set/Get the document data for an RSS feed.
     * @updated : 7th June 2011
     * @by : Charles Jackson
     */

    function getDocumentData() {

        return array(
            'xmlns:itunes' => 'http://www.itunes.com/dtds/podcast-1.0.dtd',
            'xmlns:itunesu' => 'http://www.itunesu.com/feed',
            'xmlns:media' => 'http://search.yahoo.com/mrss/',
            'xmlns:atom' => 'http://www.w3.org/2005/Atom',
            'xmlns:oupod' => 'http://purl.org/net/oupod/',
            'xmlns:s' => 'http://purl.org/steeple'
        );
    }

    /*
     * @name : getChannelData
     * @description : Set/Get the channel data for an RSS feed using the details captured within
     * the captureParameters method.
     * @updated : 7th June 2011
     * @by : Charles Jackson
     */

    function getChannelData() {

        $channelData = array(
            'title' => $this->data['Podcast']['title'].$this->title_suffix,
            'link' => $this->data['Podcast']['link'],
            'description' => $this->data['Podcast']['summary'],
            'copyright' => $this->data['Podcast']['copyright'],
            'language' => 'en-uk',
            'lastBuildDate' => str_replace('  ', ' ', date('r')),
            'generator' => 'OU Podcast System by KMi',
            'docs' => 'http://blogs.law.harvard.edu/tech/rss' );

        $channelData['atom:link']['attrib']['href'] = $this->media_server . FEEDS_FOLDER . $this->data['Podcast']['custom_id'] . '/' . $this->rss_filename;
        $channelData['atom:link']['attrib']['type'] = 'application/rss+xml';
        $channelData['atom:link']['attrib']['rel'] = 'self';


        if ( !empty( $this->podcast_path_and_image ) ) {

            $channelData['image']['url'] = $this->podcast_path_and_image;
            $channelData['image']['title'] = $this->data['Podcast']['title'].$this->title_suffix;
            $channelData['image']['link'] = $this->data['Podcast']['link'];
        }

        // BEGIN - Yahoo specific elements
        $channelData['media:title'] = $this->data['Podcast']['title'].$this->title_suffix;
        $channelData['media:description'] = $this->data['Podcast']['summary'];
        $channelData['media:keywords'] = $this->data['Podcast']['keywords'];

        if ( !empty( $this->podcast_path_and_image ) )
            $channelData['media:thumbnail']['attrib']['url'] = $this->podcast_path_and_image;
        // END - Yahoo specific elements

        // BEGIN - iTunes specific elements
        $channelData['itunes:subtitle'] = $this->data['Podcast']['subtitle'];
        $channelData['itunes:summary'] = $this->data['Podcast']['summary'];
        $channelData['itunes:keywords'] = $this->data['Podcast']['keywords'];
        $channelData['itunes:author'] = strlen( trim( $this->data['Podcast']['author'] ) ) ? $this->data['Podcast']['author'] : DEFAULT_AUTHOR;
        $channelData['itunes:explicit'] = ucfirst( $this->data['Podcast']['explicit'] );

        if ( !empty( $this->podcast_path_and_image ) )
            $channelData['itunes:image']['attrib']['href'] = $this->podcast_path_and_image;


        $channelData['itunes:owner']['itunes:name'] = $this->data['Podcast']['contact_name'];
        $channelData['itunes:owner']['itunes:email'] = $this->data['Podcast']['contact_email'];

        if ( $this->itunes_complete )
            $channelData['itunes:complete'] = 'true';


        foreach ( $this->data['Categories'] as $category ) {

            if ( (int)$category['parent_id'] ) {

                $channelData['itunes:category']['attrib']['text'] = $category['ParentCategory']['category'];

            } else {

                $channelData['itunes:category']['attrib']['text'] = $category['category'];
            }
        }
        // END - iTunes specific elements

        if ( !empty($this->data['Nodes']['subject_code']) && !empty( $this->data['Nodes']['title'] ) ) {

            $channelData['atom:category']['attrib']['scheme'] = 'http://purl.org/ou/blue#';
            $channelData['atom:category']['attrib']['term'] = $this->data['Nodes']['subject_code'];
            $channelData['atom:category']['attrib']['label'] = $this->data['Nodes']['subject_title'];
        }

        if ( !empty( $this->data['Podcast']['course_code'] ) ) {
            
            $channelData['atom:category']['attrib']['scheme'] = 'http://purl.org/steeple/course';
            $channelData['atom:category']['attrib']['term'] = $this->data['Podcast']['course_code'];
            $channelData['atom:category']['attrib']['label'] = null;
        }

        return $channelData;
    }


    /*
     * @name : buildPodcastItem
     * @description :
     * @updated : 7th June 2011
     * @by : Charles Jackson
     */

    function buildPodcastItem( $track_number = 0 ) {

        $item = array();

        // We only want to include this media if a copy exists on the media box. Break out of the loop and
        // start again if the media does not exist.
        if( parent::mediaFileExist( $this->media_server.FEEDS_FOLDER.$this->data['Podcast']['custom_id'].$this->podcast_item_media_folder.$this->podcast_item_media_folder.$this->podcast_media['filename'] ) == false )
            return false;

        $item['title'] = $this->podcast_item['title'];
        $item['description'] = $this->podcast_item['summary'];

        // Yahoo specific
        $item['media:title'] = $this->podcast_item['title'];
        $item['media:description'] = $this->podcast_item['summary'];
        $item['media:keywords'] = $this->data['Podcast']['keywords'];

        if( strtoupper( $this->podcast_item_image_extension ) == 'PDF' ) {

            $item['media:thumbnail']['attrib']['url'] = $this->media_server.'/images/'.$this->podcast_item_thumbnail_image;

        } elseif( !empty( $this->podcast_item_standard_image ) ) {

            $item['media:thumbnail']['attrib']['url'] = $this->media_server.FEEDS_FOLDER.$this->data['Podcast']['custom_id'].$this->podcast_item_media_folder.$this->podcast_item_standard_image;

        } elseif( !empty( $this->podcast_item_image ) ) {

            $item['media:thumbnail']['attrib']['url'] = $this->media_server.FEEDS_FOLDER.$this->data['Podcast']['custom_id'].$this->podcast_item_media_folder.$this->podcast_item_image;
        }

        // BEGIN - iTunes specific
        $item['itunes:summary'] = $this->podcast_item['summary'];
        $item['itunes:keywords'] = $this->data['Podcast']['keywords'];
        $item['itunes:author'] = strlen( trim( $this->podcast_item['author'] ) ) ? $this->podcast_item['Podcast']['author'] : DEFAULT_AUTHOR;
        $item['itunes:explicit'] = ucfirst( $this->podcast_item['explicit'] );
        $item['itunes:subtitle'] = $this->podcast_item['summary'];

        if( $this->itunes_complete )
            $item['itunes:order'] = $track_number;

        $item = $this->__setItunesItemCode( $item );
        
        // End Itunes specific


        if (!empty( $this->podcast_item['item_link'] ) )
            $item['link'] = $this->podcast_item['item_link'];

        $item['guid'] = $this->media_server.FEEDS_FOLDER.$this->data['Podcast']['custom_id'].$this->podcast_item_media_folder.$this->podcast_media['filename'];
        $item['pubDate'] = $this->podcast_item['publication_date'];
        $item['enclosure']['url'] = $this->media_server.FEEDS_FOLDER.$this->data['Podcast']['custom_id'].$this->podcast_item_media_folder.$this->podcast_media['filename'];

        // OK, we are not processing an eBook or PDF transcript, add duration
        if( in_array( strtolower( $this->podcast_item_image_extension ), array('epub','pdf') ) == false )
            $item['itunes:duration'] = $this->podcast_media['duration'];

        // If we are processing a transcript add appropriate atom element.
        $item = $this->setAtom( $item );

        if ( ( strtoupper( $this->media_type ) == 'YOUTUBE' ) && ( strtoupper( $this->podcast_item['youtube_legacy_track'] ) == 'Y' ) )
            $item['oupod:legacy'] = 'true';

        $this->podcast_items[] = $item;

    }

    /*
     * @name : buildPodcastItemTranscript
     * @description : If we are not already processing a transcript and a transcript exists for this podcast_item
     * capture the details here.
     * @updated : 9th June 2011
     * @by : Charles Jackson
     */
    function buildPodcastItemTranscript( $track_number = null ) {

        $item = array();

        $item['title'] = TRANSCRIPT_PREFIX.$this->podcast_item['title'];
        $item['description'] = TRANSCRIPT_PREFIX.$this->podcast_item['summary'];

        // Yahoo specific
        $item['media:title'] = TRANSCRIPT_PREFIX.$this->podcast_item['title'];
        $item['media:description'] = TRANSCRIPT_PREFIX.$this->podcast_item['summary'];
        $item['media:keywords'] = $this->data['Podcast']['keywords'];
        //$item['media:thumbnail'] = $this->media_server.FEEDS_FOLDER.'images/pdf-icon.png';

        // Itunes specific
        $item['itunes:summary'] = $this->podcast_item['summary'];
        $item['itunes:keywords'] = $this->data['Podcast']['keywords'];
        $item['itunes:author'] = strlen( trim( $this->podcast_item['author'] ) ) ? $this->podcast_item['Podcast']['author'] : DEFAULT_AUTHOR;
        $item['itunes:explicit'] = ucfirst( $this->podcast_item['explicit'] );
        $item['itunes:subtitle'] = TRANSCRIPT_PREFIX.$this->podcast_item['summary'];
        $item['itunes:keywords'] = $this->data['Podcast']['keywords'];
        
        if( $this->itunes_complete )
            $item['itunes:order'] = $track_number;

        $item = $this->__setItunesItemCode( $item );

        if (!empty( $this->podcast_item['item_link'] ) )
            $item['link'] = $this->podcast_item['item_link'];

        $item['guid'] = $this->media_server.FEEDS_FOLDER.$this->data['Podcast']['custom_id'].'/'.strtolower( TRANSCRIPT ).'/'.$this->podcast_transcript['filename'];
        // Remove 1 second from datestamp so as not to conflict with actual media.
        $item['pubDate'] = ($this->podcast_item['publication_date'] - 1 );
        $item['enclosure']['url'] = $this->media_server.FEEDS_FOLDER.$this->data['Podcast']['custom_id'].'/'.strtolower( TRANSCRIPT ).'/'.$this->podcast_transcript['filename'];

        $this->podcast_items[] = $item;
    }

    // BELOW THIS LINE ARE THE SETTERS / GETTERS
    // NOTE: Most of the Getters and some of the Setter have logic, not totally straightforward.

    /*
     * @name : setData
     * @description : Basic setter
     * @updated : 13th June 2011
     * @by : Charles Jackson
     */
    function setData( $data = array() ) {

        $this->data = $data;
    }

    /*
     * @name : setMediaType
     * @description : Basic Setter
     * @updated : 13th June 2011
     * @by : Charles Jackson
     */
    function setMediaType( $media_type = null ) {

        $this->media_type = $media_type;
    }

    /*
     * @name : setMediaServer
     * @description : Setter that depends upon 3rd party attribute media_type
     * @updated : 13th June 2011
     * @by : Charles Jackson
     */
    function setMediaServer( $media_server = null ) {

        if ( empty( $media_server ) ) {

            if ( empty( $this->media_type ) ) {

                $this->media_server = DEFAULT_MEDIA_URL;

            } else {

                $this->media_server = DEFAULT_ITUNES_MEDIA_URL;
            }

        } else {

            $this->media_server = $media_server;
        }
    }

    /*
     * @name : setRssFilename
     * @description : Basic setter that will use a default value as defined in the bootstrap if none exists
     * @updated : 13th June 2011
     * @by : Charles Jackson
     */
    function setRssFilename( $rss_filename = null ) {

        if ( empty( $rss_filename ) ) {

            $this->rss_filename = DEFAULT_RSS_FILENAME;

        } else {

            $this->rss_filename = $rss_filename;
        }
    }

    /*
     * @name : setItunesComplete
     * @description : Basic setter
     * @updated : 13th June 2011
     * @by : Charles Jackson
     */
    function setItunesComplete( $itunes_complete = null ) {

        $this->itunes_complete = $itunes_complete;
    }

    /*
     * @name : setInterlace
     * @description : Basic setter
     * @updated : 13th June 2011
     * @by : Charles Jackson
     */
    function setInterlace( $interlace = null ) {

        // Interlacing determines if media transcripts are included at the end of a podcast
        // listing or they are listed directly after their media equivalent. We NEVER
        // interlace a podcast listed as private and this setter can override any passed parameter.
        if (
                $this->data['Podcast']['itunesu_site'] == strtoupper('PRIVATE') &&
                ( strtoupper( $this->data['Podcast']['intended_itunesu_flag']) == 'Y' )
        ) {

            $this->setInterlace(false);
            
        } else {

            $this->interlace = $interlace;
        }
    }

    /*
     * @name : setTitleSuffix
     * @description : Standard setter that uses a combination of media_type and the class array itunes_title_suffix else
     * the logic that can be overridden by passing a parameter.
     * @updated : 15th June 2011
     * @by : Charles Jackson
     */
    function setTitleSuffix( $title_suffix = null ) {

        if( empty( $title_suffix ) ) {

            if( empty( $this->media_type ) ) {

                $this->title_suffix = null;

            } else {

                $this->title_suffix = isSet( $this->itunes_title_suffix[$this->media_type] ) ? ' - '.$this->itunes_title_suffix[$this->media_type] : null;
            }

        } else {

            $this->title_suffix = ' - '.$title_suffix;
        }

    }
    /*
     * @name : setPodcastImage
     * @description : Sets the value of the podcast image including full path
     * @updated : 15th June 2011
     * @by : Charles Jackson
     */
    function setPodcastImage() {

        if( empty( $this->data['Podcast']['image'] ) ) {
            
            $this->podcast_path_and_image = null;

        } else {
            
            $this->podcast_path_and_image = $this->media_server.FEEDS_FOLDER.$this->data['Podcast']['custom_id'].'/'.$this->data['Podcast']['image'];
        }
    }

    /*
     * @name : setPodcastItem
     * @description : Basic setter
     * @updated : 13th June 2011
     * @by : Charles Jackson
     */
    function setPodcastItem( $podcast_item = array() ) {

        $this->podcast_item = $podcast_item;
    }


    /*
     * @name : setAtom
     * @description :
     * @updated : 15th June 2011
     * @by : Charles Jackson
     */
    function setAtom( $item = array() ) {

        if( strtoupper( $this->media_type ) == TRANSCRIPT ) {

            // Make a header request to check if the file exists
            if( get_headers( $this->media_server.FEEDS_FOLDER.$this->data['Podcast']['custom_id'].'/'.TRANSCRIPT.'/'.$this->data['Transcript']['filename'] ) ) {

                $item['atom:link']['type'] = 'application/pdf';
                $item['atom:link']['title'] = 'Title for '.$this->podcast_item['title'];
                $item['atom:link']['type'] = 'application/pdf';
           }
        }

        return $item;
    }

    /*
     * @name : setPodcastMedia
     * @description : Read through all flavours of media associated with this podcast_item
     * and find the flavour associated with the media_type parameter passed in the URL.
     * @updated : 7th June 2011
     * @by : Charles Jackson
     */

    function setPodcastMedia() {

        foreach ( $this->podcast_item['PodcastMedia'] as $podcast_media ) {

            $this->podcast_media = array();

            if ( $podcast_media['media_type'] == $this->media_type ) {
                $this->podcast_media = $podcast_media;
                return true;
            }
        }

        return false;
    }

    /*
     * @name : setPodcastItemMediaFolder
     * @description : Will set the folder under the "/feed/custom_id/***" where "***" is the folder.
     * @updated : 15th June 2011
     * @by : Charles Jackson
     */
    function setPodcastItemMediaFolder() {

        $this->podcast_item_media_folder = isSet($this->media_folder[$this->media_type]) ? '/'.$this->media_folder[$this->media_type].'/' : '/';
    }

    /*
     * @name : setPodcastItemImageDetails
     * @description :
     * @updated : 15th June 2011
     * @by : Charles Jackson
     */
    function setPodcastItemImageDetails() {

        $this->podcast_item_image = $this->podcast_item['image_filename'];
        $this->podcast_item_standard_image = parent::getStandardImageName( $this->podcast_item['image_filename'] );

        if( strtoupper( $this->podcast_item_image_extension ) == 'PDF' ) {

            $this->podcast_item_thumbnail_image = 'pdf-icon.jpg';

        } else {
            
            $this->podcast_item_thumbnail_image = parent::getThumbnailImageName( $this->podcast_item['image_filename'] );
        }
        $this->podcast_item_image_extension = parent::getExtension( $this->podcast_item['image_filename'] );
    }

    /*
     * @name : setTranscript
     * @description : Checks to see if the value is $this->interlave is true and a transcript is available. If true,
     * will assign the transcript to a class variable. Returns a bool.
     * @updated : 10th June 2011
     * @by : Charles Jackson
     */
    function setTranscript() {

        if(
            ( $this->interlace ) &&
            ( isSet( $this->podcast_item['Transcript'] ) && is_array( $this->podcast_item['Transcript'] ) && count( $this->podcast_item['Transcript'] ) ) ) {

            $this->podcast_transcript = $this->podcast_item['Transcript'];
            return true;
        }

        $this->podcast_transcript = array(); // No transcript, null the array.

        return false;
    }

    /*
     * @name : __setItunesItemCode
     * @description :
     * @updated : 15th June 20111
     * @by : Charles Jackson
     */
    function __setItunesItemCode( $item = array() ) {

        if ( ( is_array( $this->data['iTuneCategories'] ) && count( $this->data['iTuneCategories'] ) ) &&
                ( in_array($this->media_type, array( 'ipod', 'ipod-all', 'audio', 'epub', '' ) ) ) ) {

            $item['itunes:category']['attrib']['itunes:code'] = $this->data['iTuneCategories'][0]['code'] = null;

        } else {

            $item['itunes:category']['attrib']['itunes:code'] = null;
        }

        return $item;
    }

    /*
     * @name : getPodcastItems
     * @description : Return the array of podcast items.
     * @updated : 7th June 20111
     * @by : Charles Jackson
     */
    function getPodcastItems() {

        return $this->podcast_items;
    }


    /*
     * @name : writeRssFile
     * @description : Writes a flat file
     * @updated : 16th June 20111
     * @by : Charles Jackson
     */
    function writeRssFile( $file_path_and_name, $data = array() ) {

        $file = $file_path_and_name;
        $fh = fopen($file, 'w') or die("Can't open RSS file for writing, see administrator ".$file_path_and_name );
        fwrite($fh, $data);
        fclose($fh);
    }

    function buildParameters( $id, $flavour ) {
        
        return ($id.'/'.$flavour['media_type'].'/'.$flavour['rss_filename'].'/'.$flavour['itunes_complete'].'.rss');
    }

	/*
	 * @name : buildRssPath
	 * @description : Will build a path relative to the file repository where everything will get written in preparation 
	 * for transfer to the media server.
	 * @updated : 24th June 2011
	 * @by : Charles Jackson
	 */
    function buildRssPath( $podcast = array(), $flavour = array() ) {

        // The media_type can be empty but if not append a slash '/' for the purposes of creating the path line.
        if( !empty( $flavour['media_type'] ) )
			$flavour['media_type'] = $flavour['media_type'].'/';

		return $podcast['Podcast']['custom_id'].'/'.$flavour['media_type'];
    }

	/*
	 * @name : buildApiEntry
	 * @description : Will format an array that will eventually be passed to the Api.
	 * @updated : 24th June 2011
	 * @by : Charles Jackson
	 */
    function buildApiEntry( $custom_id, $media_type = null, $file_name = null ) {

        // The media_type can be empty but if not append a slash '/' for the purposes of creating the path line.
        if( !empty( $media_type ) )
            $media_type .= '/';

		return
			array(
				'source_path' => $custom_id.'/'.$media_type,
				'destination_path' => $custom_id.'/'.$media_type,
				'filename' => $file_name
			);
    }

    /*
     * @name : beingCalledAsMethod
     * @description : It is possible for the 'add' method with the feeds controller to be called in two distinct ways.
     * Number 1 : Via a direct link. When the user clicks on a "generate rss button" and the user page is directed to the method RSS feeds
     * generated and associated flash messages created before they are redircted back to the original calling page.
     * Number 2 : As a function using the command $this->requestAction whereas the user has updated the podcast and the method is called
     * 'behind the scenes' from a.n.other controller method. In these case we do not want to generate any flash messages or redirect the
     * user we merely want to return 'true' or 'false'.
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function beingCalledAsMethod( $parameters = array() ) {

        if( isSet( $parameters['id'] ) && (int)$parameters['id'] )
            return true;

        return false;

    }
}