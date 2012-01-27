<div id="FormPodcastSummary" class="one_column">
    <input type="hidden" id="PodcastElement" name="data[Podcast][element]" value="<?php echo $element; ?>">
    <input type="hidden" id="PodcastId" name="data[Podcast][id]" value="<?php echo $this->data['Podcast']['id']; ?>">
    <input type="hidden" id="PodcastCustomId" name="data[Podcast][custom_id]" value="<?php echo $this->data['Podcast']['custom_id']; ?>">
    <input type="hidden" id="PodcastDeleted" name="data[Podcast][deleted]" value="<?php echo $this->data['Podcast']['deleted']; ?>">
    <input type="hidden" value="<?php echo $this->data['Podcast']['intended_itunesu_flag']; ?>" id="PodcastIntendedItunesuFlag" name="data[Podcast][intended_itunesu_flag]">
    <input type="hidden" value="<?php echo $this->data['Podcast']['intended_youtube_flag']; ?>" id="PodcastIntendedYoutubeFlag" name="data[Podcast][intended_youtube_flag]">    
    <input type="hidden" id="PodcastMediaLocation" name="data[Podcast][media_location]" value="<?php echo $this->data['Podcast']['media_location']; ?>">
    <input type="hidden" id="PodcastSyndicated" name="data[Podcast][syndicated]" value="<?php echo $this->data['Podcast']['syndicated']; ?>">
    <input type="hidden" id="PodcastCreated" name="data[Podcast][created]" value="<?php echo $this->data['Podcast']['created']; ?>">
    <input type="hidden" id="PreferredNodeTitle" name="data[PreferredNode][title]" value="<?php echo $this->data['PreferredNode']['title']; ?>">            
    <div <?php echo $element == 'summary' ? 'class="summary"' : 'style="display:none"'; ?>>

        <?php echo $this->element('../podcasts/_summary'); ?> 
        <?php echo $this->element('../podcasts/_form_summary'); ?> 
                
    </div>
    
    <div <?php echo $element == 'sharing' ? 'class="sharing"' : 'style="display:none"'; ?>>        
    
        <?php echo $this->element('../podcasts/_form_sharing'); ?>
        <?php echo $this->element('../podcasts/_sharing'); ?>

        
    </div>
    
    <div <?php echo $element == 'youtube' ? 'class="youtube"' : 'style="display:none"'; ?>>        
    
        <?php echo $this->element('../podcasts/_youtube'); ?>
        <?php echo $this->element('../podcasts/_form_youtube'); ?>
        
    </div>
    
    <div <?php echo $element == 'itunes' ? 'class="itunes"' : 'style="display:none"'; ?>>        
    
        <?php echo $this->element('../podcasts/_itunes'); ?>

        <?php if( $this->Permission->isItunesUser() ) : ?>
            
            <?php echo $this->element('../podcasts/_form_itunes'); ?>
            
        <?php else : ?>
        
            <?php echo $this->element('../podcasts/_form_itunes_lite'); ?>
            
        <?php endif; ?>
        
    </div>
    
    <div class="action_buttons track_save_cancel" id="PodcastUpdateButtonContainer" <?php echo isSet($edit_mode) == false ? 'style="display:none"' : ''; ?>>			
        <ul>
            <li><button id="PodcastUpdateButton" type="submit" class="button approve auto_select_and_submit"><span>Update</span></button></li>
            <li><button id="PodcastCancelButton" type="button" class="button cancel"><span>Cancel</span></button></li>
        </ul>
    </div>
</div>

