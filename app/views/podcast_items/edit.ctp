<form accept-charset="utf-8" action="/podcast_items/edit/<?php echo $this->data['PodcastItem']['id']; ?>" method="post" id="PodcastItemEditForm" enctype="multipart/form-data">
    <input type="hidden" id="PodcastItemId" value="<?php echo $this->data['PodcastItem']['id']; ?>" name="data[PodcastItem][id]">
    <input type="hidden" id="PodcastCourseCode" value="<?php echo trim( $this->data['Podcast']['course_code'] ); ?>" name="data[PodcastItem][course_code]">
    <input type="hidden" id="PodcastItemPodcastId" value="<?php echo $this->data['PodcastItem']['podcast_id']; ?>" name="data[PodcastItem][podcast_id]">
	<fieldset>
        <legend><span>Media</span></legend>
		<?php echo $this->element('../podcast_items/_form'); ?>
        <button id="update_podcast_item" type="submit"  class="button light-blue auto_select_and_submit">Update Collection Media</button>
    </fieldset>
</form>