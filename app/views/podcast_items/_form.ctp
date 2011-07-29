<input type="hidden" id="PodcastId" name="data[Podcast][id]" value="<?php echo $this->data['Podcast']['id']; ?>">
<input type="hidden" id="PodcastCustomId" name="data[Podcast][custom_id]" value="<?php echo $this->data['Podcast']['custom_id']; ?>">    
<input type="hidden" id="PodcastTitle" name="data[Podcast][title]" value="<?php echo $this->data['Podcast']['title']; ?>">
<input type="hidden" id="PodcastItemFilename" name="data[PodcastItem][filename]" value="<?php echo $this->data['PodcastItem']['filename']; ?>">
<input type="hidden" id="PodcastItemMediaPodcastItem" name="data[PodcastItemMedia][podcast_item]" value="<?php echo $this->data['PodcastItem']['id']; ?>">    
<div class="input text">
    <label for="PodcastItemTitle">Title</label>
    <input type="text" id="PodcastItemTitle" name="data[PodcastItem][title]" value="<?php echo $this->data['PodcastItem']['title']; ?>">
    <?php echo $this->Form->error('PodcastItem.title'); ?>
</div>
<div class="input textarea">
    <label for="PodcastItemSummary">Summary</label>
    <textarea id="PodcastItemSummary" name="data[PodcastItem][summary]"><?php echo $this->data['PodcastItem']['summary']; ?></textarea>
    <?php echo $this->Form->error('PodcastItem.summary'); ?>
</div>
<div class="input text">
    <label for="PodcastItemAuthor">Author</label>
    <textarea id="PodcastItemAuthor" name="data[PodcastItem][author]"><?php echo $this->data['PodcastItem']['author']; ?></textarea>
    <?php echo $this->Form->error('PodcastItem.author'); ?>
</div>
<div class="input checkbox">
    <input type="hidden" value="N" id="PodcastItemPublishedFlag_" name="data[PodcastItem][published_flag]">
    <input type="checkbox" id="PodcastItemPublishedFlag" value="Y" <?php echo $this->data['PodcastItem']['published_flag'] == 'Y' ? 'checked="checked"' : '';?> name="data[PodcastItem][published_flag]">
    <label for="PodcastItemPublishedFlag">Published?</label>
    <?php echo $this->Form->error('PodcastItem.publiished_flag'); ?>
</div>
<div class="input text">
    <label for="PodcastItemPublicationDate">Published Date</label>
    <input type="text" id="PodcastItemPublicationDate" value="<?php echo (int)$this->data['PodcastItem']['publication_date'] ? $this->data['PodcastItem']['publication_date'] : ''; ?>" class="datepicker" name="data[PodcastItem][publication_date]">
    <?php echo $this->Form->error('PodcastItem.publication_date'); ?>
</div>
<div class="input file">
    <img src="<?php echo $this->Attachment->getMediaImage( $this->data['PodcastItem']['image_filename'].'.jpg', $this->data['Podcast']['custom_id'], THUMBNAIL_EXTENSION ); ?>" />
    <?php if( !empty( $this->data['PodcastItem']['image_filename']) ) : ?>
	    <a href="/podcast_items/delete_attachment/image/<?php echo $this->data['PodcastItem']['id']; ?>" onclick="return confirm('Are you sure you wish to delete this image?');" title="delete image">delete image</a>
    <?php endif; ?>
    <label for="PodcastItemImage">Item Image</label>
    <input type="hidden" id="PodcastItemImageFilename" name="data[PodcastItem][image_filename]" value="<?php echo $this->data['PodcastItem']['image_filename']; ?>" />
    <input type="file" id="PodcastItemNewImageFilename" name="data[PodcastItem][new_image_filename]" />
    <?php echo $this->Form->error('PodcastItem.image_filename'); ?>
</div>
<div class="input text">
    <label for="PodcastItemUnitCourse">Unit Course</label>
    <input type="text" id="PodcastItemUnitCourse" value="<?php echo $this->data['PodcastItem']['unit_course']; ?>" name="data[PodcastItem][unit_course]">
    <?php echo $this->Form->error('PodcastItem.unit_course'); ?>
</div>
<div class="input text">
    <label for="PodcastItemUnitCourseTitle">Unit Course Title</label>
    <input type="text" id="PodcastItemUnitCourseTitle" value="<?php echo $this->data['PodcastItem']['unit_course_title']; ?>" name="data[PodcastItem][unit_course_title]">
    <?php echo $this->Form->error('PodcastItem.unit_course_title'); ?>
</div>
<div class="input text">
    <label for="PodcastItemTargetUrl">Target URL</label>
    <input type="text" id="PodcastItemTargetUrl" name="data[PodcastItem][target_url]" value="<?php echo $this->data['PodcastItem']['target_url']; ?>">
    <?php echo $this->Form->error('PodcastItem.TargetUrl'); ?>
</div>
<div class="input text">
    <label for="PodcastItemTargetUrlText">Target URL Text</label>
    <input type="text" id="PodcastItemTargetUrlText" name="data[PodcastItem][target_url_text]" value="<?php echo $this->data['PodcastItem']['target_url_text']; ?>">
    <?php echo $this->Form->error('PodcastItem.TargetUrlText'); ?>
</div>
<div class="input file">
    <label for="TranscriptFilename">Transcript</label>
    <input type="hidden" id=TranscriptId" name="data[Transcript][id]" value="<?php echo $this->data['Transcript']['id']; ?>" >
    <input type="file" id="TranscriptFilename" name="data[Transcript][new_filename]">
    <?php echo $this->Form->error('PodcastItem.filename'); ?>
    <?php if( !empty( $this->data['Transcript']['filename'] ) ) : ?>
	    <a href="/podcast_item_medias/delete/<?php echo $this->data['Transcript']['id']; ?>" onclick="return confirm('Are you sure you wish to delete transcript?');" title="delete transcript">delete <i><?php echo $this->data['Transcript']['filename']; ?></i> transcript</a>
    <?php endif; ?>
</div>
<?php echo $this->element('../podcast_items/_form_itunes'); ?>
<?php echo $this->element('../podcast_items/_form_youtube'); ?>

  
