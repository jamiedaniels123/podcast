<fieldset>
    <legend><h3><?php echo $this->data['PodcastItem']['title'];?> <?php echo MEDIA; ?></h3></legend>
    
    <img src="/img/collection-large.png" width="45" height="34" />
   
    <div class="clear"></div>    
    <?php echo $this->element('../podcast_items/_view'); ?>
    <?php echo $this->element('../podcast_item_medias/_index'); ?>
    
     <?php 
	if( $this->Permission->toUpdate( $this->data['Podcast'] ) ) : ?>
		<a href="/podcast_items/edit/<?php echo $this->data['PodcastItem']['id'];?>" title="edit" class="button blue">Edit <?php echo MEDIA; ?></a>
	<?php endif; ?>
    
</fieldset>

