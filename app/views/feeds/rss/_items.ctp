<?php
foreach( $this->data['PodcastItems'] as $podcast_item ) {
    echo $this->Rss->item(
        array(),
        array(
            'title' => $podcast_item['title'],
            'description' => $podcast_item['summary']
        )
    );
}