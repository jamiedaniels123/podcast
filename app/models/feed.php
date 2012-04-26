<?php

class Feed extends AppModel {

	var $name = 'Feed';
	var $useTable = false;
	var $validate = array();

	// The following array defines the flavours of RSS we will attempt to create if available.
	var $rss_flavours = array(

			'3gp' => array('media_type' => '3gp', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 1, 'interlace' => 1  ),
			'audio' => array('media_type' => 'audio', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 1, 'interlace' => 1  ),
			'desktop' => array('media_type' => 'desktop', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 1, 'interlace' => 1  ),
			'hd' => array('media_type' => 'hd', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 1, 'interlace' => 1  ),
			'hd-1080' => array('media_type' => 'hd-1080', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 1, 'interlace' => 1  ),
			'iphone' => array('media_type' => 'iphone', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 1, 'interlace' => 1  ),
			'ipod' => array('media_type' => 'ipod', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 1, 'interlace' => 1  ),
			'large' => array('media_type' => 'large', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 1, 'interlace' => 1  ),
			'transcript' => array('media_type' => 'transcript', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 1, 'interlace' => 0 ),
			'ipod-all' => array('media_type' => 'ipod-all', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 1, 'interlace' => 1 ),
			'desktop-all' => array('media_type' => 'desktop-all', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 1, 'interlace' => 1 ),
			'youtube' => array('media_type' => 'youtube', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 0, 'interlace' => 0 ),
			'extra' => array('media_type' => 'extra', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 1, 'interlace' => 0 ),
			'epub' => array('media_type' => 'epub', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 1, 'interlace' => 0 ),
			'default' => array('media_type' => 'default', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 0, 'interlace' => 0 ),
			'wm' => array('media_type' => 'wm-default', 'rss_filename' => DEFAULT_RSS_FILENAME, 'itunes_complete' => 0, 'interlace' => 0 )
	);

	var $default_rss_flavours = array( '240','270','360','480','540','720','1080' );

	var $itunes_title_suffix = array(
			'3gp' 						=> ' - Mobile Video',
			'audio-mp3'				=> ' - Audio',
			'audio'						=> ' - Audio',
			'audio-m4a' 			=> ' - Audio',
			'audio-m4b' 			=> ' - Audio Book',
			'desktop' 				=> ' - iPad/Mac/PC Video',
			'hd' 							=> ' - HD Video',
			'iphone' 					=> ' - iPhone Video',
			'iphonecellular'	=> ' - iPhone (Edge) Video',
			'ipod' 						=> ' - iPod/iPhone Video',
			'large'						=> ' - HQ Video',
			'transcript'			=> ' - Transcript',
			'youtube'					=> ' - YouTube Video',
			'extra'						=> ' - Extras',
			'high'						=> ' - HQ Video',
			'ipod-all'				=> ' - for iPod/iPhone',
			'desktop-all'			=> ' - for iPod/Mac/PC',
			'wm' 							=> '',
			'epub' 						=> ''
	);
	var $media_folder = array(
			'3gp' => '3gp/', 									// iTunes U (Public) - 3gp video only
			'audio-mp3' => 'audio/',					// iTunes U (Public) - audio only (contains both MP3 and AAC - both m4a and m4b - latter audiobooks)
			'audio-m4a' => 'audio/',					// iTunes U (Public) - audio only (contains both MP3 and AAC - both m4a and m4b - latter audiobooks)
			'audio-m4b' => 'audio/',					// iTunes U (Public) - audio only (contains both MP3 and AAC - both m4a and m4b - latter audiobooks)
			'desktop' => 'desktop/',					// iTunes U (Public) - desktop quality (640 wide) video only
			'desktop-all' => 'desktop-all/',  // iTunes U (Public) - desktop quality (640 wide) video AND audio
			'hd' => 'hd/',										// iTunes U (Public) - 720p HD video only
			'hd-1080' => 'hd-1080/',					// iTunes U (Public) - 1080p HD video only
			'iphone' => 'iphone/',						// iTunes U (Public) - iPhone (wifi) video only (H264 baseline encoded)
			'iphonecellular' => 'iphone/',		// iTunes U (Public) - iPhone 3gp (Edge) video only (H264 encoding)
			'ipod' => 'ipod/',								// iTunes U (Public) - iPod video only (H264 baseline encoded)
			'ipod-all' => 'ipod-all/',				// iTunes U (Public) - iPod video AND audio
			'large' => 'large/',							// iTunes U (Public) - video only (native video dimensions)
			'transcript' => 'transcript/',		// transcripts of corresponding track entry (for audio and video tracks only)
			'youtube' => 'youtube/',					// YouTube - encoded for uploading to YouTube, has different trailer
			'extra' => 'extra/',
			'cc-scc' => 'closed-captions/',
			'cc-dfxp' => 'closed-captions/',
			'epub' => 'epub/',
			'default' => null,
			'240' => null,
			'270' => null,
			'360' => null,
			'480' => null,
			'540' => null,
			'720' => null,
			'1080' => null,
			'wm-default' => 'wm/',
			'wm-240' => 'wm/',
			'wm-270' => 'wm/',
			'wm-360' => 'wm/',
			'wm-480' => 'wm/',
			'wm-540' => 'wm/',
			'wm-720' => 'wm/',
			'wm-1080' => 'wm/'
	);

	var $mime_types = array(
			'mp3' => 'audio/mpeg',
			'm4a' => 'audio/x-m4a',
			'm4b' => 'audio/x-m4b',
			'3gp' => 'video/x-m4v',
			'mp4' => 'video/mp4',
			'dv' => 'video/x-dv',
			'm4v' => 'video/x-m4v',
			'mov' => 'video/quicktime',
			'pdf' => 'application/pdf',
			'epub' => 'application/epub+zip',
			'scc' => 'application/x-rpt',
			'xml' => 'application/ttml+xml'
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

		// Append the suffix to the podcast title.
		$this->data['Podcast']['title'] .= $this->title_suffix;

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
				'xmlns:oup' => 'http://podcast.open.ac.uk/2012',
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

		// set flag for the player.xml file because it contains certain elements that should not be in the defualt rss files.
		if($this->rss_filename=='player.xml'){
			$isplayerxml=true;
		}
		else{
			$isplayerxml=false;
		}
		
		error_log("models/feed > getChannelData | data['Podcast']['title'] =".$this->data['Podcast']['title']." | title_suffix =".$this->title_suffix);
		
		$channelData = array(
				'title' => $this->data['Podcast']['title'].$this->title_suffix,
				'link' => $this->data['Podcast']['link'],
				'description' => $this->data['Podcast']['summary'],
				'copyright' => $this->data['Podcast']['copyright'],
				'language' => 'en-uk',
				'lastBuildDate' => str_replace('  ', ' ', date('r')),
				'generator' => 'OU Podcast System by KMi',
				'docs' => 'http://blogs.law.harvard.edu/tech/rss' );

		$channelData['atom:link']['attrib']['href'] = $this->media_server . FEEDS . $this->data['Podcast']['custom_id'] . '/' . $this->podcast_item_media_folder . $this->rss_filename;
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
		if ( !empty( $this->podcast_path_and_image ) ) {
			$channelData['media:thumbnail']['attrib']['url'] = $this->podcast_path_and_image;
		} else {
			$channelData['media:thumbnail']['attrib']['url'] = DEFAULT_MEDIA_URL.FEEDS.'default-project-thumbnail.png';
		}
		// END - Yahoo specific elements

		// BEGIN - iTunes specific elements
		$channelData['itunes:subtitle'] = $this->data['Podcast']['subtitle'];
		$channelData['itunes:summary'] = $this->data['Podcast']['summary'];
		$channelData['itunes:keywords'] = $this->data['Podcast']['keywords'];
		$channelData['itunes:author'] = strlen( trim( $this->data['Podcast']['author'] ) ) ? $this->data['Podcast']['author'] : DEFAULT_AUTHOR;


		if ( !empty( $this->podcast_path_and_image ) )
			$channelData['itunes:image']['attrib']['href'] = $this->podcast_path_and_image;


		$channelData['itunes:owner']['itunes:name'] = $this->data['Podcast']['contact_name'];
		$channelData['itunes:owner']['itunes:email'] = $this->data['Podcast']['contact_email'];

		if ( $this->itunes_complete )
			$channelData['itunes:complete'] = 'true';


		foreach ( $this->data['Categories'] as $category ) {
			// if ( (int)$category['parent_id'] ) {

			// } else {


			$channelData['itunes:category_1']['attrib']['text'] = $category['ParentCategory']['category'];
			$channelData['itunes:category_1']['itunes:category_2']['attrib']['text'] = $category['category'];
			//$channelData['itunes:category_1']['attrib']['text'] = $category['category'];
			// }
		}

		//print_r($channelData);die('dead');

		// END - iTunes specific elements


		// We name the element "atom:category" by an alias identified the regular expression "atom:category_."
		// We use an alias because the element name is used as the key in the array therefore we cannot have
		// the same element twice.
		// All occurences of the alias are replaced in bespoke_rss.php in the "elem" method using
		// preg_replace
		if ( !empty( $this->data['Podcast']['course_code'] ) ) {
			$channelData['atom:category_1']['attrib']['scheme'] = 'http://purl.org/steeple/course';
			$channelData['atom:category_1']['attrib']['term'] = trim($this->data['Podcast']['course_code']);
			$channelData['atom:category_1']['attrib']['label'] = null;
		}

		if ( !empty($this->data['PreferredNode']['subject_code']) && !empty( $this->data['PreferredNode']['title'] ) ) {

			$channelData['atom:category_2']['attrib']['scheme'] = 'http://purl.org/ou/blue#';
			$channelData['atom:category_2']['attrib']['term'] = trim($this->data['PreferredNode']['subject_code']);
			$channelData['atom:category_2']['attrib']['label'] = $this->data['PreferredNode']['title'];
		}

    // PLAYER.XML - additions to CHANNEL level for player.xml specific output (JDD 20120328, BH 20120316)

		if ($isplayerxml) {
			
    	// custom_ID
    	// Example: <atom:link rel="alternate" type="text/html" title="Permalink for Student views of the OU" href="http://podcast.open.ac.uk/pod/student-experiences/" />    
			$channelData['atom:linkalternative']['attrib']['rel'] = "alternative";
			$channelData['atom:linkalternative']['attrib']['type'] = "text/html";
			$channelData['atom:linkalternative']['attrib']['href'] = $this->media_server . FEEDS . $this->data['Podcast']['custom_id'] . '/' . $this->podcast_item_media_folder . $this->rss_filename;
			$channelData['atom:linkalternative']['attrib']['title'] = "Permalink for " . $this->data['Podcast']['title'].$this->title_suffix;

      // itunes_u_url
      // Example: <atom:link rel="oup:rel-itunes-url" type=""  href="http://deimos.apple.com/WebObjects/Core.woa/Browse/itunes.open.ac.uk.1542410972" />
			// iTunes U flag for OU media player is called atom:linkitunesu to avoid the issue with the rss helper not liking two elements with the same name.
			// at the end of views/helpers/bespoke_rss.php we remove the 'itunesu' to change it back to atom:link
			if ( !empty( $this->data['Podcast']['itunes_u_url'] ) ) {
				$channelData['atom:linkitunesu']['attrib']['rel'] = "oup:rel-itunes-url";
				$channelData['atom:linkitunesu']['attrib']['type'] = "";
				$channelData['atom:linkitunesu']['attrib']['href'] = $this->data['Podcast']['itunes_u_url'];
			}

      // link and link_text
      // Example: <atom:link rel="related" type="text/html" title="Study at .." href="http://www3.open.ac.uk/study/" />
			if ( !empty( $this->data['Podcast']['link'] ) ) {
				$channelData['atom:linkrelated']['attrib']['rel'] = "related";
				$channelData['atom:linkrelated']['attrib']['type'] = "text/html";
				$channelData['atom:linkrelated']['attrib']['href'] = $this->data['Podcast']['link'];
				$channelData['atom:linkrelated']['attrib']['title'] = $this->data['Podcast']['link_text'];
			}
			
      // private
      // Example: <oup:private>0</oup:private>
			if ( !empty( $this->data['Podcast']['private'] ) ) {
				if($this->data['Podcast']['private'] =='Y'){
					$isprivate=1;
				}
				else{
					$isprivate=0;
				}
				$channelData['oup:private'] = $isprivate;
			}

			// intranet_only
			// Example: <oup:intranet_only>0</oup:intranet_only>
			if ( !empty( $this->data['Podcast']['intranet_only'] ) ) {
				if($this->data['Podcast']['intranet_only'] =='Y'){
					$isintranet=1;
				}
				else{
					$isintranet=0;
				}
				$channelData['oup:intranet_only'] = $isintranet;
			}


			// deleted
			// Example: <oup:deleted>0</oup:deleted>
			$channelData['oup:deleted'] = $this->data['Podcast']['deleted'];

		}
    // (END) PLAYER.XML - additions to CHANNEL level
		
		return $channelData;
	}


	/*
	 * @name : buildPodcastItem
	* @description :
	* @updated : 7th June 2011
	* @by : Charles Jackson
	*/

	function buildPodcastItem( $track_number = 0 ) {
		
		// set flag for the player.xml file because it contains certain elements that should not be in the defualt rss files.
		if($this->rss_filename=='player.xml'){
			$isplayerxml=true;
		}
		else{
			$isplayerxml=false;
		}
		
		$item = array();
		//print_r($this->data['Podcast']);
		//print_r($this->podcast_item);
		//print_r($this->rss_filename);
		//die('dead');
		$item['title'] = $this->podcast_item['title'];
		$item['description'] = $this->podcast_item['summary'];

		// Yahoo specific
		$item['media:title'] = $this->podcast_item['title'];
		$item['media:description'] = $this->podcast_item['summary'];
		$item['media:keywords'] = $this->data['Podcast']['keywords'];

		if( strtoupper( $this->podcast_item_image_extension ) == 'PDF' ) {

			$item['media:thumbnail']['url'] = $this->media_server.'/images/'.$this->podcast_item_thumbnail_image;

		} elseif( !empty( $this->podcast_item_standard_image ) ) {

			$item['media:thumbnail']['url'] = $this->media_server.FEEDS.$this->data['Podcast']['custom_id'].$this->podcast_item_media_folder.$this->podcast_item_standard_image.$this->podcast_item_image_extension;

		} elseif( !empty( $this->podcast_item_image ) ) {

			$item['media:thumbnail']['url'] = $this->media_server.FEEDS.$this->data['Podcast']['custom_id'].$this->podcast_item_media_folder.$this->podcast_item_image.$this->podcast_item_image_extension;
		} else {

			$item['media:thumbnail']['url'] = DEFAULT_MEDIA_URL.FEEDS.'default-project-thumbnail.png';

		}

		// BEGIN - iTunes (Podcast) specific
		$item['itunes:summary'] = $this->podcast_item['summary'];
		$item['itunes:keywords'] = $this->data['Podcast']['keywords'];
		$item['itunes:author'] = strlen( trim( $this->podcast_item['author'] ) ) ? $this->podcast_item['Podcast']['author'] : DEFAULT_AUTHOR;
		$item['itunes:explicit'] = ucfirst( $this->podcast_item['explicit'] );
		$item['itunes:subtitle'] = $this->podcast_item['summary'];

		if( $this->itunes_complete )
			$item['itunes:order'] = $track_number;

		//print_r($this->podcast_item);die('dead after showing podcast item');
		$item = $this->__setItunesItemCode( $item );

		// ENDS - iTunes (Podcast) specific

		if (!empty( $this->podcast_item['item_link'] ) ) {
			$item['link'] = $this->podcast_item['item_link'];
		}

		$item['guid'] = $this->media_server.FEEDS.$this->data['Podcast']['custom_id'].$this->podcast_item_media_folder.$this->podcast_media['filename'];
		$item['pubDate'] = $this->podcast_item['publication_date'];
		$item['enclosure']['url'] = $this->media_server.FEEDS.$this->data['Podcast']['custom_id'].$this->podcast_item_media_folder.$this->podcast_media['filename'];
		$item['media:content']['url'] = $this->media_server.FEEDS.$this->data['Podcast']['custom_id'].$this->podcast_item_media_folder.$this->podcast_media['filename'];

		// OK, we are not processing an eBook or PDF transcript, add duration
		if( in_array( strtolower( $this->podcast_item_image_extension ), array('epub','pdf') ) == false ) {
			$duration=$this->podcast_media['duration'];
		}
		$duration = date('H:i:s',$duration);
		$item['itunes:duration'] =$duration;

		// If we are processing a transcript add appropriate atom element.
		$item = $this->setAtom( $item );

		if ( ( strtoupper( $this->media_type ) == 'YOUTUBE' ) && ( strtoupper( $this->podcast_item['youtube_legacy_track'] ) == 'Y' ) ) {
			$item['oupod:legacy'] = 'true';
		}

    // PLAYER.XML - additions to ITEM level for player.xml specific output  (JDD 20120328, BH 20120316)
    //

		if ($isplayerxml) {

			// BH 20120426 - the use of $this->podcast_item_media_folder in some places could be considered unnecessary for player.xml since at present
			//							 player.xml is only generated for the 'default' flavour which is in the root of the podcast, however this may change in
			//							 future so is include in case it is needed.
			//							 IMPORTANT: $this->podcast_item_media_folder includes a leading '/' so even if we are creating the default flavour it 
			//               will be set to '/'.
			
			// shortcode
			// Example: <atom:link rel="alternate" type="text/html" title="Permalink for Student views of OU" href="http://podcast.open.ac.uk/pod/student-experiences/#!db6cc60d6b" />
			// NOTE: This link is /#!{shortcode}  - includes '/' - compared with 'oup:longlink' below
			if ( !empty($this->podcast_item['shortcode'] ) ) {
				$item['atom:link']['attrib']['rel'] = 'alternate';
				$item['atom:link']['attrib']['type'] = 'text/html';
				$item['atom:link']['attrib']['href'] = 'http://podcast.open.ac.uk/pod/'.$this->data['Podcast']['custom_id'].$this->podcast_item_media_folder.'#!'.$this->podcast_item['shortcode'];
				$item['atom:link']['attrib']['title'] = 'Permalink for '.$this->podcast_item['title'];
			}
			
			// shortcode (longlink)
			// Example: <atom:link rel="oup:longlink" type="text/html" title="Permalink (2).." href="http://podcast.open.ac.uk/oulife/podcast-student-experiences#!db6cc60d6b" />
			// NOTE: This link is #!{shortcode}  - EXCLUDES '/' - compared with 'alternate' above
			if ( !empty($this->podcast_item['shortcode'] ) ) {
				$item['atom:linklong']['attrib']['rel'] = 'oup:longlink';
				$item['atom:linklong']['attrib']['type'] = 'text/html';
				// trim '/' of the media_folder as this version of the link does not include a '/' before the #! 
				$trimmed_media_folder = (strlen($this->podcast_item_media_folder) > 1) ? substr($this->podcast_item_media_folder,1) : "";
				$item['atom:linklong']['attrib']['href'] = 'http://podcast.open.ac.uk/pod/'.$this->data['Podcast']['custom_id'].$trimmed_media_folder.'#!'.$this->podcast_item['shortcode'];
				$item['atom:linklong']['attrib']['title'] = 'Permalink for '.$this->podcast_item['title'];
			}
			
			// target_url and target_url_text
			// Example: <atom:link rel="related" type="text/html" title="A page" href="http://www3.open.ac.uk/a/path" />
			if ( !empty($this->podcast_item['target_url'] ) ) {
				$item['atom:link1']['attrib']['rel'] = 'related';
				$item['atom:link1']['attrib']['type'] = 'text/html';
				$item['atom:link1']['attrib']['href'] = $this->data['Podcast']['target_url'];
				$item['atom:link1']['attrib']['title'] = $this->data['Podcast']['target_url_text'];
			}
			
			// youtube_id
			// Example: <atom:content type='application/x-shockwave-flash' src='https://www.youtube.com/v/iiZp4va0iHE?version=3&amp;f=videos&amp;app=podcast.open.ac.uk/feeds' />
			if ( !empty($this->podcast_item['youtube_id'] ) ) {
				$item['atom:content']['attrib']['type'] = 'application/x-shockwave-flash';
				$item['atom:content']['attrib']['src'] = "http://www.youtube.com/v/".$this->podcast_item['youtube_id']."version=3&amp;f=videos&amp;app=podcast.open.ac.uk/feeds";
			}
			
			// aspect_ratio
			// Example: <oup:aspect_ratio>0.5625</oup:aspect_ratio>
			if (!empty($this->data['Podcast']['aspect_ratio'])){
				$item['oup:aspect_ratio'] = $this->data['Podcast']['aspect_ratio'];
			} else {
				$item['oup:aspect_ratio'] = 0;
			}
			
			// unit_course and unit_course_title
			// Example: <atom:category scheme="http://purl.org/steeple/course" term="A180_2" label="Aberdulais Falls: A case study.." />
			if ( !empty($this->podcast_item['unit_course']) ) {
				$item['atom:categorycourse']['attrib']['term'] = $this->podcast_item['unit_course'];
				$item['atom:categorycourse']['attrib']['label'] = $this->podcast_item['unit_course_title'];
				$item['atom:categorycourse']['attrib']['scheme'] = 'http://purl.org/steeple/course';
			}
			
			// published_flag
			// Example: <oup:published_flag>1</oup:published_flag>
			if($this->podcast_item['published_flag'] == 'Y') {
				$item['oup:published'] = 1;
			} else {
				$item['oup:published'] = 0;
			}
			
			// closed Captions
			// Example: <atom:link rel="alternate" type="application/ttml+xml" title="Captions for S.." href="http://podcast.open.ac.uk/feeds/student-experiences/closed-captions/openings-being-an-ou-student.xml" />
			
			// BH 20120331 - Don't think this is right, the podcast_item['closed_caption'] is a field not necessarily populated correctly, instead the
			//               podcast_item_media table should be used with media_type = 'cc-dfxp'
			// DISABLED FOR NOW
			
			/*
			if ( !empty($this->podcast_item['closed_caption'] ) ) {
				$item['atom:link3']['attrib']['rel'] = 'alternate';
				$item['atom:link3']['attrib']['type'] = 'application/ttml+xml';
				$item['atom:link3']['attrib']['href'] = 'http://podcast.open.ac.uk/pod/'.$this->data['Podcast']['custom_id'].'/closed-captions/'.$this->podcast_item['closed_caption'];
				$item['atom:link3']['attrib']['title'] = 'Closed Captions for '.$this->podcast_item['title'];
			}
			*/
					
		}
    // (END) PLAYER.XML - additions to ITEM level

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
		//$item['media:thumbnail'] = $this->media_server.FEEDS.'images/pdf-icon.png';

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

		$item['guid'] = $this->media_server.FEEDS.$this->data['Podcast']['custom_id'].'/'.strtolower( TRANSCRIPT ).'/'.$this->podcast_transcript['filename'];
		// Remove 1 second from datestamp so as not to conflict with actual media.
		$item['pubDate'] = date("Y-m-d H:i:s", strtotime( $this->podcast_item['publication_date'] ) - 1 );
		$item['enclosure']['url'] = $this->media_server.FEEDS.$this->data['Podcast']['custom_id'].'/'.strtolower( TRANSCRIPT ).'/'.$this->podcast_transcript['filename'];
		$item['media:content']['url'] = $this->media_server.FEEDS.$this->data['Podcast']['custom_id'].'/'.strtolower( TRANSCRIPT ).'/'.$this->podcast_transcript['filename'];

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

		if( $this->media_type == 'default' )
			$this->media_type = null;

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

				$this->title_suffix = isSet( $this->itunes_title_suffix[$this->media_type] ) ? $this->itunes_title_suffix[$this->media_type] : null;
			}

		} else {

			$this->title_suffix = $title_suffix;
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

			$this->podcast_path_and_image = DEFAULT_MEDIA_URL.FEEDS.'default-project-thumbnail.png';

		} else {

			$this->podcast_path_and_image = $this->media_server.FEEDS.$this->data['Podcast']['custom_id'].'/'.$this->data['Podcast']['image'];
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
			if( get_headers( $this->media_server.FEEDS.$this->data['Podcast']['custom_id'].'/'.TRANSCRIPT.'/'.$this->data['Transcript']['filename'] ) ) {

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

		$status = false;
		$this->podcast_media = array();

		// Due to legacy issues we cannot guarantee a "default" flavoured entry will exist on the
		// podcast_item_media table. As such we take the value straight from the podcast_items table.
		if( empty( $this->media_type ) ) {

			$this->podcast_media['filename'] = $this->podcast_item['filename'];
			$this->podcast_media['duration'] = $this->podcast_item['duration'];
			return true;

		} else {


			foreach ( $this->podcast_item['PodcastMedia'] as $podcast_media ) {

				if ( $podcast_media['media_type'] == $this->media_type ) {
					$this->podcast_media = $podcast_media;
					$status = true;
					break;
				}
			}
		}

		return $status;
	}

	/*
	 * @name : setPodcastItemMediaFolder
	* @description : Will set the folder under the "/feed/custom_id/***" where "***" is the folder.
	* @updated : 15th June 2011
	* @by : Charles Jackson
	*/
	function setPodcastItemMediaFolder() {

		$this->podcast_item_media_folder = ( !empty( $this->media_type ) && isSet( $this->media_folder[$this->media_type] ) ) ? '/'.$this->media_folder[$this->media_type] : '/';
	}

	/*
	 * @name : setPodcastItemImageDetails
	* @description : Sets the default value of the image at item level. If there is no image we leave the class property empty
	* and use the default image stored on the media server : /feeds/default-project-thumbnail.png
	* @updated : 15th June 2011
	* @by : Charles Jackson
	*/
	function setPodcastItemImageDetails() {

		if( !empty( $this->podcast_item['image_filename'] ) ) {

			$this->podcast_item_image = $this->podcast_item['image_filename'];
			$this->podcast_item_standard_image = parent::getStandardImageName( $this->podcast_item['image_filename'] );

			if( strtoupper( $this->podcast_item_image_extension ) == 'PDF' ) {

				$this->podcast_item_thumbnail_image = 'pdf-icon.jpg';

			} else {

				$this->podcast_item_thumbnail_image = parent::getThumbnailImageName( $this->podcast_item['image_filename'] );
			}

			$this->podcast_item_image_extension = '.jpg'; //parent::getExtension( $this->podcast_item['image_filename'] );


		} else {

			$this->podcast_item_image = null;
			$this->podcast_item_standard_image = null;
			$this->podcast_item_thumbnail_image = null;
			$this->podcast_item_image_extension = null;
		}
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

		if ( ( is_array( $this->data['iTuneCategories'] ) && count( $this->data['iTuneCategories'] ) )) {

			$item['itunesu:category']['attrib']['itunesu:code'] = $this->data['iTuneCategories'][0]['code'];
		} else {

			$item['itunesu:category']['attrib']['itunesu:code'] = null;
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

	/*
	 * @name : buildParameters
	* @description : Buils the parameters that are passed to the feeds_controller view method that generates the RSS feeds captured
	* by the calling routine.
	* @updated : 30th August 2011
	* @by : Charles Jackson
	*/
	function buildParameters( $id, $flavour, $player = false ) {

		// We wish to build a RSS feed called "player.xml" that contains all podcast items regardless of whether they are published
		if( $player )
			return ($id.'/'.$flavour['media_type'].'/player.xml/'.$flavour['itunes_complete'].'/'.$flavour['interlace'].'/PlayerItems.rss' );

		// We are building the defacto RSS feeds containing all published items.
		return ($id.'/'.$flavour['media_type'].'/'.$flavour['rss_filename'].'/'.$flavour['itunes_complete'].'/'.$flavour['interlace'].'/PublishedPodcastItems.rss' );
	}

	/*
	 * @name : buildRssPath
	* @description : Will build a path relative to the file repository where everything will get written in preparation
	* for transfer to the media server.
	* @updated : 24th June 2011
	* @by : Charles Jackson
	*/
	function buildRssPath( $podcast = array(), $flavour = array() ) {

		if( $flavour['media_type'] == 'default' ) {

			$media_folder = null;

		} elseif( !empty( $flavour['media_type'] ) && $flavour['media_type'] != null ) {

			$media_folder = (isSet($this->media_folder[$flavour['media_type']])) ? $this->media_folder[$flavour['media_type']] : null;
			
		} else {
		
			$media_folder = null;

		}
		// error_log("models/feed > buildRssPath | flavour['media_type'] = ".$flavour['media_type']." | media_folder =".$media_folder);

		return $podcast['Podcast']['custom_id'].'/'.$media_folder;
	}

/*	function buildRssPath( $podcast = array(), $flavour = array() ) {

		if( $flavour['media_type'] == 'default' ) {

			$flavour['media_type'] = null;

			// The media_type can be empty but if not append a slash '/' for the purposes of creating the path line.
		} else {

			$flavour['media_type'] = $flavour['media_type'].'/';
		}

		return $podcast['Podcast']['custom_id'].'/'.$flavour['media_type'];
	}
*/

	/*
	 * @name : buildApiEntry
	* @description : Will format an array that will eventually be passed to the Api.
	* @updated : 24th June 2011
	* @by : Charles Jackson
	*/
	function buildApiEntry( $custom_id, $media_type = null, $file_name = null ) {

		// The media_type can be empty but if not append a slash '/' for the purposes of creating the path line.
		if( strtolower( $media_type ) == 'default' ) {

			$media_folder = null;

		} elseif( !empty( $media_type ) && $media_type != null ) {

			$media_folder = (isSet($this->media_folder[$media_type])) ? $this->media_folder[$media_type] : null;
			
		} else {
		
			$media_folder = null;

		}

		// error_log("models/feed > buildApiEntry | this->mediatype = ".$this->media_type." | media_type = ".$media_type." | media_folder =".$media_folder);
		
		return
		array(
				'source_path' => $custom_id.'/'.$media_folder,
				'source_filename' => $file_name,
				'destination_path' => $custom_id.'/'.$media_folder,
				'destination_filename' => $file_name
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

	/*
	 * @name : getDefaultFlavours
	* @description : Will retrieve all 'default flavours' as defined in the class property for a specific podcast_item_id.
	* @updated : 23rd August 2011
	* @by : Charles Jackson
	*/
	function getDefaultFlavours() {

		$podcastItemMedia = ClassRegistry::init('PodcastItemMedia');

		return $podcastItemMedia->find('all', array(
				'conditions' => array(
						'PodcastItemMedia.podcast_item' =>  $this->podcast_item['id'],
						'PodcastItemMedia.media_type' =>  $this->default_rss_flavours
				)
		)
		);
	}
}