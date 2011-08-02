<fieldset>
    <legend> <?php echo $this->data['PodcastItem']['title'];?> Media </legend>
    <?php 
	if( $this->Permission->toUpdate( $this->data['Podcast'] ) ) : ?>
		<a href="/podcast_items/edit/<?php echo $this->data['PodcastItem']['id'];?>" title="edit">edit</a>
        <a href="/podcasts/view/<?php echo $this->data['Podcast']['id'];?>" title="edit">collection</a>
	<?php endif; ?>
    <?php if( $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) ) : ?>
		<a href="/podcast_items/delete/<?php echo $this->data['PodcastItem']['id'];?>" title="delete" onclick="return confirm('Are you sure you wish to delete this media?');" >delete</a>
    <?php endif; ?>    
    <div class="clear"></div>    
    <?php echo $this->element('../podcast_items/_view'); ?>
    <?php echo $this->element('../podcast_item_medias/_index'); ?>
    
</fieldset>

