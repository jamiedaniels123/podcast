<div class="input checkbox">
    <input type="hidden" value="0" id="PodcastConsiderForItunesu_" name="data[Podcast][consider_for_itunesu]">
    <input type="checkbox" id="PodcastConsiderForItunesu" value="1" <?php echo $this->data['Podcast']['consider_for_itunesu'] ? 'checked="checked"' : '';?> name="data[Podcast][consider_for_itunesu]">
    <label for="PodcastConsiderForItunesu">Consider for iTunes U</label>
    <?php echo $this->Form->error('Podcast.consider_for_itunesu'); ?>
</div>
<div class="clear"></div>
<div class="input textarea itunes_container" style="display:none;">
    <label for="PodcastItunesJustification">Itunes Justification</label>
    <p>
        Please enter a short brief on why you believe this podcast is suiable for inclusion of iTunesU. Details will be passed to the
        iTunes team who will notify you of their decision.
    </p>
    <input type="hidden" value="" id="PodcastItunesuJustification_" name="data[Podcast][itunesu_justification]">
    <textarea id="summary" rows="6" cols="30" name="data[Podcast][itunesu_justification]"><?php echo $this->data['Podcast']['itunesu_justification']; ?></textarea>
    <?php echo $this->Form->error('Podcast.itunesu_justification'); ?>
</div>