<fieldset class="youtube">
	<legend>Youtube <img src="/img<?php echo $this->Object->getApprovalStatus( $this->data['Podcast'], 'youtube' ); ?>"/></legend>
	<ul class="youtube">
	    <li><a href="/" id="PodcastItemYoutubeToggle" class="youtube_toggler">Toggle</a></li>
	    <?php if( $this->Permission->toUpdate( $this->data ) ) : ?>
	    
			<?php if( ( $this->Permission->isYoutubeUser() == false ) && ( $this->Object->intendedForYoutube( $this->data['Podcast'] ) == false ) && ( $this->Object->considerForYoutube( $this->data['Podcast'] ) == false ) ) : ?>
			
				<li><a href="/podcasts/status/youtube/1/N/N/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubeSubmit" onclick="return confirm('You are about to submit this collection to the Youtube team for consideration. Do you wish to continue?');">Submit for Consideration</a></li>
				
			<?php elseif( $this->Permission->isYoutubeUser() ) : ?>			
				
				<?php if( $this->Object->intendedForYoutube( $this->data['Podcast'] ) == false ) : ?>			
				
					<li><a href="/podcasts/status/youtube/1/Y/N/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubeIntended" onclick="return confirm('You are about to approve this collection for publication on Youtube. Are you sure?');">Approve</a></li>

					<?php if( $this->Object->considerForYoutube( $this->data['Podcast'] ) ) : ?>
					
						<li><a href="/podcasts/status/youtube/0/N/N/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubeReject" onclick="return confirm('You are about to reject this collection. Are you sure?');">Reject</a></li>
						
					<?php endif; ?>

				<?php elseif( $this->Object->intendedForYoutube( $this->data['Podcast'] ) ) : ?>
				
					<li><a href="/podcasts/status/youtube/0/N/N/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubeReject" onclick="return confirm('You are about to set this collection as being removed from youtube and remove it\'s approved status. Are you sure?');">Unapprove</a></li>

					<?php if( $this->Object->youtubePublished( $this->data['Podcast'] ) == false ) : ?>			
			
						<li><a href="/podcasts/status/youtube/1/Y/Y/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubePublish" onclick="return confirm('You are about to set this collection as published on Youtube. Are you sure?');">Set as Published</a></li>
					
					<?php elseif( $this->Object->youtubePublished( $this->data['Podcast'] ) ) : ?>				
					
						<li><a href="/podcasts/status/youtube/1/Y/N/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubePublish" onclick="return confirm('You are about to set this collection as published on Youtube. Are you sure?');">Set as Unpublished</a></li>
					
					<?php endif; ?>	
					
				<?php endif; ?>
				
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
