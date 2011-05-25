<div class="wrapper">
    <div class="float_right">
            <?php echo $this->Attachment->getPodcastStandardImage( $this->data ); ?>
    </div>
    <div class="float_left">
        <dl>
            <dt>Title: </dt>
            <dd><?php echo $this->data['Podcast']['title']; ?>&nbsp;</dd>
            <dt>Summary: </dt>
            <dd><?php echo nl2br( $this->data['Podcast']['summary'] ); ?>&nbsp;</dd>
            <dt>Created: </dt>
            <dd><?php echo $this->data['Podcast']['created'] ? $this->Time->getPrettyShortDate( $this->data['Podcast']['created'] ) : $this->Time->getPrettyShortDate( $this->data['Podcast']['created_when'] ); ?>&nbsp;</dd>
            <dt>Owned By: </dt>
            <dd><?php echo $this->data['Owner']['full_name']; ?>&nbsp;</dd>
            <dt>Copyright: </dt>
            <dd><?php echo $this->data['Podcast']['copyright']; ?>&nbsp;</dd>

        </dl>
    </div>
</div>
<div class="clear"></div>
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
<div class="clear"></div>