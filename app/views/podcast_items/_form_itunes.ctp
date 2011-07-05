<fieldset class="itunes">
	<legend>iTunes Specific</legend>
    <div class="input checkbox">
        <input type="hidden" value="N" id="PodcastItemItunesFlag_" name="data[PodcastItem][itunes_flag]">
        <input type="checkbox" id="PodcastItemItunesFlag" value="Y" <?php echo $this->data['PodcastItem']['itunes_flag'] == 'Y' ? 'checked="checked"' : '';?> name="data[PodcastItem][itunes_flag]">
        <label for="PodcastItemItunesFlag">Published?</label>
        <?php echo $this->Form->error('PodcastItem.itunes_flag'); ?>
    </div>
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
</fieldset>