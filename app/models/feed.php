<?php
class Feed extends AppModel {

    var $name = 'Feed';
    var $useTable = false;
    var $validate = array();


    /*
     * @name : sanitizeForRSS
     * @description : Will perform some basic data checks. Called directly before the RSS
     * is generated.
     * @updated : 2nd June 2011
     * @by : Charles Jackson
     */
    function sanitizeForRSS( $media_type = null, $reverse_order = null, $rss_filename, $itunes_complete = false, $interlace = true ) {

        // Capture the parameters passed so we may use them in view based helpers.
        $this->data['Params']['media_type'] = $media_type;
        $this->data['Params']['reverse_order'] = $reverse_order;
        $this->data['Params']['rss_filename'] = $rss_filename;
        $this->data['Params']['itunes_complete'] = $itunes_complete;
        $this->data['Params']['interlace'] = $interlace;

        // If the podcast is intended for iTunes clean the appropriate data.
        if( $this->data['Podcast']['intended_itunesu_flag'] == strtoupper('Y') )
            $this->__cleanItunesRSS();
    }

    function __cleanItunesRSS() {

        // If the feed is for iTunes check we have an author else
        // set the default author text string as defined in the bootstrap.
        if( empty( $this->data['Podcast']['author'] ) )
            $this->data['Podcast']['author'] = DEFAULT_AUTHOR;

        if( $this->data['Podcast']['itunesu_site'] == strtoupper('PRIVATE') )
            $this->data['Params']['interlace'] = false;



    }
}