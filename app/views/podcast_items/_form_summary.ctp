<div id="FormPodcastItemSummaryContainer" class="preview" <?php echo isSet($edit_mode) == false ? 'style="display:none"' : ''; ?>>
    
    <div class="input">
    
        <div class="text form_title">
            <label for="PodcastItemTitle">Title</label>
            <input type="text" size="60" id="PodcastItemTitle" name="data[PodcastItem][title]" value="<?php echo $this->data['PodcastItem']['title']; ?>">
            <?php echo $this->Form->error('PodcastItem.title'); ?>
        </div>
    
        <div class="textarea">
            <label for="PodcastItemSummary">Summary</label>
            <textarea cols="57" id="PodcastItemSummary" name="data[PodcastItem][summary]"><?php echo $this->data['PodcastItem']['summary']; ?></textarea>
            <?php echo $this->Form->error('PodcastItem.summary'); ?>
        </div>
    
        <div class="text">
            <label for="PodcastItemAuthor">Author</label>
            <textarea id="PodcastItemAuthor" rows="1" cols="57"  name="data[PodcastItem][author]"><?php echo $this->data['PodcastItem']['author']; ?></textarea>
            <?php echo $this->Form->error('PodcastItem.author'); ?>
        </div>
    
        <div class="text">
            <label for="PodcastItemPublicationDate">Published Date</label>
            <input type="text" size="120" id="PodcastItemPublicationDate" value="<?php echo (int)$this->data['PodcastItem']['publication_date'] ? $this->data['PodcastItem']['publication_date'] : ''; ?>" class="datepicker" name="data[PodcastItem][publication_date]">
            <?php echo $this->Form->error('PodcastItem.publication_date'); ?>
        </div>
    
        <div class="text file">
    
                <div class="image wrapper">
                    <div class="float_right text_right">
                        <img size="50" src="<?php echo $this->Attachment->getMediaImage( $this->data['PodcastItem']['image_filename'].'.jpg', $this->data['Podcast']['custom_id'], RESIZED_IMAGE_EXTENSION ); ?>" />
                        <?php if( !empty( $this->data['PodcastItem']['image_filename'] ) ) : ?>
                            <div class="clear"></div>
                            <a href="/podcast_items/delete_attachment/image/<?php echo $this->data['PodcastItem']['id']; ?>" class="button delete ajax_link" title="delete image">delete image</a>
                        <?php endif; ?>
                    </div>
                    <div class="text">
                        <label for="PodcastItemImage">Item Image</label>
                        <input type="hidden" id="PodcastItemImageFilename" name="data[PodcastItem][image_filename]" value="<?php echo $this->data['PodcastItem']['image_filename']; ?>" />
                        <input type="file" size="60"  id="PodcastItemNewImageFilename" name="data[PodcastItem][new_image_filename]" />
                        <span class="tip-text">JPG or GIF only. PNGs not yet supported! 100 pixel square</span>
                    </div>            
                    <?php echo $this->Form->error('PodcastItem.image_filename'); ?>
                    <div class="clear"></div>
                </div>
    	</div>
    
    </div><!--/input-->
    
    <div class="input">
    
        <div class="text">
            <label for="PodcastItemUnitCourse">Unit Course</label>
            <input type="text" size="60"  id="PodcastItemUnitCourse" value="<?php echo $this->data['PodcastItem']['unit_course']; ?>" name="data[PodcastItem][unit_course]">
            <?php echo $this->Form->error('PodcastItem.unit_course'); ?>
        </div>
        
        <div class="text">
            <label for="PodcastItemUnitCourseTitle">Unit Course Title</label>
            <input type="text" size="60" id="PodcastItemUnitCourseTitle" value="<?php echo $this->data['PodcastItem']['unit_course_title']; ?>" name="data[PodcastItem][unit_course_title]">
            <?php echo $this->Form->error('PodcastItem.unit_course_title'); ?>
        </div>
        
        <div class="text">
            <label for="PodcastItemTargetUrl">Target URL</label>
            <input type="text" size="60" id="PodcastItemTargetUrl" name="data[PodcastItem][target_url]" value="<?php echo $this->data['PodcastItem']['target_url']; ?>">
            <?php echo $this->Form->error('PodcastItem.TargetUrl'); ?>
        </div>
        
        <div class="text">
            <label for="PodcastItemTargetUrlText">Target URL Text</label>
            <input type="text" size="60" id="PodcastItemTargetUrlText" name="data[PodcastItem][target_url_text]" value="<?php echo $this->data['PodcastItem']['target_url_text']; ?>">
            <?php echo $this->Form->error('PodcastItem.TargetUrlText'); ?>
        </div>
        
        <div class="file">
            <label for="TranscriptFilename">Transcript</label>
            <input type="hidden" id="TranscriptId" name="data[Transcript][id]" value="<?php echo $this->data['Transcript']['id']; ?>" >
            <input type="file" size="60"  id="TranscriptFilename" name="data[Transcript][new_filename]">
            <?php echo $this->Form->error('PodcastItem.filename'); ?>
            <?php if( !empty( $this->data['Transcript']['filename'] ) ) : ?>
                <a href="/podcast_item_medias/delete/<?php echo $this->data['Transcript']['id']; ?>" onclick="return confirm('Are you sure you wish to delete transcript?');" title="delete transcript">delete <i><?php echo $this->data['Transcript']['filename']; ?></i> transcript</a>
            <?php endif; ?>
            <div class="clear"></div>
        </div>
        
     </div><!--/input-->
     
</div>