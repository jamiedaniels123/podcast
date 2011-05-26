<fieldset>
    <legend>Media</legend>
    <input type="hidden" id="PodcastId" name="data[Podcast][id]" value="<?php echo $this->data['Podcast']['id']; ?>">
    <input type="hidden" id="PodcastTitle" name="data[Podcast][title]" value="<?php echo $this->data['Podcast']['title']; ?>">
    <input type="hidden" id="PodcastItemFilename" name="data[PodcastItem][filename]" value="<?php echo $this->data['PodcastItem']['filename']; ?>">
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
        <label for="PodcastItemTargetUrl">Item Link URL</label>
        <input type="text" id="PodcastItemTargetUrl" name="data[PodcastItem][target_url]" value="<?php echo $this->data['PodcastItem']['target_url']; ?>">
        <?php echo $this->Form->error('PodcastItem.TargetUrl'); ?>
    </div>
    <div class="input text">
        <label for="PodcastItemTargetUrlText">Item Link Text</label>
        <input type="text" id="PodcastItemTargetUrlText" name="data[PodcastItem][target_url_text]" value="<?php echo $this->data['PodcastItem']['target_url_text']; ?>">
        <?php echo $this->Form->error('PodcastItem.TargetUrlText'); ?>
    </div>
    <div class="input file">
        <label for="PodcastItemImage">Item Image</label>
        <input type="file" id="PodcastItemImage" name="data[PodcastItem][image]">
        <?php echo $this->Form->error('PodcastItem.image'); ?>
    </div>
    <div class="input checkbox">
        <input type="hidden" value="N" id="PodcastItemPublishedFlag_" name="data[PodcastItem][published_flag]">
        <input type="checkbox" id="PodcastItemPublishedFlag" value="Y" <?php echo $this->data['PodcastItem']['published_flag'] == 'Y' ? 'checked="checked"' : '';?> name="data[PodcastItem][published_flag]">
        <label for="PodcastItemPublishedFlag">Published?</label>
        <?php echo $this->Form->error('PodcastItem.publiished_flag'); ?>
    </div>
    <div class="input checkbox">
        <input type="hidden" value="N" id="PodcastItemYoutubeFlag_" name="data[PodcastItem][youtube_flag]">
        <input type="checkbox" id="PodcastItemYoutubeFlag" value="Y" <?php echo $this->data['PodcastItem']['youtube_flag'] == 'Y' ? 'checked="checked"' : '';?> name="data[PodcastItem][youtube_flag]">
        <label for="PodcastItemYoutubeFlag">YouTube?</label>
        <?php echo $this->Form->error('PodcastItem.youtube_flag'); ?>
    </div>
    <div class="input checkbox">
        <input type="hidden" value="N" id="PodcastItemItunesFlag_" name="data[PodcastItem][itunes_flag]">
        <input type="checkbox" id="PodcastItemItunesFlag" value="Y" <?php echo $this->data['PodcastItem']['itunes_flag'] == 'Y' ? 'checked="checked"' : '';?> name="data[PodcastItem][itunes_flag]">
        <label for="PodcastItemItunesFlag">iTunes?</label>
        <?php echo $this->Form->error('PodcastItem.itunes_flag'); ?>
    </div>
    <div class="input select">
        <label for="PodcastSubsection">Sub Section</label>
        <select id="PodcastSubsection" name="data[PodcastItem][subsection]">
            <option value="0">None</option>
        </select>
        <?php echo $this->Form->error('PodcastItem.subsection'); ?>
    </div>
    <div class="input text">
        <label for="PodcastItemPublicationDate">Publication Date</label>
        <input type="hidden" value="" id="PodcastItemPublicationDate_" name="data[PodcastItem][publication_date]">
        <input type="text" id="PodcastItemPublicationDate" value="<?php echo (int)$this->data['PodcastItem']['publication_date'] ? $this->data['PodcastItem']['publication_date'] : ''; ?>" class="datepicker" name="data[PodcastItem][publication_date]">
        <?php echo $this->Form->error('PodcastItem.publication_date'); ?>
    </div>
    <div class="input checkbox">
        <input type="hidden" value="N" id="PodcastItemAutoPublishFlag_" name="data[PodcastItem][auto_publish_flag]">
        <input type="checkbox" id="PodcastItemAutoPublishFlag" value="Y" <?php echo $this->data['PodcastItem']['auto_publish_flag'] == 'Y' ? 'checked="checked"' : '';?> name="data[PodcastItem][auto_publish_flag]">
        <label for="PodcastItemAutoPublishFlag">Automatically Publish?</label>
        <?php echo $this->Form->error('PodcastItem.auto_publish_flag'); ?>
    </div>
    <?php if( isSet( $this->params['admin'] ) || $this->Permission->isItunesUser() ) : ?>
        <fieldset>
            <legend>iTunes Explicit</legend>
            <div class="input radio">
                <input type="radio" value="yes" id="PodcastItemExplicit" <?php echo $this->data['PodcastItem']['explicit'] == 'yes' ? 'checked="checked"' : '';?> name="data[PodcastItem][explicit]">
                <label for="PodcastItemExplicit">Yes</label>
                <input type="radio" value="no" id="PodcastItemExplicit" <?php echo $this->data['PodcastItem']['explicit'] == 'no' ? 'checked="checked"' : '';?> name="data[PodcastItem][explicit]">
                <label for="PodcastItemExplicit">No</label>
                <input type="radio" value="clean" id="PodcastItemExplicit" <?php echo $this->data['PodcastItem']['explicit'] == 'clean' ? 'checked="checked"' : '';?> name="data[PodcastItem][explicit]">
                <label for="PodcastItemExplicit">Clean</label>
            </div>
        </fieldset>
    <?php endif; ?>
    <div class="input file">
        <label for="PodcastItemTranscript">Transcript</label>
        <input type="file" id="PodcastItemTranscript" name="data[PodcastItem][transcript]">
        <?php echo $this->Form->error('PodcastItem.transcript'); ?>
    </div>
</fieldset>