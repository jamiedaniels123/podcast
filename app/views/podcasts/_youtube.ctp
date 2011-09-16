<div id="PodcastYoutubeContainer" <?php echo isSet($edit_mode) ? 'style="display:none"' : ''; ?>>
    <div class="float_left one_column"><dl>
        <dt>Series Playlist:&nbsp;</dt>
        <dd><?php echo $this->data['Podcast']['youtube_series_playlist_text']; ?>&nbsp;</dd>
        <dt>Series Playlist Link:&nbsp;</dt>
        <dd><?php echo $this->data['Podcast']['youtube_series_playlist_link']; ?>&nbsp;</dd>
        <dt>Channel:&nbsp;</dt>
        <dd><?php echo $this->data['Podcast']['youtube_channel']; ?>&nbsp;</dd>
        <dt>Course Code:&nbsp;</dt>
        <dd><?php echo $this->data['Podcast']['course_code']; ?>&nbsp;</dd>
    </dl>
    </div>    

   	<div class="action_buttons track_save_cancel">
    	<ul>
        <?php if( $this->Permission->toUpdate( $this->data ) ) : ?>
	            <li><a href="/" class="jquery_display button blue"  data-source="PodcastYoutubeContainer" data-target="FormPodcastYoutubeContainer" id="PodcastYoutubeButton"><span>edit</span></a></li>
		<?php endif; ?>
        
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
        
                <?php endif; ?>
                        
            <?php endif; ?>
        </ul>
	</div>
</div>