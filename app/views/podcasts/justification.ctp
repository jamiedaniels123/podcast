<fieldset>
    <legend>Justification View</legend>
    <?php if( $this->Object->waitingItunesApproval( $this->data['Podcast'] ) ) : ?>
        <fieldset id="itunesu_justification">
            <legend>iTunes Justification</legend>
            <?php echo $this->data['Podcast']['itunesu_justification']; ?>
			<form accept-charset="utf-8" action="/podcasts/rejection" method="post" id="PodcastItuneJustificationForm" class="rejection" style="display:none">
	            <input type="hidden" name="data[Podcast][media_channel]" value="ITUNES" />
	            <input type="hidden" name="data[Podcast][id]" value="<?php echo $this->data['Podcast']['id']; ?>" />
	            <div class="input textarea">
                    <label for="PodcastItuneJustification">Reason for iTunes U rejection</label>
                    <textarea name="data[Podcast][justification]" id="PodcastItuneJustification"></textarea>
	            </div>
	            <div class="input submit">
                    <button type="submit"><span>submit rejection</span></button>
	            </div>
            </form>
            <div class="clear"></div>            
            <a href="/podcasts/approval/itunes/<?php echo $this->data['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to approve this podcast for itunesu?');" id="approve_itunes_podcast_<?php echo $this->data['Podcast']['id']; ?>">approve</a>
            <a href="/podcasts/rejection/itunes/<?php echo $this->data['Podcast']['id']; ?>" class="reject_podcast">reject</a>
        </fieldset>
    <?php endif; ?>
    <?php if( $this->Object->waitingYoutubeApproval( $this->data['Podcast'] ) ) : ?>
        <fieldset id="youtube_justification">
            <legend>Youtube Justification</legend>
            <?php echo $this->data['Podcast']['youtube_justification']; ?>
			<form accept-charset="utf-8" action="/podcasts/rejection" method="post" id="PodcastYoutubeJustificationForm" class="rejection" style="display:none">
	            <input type="hidden" name="data[Podcast][media_channel]" value="YOUTUBE" />
                <input type="hidden" name="data[Podcast][id]" value="<?php echo $this->data['Podcast']['id']; ?>" />
	            <div class="input textarea">
                    <label for="PodcastYoutubeJustification">Reason for Youtube rejection</label>
                    <textarea name="data[Podcast][justification]" id="PodcastYoutubeJustification"></textarea>
	            </div>
	            <div class="input submit">
                    <button type="submit"><span>submit rejection</span></button>
	            </div>
            </form>
            <div class="clear"></div>            
            <a href="/podcasts/approval/youtube/<?php echo $this->data['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to approve this podcast for youtube?');" class="approve_podcast">approve</a>
            <a href="/podcasts/rejection/youtube/<?php echo $this->data['Podcast']['id']; ?>" class="reject_podcast">reject</a>
        </fieldset>
    <?php endif; ?>
    <?php echo $this->element('../podcasts/_view'); ?>
    <div class="clear"></div>
    <?php echo $this->element('../podcast_items/_index'); ?>    
</fieldset>