<fieldset class="youtube">
	<legend>Youtube</legend>
	<dl>
	    <dt><a href="/" id="PodcastItemYoutubeToggle" class="youtube_toggler">Toggle</a></dt>
    </dl>		
	<div class="youtube_container youtube" style="display:none">
        <div class="input text">
            <label for="PodcastYoutubeSeriesPlaylistText">Series Playlist</label>
            <input type="text" id="PodcastYoutubeSeriesPlaylistText" value="<?php echo $this->data['Podcast']['youtube_series_playlist_text']; ?>" name="data[Podcast][youtube_series_playlist_text]">
            <?php echo $this->Form->error('Podcast.youtube_series_playlist_text'); ?>
        </div>
        <div class="input text">
            <label for="PodcastYoutubeSeriesPlaylistLink">Series Playlist Link</label>
            <input type="text" id="PodcastYoutubeSeriesPlaylistLink" value="<?php echo $this->data['Podcast']['youtube_series_playlist_link']; ?>" name="data[Podcast][youtube_series_playlist_link]">
            <?php echo $this->Form->error('Podcast.youtube_series_playlist_link'); ?>
        </div>
        <div class="input select">
            <label for="PodcastYoutubeChannel">Youtube Channel</label>
            <select name="data[Podcast][youtube_channel]" id="PodcastYoutubeChannel">
				<option value="">Please select</option>
				<?php foreach( $youtube_channels as $key => $value ) : ?>
					<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
				<?php endforeach; ?>
            </select>
            <?php echo $this->Form->error('Podcast.youtube_channel'); ?>
        </div>
        <div class="input text">
            <label for="PodcastCourseCode">Course Code</label>
            <input type="text" id="PodcastCourseCode" value="<?php echo $this->data['Podcast']['course_code']; ?>" name="data[Podcast][course_code]">
            <?php echo $this->Form->error('Podcast.course_code'); ?>
        </div>
	</div>
</fieldset>
