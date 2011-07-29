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
        <div class="input select">
            <label for="PodcastYoutubeChannel">Youtube Channel</label>
            <select name="data[Podcast][youtube_channel]" id="PodcastYoutubeChannel">
				<option value="">Please select</option>
				<?php foreach( $youtube_channels as $key => $value ) : ?>
					<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
				<?php endforeach; ?>
            </select>
            <?php echo $this->Form->error('Podcast.youtube_channel'); ?>
        </div>
        <div class="input text">
            <label for="PodcastCourseCode">Course Code</label>
            <input type="text" id="PodcastCourseCode" value="<?php echo $this->data['Podcast']['course_code']; ?>" name="data[Podcast][course_code]">
            <?php echo $this->Form->error('Podcast.course_code'); ?>
        </div>
	</div>
</fieldset>
