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
	<div class="clear"></div>
    <div class="input select">
        <label for="PodcastItemYoutubePrivacy">Privacy</label>
		<select name="data[PodcastItem][youtube_privacy]" id="PodcastItemYoutubePrivacy">
			<?php foreach( $youtube_privacy as $privacy ) : ?>
				<option value="<?php echo $privacy; ?>" <?php echo $privacy == $this->data['PodcastItem']['youtube_privacy'] ? 'selected="true"' : ''; ?>><?php echo $privacy; ?></option>
			<?php endforeach; ?>
		</select>
        <?php echo $this->Form->error('PodcastItem.youtube_privacy'); ?>
    </div>
	<div class="clear"></div>
    <div class="input select">
        <label for="PodcastItemYoutubeLicense">License</label>
		<select name="data[PodcastItem][youtube_license]" id="PodcastItemYoutubeLicense">
			<?php foreach( $youtube_licenses as $youtube_license ) : ?>
				<option value="<?php echo $youtube_license; ?>" <?php echo $youtube_license == $this->data['PodcastItem']['youtube_license'] ? 'selected="true"' : ''; ?>><?php echo $youtube_license; ?></option>
			<?php endforeach; ?>
		</select>
        <?php echo $this->Form->error('PodcastItem.youtube_license'); ?>
    </div>
    <div class="input select">
        <label for="PodcastItemYoutubeComments">Comments</label>
		<select name="data[PodcastItem][youtube_comments]" id="PodcastItemYoutubeComments">
			<?php foreach( $youtube_comments as $youtube_comment ) : ?>
				<option value="<?php echo $youtube_comment; ?>" <?php echo $youtube_comment == $this->data['PodcastItem']['youtube_comments'] ? 'selected="true"' : ''; ?>><?php echo $youtube_comment; ?></option>
			<?php endforeach; ?>
		</select>
        <?php echo $this->Form->error('PodcastItem.youtube_comments'); ?>
    </div>
    <div class="input select">
        <label for="PodcastItemYoutubeVoting">Voting</label>
		<select name="data[PodcastItem][youtube_voting]" id="PodcastItemYoutubeVoting">
			<option value="1" <?php echo (int)$this->data['PodcastItem']['youtube_voting'] == 1 ? 'selected="true"' : ''; ?>>Yes</option>
			<option value="0" <?php echo (int)$this->data['PodcastItem']['youtube_voting'] == 0 ? 'selected="true"' : ''; ?>>No</option>
		</select>
        <?php echo $this->Form->error('PodcastItem.youtube_voting'); ?>
    </div>
    <div class="input select">
        <label for="PodcastItemYoutubeVideoResponse">Video Response</label>
		<select name="data[PodcastItem][youtube_video_response]" id="PodcastItemYoutubeVideoResponse">
			<?php foreach( $youtube_video_responses as $youtube_video_response ) : ?>
				<option value="<?php echo $youtube_video_response; ?>" <?php echo $youtube_video_response == $this->data['PodcastItem']['youtube_video_response'] ? 'selected="true"' : ''; ?>><?php echo $youtube_video_response; ?></option>
			<?php endforeach; ?>
		</select>
        <?php echo $this->Form->error('PodcastItem.youtube_video_response'); ?>
    </div>    
    <div class="input select">
        <label for="PodcastItemYoutubeRatings">Ratings</label>
		<select name="data[PodcastItem][youtube_ratings]" id="PodcastItemYoutubeRatings">
			<option value="1" <?php echo (int)$this->data['PodcastItem']['youtube_ratings'] == 1 ? 'selected="true"' : ''; ?>>Yes</option>
			<option value="0" <?php echo (int)$this->data['PodcastItem']['youtube_ratings'] == 0 ? 'selected="true"' : ''; ?>>No</option>
		</select>
        <?php echo $this->Form->error('PodcastItem.youtube_ratings'); ?>
    </div>    
    <div class="input select">
        <label for="PodcastItemYoutubeEmbedding">Embedding Allowed</label>
		<select name="data[PodcastItem][youtube_embedding]" id="PodcastItemYoutubeEmbedding">
			<option value="1" <?php echo (int)$this->data['PodcastItem']['youtube_embedding'] == 1 ? 'selected="true"' : ''; ?>>Yes</option>
			<option value="0" <?php echo (int)$this->data['PodcastItem']['youtube_embedding'] == 0 ? 'selected="true"' : ''; ?>>No</option>
		</select>
        <?php echo $this->Form->error('PodcastItem.youtube_embedding'); ?>
    </div>    
    <div class="input select">
        <label for="PodcastItemYoutubeSyndication">Syndication</label>
		<select name="data[PodcastItem][youtube_syndication]" id="PodcastItemYoutubeSyndication">
			<option value="1" <?php echo (int)$this->data['PodcastItem']['youtube_syndication'] == 1 ? 'selected="true"' : ''; ?>>Yes</option>
			<option value="0" <?php echo (int)$this->data['PodcastItem']['youtube_syndication'] == 0 ? 'selected="true"' : ''; ?>>No</option>
		</select>
        <?php echo $this->Form->error('PodcastItem.youtube_syndication'); ?>
    </div>    
    
    <fieldset>
    	<legend>Management</legend>
	    <div class="input text">
	        <label for="PodcastItemYoutubeDirectLink">Direct Link</label>
	        <input type="text" id="PodcastItemYoutubeDirectLink" name="data[PodcastItem][youtube_direct_link]" value="<?php echo $this->data['PodcastItem']['youtube_direct_link']; ?>">
	        <?php echo $this->Form->error('PodcastItem.youtube_direct_link'); ?>
	    </div>    	
	    <div class="input text">
	        <label for="PodcastItemYoutubeDateUploaded">Date Uploaded</label>
	        <input type="text" id="PodcastItemYoutubeDateUploaded" name="data[PodcastItem][youtube_date_uploaded]" value="<?php echo $this->data['PodcastItem']['youtube_date_uploaded']; ?>">
	        <?php echo $this->Form->error('PodcastItem.youtube_date_uploaded'); ?>
	    </div>    	
	    <div class="input textarea">
	        <label for="PodcastItemYoutubeRightsCleared">Rights Cleared</label>
	        <textarea id="PodcastItemYoutubeRightsCleared" name="data[PodcastItem][youtube_rights_cleared]"><?php echo $this->data['PodcastItem']['youtube_rights_cleared']; ?></textarea>
	        <?php echo $this->Form->error('PodcastItem.youtube_rights_cleared'); ?>
	    </div>
        <div class="input select">
           <label for="PodcastItemYoutubeAdvertisingOverlay">Advertising Overlay</label>
		   <select name="data[PodcastItem][youtube_advertising_overlay]" id="PodcastItemYoutubeAdvertisingOverlay">
			   <option value="1" <?php echo (int)$this->data['PodcastItem']['youtube_advertising_overlay'] == 1 ? 'selected="true"' : ''; ?>>Yes</option>
			   <option value="0" <?php echo (int)$this->data['PodcastItem']['youtube_advertising_overlay'] == 0 ? 'selected="true"' : ''; ?>>No</option>
		   </select>
           <?php echo $this->Form->error('PodcastItem.youtube_advertising_overlay'); ?>
        </div>  
        <div class="input select">
           <label for="PodcastItemYoutubeContributorFormIncluded">Contributor Forms</label>
		   <select name="data[PodcastItem][youtube_contributor_forms_included]" id="PodcastItemYoutubeContributorFormIncluded">
			   <option value="1" <?php echo (int)$this->data['PodcastItem']['youtube_contributor_forms_included'] == 1 ? 'selected="true"' : ''; ?>>Yes</option>
			   <option value="0" <?php echo (int)$this->data['PodcastItem']['youtube_contributor_forms_included'] == 0 ? 'selected="true"' : ''; ?>>No</option>
		   </select>
           <?php echo $this->Form->error('PodcastItem.youtube_contributor_forms_included'); ?>
        </div>  
	    <div class="input text">
	        <label for="PodcastItemYoutubeProducedBy">Produced By</label>
	        <input type="text" id="PodcastItemYoutubeProducedBy" name="data[PodcastItem][youtube_produced_by]" value="<?php echo $this->data['PodcastItem']['youtube_produced_by']; ?>">
	        <?php echo $this->Form->error('PodcastItem.youtube_produced_by'); ?>
	    </div>    		      
	    <div class="input text">
	        <label for="PodcastItemYoutubeAcademicContact">Academic Contact</label>
	        <input type="text" id="PodcastItemYoutubeAcademicContact" name="data[PodcastItem][youtube_academic_contact]" value="<?php echo $this->data['PodcastItem']['youtube_academic_contact']; ?>">
	        <?php echo $this->Form->error('PodcastItem.youtube_academic_contact'); ?>
	    </div>    		      
	    <div class="input textarea">
	        <label for="PodcastItemYoutubeNotes">Notes</label>
	        <textarea id="PodcastItemYoutubeNotes" name="data[PodcastItem][youtube_notes]"><?php echo $this->data['PodcastItem']['youtube_notes']; ?></textarea>
	        <?php echo $this->Form->error('PodcastItem.youtube_notes'); ?>
	    </div>

    </fieldset>

</fieldset>
