<?php 
$channelData = array(
    'title' => 'Podcast',
    'link' => 'http://www.example.com',
    'description' => 'blah',
    'language' => 'en-uk'
);

$this->set('channelData',$channelData);

foreach( $podcasts as $podcast ) {
    echo $rss->item(
        array(),
        array(
            'title' => $podcast['Podcast']['title'],
            'link' => $podcast['Podcast']['link'],
            'guid' => array(
                'controller' => 'podcasts',
                'action' => 'view', $podcast['Podcast']['id']
            ),
            'description' => $podcast['Podcast']['summary']
        )
    );
}