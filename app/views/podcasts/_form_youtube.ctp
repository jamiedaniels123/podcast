<fieldset class="youtube">
	<legend>Youtube Specific</legend>
    <div class="youtube_container">
        <div class="input checkbox">
            <label for="PodcastPublishYoutube">Published</label>
            <input type="hidden" value="N" id="PodcastPublishYoutube_" name="data[Podcast][publish_youtube]">
            <input type="checkbox" id="PodcastPublishYoutube" value="Y" <?php echo (int)$this->data['Podcast']['publish_youtube'] == 'Y' ? 'checked="checked"' : ''; ?>" name="data[Podcast][publish_youtube]">
            <?php echo $this->Form->error('Podcast.publish_youtube'); ?>
        </div>
        <div class="input text">
            <label for="PodcastYoutubeChannel">Youtube Channel</label>
            <input type="text" id="PodcastYoutubeChannel" value="<?php echo $this->data['Podcast']['youtube_channel']; ?>" name="data[Podcast][youtube_channel]">
            <?php echo $this->Form->error('Podcast.youtube_channel'); ?>
        </div>
        
	</div>
</fieldset>