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
    'title' => $podcast['Podcast']['title'],
    'link' => 'http://podcasts.open.ac.uk',
    'description' => $podcast['Podcast']['summary'],
    'copyright' => $podcast['Podcast']['copyright'],
    'language' => 'en-uk',
    'lastBuildDate' => date('r'),
    'generator' => 'OU Podcast System by KMi',
    'docs' => 'http://blogs.law.harvard.edu/tech/rss',
    'atom:link' => '?',
    'image' => array(
        'url' => $podcast['Podcast']['custom_id'].'/'.$podcast['Podcast']['image'],
        'title' => $podcast['Podcast']['title'],
        'link' => $podcast['Podcast']['link']
    ),
    'media:title' => $podcast['Podcast']['title'],
    'media:description' => $podcast['Podcast']['summary'],
    'media:keywords' => $podcast['Podcast']['keywords'],
    'media:thumbnail' => null,
    'itunes:subtitle' => $podcast['Podcast']['summary'],
    'itunes:summary' => $podcast['Podcast']['summary'],
    'itunes:keywords' => $podcast['Podcast']['keywords'],
    'itunes:author' => $podcast['Podcast']['author'],
    'itunes:explicit' => $podcast['Podcast']['explicit'],
    'itunes:owner' => array(
        'itunes:name' => $podcast['Podcast']['contact_name'],
        'itunes:email' => $podcast['Podcast']['contact_email']
    )
);

//if( isSet( $podcast['Categories'][0]['ParentCategory'] ) && !empty( $podcast['Categories'][0]['ParentCategory'] ) )
  //  $channelData['itunes:category'] = $data['ParentCategory']['category'];

$this->set('documentData', $documentData );
$this->set('channelData',$channelData);

foreach( $podcast['PodcastItems'] as $podcast_item ) {
    echo $rss->item(
        array(),
        array(
            'title' => $podcast_item['title'],
            'description' => $podcast_item['summary'],
            'media:title' => $podcast_item['title'],
            'media:description' => $podcast_item['summary'],
            'media:keywords' => $podcast['Podcast']['keywords'],
            'media:thumbnail' => $podcast['Podcast']['custom_id'].'/'.$podcast['Podcast']['image'],
            'itunes:summary' => $podcast_item['summary'],
            'itunes:keywords' => $podcast['Podcast']['keywords'],
            'itunes:author' => $podcast['Podcast']['author'],
            'itunes:explicit' => $podcast_item['explicit'],
            'itunes:subtitle' => $podcast_item['summary'],
            'itunesu: category itunesu:code="?"',
            'link' => $podcast['Podcast']['link'],
            'guid' => 'lllllllllllllllllll',
            'pubDate' => $podcast_item['created']
        )
    );
}