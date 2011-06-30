<form accept-charset="utf-8" action="/podcast_items/edit/<?php echo $this->data['PodcastItem']['id']; ?>" method="post" id="PodcastItemEditForm" enctype="multipart/form-data">
    <input type="hidden" id="PodcastItemId" value="<?php echo $this->data['PodcastItem']['id']; ?>" name="data[PodcastItem][id]">
    <input type="hidden" id="PodcastItemPodcastId" value="<?php echo $this->data['PodcastItem']['podcast_id']; ?>" name="data[PodcastItem][podcast_id]">
    <p>
        Use the form below to update the meta data for the <em><?php echo $this->data['Podcast']['title']; ?></em> podcast
        media file <em><?php echo $this->data['PodcastItem']['filename']; ?></em>.
    </p>
	<fieldset>
        <legend>Media</legend>
		<?php echo $this->element('../podcast_items/_form'); ?>
        <button id="update_podcast_item" type="submit">update podcast media</button>
    </fieldset>
</form>