<div class="input checkbox">
    <input type="checkbox" id="PodcastConsiderForYoutube" value="1" <?php echo $this->data['Podcast']['consider_for_youtube'] ? 'checked="checked"' : '';?> name="data[Podcast][consider_for_youtube]">
    <label for="PodcastConsiderForYoutube">Consider for Youtube</label>
    <?php echo $this->Form->error('Podcast.consider_for_youtube'); ?>
</div>
<div class="clear"></div>
<div class="input textarea youtube_container" style="display:none;">
    <label for="PodcastYoutubeJustification">Youtube Justification</label>
    <p>
        Please enter a short brief on why you believe this podcast is suiable for inclusion on Youtube. Details will be passed to the
        Youtube team who will notify you of their decision.
    </p>
    <input type="hidden" value="" id="PodcastYoutubeJustification_" name="data[Podcast][youtube_justification]">
    <textarea id="summary" rows="6" cols="30" name="data[Podcast][youtube_justification]"><?php echo $this->data['Podcast']['youtube_justification']; ?></textarea>
    <?php echo $this->Form->error('Podcast.youtube_justification'); ?>
</div>