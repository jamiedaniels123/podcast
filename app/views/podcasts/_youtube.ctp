<fieldset class="youtube">
	<legend>Youtube <img src="/img<?php echo $this->Object->getApprovalStatus( $this->data['Podcast'], 'youtube' ); ?>"/></legend>
	<ul class="itunes">
	    <li><a href="/" id="PodcastItemYoutubeToggle" class="youtube_toggler">Toggle</a></li>
	    
	    <?php if( $this->Permission->toUpdate( $this->data ) ) : ?>
	    
			<?php if( ( $this->Permission->isYoutubeUser() == false ) && ( $this->Object->youtubePublished( $this->data['Podcast'] ) == false ) && ( $this->Object->considerForYoutube( $this->data['Podcast'] ) == false ) ) : ?>
			
				<li><a href="/podcasts/consider/youtube/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubeSubmit" onclick="return confirm('You are about to submit this collection to the Youtube team for consideration. Do you wish to continue?');">Submit for Consideration</a></li>
				
			<?php elseif( $this->Permission->isYoutubeUser() && $this->Object->youtubePublished( $this->data['Podcast'] ) == false ) : ?>			
			
				<li><a href="/podcasts/publish/youtube/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubePublish" onclick="return confirm('You are about to publish this collection and approved media on Youtube. Are you sure?');">Publish</a></li>

				<?php if( $this->Object->considerForYoutube( $this->data['Podcast'] ) ) : ?>
				
					<li><a href="/podcasts/unpublish/youtube/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubeReject" onclick="return confirm('You are about to reject this collection. Are you sure?');">Reject</a></li>
				
				<?php endif; ?>
				
			<?php elseif( $this->Permission->isYoutubeUser() && $this->Object->youtubePublished( $this->data['Podcast'] ) ) : ?>			
			
				<li><a href="/podcasts/unpublish/youtube/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubeUnpublish" onclick="return confirm('You are about to remove this collection from Youtube. Are you sure?');">Unpublish</a></li>
				
			<?php endif; ?>
			
		<?php endif; ?>
    </ul>	
    <div class="wrapper youtube" style="display:none">
        <div class="float_right images_container">
			&nbsp;
        </div>
        <div class="float_left two_column">    
            <dl>
                <dt>Channel: </dt>
                <dd><?php echo $this->data['Podcast']['youtube_channel']; ?>&nbsp;</dd>
                <dt>Course Code: </dt>
                <dd><?php echo $this->data['Podcast']['course_code']; ?>&nbsp;</dd>
            </dl>    
        </div>
    </div>
</fieldset>
