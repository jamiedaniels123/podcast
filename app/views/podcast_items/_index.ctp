<fieldset id="podcast_media">
    <legend>Podcast Media</legend>
    <ul>
        <?php foreach( $this->data['PodcastItems'] as $podcast_item ) : ?>
            <?php if( isSet( $this->params['admin'] ) ) : ?>
                <li><a href="/admin/podcast_items/view/<?php echo $podcast_item['id']; ?>" title="view <?php echo $podcast_item['title']; ?>"><?php echo strlen( $podcast_item['title'] ) ? $podcast_item['title'] : $podcast_item['filename']; ?></a></li>
            <?php else : ?>
                <li><a href="/podcast_items/view/<?php echo $podcast_item['id']; ?>" title="view <?php echo $podcast_item['title']; ?>"><?php echo strlen( $podcast_item['title'] ) ? $podcast_item['title'] : $podcast_item['filename']; ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</fieldset>