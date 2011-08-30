<form accept-charset="utf-8" action="/podcast_items/edit/<?php echo $this->data['PodcastItem']['id']; ?>" method="post" id="PodcastItemEditForm" enctype="multipart/form-data">
    <input type="hidden" id="PodcastItemId" value="<?php echo $this->data['PodcastItem']['id']; ?>" name="data[PodcastItem][id]">
    <input type="hidden" id="PodcastCourseCode" value="<?php echo trim( $this->data['Podcast']['course_code'] ); ?>" name="data[Podcast][course_code]">
    <input type="hidden" id="PodcastItemPodcastId" value="<?php echo $this->data['PodcastItem']['podcast_id']; ?>" name="data[PodcastItem][podcast_id]">
	<fieldset>
        <legend><h3><?php echo ucfirst( MEDIA ); ?></h3></legend>
        
        <img src="/img/collection-large.png" width="45" height="34" />
        
		<?php echo $this->element('../podcast_items/_form'); ?>
        <button id="update_podcast_item" type="submit"  class="button blue auto_select_and_submit">Update <?php echo MEDIA; ?></button>
    </fieldset>
</form>