<fieldset class="itunes">
	<legend>Youtube Specific</legend>
    <div class="input checkbox">
        <input type="hidden" value="N" id="PodcastItemYoutubeFlag_" name="data[PodcastItem][youtube_flag]">
        <input type="checkbox" id="PodcastItemYoutubeFlag" value="Y" <?php echo $this->data['PodcastItem']['youtube_flag'] == 'Y' ? 'checked="checked"' : '';?> name="data[PodcastItem][youtube_flag]">
        <label for="PodcastItemYoutubeFlag">Published?</label>
        <?php echo $this->Form->error('PodcastItem.youtube_flag'); ?>
    </div>
    <div class="input text">
        <label for="PodcastYoutubeTitle">Title</label>
        <input type="text" id="PodcastItemYoutubeTitle" name="data[PodcastItem][youtube_title]" value="<?php echo $this->data['PodcastItem']['youtube_title']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_title'); ?>
    </div>
</fieldset>