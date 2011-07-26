<fieldset class="youtube">
	<legend>Youtube</legend>
	<dl>
	    <dt><a href="/" id="PodcastItemYoutubeToggle" class="youtube_toggler">Toggle</a></dt>
	    <dt>Published: </dt>
	    <dd><img src="/img<?php echo $this->data['PodcastItem']['youtube_flag'] == YES ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" /></dd>
    </dl>
    <div class="wrapper youtube" style="display:none">		
    <div class="input text">
        <label for="PodcastItemYoutubeTitle">Title</label>
        <input type="text" id="PodcastItemYoutubeTitle" name="data[PodcastItem][youtube_title]" value="<?php echo $this->data['PodcastItem']['youtube_title']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_title'); ?>
    </div>
    <div class="input text">
        <label for="PodcastItemYoutubeTags">Tags</label>
        <input type="text" id="PodcastItemYoutubeTags" name="data[PodcastItem][youtube_tags]" value="<?php echo $this->data['PodcastItem']['youtube_tags']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_tags'); ?>
    </div>
    <div class="input text">
        <label for="PodcastItemGeoLocation">Geo Location</label>
        <input type="text" id="PodcastItemGeoLocation" name="data[PodcastItem][geo_location]" value="<?php echo $this->data['PodcastItem']['geo_location']; ?>">
        <?php echo $this->Form->error('PodcastItem.geo_location'); ?>
    </div>
</fieldset>