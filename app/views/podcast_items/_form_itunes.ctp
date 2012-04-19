<div id="FormPodcastItemItunesContainer" class="preview" <?php echo isSet($edit_mode) == false ? 'style="display:none"' : ''; ?>>
	
	<!-- Hide epub fields as we current dont support the uploading of them.  Uncomment when we do 
	<div class="input">
    <div class="text">
        <label for="PodcastItemEpubIsbn">ePub ISBN</label>
        <input size="60" type="text" id="PodcastItemEpubIsbn" name="data[PodcastItem][epub_isbn]" value="<?php echo $this->data['PodcastItem']['epub_isbn']; ?>">
        <?php echo $this->Form->error('PodcastItem.epub_isbn'); ?>
    </div>
    <div class="text">
        <label for="PodcastItemEpubStudyHours">ePub Study Hours</label>
        <input size="60" type="text" id="PodcastItemEpubStudyHours" name="data[PodcastItem][epub_study_hours]" value="<?php echo $this->data['PodcastItem']['epub_study_hours']; ?>">
        <?php echo $this->Form->error('PodcastItem.epub_study_hours'); ?>
    </div>
    <div class="text">
        <label for="PodcastItemEpubStudyLevel">ePub Study Level</label>
        <input size="60" type="text" id="PodcastItemEpubStudyLevel" name="data[PodcastItem][epub_study_level]" value="<?php echo $this->data['PodcastItem']['epub_study_level']; ?>">
        <?php echo $this->Form->error('PodcastItem.epub_study_level'); ?>
    </div>
 
    </div>
   End of ePub fields --> 
   
       

        
         <div class="input"><!--explicit-->
         <label for="data[PodcastItem][explicit]">Explicit</label>
            <select name="data[PodcastItem][explicit]">
                <option value="yes" id="PodcastItemExplicit" <?php echo $this->data['PodcastItem']['explicit'] == 'yes' ? 'selected="true"' : '';?> name="data[PodcastItem][explicit]">
                <label for="PodcastItemExplicit">Yes</label>
                <option value="no" id="PodcastItemExplicit" <?php echo $this->data['PodcastItem']['explicit'] == 'no' ? 'selected="true"' : '';?> name="data[PodcastItem][explicit]">
                <label for="PodcastItemExplicit">No</label>
                <option value="clean" id="PodcastItemExplicit" <?php echo $this->data['PodcastItem']['explicit'] == 'clean' ? 'selected="true"' : '';?> name="data[PodcastItem][explicit]">
                <label for="PodcastItemExplicit">Clean</label>
            </select>
        </div><!--/end of explicit-->       

    
        <div class="input"><!--Rights-->
		<!-- Commented out as not requoired at the moment.
        <div class="text">
            <label for="PodcastItemRightsIssues">Rights Issues</label>
            <input size="60" type="text" id="PodcastItemRightsIssues" name="data[PodcastItem][rights_issues]" value="<?php echo $this->data['PodcastItem']['rights_issues']; ?>">
            <?php echo $this->Form->error('PodcastItem.rights_issues'); ?>
        </div>
        <div class="text">
            <label for="PodcastItemRightsApproved">Rights Approved</label>
            <input size="60" type="text" id="PodcastItemRightsApproved" name="data[PodcastItem][rights_approved]" value="<?php echo $this->data['PodcastItem']['rights_approved']; ?>">
            <?php echo $this->Form->error('PodcastItem.rights_approved'); ?>
        </div>
    
            <div class="text">
            <label for="PodcastItemRightsIssues">Archive Details</label>
            <input size="60" type="text" id="PodcastItemRightsIssues" name="data[PodcastItem][archive_details]" value="<?php echo $this->data['PodcastItem']['archive_details]']; ?>">
            <?php echo $this->Form->error('PodcastItem.archive_details'); ?>
        </div>
        <div class="text">
            <label for="PodcastItemRightsApproved">Music Details</label>
            <input size="60" type="text" id="PodcastItemRightsApproved" name="data[PodcastItem][music_details]" value="<?php echo $this->data['PodcastItem']['music_details']; ?>">
            <?php echo $this->Form->error('PodcastItem.music_details'); ?>
        </div>
		-->
    </div><!--/end of rights-->
   
    
</div>
