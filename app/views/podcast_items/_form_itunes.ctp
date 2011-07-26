<fieldset class="itunes">
	<legend>iTunes Specific</legend>
	<dl>
	    <dt><a href="/" id="PodcastItemItunesToggle" class="itunes_toggler">Toggle</a></dt>
	    <dt>Published: </dt>
	    <dd><img src="/img<?php echo $this->data['PodcastItem']['itunes_flag'] == YES ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" /></dd>
    </dl>
    <div class="wrapper itunes" style="display:none">		
	    <div class="input text">
	        <label for="PodcastItemEpubIsbn">ePub ISBN</label>
	        <input type="text" id="PodcastItemEpubIsbn" name="data[PodcastItem][epub_isbn]" value="<?php echo $this->data['PodcastItem']['epub_isbn']; ?>">
	        <?php echo $this->Form->error('PodcastItem.epub_isbn'); ?>
	    </div>
	    <div class="input text">
	        <label for="PodcastItemEpubStudyHours">ePub Study Hours</label>
	        <input type="text" id="PodcastItemEpubStudyHours" name="data[PodcastItem][epub_study_hours]" value="<?php echo $this->data['PodcastItem']['epub_study_hours']; ?>">
	        <?php echo $this->Form->error('PodcastItem.epub_study_hours'); ?>
	    </div>
	    <div class="input text">
	        <label for="PodcastItemEpubStudyLevel">ePub Study Level</label>
	        <input type="text" id="PodcastItemEpubStudyLevel" name="data[PodcastItem][epub_study_level]" value="<?php echo $this->data['PodcastItem']['epub_study_level']; ?>">
	        <?php echo $this->Form->error('PodcastItem.epub_study_level'); ?>
	    </div>
	    <div class="input text">
	        <label for="PodcastItemItunesTags">iTunes Tags</label>
	        <input type="text" id="PodcastItemItunesTags" name="data[PodcastItem][itunes_tags]" value="<?php echo $this->data['PodcastItem']['itunes_tags']; ?>">
	        <?php echo $this->Form->error('PodcastItem.itunes_tags'); ?>
	    </div>
	    <fieldset>
	        <legend>Explicit</legend>
	        <div class="input radio">
	            <input type="radio" value="yes" id="PodcastItemExplicit" <?php echo $this->data['PodcastItem']['explicit'] == 'yes' ? 'checked="checked"' : '';?> name="data[PodcastItem][explicit]">
	            <label for="PodcastItemExplicit">Yes</label>
	            <input type="radio" value="no" id="PodcastItemExplicit" <?php echo $this->data['PodcastItem']['explicit'] == 'no' ? 'checked="checked"' : '';?> name="data[PodcastItem][explicit]">
	            <label for="PodcastItemExplicit">No</label>
	            <input type="radio" value="clean" id="PodcastItemExplicit" <?php echo $this->data['PodcastItem']['explicit'] == 'clean' ? 'checked="checked"' : '';?> name="data[PodcastItem][explicit]">
	            <label for="PodcastItemExplicit">Clean</label>
	        </div>
	    </fieldset>
	    <div class="input text">
	        <label for="PodcastItemRightsIssues">Rights Issues</label>
	        <input type="text" id="PodcastItemRightsIssues" name="data[PodcastItem][rights_issues]" value="<?php echo $this->data['PodcastItem']['rights_issues']; ?>">
	        <?php echo $this->Form->error('PodcastItem.rights_issues'); ?>
	    </div>
	    <div class="input text">
	        <label for="PodcastItemRightsApproved">Rights Approved</label>
	        <input type="text" id="PodcastItemRightsApproved" name="data[PodcastItem][rights_approved]" value="<?php echo $this->data['PodcastItem']['rights_approved']; ?>">
	        <?php echo $this->Form->error('PodcastItem.rights_approved'); ?>
	    </div>
    </div>    
</fieldset>