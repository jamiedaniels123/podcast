<fieldset class="itunes youtube">
	<legend>iTunes &amp; Youtube Specific</legend>
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
</fieldset>