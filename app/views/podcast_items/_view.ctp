<div class="wrapper">
    <div class="float_right">
            <?php echo $this->Attachment->getPodcastMediaStandardImage( $this->data ); ?>
    </div>
    <div class="float_left">
        <dl>
            <dt>Title: </dt>
            <dd><?php echo $this->data['PodcastItem']['title']; ?>&nbsp;</dd>
            <dt>Summary: </dt>
            <dd><?php echo nl2br( $this->data['PodcastItem']['summary'] ); ?>&nbsp;</dd>
            <dt>Created: </dt>
            <dd><?php echo $this->data['PodcastItem']['created'] ? $this->Time->getPrettyShortDate( $this->data['PodcastItem']['created'] ) : $this->Time->getPrettyShortDate( $this->data['PodcastItem']['created_when'] ); ?>&nbsp;</dd>
        </dl>
    </div>
</div>
<div class="clear"></div>