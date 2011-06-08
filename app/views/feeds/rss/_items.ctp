<?php

foreach( $this->data['PodcastItems'] as $podcast_item ) :
    
    $data = array();

    //if( $this->data['Params']['media_type'] == '')
    $data['title'] = $podcast_item['title'];
    $data['description'] = $podcast_item['summary'];

    echo $this->Rss->item(
        array(),
        $data
    );
    
endforeach;