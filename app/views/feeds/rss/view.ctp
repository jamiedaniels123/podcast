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
    'lastBuildDate' => date('r'),
    'generator' => 'OU Podcast System by KMi',
    'docs' => 'http://blogs.law.harvard.edu/tech/rss',
    'atom:link' => '?',
    'image' => array(
        'url' => $this->data['Params']['media_server'].FEEDS_FOLDER.$this->data['Podcast']['custom_id'].'/'.$this->data['Podcast']['image'],
        'title' => $this->BespokeRss->clean( $this->data['Podcast']['title'] ),
        'link' => $this->BespokeRss->clean( $this->data['Podcast']['link'] )
    ),
    'media:title' => $this->BespokeRss->clean( $this->data['Podcast']['title'] ),
    'media:description' => $this->BespokeRss->clean( $this->data['Podcast']['summary'] ),
    'media:keywords' => $this->BespokeRss->clean( $this->data['Podcast']['keywords'] ),
    'media:thumbnail' => null,
    'itunes:subtitle' => $this->BespokeRss->clean( $this->data['Podcast']['summary'] ),
    'itunes:summary' => $this->BespokeRss->clean( $this->data['Podcast']['summary'] ),
    'itunes:keywords' => $this->BespokeRss->clean( $this->data['Podcast']['keywords'] ),
    'itunes:author' => $this->BespokeRss->clean( $this->data['Podcast']['author'] ),
    'itunes:explicit' => $this->BespokeRss->clean( $this->data['Podcast']['explicit'] ),
    'itunes:owner' => array(
        'itunes:name' => $this->BespokeRss->clean( $this->data['Podcast']['contact_name'] ),
        'itunes:email' => $this->BespokeRss->clean( $this->data['Podcast']['contact_email'] )
    )
);

//if( isSet( $podcast['Categories'][0]['ParentCategory'] ) && !empty( $podcast['Categories'][0]['ParentCategory'] ) )
  //  $channelData['itunes:category'] = $data['ParentCategory']['category'];

$this->set('documentData', $documentData );
$this->set('channelData',$channelData);

foreach( $this->data['PodcastItems'] as $podcast_item ) {
    echo $rss->item(
        array(),
        array(
            'title' => $podcast_item['title'],
            'description' => $podcast_item['summary'],
            'media:title' => $podcast_item['title'],
            'media:description' => $podcast_item['summary'],
            'media:keywords' => $this->data['Podcast']['keywords'],
            'media:thumbnail' => $this->data['Podcast']['custom_id'].'/'.$this->data['Podcast']['image'],
            'itunes:summary' => $podcast_item['summary'],
            'itunes:keywords' => $this->data['Podcast']['keywords'],
            'itunes:author' => $this->data['Podcast']['author'],
            'itunes:explicit' => $podcast_item['explicit'],
            'itunes:subtitle' => $podcast_item['summary'],
            'itunesu: category itunesu:code="?"',
            'link' => $this->data['Podcast']['link'],
            'guid' => 'lllllllllllllllllll',
            'pubDate' => $podcast_item['created']
        )
    );
}