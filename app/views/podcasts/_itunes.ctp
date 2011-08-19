<div class="wrapper ">
<fieldset>
	<legend><h3>iTunes U</h3></legend>
    
    <img src="/img/collection-itunes-large.png"  width="46" height="33" />
    
    <img src="/img<?php echo $this->Object->getApprovalStatus( $this->data['Podcast'], 'itunes' ); ?>"/>
    


    <div class="itunes" id="PodcastItunesContainer" style="display:none">
        <div class="float_right images_container">
            <div>
                <h2><?php echo PODCAST; ?> Image Logoless</h2>
                <?php echo !empty( $this->data['Podcast']['image_ll_copyright'] ) ? $this->data['Podcast']['image_ll_copyright'] : 'Copyright Unknown'; ?>
                <div class="clear"></div>        
                <img src="<?php echo $this->Attachment->getMediaImage( $this->data['Podcast']['image_logoless'], $this->data['Podcast']['custom_id'], THUMBNAIL_EXTENSION); ?>" class="thumbnail" title="podcast logoless image" />
            </div>
            <div>
                <h2><?php echo PODCAST; ?> Image Wide</h2>
                <?php echo !empty( $this->data['Podcast']['image_wide_copyright'] ) ? $this->data['Podcast']['image_wide_copyright'] : 'Copyright Unknown'; ?>
                <div class="clear"></div>        
                <img src="<?php echo $this->Attachment->getMediaImage( $this->data['Podcast']['image_wide'], $this->data['Podcast']['custom_id'], THUMBNAIL_EXTENSION); ?>" class="thumbnail" title="podcast wide image" />
            </div>
    
        </div>
        <div class="float_left two_column">    
            <dl>
                <dt>Author: </dt>
                <dd><?php echo $this->data['Podcast']['author']; ?>&nbsp;</dd>
                <dt>Explicit: </dt>
                <dd><?php echo ucfirst( $this->data['Podcast']['explicit'] ); ?>&nbsp;</dd>
                <dt>iTunes URL: </dt>
                <dd><?php echo $this->data['Podcast']['itunes_u_url']; ?>&nbsp;</dd>
                <dt>Course Code: </dt>
                <dd><?php echo $this->data['Podcast']['course_code']; ?>&nbsp;</dd>
                <dt>Course Type: </dt>
                <dd><?php echo $this->data['Podcast']['course_type']; ?>&nbsp;</dd>
                <dt>iTunes Site: </dt>
                <dd><?php echo ucfirst( $this->data['Podcast']['itunesu_site'] ); ?>&nbsp;</dd>                
                <dt>Artwork File: </dt>
                <dd><?php echo $this->Attachment->getArtworkLink( $this->data['Podcast']['custom_id'], $this->data['Podcast']['artwork_file'] ); ?>&nbsp;</dd>                
                <dt>Open Learn ePub: </dt>
                <dd><img src="/img<?php echo ( $this->data['Podcast']['openlearn_epub'] == 'Y' ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="openlearn status" /></dd>
                <dt>Categories</dt>
                <dd>
                    <?php 
                    foreach( $this->data['Categories'] as $category ) :
                        echo $category['category'].'. ';
                    endforeach; 
                    ?>
                    &nbsp;
                </dd>   
                <dt>iTunes U Categories</dt>
                <dd>
                    <?php 
                    foreach( $this->data['iTuneCategories'] as $itunesu_category ) :
                        echo $itunesu_category['code_title'].'. ';
                    endforeach; 
                    ?>
                    &nbsp;
                </dd>                                 
                <dt>iTunes U Publish Date: </dt>
                <dd><?php echo $this->Time->getPrettyLongDate( $this->data['Podcast']['publish_itunes_date'] ); ?>&nbsp;</dd>
                <dt>iTunes U Updated Date: </dt>
                <dd><?php echo $this->Time->getPrettyLongDate( $this->data['Podcast']['update_itunes_date'] ); ?>&nbsp;</dd>
                <dt>iTunes U Target Date: </dt>
                <dd><?php echo $this->Time->getPrettyLongDate( $this->data['Podcast']['target_itunesu_date'] ); ?>&nbsp;</dd>
                <dt>Production Date: </dt>
                <dd><?php echo $this->Time->getPrettyLongDate( $this->data['Podcast']['production_date'] ); ?>&nbsp;</dd>
                <dt>Rights Date: </dt>
                <dd><?php echo $this->Time->getPrettyLongDate( $this->data['Podcast']['rights_date'] ); ?>&nbsp;</dd>
                <dt>Metadata Date: </dt>
                <dd><?php echo $this->Time->getPrettyLongDate( $this->data['Podcast']['metadata_date'] ); ?>&nbsp;</dd>
                <dt>Link: </dt>
                <dd><?php echo !$this->Object->intendedForItunes( $this->data['Podcast'] ) ? DEFAULT_MEDIA_URL.FEEDS.$this->data['Podcast']['custom_id'].'' : ''; ?>&nbsp;</dd>
                <dt>Desktop Link: </dt>
                <dd><?php echo !$this->Object->intendedForItunes( $this->data['Podcast'] ) ? DEFAULT_MEDIA_URL.FEEDS.$this->data['Podcast']['custom_id'].'/desktop-all' : ''; ?>&nbsp;</dd>
                <dt>Audio Link:</dt>
                <dd><?php echo !$this->Object->intendedForItunes( $this->data['Podcast'] ) ? DEFAULT_MEDIA_URL.FEEDS.$this->data['Podcast']['custom_id'].'/audio' : ''; ?>&nbsp;</dd>
                <dt>iPod Link: </dt>
                <dd><?php echo !$this->Object->intendedForItunes( $this->data['Podcast'] ) ? DEFAULT_MEDIA_URL.FEEDS.$this->data['Podcast']['custom_id'].'/ipod-all' : ''; ?>&nbsp;</dd>
                <dt>iTunesU URL: </dt>
                <dd><?php echo $this->data['Podcast']['itunes_u_url']; ?>&nbsp;</dd>

            </dl>    
        </div>
    </div>
    
	<div class="wrapper">
        <ul class="itunes">
	    <li><a href="/" id="PodcastItemItunesToggle" data-target="PodcastItunesContainer" class="button white juggle"><img class="icon" alt="sharing - ownership" src="/img/icon-16-open.png"> View</a></li>
	    <?php if( $this->Permission->toUpdate( $this->data ) && ( $this->Object->considerForItunes( $this->data['Podcast'] ) == false ) && $this->Permission->isItunesUser() == false ) : ?>
        
				<li><a href="/podcasts/consider/itunes/<?php echo $this->data['Podcast']['id']; ?>" class="button white" id="PodcastItunesSubmit" onclick="return confirm('You are about to submit this collection to the iTunes team for consideration. Do you wish to continue?');">Submit for Consideration</a></li>
                
		<?php elseif( $this->Permission->isItunesUser() ) : ?>

            	<?php if( $this->Object->considerForItunes( $this->data['Podcast'] ) == false && $this->Object->intendedForItunes( $this->data['Podcast'] ) == false ) : ?>		

					<li><a class="button approve" href="/itunes/podcasts/approve/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastItunesIntended" onclick="return confirm('You are about to approve this collection for publication on iTunes. Are you sure?');">Approve</a></li>
                
				<?php elseif( $this->Object->considerForItunes( $this->data['Podcast'] ) && $this->Object->intendedForItunes( $this->data['Podcast'] ) == false ) : ?>			
				
					<li><a class="button orange" href="/itunes/podcasts/approve/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastItunesIntended" onclick="return confirm('You are about to approve this collection for publication on iTunes. Are you sure?');">Approve</a></li>

					<li><a class="button orange" href="/itunes/podcasts/reject/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastItunesReject" onclick="return confirm('You are about to reject this collection. Are you sure?');">Reject</a></li>
						
				<?php endif; ?>

				<?php if( $this->Object->intendedForItunes( $this->data['Podcast'] ) ) : ?>
				
					<li><a class="button light-blue" href="/itunes/podcasts/reject/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastItunesReject" onclick="return confirm('You are about to set this collection as being removed from iTunes and remove it\'s approved status. Are you sure?');">Unapprove</a></li>
                    
					<?php if( $this->Object->itunesPublished( $this->data['Podcast'] ) == false ) : ?>			
                
                            <li><a class="button white" href="/itunes/podcasts/publish/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastItunesPublish" onclick="return confirm('You are about to set this collection as published on iTunes. Are you sure?');">Set as Published</a></li>
                        
                    <?php elseif( $this->Object->itunesPublished( $this->data['Podcast'] ) ) : ?>				
                        
                            <li><a class="button white" href="/itunes/podcasts/unpublish/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastItunesPublish" onclick="return confirm('You are about to set this collection as published on iTunes. Are you sure?');">Set as Unpublished</a></li>
                        
                    <?php endif; ?>
                    
				<?php endif; ?>
				
		<?php endif; ?>
			
    	</ul>
    </div>
    
    
</fieldset>
</div>
