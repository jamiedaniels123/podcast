<div class="wrapper" id="PodcastItemSummaryContainer">
    <div class="float_right images_container">
            <?php echo !empty( $this->data['Podcast']['image_copyright'] ) ? $this->data['Podcast']['image_copyright'] : 'Copyright Unknown'; ?>
        <div class="clear"></div>
            <!--<img src="<?php echo $this->Attachment->getMediaImage( $this->data['PodcastItem']['image_filename'].'.jpg', $this->data['Podcast']['custom_id'], RESIZED_IMAGE_EXTENSION ); ?>" title="podcast image" />-->
    </div>
    
    <div class="float_left two_column">
        <dl>
            <dt>Title: </dt>
            <dd><?php echo $this->data['PodcastItem']['title']; ?>&nbsp;</dd>
            <dt>Summary: </dt>
            <dd><?php echo nl2br( $this->data['PodcastItem']['summary'] ); ?>&nbsp;</dd>
            <dt>Author: </dt>
            <dd><?php echo $this->data['PodcastItem']['author']; ?>&nbsp;</dd>
            <dt>Created: </dt>
            <dd><?php echo $this->data['PodcastItem']['created'] ? $this->Time->getPrettyLongDate( $this->data['PodcastItem']['created'] ) : $this->Time->getPrettyShortDate( $this->data['PodcastItem']['created_when'] ); ?>&nbsp;</dd>
            <dt>Processed State</dt>
            <dd><?php echo $this->Object->getProcessedState( $this->data['PodcastItem']['processed_state'] ); ?></dd>
            <dt>Published: </dt>
            <dd><?php echo $this->data['PodcastItem']['published_flag'] == YES ? 'Yes' : 'No'; ?>&nbsp;</dd>
            <?php if( $this->data['PodcastItem']['published_flag'] == YES ) : ?>
				<dt>Published Date: </dt>
				<dd><?php echo (int)$this->data['PodcastItem']['publication_date'] ? $this->Time->getPrettyLongDate( $this->data['PodcastItem']['publication_date'] ) : 'Unknown'; ?>&nbsp;</dd>
            <?php endif; ?>
            <dt>Unit Course</dt>
            <dd><?php echo $this->data['PodcastItem']['unit_course']; ?>&nbsp;</dd>
            <dt>Unit Course Title</dt>
            <dd><?php echo $this->data['PodcastItem']['unit_course_title']; ?>&nbsp;</dd>
            <dt>Target URL</dt>
            <dd><?php echo $this->data['PodcastItem']['target_url']; ?>&nbsp;</dd>
            <dt>Target URL Text</dt>
            <dd><?php echo $this->data['PodcastItem']['target_url_text']; ?>&nbsp;</dd>
            <dt>Transcript</dt>
            <dd><?php echo $this->Attachment->getTranscriptLink( $this->data['Podcast']['custom_id'], $this->data['PodcastItem']['transcript_filename'] ); ?>			</dd>
            <dt>Parent Collection</dt>
            <dd><?php echo $this->data['Podcast']['title']; ?>&nbsp;</dd>
        </dl>
    </div>
</div>
<div class="clear"></div>
<div class="two-column-controls">
	<?php if( $this->Object->isPodcast( $this->data['Podcast']['podcast_flag'] ) ) : ?>
    
        <?php echo $this->element('../podcast_items/_itunes'); ?>
        
        <?php if( $this->Permission->isYoutubeUser() ) : ?>
            
            <?php echo $this->element('../podcast_items/_youtube'); ?>
        
        <?php else : ?>
        
            <?php echo $this->element('../podcast_items/_youtube_lite'); ?>
            
        <?php endif; ?>
        
    <?php endif; ?>
     <?php 
	if( $this->Permission->toUpdate( $this->data['Podcast'] ) ) : ?>
		<a href="/podcast_items/edit/<?php echo $this->data['PodcastItem']['id'];?>" title="edit" class="button edit">Edit <?php echo MEDIA; ?></a>
		<a class="button delete" href="/podcast_items/delete/<?php echo $this->data['PodcastItem']['id']; ?>" title="delete media" onclick="return confirm('Are you sure you wish to delete this media?');">Delete</a>
        
	<?php endif; ?>
