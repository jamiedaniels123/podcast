<?php

// Pass the data into the layout (possible with RSS files
$this->set('documentData', $documentData );
$this->set('channelData',$channelData );

foreach( $podcast_items as $podcast_item ) :

    echo $this->BespokeRss->item(
        array(),
        $podcast_item
    );
        
endforeach;