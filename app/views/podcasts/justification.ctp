<fieldset>
    <legend>Justification View</legend>
    <?php if( !empty( $this->data['Podcast']['itunesu_justification'] ) && $this->Permission->isItunesUser() ) : ?>
        <fieldset id="itunesu_justification">
            <legend>iTunes Justification</legend>
            <?php echo $this->data['Podcast']['itunesu_justification']; ?>
            <div class="clear"></div>
            <a href="/podcasts/itunes/<?php echo $this->data['Podcast']['id']; ?>" id="edit_itunespodcast_<?php echo $podcast['Podcast']['id']; ?>">edit</a>
            <a href="/podcasts/approval/itunes/<?php echo $this->data['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to approve this podcast for itunesu?');" id="approve_itunes_podcast_<?php echo $podcast['Podcast']['id']; ?>">approve</a>
            <a href="/podcasts/rejection/itunes/<?php echo $this->data['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to reject this podcast for itunesu?');" id="reject_itunes_podcast_<?php echo $podcast['Podcast']['id']; ?>">reject</a>
        </fieldset>
    <?php endif; ?>
    <?php if( !empty( $this->data['Podcast']['youtube_justification'] ) && $this->Permission->isYouTubeUser() ) : ?>
        <fieldset id="youtube_justification">
            <legend>Youtube Justification</legend>
            <?php echo $this->data['Podcast']['youtube_justification']; ?>
            <div class="clear"></div>
            <a href="/podcasts/approval/youtube/<?php echo $this->data['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to approve this podcast for youtube?');" id="approve_youtube_podcast_<?php echo $podcast['Podcast']['id']; ?>">youtube approve</a>
            <a href="/podcasts/rejection/youtube/<?php echo $this->data['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to reject this podcast for youtube?');" id="reject_youtube_podcast_<?php echo $podcast['Podcast']['id']; ?>">youtube reject</a>
        </fieldset>
    <?php endif; ?>
    <?php echo $this->element('../podcasts/_view'); ?>
</fieldset>