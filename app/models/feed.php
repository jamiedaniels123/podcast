<?php

class Feed extends AppModel {

    var $name = 'Feed';
    var $useTable = false;
    var $validate = array();
    var $itunes_title_suffix = array(
        '3gp' => 'Mobile Video',
        'audio-mp3' => 'Audio',
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
    var $data;
    var $id;
    var $media_type;
    var $rss_filename;
    var $itunes_complete;
    var $interlace;
    var $media_server;
    var $media_path;
    var $title_suffix;
    var $podcast_title = null;
    var $podcast_image = null;
    var $podcast_standard_image = null;
    var $podcast_thumbnail_image = null;
    var $podcast_image_extension = null;
    var $xml_file_name = null;

    // Item level class variables
    var $podcast_items = array(); // The collection passed to the view
    var $podcast_item = array(); // used in the for loop
    var $podcast_item_media_file = null; // The name of the media file we are going to link to.
    var $podcast_item_media_file_path = null; // Full path to remote location including server, custom_id and media folder (not filename)
    var $podcast_item_date_stamp = null;
    var $podcast_item_image = null;
    var $podcast_item_standard_image = null;
    var $podcast_item_thumbnail_image = null;
    var $podcast_item_image_extension = null;

    var $podcast_item_transcript_file = null; // Full path to remote location including server, custom_id and media folder (not filename)
    var $podcast_item_transcript_file_size = null;
    var $podcast_item_transcript_file_path = null;

    var $atom_string = null;

    // The current flavour of media for the podcast item
    var $podcast_media = array();

    /*
     * @name : captureParameters
     * @description : Takes the parameters passed and puts them into the data array
     * for ease of reference in the RSS view and associated helpers.
     * @updated : 2nd June 2011
     * @by : Charles Jackson
     */
    function captureParameters($data, $id, $media_type, $rss_filename, $itunes_complete, $interlace) {

        // Capture the parameters passed so we may use them in view based helpers.
        $this->data = $data;
        $this->id = $id;
        $this->media_type = $media_type;
        $this->rss_filename = $rss_filename;
        $this->itunes_complete = $itunes_complete;
        $this->interlace = $interlace;

        return true;
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
            'title' => $this->data['Podcast']['title'],
            'link' => parent::clean($this->data['Podcast']['link']),
            'description' => parent::clean($this->data['Podcast']['summary']),
            'copyright' => $this->data['Podcast']['copyright'],
            'language' => 'en-uk',
            'lastBuildDate' => str_replace('  ', ' ', date('r')),
            'generator' => 'OU Podcast System by KMi',
            'docs' => 'http://blogs.law.harvard.edu/tech/rss',
            'atom:link href="' . parent::cleanAttribute($this->media_server) . FEEDS_FOLDER . $this->data['Podcast']['custom_id'] . '/' . $this->rss_filename . '" type="application/rss+xml" rel="self"' => null
        );

        if (!empty($this->podcast_image)) {

            $channelData['image']['url'] = $this->media_server . FEEDS_FOLDER . $this->data['Podcast']['custom_id'] . '/' . $this->podcast_image;
            $channelData['image']['title'] = parent::clean($this->data['Podcast']['title']);
            $channelData['image']['link'] = parent::clean($this->data['Podcast']['link']);
        }

        // BEGIN - Yahoo specific elements
        $channelData['media:title'] = parent::clean($this->data['Podcast']['title']);
        $channelData['media:description'] = parent::clean($this->data['Podcast']['summary']);
        $channelData['media:keywords'] = parent::clean($this->data['Podcast']['keywords']);
        if (!empty($this->podcast_image))
            $channelData['media:thumbnail url="' . parent::cleanAttribute($this->media_server) . FEEDS_FOLDER . $this->data['Podcast']['custom_id'] . '/' . $this->podcast_image . '"'] = null;
        // END - Yahoo specific elements
        // BEGIN - iTunes specific elements
        $channelData['itunes:subtitle'] = parent::clean($this->data['Podcast']['summary']);
        $channelData['itunes:summary'] = parent::clean($this->data['Podcast']['summary']);
        $channelData['itunes:keywords'] = parent::clean($this->data['Podcast']['keywords']);
        $channelData['itunes:author'] = parent::clean($this->data['Podcast']['author']);
        $channelData['itunes:explicit'] = parent::clean(ucfirst($this->data['Podcast']['explicit']));

        if (!empty($this->podcast_standard_image))
            $channelData['itunes:image href="' . parent::cleanAttribute($this->media_server) . FEEDS_FOLDER . $this->data['Podcast']['custom_id'] . '/' . $this->podcast_image . '"'] = null;

        $channelData['itunes:owner']['itunes:name'] = parent::clean($this->data['Podcast']['contact_name']);
        $channelData['itunes:owner']['itunes:email'] = parent::clean($this->data['Podcast']['contact_email']);

        if ($this->itunes_complete)
            $channelData['itunes:complete'] = 'true';


        foreach ($this->data['Categories'] as $category) :

            if ((int) $category['parent_id']) :
                //$channelData['itunes:category text="'.$category['ParentCategory']['category'].'"']['itunes:category text="'.$category['category'].'"'] = null;
                $channelData['itunes:category text="' . $category['category'] . '"'] = null;
            else :
                $channelData['itunes:category text="' . $category['category'] . '"'] = null;
            endif;

        endforeach;

        // END - iTunes specific elements

        if (!empty($this->data['Nodes']['subject_code']) && !empty($this->data['Nodes']['title']))
            $channelData['atom:category scheme="' . parent::cleanAttribute('http://purl.org/ou/blue#') . '" term="' . parent::cleanAttribute($this->data['Nodes']['subject_code']) . '" label="' . parent::cleanAttribute($this->data['Nodes']['subject_title']) . '"'] = null;

        if (!empty($this->data['Podcast']['course_code']))
            $channelData['atom:category scheme="' . parent::cleanAttribute('http://purl.org/steeple/course') . '" term="' . parent::cleanAttribute($this->data['Podcast']['course_code']) . '" label=""'] = null;

        return $channelData;
    }

    /*
     * @name : defineDataDefaults
     * @description : Define the value of various parameters referenced in the RSS feed primaril at channel level but
     * also item level.
     * @updated : 3rd June 2011
     * @by : Charles Jackson
     */

    function defineDataDefaults() {

        if (empty($this->media_type)) {

            $this->media_server = DEFAULT_MEDIA_URL;
            $this->media_path = $this->media_path . '/';
            $this->title_suffix = null;
            
        } else {

            $this->media_server = DEFAULT_ITUNES_MEDIA_URL;
            $this->media_path = null;
            $this->title_suffix = isSet($this->itunes_title_suffix[$this->media_type]) ? $this->itunes_title_suffix[$this->media_type] : null;
        }

        /// if no value is passed take the value defined in the bootstrap.
        if (empty($this->rss_filename))
            $this->rss_filename = DEFAULT_RSS2_FILENAME;

        // Append the suffix to the poodcast title.
        $this->data['Podcast']['title'] .= " " . $this->title_suffix;

        if (!empty($this->data['Podcast']['image'])) {

            $this->podcast_image = $this->data['Podcast']['image'];
            $this->podcast_standard_image = parent::getStandardImageName($this->data['Podcast']['image']);
            $this->podcast_thumbnail_image = parent::getThumbnailImageName($this->data['Podcast']['image']);
            $this->podcast_image_extension = parent::getImageExtension($this->data['Podcast']['image']);
        }


        // If the feed is for iTunes check we have an author else
        // set the default author text string as defined in the bootstrap.
        if (( strtoupper($this->data['Podcast']['intended_itunesu_flag']) == YES ) && ( empty($this->data['Podcast']['author']) )) {
            $this->data['Podcast']['author'] = DEFAULT_AUTHOR;
        }

        // Interlacing determines if media transcripts are included at the end of a podcast
        // listing or they are listed directly after there media equivalent. We NEVER
        // interlace a podcast listed as private
        if ($this->data['Podcast']['itunesu_site'] == strtoupper('PRIVATE') && ( strtoupper($this->data['Podcast']['intended_itunesu_flag']) == 'Y' ))
            $this->interlace = false;
    }

    /*
     * @name : buildItemData
     * @description : Iterates through every row in the PublishedPodcastItems array as defined in the podcast.php model
     * file and if appropriate, will build an array called $this->podcast_item and append to the plural $this->podcast_items
     * ready to be passed into the view.
     * @updated : 7th June 2011
     * @by : Charles Jackson
     */

    function buildItemData() {

        foreach ($this->data['PublishedPodcastItems'] as $podcast_item) {
            
            $this->podcast_item = $podcast_item;
            
            $item = array();

            if (( strtoupper($this->media_type) == YOUTUBE && strtoupper($this->podcast_item['youtube_flag'] == YES) )
                    || ( strtoupper($this->media_type) != YOUTUBE )) {

                // We only want to include this item if there are a flavour of media to match the users request.
                if ($this->__setPodcastMedia() == false )
                    continue;

                $this->__setPodcastItemDefaults();

                // We only want to include this media if a copy exists on the media box. Break out of the loop and
                // start again if the media does not exist.
                if( parent::mediaFileExist( $this->podcast_item_media_file_path.$this->podcast_item_media_file ) == false )
                    continue;

                $item['title'] = parent::clean($this->podcast_item['title']);
                $item['description'] = parent::clean($this->podcast_item['summary']);

                // Yahoo specific
                $item['media:title'] = parent::clean($this->podcast_item['title']);
                $item['media:description'] = parent::clean($this->podcast_item['summary']);
                $item['media:keywords'] = parent::clean($this->data['Podcast']['keywords']);

                if (parent::isPdf( $this->podcast_item['filename'] ) ) {

                    $item['media:thumbnail url="' . parent::cleanAttribute(DEFAULT_MEDIA_URL) . 'images/pdf-icon.png" width="400" height="294"'] = null;

                } elseif (!empty( $this->podcast_item['image_filename'])) {

                    $item['media:thumbnail url="' . parent::cleanAttribute($this->media_server) . FEEDS_FOLDER . $this->data['Podcast']['custom_id'] . '/' . parent::getStandardImageName( $this->podcast_item['image_filename'] ) . '"'] = null;

                } else {

                    $item['media:thumbnail url="' . parent::cleanAttribute($this->datamedia_server) . FEEDS_FOLDER . $this->data['Podcast']['custom_id'] . '/' . $this->podcast_item['image_filename'] . '"'] = null;
                }

                // BEGIN - iTunes specific
                $item['itunes:summary'] = parent::clean( $this->podcast_item['summary'] );
                $item['itunes:keywords'] = parent::clean( $this->data['Podcast']['keywords'] );
                $item['itunes:author'] = parent::clean( $this->podcast_item['author'] );
                $item['itunes:explicit'] = ucfirst( $this->podcast_item['author'] );
                $item['itunes:subtitle'] = parent::clean( $this->podcast_item['summary'] );
                // END - iTunes specific

                if ( ( is_array( $this->data['iTuneCategories'] ) && count( $this->data['iTuneCategories'] ) ) &&
                        ( in_array($this->media_type, array( 'ipod', 'ipod-all', 'audio', 'epub', '' ) ) ) ) {

                    $item['itunes:category itunes:code="' . $this->data['iTuneCategories'][0]['code'] . '"'] = null;

                }

                if (!empty( $this->podcast_item['item_link'] ) )
                    $item['link'] = parent::clean($this->podcast_item['item_link']);

                $item['guid'] = parent::cleanAttribute($this->media_server) . FEEDS_FOLDER . $this->data['Podcast']['custom_id'] . '/' . $this->podcast_item_image;
                $item['pubDate'] = $this->podcast_item['publication_date'];

                $item['enclosure url="' . parent::cleanAttribute($this->media_server) . FEEDS_FOLDER . $this->data['Podcast']['custom_id'] . '/' . $this->podcast_item_media_path . $this->podcast_media['filename'] . '"'] = null;
            }

            $this->podcast_items[] = $item;
        }

    }

    /*
     * @name : __setPodcastMedia
     * @description : Read through all flavours of media associated with this podcast_item
     * and find the flavour associated with the media_type parameter passed in the URL.
     * @updated : 7th June 2011
     * @by : Charles Jackson
     */

    function __setPodcastMedia() {

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
     * @name : __setPodcastItemDefaults
     * @description : Sets various values for a particular item / media within the foreach loop of the buildPodcastItemData
     * method.
     * @updated : 7th June 20111
     * @by : Charles Jackson
     */

    function __setPodcastItemDefaults() {

        $podcast_item_media_folder = isSet($this->media_folder[$this->podcast_media['media_type']]) ? $this->media_folder[$this->podcast_media['media_type']].'/' : '';
        $this->podcast_item_media_file = $this->podcast_media['filename'];
        $this->podcast_item_media_file_path = $this->media_server.FEEDS_FOLDER.$this->data['Podcast']['custom_id'].'/'.$podcast_item_media_folder;
        $this->podcast_item_date_stamp = str_replace('  ', ' ', date('r', $this->podcast_media['publication_date']));

        $this->podcast_item_image = $this->podcast_item['image_filename'];
        $this->podcast_item_standard_image = parent::getStandardImageName( $this->podcast_item['image_filename'] );
        $this->podcast_item_thumbnail_image = parent::getThumbnailImageName( $this->podcast_item['image_filename'] );
        $this->podcast_item_image_extension = parent::getImageExtension( $this->podcast_item['image_filename'] );
    }

    /*
     * @name : __setPodcastItemTranscript
     * @description : If we are not already processing a transcript and a transcript exists for this podcast_item
     * capture the details here.
     * @updated : 9th June 2011
     * @by : Charles Jackson
     */
    function __setPodcastItemTranscript() {

        if( strtoupper( $this->media_type ) == TRANSCRIPT ) {

            // Make a header request to check if the file exists
            if( get_headers( $this->media_server.$this->data['Podcast']['custom_id'].'/'.TRANSCRIPT.'/'.$this->data['Transcript']['filename'] ) ) {
                
                $this->podcast_item_transcript_file = $this->data['Transcript']['filename'];
                $this->podcast_item_transcript_file_path = $this->media_server.FEEDS_FOLDER.$this->data['Podcast']['custom_id'].'/'.TRANSCRIPT.'/';
                $this->podcast_item_transcript_file_size = filesize( $this->podcast_item_transcript_file_path.$this->podcast_item_transcript_file );

                $this->__buildAtomStrings();
                
                return true;
            }

            $this->podcast_item_transcript_file = null;
            $this->podcast_item_transcript_file_size = 0;
            $this->podcast_item_transcript_file_path = null;
            $this->atom_string = null;
            $this->atom_string2 = null;

            return false;
        }
    }

    /*
     * @name : __buildAtomStrings
     * @description : Builds two very ugly ATOM strings if we have a transcript for the current podcast_item.
     * @updated : 9th June 2011
     * @by : Charles Jackson
     */
    function __buildAtomStrings() {

        $this->atom_string = '<atom:link rel="alternate" type="application/pdf" title="Transcript for '.$this->podcast_item['title'].'" href="'.$this->podcast_item_transcript_file_path.$this->podcast_item_transcript_file.'" length="'.$this->podcast_item_transcript_file_size.'" >';
        $this->atom_string2 = '<a href="'.$this->podcast_item_transcript_file_path.$this->podcast_item_transcript_file.'">Transcript '.parent::clean( $this->podcast_item['title'] ).', PDF '.sprintf('%01.0f', ( $this->podcast_item_transcript_file_size/1024 ) ).'Kb</a>';
        return true;
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

}