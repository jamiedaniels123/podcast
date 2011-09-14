<form accept-charset="utf-8" action="/podcast_items/edit/<?php echo $this->data['PodcastItem']['id']; ?>" method="post" id="PodcastItemEditForm" enctype="multipart/form-data">
    <input type="hidden" id="PodcastItemId" value="<?php echo $this->data['PodcastItem']['id']; ?>" name="data[PodcastItem][id]">
    <input type="hidden" id="PodcastCourseCode" value="<?php echo trim( $this->data['Podcast']['course_code'] ); ?>" name="data[Podcast][course_code]">
    <input type="hidden" id="PodcastItemPodcastId" value="<?php echo $this->data['PodcastItem']['podcast_id']; ?>" name="data[PodcastItem][podcast_id]">
    <input type="hidden" id="PodcastId" name="data[Podcast][id]" value="<?php echo $this->data['Podcast']['id']; ?>">
    <input type="hidden" id="PodcastCustomId" name="data[Podcast][custom_id]" value="<?php echo $this->data['Podcast']['custom_id']; ?>">    
    <input type="hidden" id="PodcastTitle" name="data[Podcast][title]" value="<?php echo $this->data['Podcast']['title']; ?>">
    <input type="hidden" id="PodcastItemProcessedState" name="data[PodcastItem][processed_state]" value="<?php echo $this->data['PodcastItem']['processed_state']; ?>">
    <input type="hidden" id="PodcastItemFilename" name="data[PodcastItem][filename]" value="<?php echo $this->data['PodcastItem']['filename']; ?>">
    <input type="hidden" id="PodcastItemMediaPodcastItem" name="data[PodcastItemMedia][podcast_item]" value="<?php echo $this->data['PodcastItem']['id']; ?>">
    <input type="hidden" id="PodcastItemYoutubeFlag" name="data[PodcastItem][youtube_flag]" value="<?php echo $this->data['PodcastItem']['youtube_flag']; ?>">
    <input type="hidden" id="PodcastItemItunesFlag" name="data[PodcastItem][itunes_flag]" value="<?php echo $this->data['PodcastItem']['itunes_flag']; ?>">    
    <input type="hidden" id="PodcastItemElement" name="data[PodcastItem][element]" value="<?php echo $element; ?>">    

		<div class="summary" <?php echo $element == 'summary' ? '' : 'style="display:none"'; ?>>

			<?php echo $this->element('../podcast_items/_summary'); ?> 
			<?php echo $this->element('../podcast_items/_form_summary'); ?>
		</div>
		<div class="youtube" <?php echo $element == 'youtube' ? '' : 'style="display:none"'; ?>>

			<?php if( $this->Permission->isYoutubeUser() ) : ?>
				<?php echo $this->element('../podcast_items/_youtube'); ?>                 
                <?php echo $this->element('../podcast_items/_form_youtube'); ?>
            
            <?php else : ?>
    			<?php echo $this->element('../podcast_items/_youtube_lite'); ?>         
                <?php echo $this->element('../podcast_items/_form_youtube_lite'); ?>
                
            <?php endif; ?>
		</div>
		<div class="itunes" <?php echo $element == 'itunes' ? '' : 'style="display:none"'; ?>>
			<?php echo $this->element('../podcast_items/_itunes'); ?> 
			<?php echo $this->element('../podcast_items/_form_itunes'); ?> 
		</div>
		<div class="embed" <?php echo $element == 'embed' ? '' : 'style="display:none"'; ?>>
			<?php echo $this->element('../podcast_items/_embed'); ?> 
		</div>
        <div class="action_buttons" id="PodcastUpdateButtonContainer" <?php echo isSet($edit_mode) == false ? 'style="display:none"' : ''; ?>>
        	<ul>
	            <li><button id="PodcastItemSubmitButton" type="button"  class="save auto_select">Update <?php echo MEDIA; ?></button></li>
	            <li><a href="/" class="cancel" data-id="<?php echo $this->data['PodcastItem']['id']; ?>" id="PodcastItemCancelButton">Cancel</a></li>					
			</ul>
		</div>
</form>