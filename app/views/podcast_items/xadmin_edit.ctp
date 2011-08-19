<form accept-charset="utf-8" action="/admin/podcast_items/edit/<?php echo $this->data['PodcastItem']['id']; ?>" method="post" id="PodcastItemEditForm" enctype="multipart/form-data">
    <input type="hidden" id="PodcastItemId" value="<?php echo $this->data['PodcastItem']['id']; ?>" name="data[PodcastItem][id]">
	<fieldset>
        <legend>Media : Administration</legend>
        <?php echo $this->element('../podcast_items/_form'); ?>
        <button id="update_podcast_item" type="submit">update podcast media</button>
	</fieldset>    
</form>