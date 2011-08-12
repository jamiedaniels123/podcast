<fieldset>
    <legend> <?php echo $this->data['PodcastItem']['title'];?> Media </legend>
    <?php 
	if( $this->Permission->toUpdate( $this->data['Podcast'] ) ) : ?>
		<a href="/podcast_items/edit/<?php echo $this->data['PodcastItem']['id'];?>" title="edit">edit</a>
	<?php endif; ?>
    <div class="clear"></div>    
    <?php echo $this->element('../podcast_items/_view'); ?>
    <?php echo $this->element('../podcast_item_medias/_index'); ?>
    
</fieldset>

