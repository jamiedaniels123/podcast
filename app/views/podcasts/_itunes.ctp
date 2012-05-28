<div id="PodcastItunesContainer" <?php echo isSet($edit_mode) ? 'style="display:none"' : ''; ?>>
	<?php if( $this->Object->intendedForItunes( $this->data['Podcast'] ) && strtoupper($this->data['Podcast']['itunesu_site']) == 'PUBLIC' ) : ?>
	<!-- Public site additional images -->
  <div class="float_right images_container">
    <div>
      <h2><?php echo ucfirst( PODCAST ); ?> Image Logoless</h2>
      <?php echo !empty( $this->data['Podcast']['image_ll_copyright'] ) ? $this->data['Podcast']['image_ll_copyright'] : 'Copyright Unknown'; ?>
      <div class="clear"></div>
      <img src="<?php echo $this->Attachment->getMediaImage( $this->data['Podcast']['image_logoless'], $this->data['Podcast']['custom_id'], THUMBNAIL_EXTENSION); ?>" title="podcast logoless image" />
    </div>
    <div>
      <h2><?php echo ucfirst( PODCAST ); ?> Image Wide</h2>
      <?php echo !empty( $this->data['Podcast']['image_wide_copyright'] ) ? $this->data['Podcast']['image_wide_copyright'] : 'Copyright Unknown'; ?>
      <div class="clear"></div>
      <img src="<?php echo $this->Attachment->getMediaImage( $this->data['Podcast']['image_wide'], $this->data['Podcast']['custom_id'], THUMBNAIL_EXTENSION); ?>" title="podcast wide image" />
    </div>
  </div>
	<?php endif; ?>
  <div class="float_left two_column" >
	<?php if( $this->Object->intendedForItunes( $this->data['Podcast'] ) ) : ?>
    <dl>
      <dt>iTunes U Site: </dt>
      <dd><?php echo ucfirst( $this->data['Podcast']['itunesu_site'] ); ?>&nbsp;</dd>
      <dt>Course Code: </dt>
      <dd><?php echo (!empty($this->data['Podcast']['course_code'])) ? $this->data['Podcast']['course_code'] : '-'; ?>&nbsp;</dd>
		<?php if( strtoupper($this->data['Podcast']['itunesu_site']) == 'PRIVATE' ) : ?>
      <!-- Private site fields -->
      <dt>Course Level: </dt>
      <dd><?php echo (!empty($this->data['Podcast']['course_type'])) ? $this->data['Podcast']['course_type'] : '-'; ?>&nbsp;</dd>
      <dt>iTunes U Feeds: </dt>
      <dt>&nbsp;&nbsp;&nbsp;Watermarked RSS Link: </dt>
      <dd><span class="rss_nobg"></span><a href="<?php echo DEFAULT_MEDIA_URL.FEEDS.$this->data['Podcast']['custom_id'].'/wm/rss2.xml'; ?>"><?php echo DEFAULT_MEDIA_URL.FEEDS.$this->data['Podcast']['custom_id'].'/wm/rss2.xml'; ?></a>&nbsp;</dd>
		<?php endif; ?>
      
    <?php if( strtoupper($this->data['Podcast']['itunesu_site']) == 'PUBLIC' ) : ?>
      <!-- Public site fields -->
      <dt>OpenLearn ePub: </dt>
      <dd><img src="/img<?php echo ( $this->data['Podcast']['openlearn_epub'] == 'Y' ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="openlearn status" />&nbsp;(for specialized purpose only)</dd>
      <dt>iTunes U Publish Date: </dt>
      <dd><?php echo $this->Time->getPrettyLongDate( $this->data['Podcast']['publish_itunes_date'] ); ?>&nbsp;</dd>
      <dt>iTunes U Updated Date: </dt>
      <dd><?php echo $this->Time->getPrettyLongDate( $this->data['Podcast']['update_itunes_date'] ); ?>&nbsp;</dd>
      <dt>iTunes U URL: </dt>
      <dd><?php echo (!empty($this->data['Podcast']['itunes_u_url'])) ? $this->data['Podcast']['itunes_u_url'] : 'n/a' ; ?>&nbsp;</dd>
      <dt>iTunes U Artwork File: </dt>
      <dd><?php echo $this->Attachment->getArtworkLink( $this->data['Podcast']['custom_id'], $this->data['Podcast']['artwork_file'] ); ?>&nbsp;</dd>                
      <dt>iTunes U Categories:</dt>
      <dd>
			<?php 
				foreach( $this->data['iTuneCategories'] as $itunesu_category ) :
					echo $itunesu_category['code_title'].'. ';
				endforeach; 
			?>
          &nbsp;
      </dd>
      <dt>iTunes U Feeds:</dt>
      <dt>&nbsp;&nbsp;&nbsp;SD RSS Link: </dt>
      <dd><span class="rss_nobg"></span><a href="<?php echo DEFAULT_MEDIA_URL.FEEDS.$this->data['Podcast']['custom_id'].'/ipod-all/rss2.xml'; ?>"><?php echo DEFAULT_MEDIA_URL.FEEDS.$this->data['Podcast']['custom_id'].'/ipod-all/rss2.xml'; ?></a>&nbsp;</dd>
      <dt>&nbsp;&nbsp;&nbsp;HD RSS Link: </dt>
      <dd><span class="rss_nobg"></span><a href="<?php echo DEFAULT_MEDIA_URL.FEEDS.$this->data['Podcast']['custom_id'].'/desktop-all/rss2.xml'; ?>"><?php echo DEFAULT_MEDIA_URL.FEEDS.$this->data['Podcast']['custom_id'].'/desktop-all/rss2.xml'; ?></a>&nbsp;</dd>
		<?php endif; ?>
    </dl>
	<?php elseif( $this->Object->considerForItunes( $this->data['Podcast'] ) ) : ?>
    <!-- iTunes U (public site) request pending -->
		<?php if( $this->Permission->isItunesUser() ) : ?>
    <p>Someone has requested this <?php echo ucfirst( PODCAST ); ?> be approved for use with iTunes U.  Only do this if this <?php echo ucfirst( PODCAST ); ?> is going to be used in iTunes U.</p>
		<?php else : ?>
    <p>This <?php echo ucfirst( PODCAST ); ?> is awaiting approval by the iTunes U (Public site) team.</p></br>
    <p>Contact: Catherine Chambers, iTunes U Producer, LTS.</p>
		<?php endif; ?>
	<?php else : ?>
    <!-- Regular collection - display upgrade option -->
		<?php if( $this->Permission->isItunesPublicUser() && $this->Permission->isItunesPrivateUser() ) : ?>
    <p>Upgrade this <?php echo ucfirst( PODCAST ); ?> for use in either the iTunes U <b>Public</b> or <b>Private</b> site.</p></br>
		<?php elseif( $this->Permission->isItunesPublicUser() ) : ?>
    <p>Upgrade this <?php echo ucfirst( PODCAST ); ?> for use in the iTunes U <b>Public</b> site.</p></br>
    <p class="tip">If you need to create an iTunes U Private site <?php echo ucfirst( PODCAST ); ?> you will need your permissions upgraded.</p>
		<?php elseif( $this->Permission->isItunesPrivateUser() ) : ?>
    <p>Upgrade this <?php echo ucfirst( PODCAST ); ?> for use in the iTunes U <b>Private</b> site.</p></br>
    <p class="tip">If you need to create an iTunes U Public site <?php echo ucfirst( PODCAST ); ?> you will need your permissions upgraded.</p>
		<?php elseif ( $this->Permission->toUpdate( $this->data ) ) : ?>
    <p>You can send a request to the iTunes U team for the inclusion of this <?php echo ucfirst( PODCAST ); ?> in the iTunes U Public site.</p>
    <p class="tip">It is recommended that you discuss this with the iTunes U team prior to submitting your request.</p></br>
    <p class="tip">Contact: Catherine Chambers, iTunes U Producer, LTS.</p>
		<?php else : ?>
    <p>A <?php echo ucfirst( PODCAST ); ?> maybe submitted for inclusion in the iTunes U Public site.</p></br>
    <p>To do so requires moderator permission for this <?php echo ucfirst( PODCAST ); ?>.</p>
		<?php endif; ?>	
	<?php endif; ?>
  </div>
  <div class="action_buttons track_save_cancel">
    <!-- iTunes U Action buttons -->
    <ul>
	<?php if( $this->Object->intendedForItunes( $this->data['Podcast'] ) ) : ?>
		<!-- Has been upgrade to iTunes U Collection -->
		<?php if( ( strtoupper($this->data['Podcast']['itunesu_site']) == 'PUBLIC' && $this->Permission->isItunesPublicUser() ) || ( strtoupper($this->data['Podcast']['itunesu_site']) == 'PRIVATE' && $this->Permission->isItunesPrivateUser() ) ) : ?>
			<!-- iTunes U Public site EDIT button -->
			<li><a href="/" class="jquery_display button edit"  data-source="PodcastItunesContainer" data-target="FormPodcastItunesContainer" id="PodcastItunesButton"><span>edit</span></a></li>
			<!-- Downgrade (remove) from iTunes U -->
			<li><a class="button unapprove" href="/itunes/podcasts/reject/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastItunesReject" onclick="return confirm('You are about to set this collection as being removed from iTunes U (<?php echo ucfirst( $this->data['Podcast']['itunesu_site'] ); ?>). Are you sure?');">Remove from iTunes U</a></li>
			
			<!-- Publish or Unpublish on iTunes U -->
			<?php if( $this->Object->itunesPublished( $this->data['Podcast'] ) == false ) : ?>			
			<li><a class="button approve" href="/itunes/podcasts/publish/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastItunesPublish" onclick="return confirm('You are about to set this collection as published on iTunes. Are you sure?');">Set as Published</a></li>
			<?php else : ?>				
			<li><a class="button unapprove" href="/itunes/podcasts/unpublish/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastItunesPublish" onclick="return confirm('You are about to set this collection as published on iTunes. Are you sure?');">Set as Unpublished</a></li>
			<?php endif; ?>
			
		<?php else : ?>
			<li>You do not have the relevant iTunes U permissions to edit this section.</li>
		<?php endif; ?>

	<?php else : ?>			
		<!-- Has NOT been upgraded to iTunes U Collection-->

		<?php if( $this->Permission->isItunesUser() ) : ?>
			<!-- iTunes U User options -->  
			<?php if( $this->Object->considerForItunes( $this->data['Podcast'] )) : ?>
			
				<?php if( $this->Permission->isItunesPublicUser() ) : ?>
			<!-- Approve/reject request for consideration -->
			<li><a class="button approve" href="/itunes/podcasts/approve/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastItunesIntended" onclick="return confirm('You are about to approve this collection for publication on iTunes U (Public). Are you sure?');">Approve request</a></li>
			<li><a class="button unapprove" href="/itunes/podcasts/reject/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastItunesReject" onclick="return confirm('You are about to reject this collection. Are you sure?');">Reject request</a></li>
			 	<?php else : ?>			
			<!-- Request Pending -->
			<li>Request for use in iTunes U (Public) site pending.</li>
				<?php endif; ?>
				
			<?php else : ?>			
			<!-- Not under consideration, offer Upgrade Collection option -->
			<li><a class="button approve" href="/itunes/podcasts/approve/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastItunesIntended" onclick="return confirm('You are about to upgrade this collection for use on iTunes U. Are you sure?');">Upgrade Collection</a></li>
			
			<?php endif; ?>
			
		<?php elseif( $this->Permission->toUpdate($this->data ) ) : ?>
			<!-- Regular User options -->
			<?php if( $this->Object->considerForItunes( $this->data['Podcast'] ) == false ) : ?>
			<!-- Submit for Consideration -->
			<li><a href="/podcasts/consider/itunes/<?php echo $this->data['Podcast']['id']; ?>" class="button itunes-icon" id="PodcastItunesSubmit" onclick="return confirm('You are about to submit this collection to the iTunes U (Public) team for consideration. Do you wish to continue?');">Submit for Consideration</a></li>
			<?php else : ?>
			<!-- Request Pending -->
			<li>Request for use in iTunes U (Public) site pending</li>
			<?php endif; ?>
		<?php endif; ?>

	<?php endif; ?>	
    </ul>
  </div>
</div>