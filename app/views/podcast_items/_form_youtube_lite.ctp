<fieldset class="youtube">
	<legend>Youtube</legend>
	<dl>
	    <dt><a href="/" id="PodcastItemYoutubeToggle" data-target="PodcastItemYoutubeContainer" class="juggle">Toggle</a></dt>
	    <dt>Published: </dt>
	    <dd><img src="/img<?php echo $this->data['PodcastItem']['youtube_flag'] == YES ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" /></dd>
    </dl>
    <div id="PodcastItemYoutubeContainer" class="wrapper youtube" style="display:none">		
    <div class="input text">
        <label for="PodcastItemYoutubeTitle">Title</label>
        <input type="text" id="PodcastItemYoutubeTitle" name="data[PodcastItem][youtube_title]" value="<?php echo $this->data['PodcastItem']['youtube_title']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_title'); ?>
    </div>
    <div class="input text">
        <label for="PodcastItemYoutubeDescription">Description</label>
        <textarea id="PodcastItemYoutubeDescription" name="data[PodcastItem][youtube_description]"><?php echo $this->data['PodcastItem']['youtube_description']; ?></textarea>
        <a href="/" id="PodcastItemGenerateYoutubeDescription">Generate Description</a>
        <?php echo $this->Form->error('PodcastItem.youtube_description'); ?>
    </div>    
    <div class="input text">
        <label for="PodcastItemYoutubeOpenlearnLink">Open learn Link</label>
        <input type="text" id="PodcastItemYoutubeOpenLearnLink" name="data[PodcastItem][youtube_openlearn_link]" value="<?php echo $this->data['PodcastItem']['youtube_openlearn_link']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_openlearn_link'); ?>
    </div>
    <div class="input text">
        <label for="PodcastItemYoutubeLink1">Additonal Link (1)</label>
        <input type="text" id="PodcastItemYoutubeLink1" name="data[PodcastItem][youtube_link_1]" value="<?php echo $this->data['PodcastItem']['youtube_link_1']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_link_1'); ?>
    </div>
    <div class="input textarea">
        <label for="PodcastItemYoutubeLink1Text">Additonal Link (1) Text</label>
        <textarea id="PodcastItemYoutubeLink1Text" name="data[PodcastItem][youtube_link_1_text]"><?php echo $this->data['PodcastItem']['youtube_link_1_text']; ?></textarea>
        <?php echo $this->Form->error('PodcastItem.youtube_link_1_text'); ?>
    </div>
    <div class="input text">
        <label for="PodcastItemYoutubeLink2">Additonal Link (2)</label>
        <input type="text" id="PodcastItemYoutubeLink2" name="data[PodcastItem][youtube_link_2]" value="<?php echo $this->data['PodcastItem']['youtube_link_2']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_link_2'); ?>
    </div>
    <div class="input textarea">
        <label for="PodcastItemYoutubeLink2Text">Additonal Link (2) Text</label>
        <textarea id="PodcastItemYoutubeLink2Text" name="data[PodcastItem][youtube_link_2_text]"><?php echo $this->data['PodcastItem']['youtube_link_2_text']; ?></textarea>
        <?php echo $this->Form->error('PodcastItem.youtube_link_2_text'); ?>
    </div>
    <div class="input text">
        <label for="PodcastItemYoutubeLink3">Additonal Link (3)</label>
        <input type="text" id="PodcastItemYoutubeLink3" name="data[PodcastItem][youtube_link_3]" value="<?php echo $this->data['PodcastItem']['youtube_link_3']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_link_3'); ?>
    </div>
    <div class="input textarea">
        <label for="PodcastItemYoutubeLink3Text">Additonal Link (3) Text</label>
        <textarea id="PodcastItemYoutubeLink3Text" name="data[PodcastItem][youtube_link_3_text]"><?php echo $this->data['PodcastItem']['youtube_link_3_text']; ?></textarea>
        <?php echo $this->Form->error('PodcastItem.youtube_link_3_text'); ?>
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
	<div class="wrapper" id="youtube_subject_playlists_container">
		<div class="float_left">
			<div class="input select">
				<span class="move" data-source="YoutubeSubjectPlaylists" data-target="PodcastItemAllYoutubeSubjectPlaylists">Move &rarr;</span>
				<label for="YoutubeSubjectPlaylists">Subject Playlists</label>
				<select name="data[YoutubeSubjectPlaylists][]" class="selected" multiple="multiple" id="YoutubeSubjectPlaylists">
					<?php if( isSet( $this->data['YoutubeSubjectPlaylists'] ) && is_array( $this->data['YoutubeSubjectPlaylists'] ) ) : ?>
						<?php foreach( $this->data['YoutubeSubjectPlaylists'] as $playlist ) : ?>
							<option value="<?php echo $playlist['id']; ?>"><?php echo $playlist['title']; ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
				</select>
				<?php echo $this->Form->error('PodcastItem.YoutubeSubjectPlaylists'); ?>
			</div>
		</div>
		<div class="float_left">
			<div class="input select">
				<span class="move" data-source="PodcastItemAllYoutubeSubjectPlaylists" data-target="YoutubeSubjectPlaylists">&larr; Move</span>
				<label for="PodcastItemAllYoutubeSubjectPlaylists">All Playlists</label>
				<input type="hidden" name="data[Podcast][PodcastItemAllYoutubeSubjectPlaylists]" value="" id="PodcastItemAllYoutubeSubjectPlaylists_" />
				<select name="data[PodcastItem][AllYoutubeSubjectPlaylists][]" multiple="multiple" id="PodcastItemAllYoutubeSubjectPlaylists">
					<?php foreach( $youtube_subject_playlist as $id => $value ) : ?>
						<option value="<?php echo $id; ?>"><?php echo $value; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>
</fieldset>