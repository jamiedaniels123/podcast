<fieldset class="youtube">
	<legend>Youtube Specific</legend>
	<dl>
	    <dt><a href="/" id="PodcastItemYoutubeToggle" class="youtube_toggler">Toggle</a></dt>
	    <dt>Published: </dt>
	    <dd><img src="/img<?php echo ( $this->data['Podcast']['publish_youtube'] == 'Y' ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" /></dd>
    </dl>		
	<div class="youtube_container youtube" style="display:none">
        <div class="input text">
            <label for="PodcastYoutubeChannel">Youtube Channel</label>
            <input type="text" id="PodcastYoutubeChannel" value="<?php echo $this->data['Podcast']['youtube_channel']; ?>" name="data[Podcast][youtube_channel]">
            <?php echo $this->Form->error('Podcast.youtube_channel'); ?>
        </div>
        
	</div>
</fieldset>