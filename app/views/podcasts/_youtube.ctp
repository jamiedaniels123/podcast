<fieldset class="youtube">
	<legend>Youtube</legend>
	<dl>
	    <dt><a href="/" id="PodcastItemYoutubeToggle" class="youtube_toggler">Toggle details</a></dt>
	    <?php if( $this->Permission->isYoutubeUser() == false ) : ?>
		    <?php if( $this->data['Podcast']['consider_for_youtube'] ) : ?>
		    	<dt><?php echo $this->data['Podcast']['youtube_justification']; ?></dt>
		    <?php else : ?>
				<dt><a href="/podcasts/consider/youtube/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubeSubmit" onclick="return confirm('You are about to submit this collection to the youtube team so they may consider it for publication on Youtube. Are you sure you wish to continue?');">Submit to youtube team for consideration</a></dt>	    	
	    	<?php endif; ?>
		<?php endif; ?>	    	
    </dl>
    <div class="wrapper youtube" style="display:none">
	    <dl>
	        <dt>Channel: </dt>
	        <dd><?php echo $this->data['Podcast']['youtube_channel']; ?>&nbsp;</dd>
	    </dl>
    </div>    
</fieldset>