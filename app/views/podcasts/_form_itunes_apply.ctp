<div class="input checkbox">
    <input type="hidden" value="N" id="PodcastIntendedItunesuFlag_" name="data[Podcast][intended_itunesu_flag]">
    <input type="checkbox" id="PodcastIntendedItunesuFlag" value="Y" <?php echo $this->data['Podcast']['intended_itunesu_flag'] == 'Y' ? 'checked="checked"' : '';?> name="data[Podcast][intended_itunesu_flag]">
    <label for="PodcastIntendedItunesuFlag">Intended for iTunes U</label>
    <?php echo $this->Form->error('Podcast.intended_itunesu_flag'); ?>
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