<div id="PodcastItemSummaryContainer" class="preview" <?php echo isSet($edit_mode) ? 'style="display:none"' : ''; ?>>
    <div class="float_right images_container">
            <?php echo !empty( $this->data['Podcast']['image_copyright'] ) ? $this->data['Podcast']['image_copyright'] : 'Copyright Unknown'; ?>
	        <div class="clear"></div>
            <img src="<?php echo $this->Attachment->getMediaImage( $this->data['PodcastItem']['image_filename'].'.jpg', $this->data['Podcast']['custom_id'], RESIZED_IMAGE_EXTENSION ); ?>" title="podcast image" />
    </div>
     <div class="track_float_left track_two_column">
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
        <dt>Published Date: </dt>
        <dd><?php echo (int)$this->data['PodcastItem']['publication_date'] ? $this->Time->getPrettyLongDateTime( $this->data['PodcastItem']['publication_date'] ) : 'Unknown'; ?>&nbsp;</dd>
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
        <dt>Keywords: </dt>
        <dd><?php echo $this->data['PodcastItem']['itunes_tags']; ?>&nbsp;</dd>
    </dl>
    </div>
</div>
<div class="action_buttons track_save_cancel">
<?php 
if( $this->Permission->toUpdate( $this->data['Podcast'] ) ) : ?>
	
		<ul>
			<li>
				<button class="jquery_display edit_track button"  type="button" data-source="PodcastItemSummaryContainer" data-target="FormPodcastItemSummaryContainer" id="PodcastItemSummaryButton"><span>Edit</span></button>
			</li>
		</ul>
	           
<?php endif; ?>
</div> 
