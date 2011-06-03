<?php
class Feed extends AppModel {

    var $name = 'Feed';
    var $useTable = false;
    var $validate = array();

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

    /*
     * @name : buildParameterArray
     * @description : Takes the parameters passed and puts them into the data array
     * for ease of reference in the RSS view and associated helpers.
     * @updated : 2nd June 2011
     * @by : Charles Jackson
     */
    function buildParameterArray( $id, $media_type, $rss_filename, $itunes_complete, $interlace ) {

        // Capture the parameters passed so we may use them in view based helpers.
        $this->data['Params']['id'] = $id;
        $this->data['Params']['media_type'] = $media_type;
        $this->data['Params']['rss_filename'] = $rss_filename;
        $this->data['Params']['itunes_complete'] = $itunes_complete;
        $this->data['Params']['interlace'] = $interlace;
    }

    /*
     * @name : sanitizeForRSS
     * @description : Will perform some basic data checks. Called directly before the RSS
     * is generated. There are more functional helpers called from the view using the
     * bespoke_rss helper.
     * @updated : 2nd June 2011
     * @by : Charles Jackson
     */
    function sanitizeForRSS() {

        $this->__defineMediaDefaults();
        
        // If the podcast is intended for iTunes clean the appropriate data.
        if( $this->data['Podcast']['intended_itunesu_flag'] == strtoupper('Y') )
            $this->__cleanItunesRSS();
    }

    /*
     * @name : __defineMediaDefaults
     * @description : Define the value of various parameters referenced in the RSS feed.
     * @updated : 3rd June 2011
     * @by : Charles Jackson
     */
    function __defineMediaDefaults() {

        if( empty( $this->data['Params']['media_type'] ) ) {

            $this->data['Params']['media_server'] = DEFAULT_MEDIA_URL;
            $this->data['Params']['media_path'] = $this->data['Params']['media_path'].'/';
            $this->data['Params']['title_suffix'] = null;
            
        } else {

            $this->data['Params']['media_server'] = DEFAULT_ITUNES_MEDIA_URL;
            $this->data['Params']['media_path'] = null;
            $this->data['Params']['title_suffix'] = isSet( $this->itunes_title_suffix[$this->data['Params']['media_type']] ) ? $this->itunes_title_suffix[$this->data['Params']['media_type']] : null;
        }
    }
    
    /*
     * @name : __cleanItunesRSS
     * @description : Make updates to the data that are specific to podcasts that we intend to publish
     * on iTunes.
     * @updated : 2nd June 2011
     * @by : Charles Jackson
     */
    function __cleanItunesRSS() {

        // If the feed is for iTunes check we have an author else
        // set the default author text string as defined in the bootstrap.
        if( empty( $this->data['Podcast']['author'] ) )
            $this->data['Podcast']['author'] = DEFAULT_AUTHOR;

        // Interlacing determines if media transcripts are included at the end of a podcast
        // listing or they are listed directly after there media equivalent. We NEVER
        // interlace a podcast listed as private
        if( $this->data['Podcast']['itunesu_site'] == strtoupper('PRIVATE') )
            $this->data['Params']['interlace'] = false;



    }
}