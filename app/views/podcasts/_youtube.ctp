<div class="wrapper ">
<fieldset>
	<legend><h3>YouTube</h3></legend>
    
    <img src="/img/collection-youtube-large.png"  width="46" height="33" />
    
    <img src="/img<?php echo $this->Object->getApprovalStatus( $this->data['Podcast'], 'youtube' ); ?>" title="approval status" class="approval_status" />
    
    
		
    <div class="youtube" id="PodcastYoutubeContainer" style="display:none">
        <div class="float_right images_container">
			&nbsp;
        </div>
        <div class="float_left two_column">    
            <dl>
                <dt>Series Playlist: </dt>
                <dd><?php echo $this->data['Podcast']['youtube_series_playlist_text']; ?>&nbsp;</dd>
                <dt>Series Playlist Link: </dt>
                <dd><?php echo $this->data['Podcast']['youtube_series_playlist_link']; ?>&nbsp;</dd>
                <dt>Channel: </dt>
                <dd><?php echo $this->data['Podcast']['youtube_channel']; ?>&nbsp;</dd>
                <dt>Course Code: </dt>
                <dd><?php echo $this->data['Podcast']['course_code']; ?>&nbsp;</dd>
            </dl>    
        </div>
    </div>
    
   <div class="clear"></div>
   <div class="wrapper ">
   <ul class="youtube">
	    <li><a href="/" id="PodcastItemYoutubeToggle" data-target="PodcastYoutubeContainer" class="button open-close juggle">View</a></li>
	    <?php if( $this->Permission->toUpdate( $this->data ) && ( $this->Object->considerForYoutube( $this->data['Podcast'] ) == false ) && $this->Permission->isYoutubeUser() == false ) : ?>
        
				<li><a href="/podcasts/consider/youtube/<?php echo $this->data['Podcast']['id']; ?>" class="button white" id="PodcastYoutubeSubmit" onclick="return confirm('You are about to submit this collection to the Youtube team for consideration. Do you wish to continue?');">Submit for Consideration</a></li>

		<?php elseif( $this->Permission->isYoutubeUser() ) : ?>

            	<?php if( $this->Object->considerForYoutube( $this->data['Podcast'] ) == false && $this->Object->intendedForYoutube( $this->data['Podcast'] ) == false ) : ?>		

					<li><a class="button approve" href="/youtube/podcasts/approve/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubeIntended" onclick="return confirm('You are about to approve this collection for publication on Youtube. Are you sure?');">Approve</a></li>
			
				<?php elseif( $this->Object->considerForYoutube( $this->data['Podcast'] ) && $this->Object->intendedForYoutube( $this->data['Podcast'] ) == false ) : ?>			
				
					<li><a class="button approve" href="/youtube/podcasts/approve/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubeIntended" onclick="return confirm('You are about to approve this collection for publication on Youtube. Are you sure?');">Approve</a></li>

					<li><a class="button unapprove" href="/youtube/podcasts/reject/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubeReject" onclick="return confirm('You are about to reject this collection. Are you sure?');">Reject</a></li>
						
				<?php endif; ?>

				<?php if( $this->Object->intendedForYoutube( $this->data['Podcast'] ) ) : ?>
				
					<li><a class="button unapprove" href="/youtube/podcasts/reject/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubeReject" onclick="return confirm('You are about to set this collection as being removed from Youtube. Are you sure?');">Unapprove</a></li>

					<?php if( $this->Object->youtubePublished( $this->data['Podcast'] ) == false ) : ?>			
                
                            <li><a class="button approve" href="/youtube/podcasts/publish/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubePublish" onclick="return confirm('You are about to set this collection as published on Youtube. Are you sure?');">Set as Published</a></li>
                        
                    <?php elseif( $this->Object->youtubePublished( $this->data['Podcast'] ) ) : ?>				
                        
                            <li><a class="button unapprove" href="/youtube/podcasts/unpublish/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastYoutubePublish" onclick="return confirm('You are about to set this collection as published on Youtube. Are you sure?');">Set as Unpublished</a></li>
                        
                    <?php endif; ?>
                    
				<?php endif; ?>
				
			<?php endif; ?>

	    	</ul>
		</div>
	</fieldset>
</div>