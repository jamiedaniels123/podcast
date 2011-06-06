<?php
$documentData = array(
    'xmlns:itunes' => 'http://www.itunes.com/dtds/podcast-1.0.dtd',
    'xmlns:itunesu' => 'http://www.itunesu.com/feed',
    'xmlns:media' => 'http://search.yahoo.com/mrss/',
    'xmlns:atom' => 'http://www.w3.org/2005/Atom',
    'xmlns:oupod' => 'http://purl.org/net/oupod/',
    'xmlns:s' => 'http://purl.org/steeple'
);

$channelData = array(
    'title' => $this->BespokeRss->clean( $this->data['Podcast']['title'] ),
    'link' => 'http://podcasts.open.ac.uk',
    'description' => $this->BespokeRss->clean( $this->data['Podcast']['summary'] ),
    'copyright' => $this->data['Podcast']['copyright'],
    'language' => 'en-uk',
    'lastBuildDate' => str_replace('  ',' ',date('r') ),
    'generator' => 'OU Podcast System by KMi',
    'docs' => 'http://blogs.law.harvard.edu/tech/rss',
    'atom:link type="application/rss+xml" rel="self" href="'.$this->BespokeRss->cleanAttribute( $this->data['Params']['media_server'] ).FEEDS_FOLDER.$this->data['Podcast']['custom_id'].'/'.$this->data['Params']['rss_filename'].'"' => null
);

if( !empty( $this->data['Podcast']['image'] ) ) {
    
    $channelData['image']['url'] = $this->data['Params']['media_server'].FEEDS_FOLDER.$this->data['Podcast']['custom_id'].'/'.$this->data['Podcast']['image'];
    $channelData['image']['title'] = $this->BespokeRss->clean( $this->data['Podcast']['title'] );
    $channelData['image']['link'] = $this->BespokeRss->clean( $this->data['Podcast']['link'] );
}

// BEGIN - Yahoo specific elements
$channelData['media:title'] = $this->BespokeRss->clean( $this->data['Podcast']['title'] );
$channelData['media:description'] = $this->BespokeRss->clean( $this->data['Podcast']['summary'] );
$channelData['media:keywords'] = $this->BespokeRss->clean( $this->data['Podcast']['keywords'] );
if( !empty( $this->data['Podcast']['image'] ) )
    $channelData['media:thumbnail url="'.$this->BespokeRss->cleanAttribute( $this->data['Params']['media_server'] ).FEEDS_FOLDER.$this->data['Podcast']['custom_id'].'/'.$this->data['Podcast']['image'].'"'] = null;
// END - Yahoo specific elements

// BEGIN - iTunes specific elements
$channelData['itunes:subtitle'] = $this->BespokeRss->clean( $this->data['Podcast']['summary'] );
$channelData['itunes:summary'] = $this->BespokeRss->clean( $this->data['Podcast']['summary'] );
$channelData['itunes:keywords'] = $this->BespokeRss->clean( $this->data['Podcast']['keywords'] );
$channelData['itunes:author'] = $this->BespokeRss->clean( $this->data['Podcast']['author'] );
$channelData['itunes:explicit'] = $this->BespokeRss->clean( ucfirst( $this->data['Podcast']['explicit'] ) );

if( !empty( $this->data['Podcast']['image'] ) )
    $channelData['itunes:image href="'.$this->BespokeRss->cleanAttribute( $this->data['Params']['media_server'] ).FEEDS_FOLDER.$this->data['Podcast']['custom_id'].'/'.$this->data['Podcast']['image'].'"'] = null;

$channelData['itunes:owner']['itunes:name'] = $this->BespokeRss->clean( $this->data['Podcast']['contact_name'] );
$channelData['itunes:owner']['itunes:email'] = $this->BespokeRss->clean( $this->data['Podcast']['contact_email'] );

if( $data['Params']['itunes_complete'] )
    $channelData['itunes:complete'] = 'true';


foreach( $this->data['Categories'] as $category ) :

    if( (int)$category['parent_id'] ) :
        $channelData['itunes:category text="'.$category['ParentCategory']['category'].'"']['itunes:category text="'.$category['category'].'"'] = null;
    else :
        $channelData['itunes:category text="'.$category['category'].'"'] = null;
    endif;
    
endforeach;

// END - iTunes specific elements

if( !empty( $this->data['Nodes']['subject_code'] ) && !empty( $this->data['Nodes']['title'] ) )
    $channelData['atom:category scheme="'.$this->BespokeRss->cleanAttribute( 'http://purl.org/ou/blue#' ).'" term="'.$this->BespokeRss->clean( $this->data['Nodes']['subject_code'] ).'" label="'.$this->BespokeRss->clean( $this->data['Nodes']['subject_title'] ).'"'] = null;

if( !empty( $this->data['Podcast']['course_code'] ) )
    $channelData['atom:category scheme="'.$this->BespokeRss->cleanAttribute( 'http://purl.org/steeple/course' ).'" term="'.$this->BespokeRss->clean( $this->data['Podcast']['course_code'] ).'" label=""'] = null;

$this->set('documentData', $documentData );
$this->set('channelData',$channelData);

// Now build the item data.
echo $this->renderElement('../feeds/_items', array( 'data' => $this->data ) );