<div id="FormPodcastItemYoutubeContainer" class="preview" <?php echo isSet($edit_mode) == false ? 'style="display:none"' : ''; ?>>
    
    <div class="input"><!--name and description-->
    
    <div class="text">
        <label for="PodcastItemYoutubeTitle">Title</label>
        <input size="60" type="text" id="PodcastItemYoutubeTitle" name="data[PodcastItem][youtube_title]" value="<?php echo $this->data['PodcastItem']['youtube_title']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_title'); ?>
    </div>
    <div class="text">
        <label for="PodcastItemYoutubeDescription">Description</label>
        <textarea cols="57" id="PodcastItemYoutubeDescription" name="data[PodcastItem][youtube_description]"><?php echo $this->data['PodcastItem']['youtube_description']; ?></textarea>
        <a href="/" id="PodcastItemGenerateYoutubeDescription">Generate Description</a>
        <?php echo $this->Form->error('PodcastItem.youtube_description'); ?>
    </div>   
    
    </div><!--/ end of name and description input-->
    
    <div class="input"><!--Linking info-->
     
    <div class="text">
        <label for="PodcastItemYoutubeOpenlearnLink">Open learn Link</label>
        <input size="60" type="text" id="PodcastItemYoutubeOpenLearnLink" name="data[PodcastItem][youtube_openlearn_link]" value="<?php echo $this->data['PodcastItem']['youtube_openlearn_link']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_openlearn_link'); ?>
    </div>
    <div class="text">
        <label for="PodcastItemYoutubeLink1">Additonal Link (1)</label>
        <input size="60" type="text" id="PodcastItemYoutubeLink1" name="data[PodcastItem][youtube_link_1]" value="<?php echo $this->data['PodcastItem']['youtube_link_1']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_link_1'); ?>
    </div>
    <div class="input textarea">
        <label for="PodcastItemYoutubeLink1Text">Additonal Link (1) Text</label>
        <textarea cols="57" id="PodcastItemYoutubeLink1Text" name="data[PodcastItem][youtube_link_1_text]"><?php echo $this->data['PodcastItem']['youtube_link_1_text']; ?></textarea>
        <?php echo $this->Form->error('PodcastItem.youtube_link_1_text'); ?>
    </div>
    <div class="text">
        <label for="PodcastItemYoutubeLink2">Additonal Link (2)</label>
        <input size="60" type="text" id="PodcastItemYoutubeLink2" name="data[PodcastItem][youtube_link_2]" value="<?php echo $this->data['PodcastItem']['youtube_link_2']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_link_2'); ?>
    </div>
    <div class="textarea">
        <label for="PodcastItemYoutubeLink2Text">Additonal Link (2) Text</label>
        <textarea cols="57" id="PodcastItemYoutubeLink2Text" name="data[PodcastItem][youtube_link_2_text]"><?php echo $this->data['PodcastItem']['youtube_link_2_text']; ?></textarea>
        <?php echo $this->Form->error('PodcastItem.youtube_link_2_text'); ?>
    </div>
    <div class="text">
        <label for="PodcastItemYoutubeLink3">Additonal Link (3)</label>
        <input size="60" type="text" id="PodcastItemYoutubeLink3" name="data[PodcastItem][youtube_link_3]" value="<?php echo $this->data['PodcastItem']['youtube_link_3']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_link_3'); ?>
    </div>
    <div class="textarea">
        <label for="PodcastItemYoutubeLink3Text">Additonal Link (3) Text</label>
        <textarea cols="57" id="PodcastItemYoutubeLink3Text" name="data[PodcastItem][youtube_link_3_text]"><?php echo $this->data['PodcastItem']['youtube_link_3_text']; ?></textarea>
        <?php echo $this->Form->error('PodcastItem.youtube_link_3_text'); ?>
    </div>
    
    </div><!--/end of linking info input-->
    
    <div class="input"><!--meta-->
    
    <div class="text">
        <label for="PodcastItemYoutubeTags">Tags</label>
        <input size="60" type="text" id="PodcastItemYoutubeTags" name="data[PodcastItem][youtube_tags]" value="<?php echo $this->data['PodcastItem']['youtube_tags']; ?>">
        <?php echo $this->Form->error('PodcastItem.youtube_tags'); ?>
    </div>
    <div class="text">
        <label for="PodcastItemGeoLocation">Geo Location</label>
        <input size="60" type="text" id="PodcastItemGeoLocation" name="data[PodcastItem][geo_location]" value="<?php echo $this->data['PodcastItem']['geo_location']; ?>">
        <?php echo $this->Form->error('PodcastItem.geo_location'); ?>
    </div>
    
    </div><!--/meta input-->
    
    
	<div class="input"><!--Select boxs-->
    
    	<div id="youtube_subject_playlists_container">
        
            <div class="float_left_list">
                <div class="input select">
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
                <div class="multiple-button">
                <div class="move float_right" data-source="YoutubeSubjectPlaylists" data-target="PodcastItemAllYoutubeSubjectPlaylists"><img src="/img/multiple-button-right.png" alt="Move right" class="icon" /></div>
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="float_left_list">
                <div class="input select">
                    <label for="PodcastItemAllYoutubeSubjectPlaylists">All Playlists</label>
                    <input type="hidden" name="data[Podcast][PodcastItemAllYoutubeSubjectPlaylists]" value="" id="PodcastItemAllYoutubeSubjectPlaylists_" />
                    <select name="data[PodcastItem][AllYoutubeSubjectPlaylists][]" multiple="multiple" id="PodcastItemAllYoutubeSubjectPlaylists">
                        <?php foreach( $youtube_subject_playlist as $id => $value ) : ?>
                            <option value="<?php echo $id; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                    <div class="multiple-button">
                    <div class="move float_left_list" data-source="PodcastItemAllYoutubeSubjectPlaylists" data-target="YoutubeSubjectPlaylists"><img src="/img/multiple-button-left.png" alt="Move right" class="icon" /></div>
                    </div>
                <div class="clear"></div>                
                
            </div>
    		<div class="clear"></div>
		
        </div><!--/end of youtube_subject_playlists_container-->

    </div><!--/end of select boxes-->
    
</div>