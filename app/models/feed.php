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
    function buildParameterArray( $data, $id, $media_type, $rss_filename, $itunes_complete, $interlace ) {
        
        // Capture the parameters passed so we may use them in view based helpers.
        $data['Params']['id'] = $id;
        $data['Params']['media_type'] = $media_type;
        $data['Params']['rss_filename'] = $rss_filename;
        $data['Params']['itunes_complete'] = $itunes_complete;
        $data['Params']['interlace'] = $interlace;

        return $data;
    }

    /*
     * @name : sanitizeForRSS
     * @description : Will perform some basic data checks. Called directly before the RSS
     * is generated. There are more functional helpers called from the view using the
     * bespoke_rss helper.
     * @updated : 2nd June 2011
     * @by : Charles Jackson
     */
    function sanitizeForRSS( $data ) {

        $data = $this->__defineMediaDefaults( $data );
        
        // If the podcast is intended for iTunes clean the appropriate data.
        if( $data['Podcast']['intended_itunesu_flag'] == strtoupper('Y') )
            $data = $this->__cleanItunesRSS( $data );

        return $data;
    }

    /*
     * @name : __defineMediaDefaults
     * @description : Define the value of various parameters referenced in the RSS feed.
     * @updated : 3rd June 2011
     * @by : Charles Jackson
     */
    function __defineMediaDefaults( $data ) {

        if( empty( $data['Params']['media_type'] ) ) {

            $data['Params']['media_server'] = DEFAULT_MEDIA_URL;
            $data['Params']['media_path'] = $data['Params']['media_path'].'/';
            $data['Params']['title_suffix'] = null;
            
        } else {

            $data['Params']['media_server'] = DEFAULT_ITUNES_MEDIA_URL;
            $data['Params']['media_path'] = null;
            $data['Params']['title_suffix'] = isSet( $this->itunes_title_suffix[$data['Params']['media_type']] ) ? $this->itunes_title_suffix[$data['Params']['media_type']] : null;
        }

        return $data;
    }
    
    /*
     * @name : __cleanItunesRSS
     * @description : Make updates to the data that are specific to podcasts that we intend to publish
     * on iTunes.
     * @updated : 2nd June 2011
     * @by : Charles Jackson
     */
    function __cleanItunesRSS( $data ) {

        // If the feed is for iTunes check we have an author else
        // set the default author text string as defined in the bootstrap.
        if( empty( $data['Podcast']['author'] ) )
            $data['Podcast']['author'] = DEFAULT_AUTHOR;

        // Interlacing determines if media transcripts are included at the end of a podcast
        // listing or they are listed directly after there media equivalent. We NEVER
        // interlace a podcast listed as private
        if( $data['Podcast']['itunesu_site'] == strtoupper('PRIVATE') )
            $data['Params']['interlace'] = false;

        return $data;

    }
}