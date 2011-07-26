<fieldset class="youtube">
	<legend>Youtube</legend>
	<input type="hidden" name="data[Podcast][publish_youtube]" id="PodcastPublishYoutube" value="<?php echo $this->data['Podcast']['publish_youtube']; ?>" />
	<dl>
	    <dt><a href="/" id="PodcastItemYoutubeToggle" class="youtube_toggler">Toggle details</a></dt>
	    <?php if( $this->Permission->isYoutubeUser() == false ) : ?>
		    <?php if( $this->data['Podcast']['consider_for_youtube'] ) : ?>
		    	<dt>This collection is currently under consideration by the youtube team</dt>
	    	<?php endif; ?>
		<?php endif; ?>	  	    
    </dl>		
	<div class="youtube_container youtube" style="display:none">
        <div class="input text">
            <label for="PodcastYoutubeChannel">Youtube Channel</label>
            <input type="text" id="PodcastYoutubeChannel" value="<?php echo $this->data['Podcast']['youtube_channel']; ?>" name="data[Podcast][youtube_channel]">
            <?php echo $this->Form->error('Podcast.youtube_channel'); ?>
        </div>
        
	</div>
</fieldset>