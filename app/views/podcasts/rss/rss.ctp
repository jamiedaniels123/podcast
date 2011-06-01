<?php 
$channelData = array(
    'title' => 'Podcasts',
    'link' => 'http://podcasts.open.ac.uk',
    'description' => 'This is an example RSS feed containing all podcasts on the application',
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