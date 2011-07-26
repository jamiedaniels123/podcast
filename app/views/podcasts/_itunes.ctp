<fieldset class="itunes">
	<legend>iTunes</legend>
	<dl>
	    <dt><a href="/" id="PodcastItemItunesToggle" class="itunes_toggler">Toggle details</a></dt>
	    <?php if( $this->Permission->isItunesUser() == false ) : ?>
		    <?php if( $this->data['Podcast']['consider_for_itunesu'] ) : ?>
		    	<dt><?php echo $this->data['Podcast']['itunes_justification']; ?></dt>
		    <?php else : ?>
				<dt><a href="/podcasts/consider/itunes/<?php echo $this->data['Podcast']['id']; ?>" id="PodcastItunesSubmit" onclick="return confirm('You are about to submit this collection to the iTunes team so they may consider it for publication on iTunes. Are you sure you wish to continue?');">Submit to itunes team for consideration</a></dt>	    	
	    	<?php endif; ?>
		<?php endif; ?>	    	
    </dl>
    <div class="wrapper itunes" style="display:none">
        <div class="float_right images_container">
            <div>
                <h2>Collection Image Logoless</h2>
                <?php echo !empty( $this->data['Podcast']['image_ll_copyright'] ) ? $this->data['Podcast']['image_ll_copyright'] : 'Copyright Unknown'; ?>
                <div class="clear"></div>        
                <img src="<?php echo $this->Attachment->getMediaImage( $this->data['Podcast']['image_logoless'], $this->data['Podcast']['custom_id'], THUMBNAIL_EXTENSION); ?>" class="thumbnail" title="podcast logoless image" />
            </div>
            <div>
                <h2>Collection Image Wide</h2>
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
                <dt>iTunes Site: </dt>
                <dd><?php echo ucfirst( $this->data['Podcast']['itunesu_site'] ); ?>&nbsp;</dd>                
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
            </dl>    
        </div>
    </div>
</fieldset>