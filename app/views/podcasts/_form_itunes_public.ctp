<div id="FormPodcastItunesContainer" <?php echo isSet($edit_mode) == false ? 'style="display:none"' : ''; ?> class="float_left two_columnn">
	<!-- for public site only -->
	<div class="collection_input"><!-- iTunes U basic metadata-->
		<div class="text">
			<label for="PodcastItunesuSite">iTunes Site</label>
			<span>Public</span>
			<span class="tip-text">You can only change site if you have access permissions</br>to both Public and Private iTunes U sites.</span>
		</div>
	
		<div class="text">
			<label for="PodcastItunesUUrl">iTunes U URL</label>
			<input type="hidden" value="" id="PodcastItunesUUrl_" name="data[Podcast][itunes_u_url]">
			<input type="text" size="100" id="PodcastItunesUUrl" name="data[Podcast][itunes_u_url]" value="<?php echo $this->data['Podcast']['itunes_u_url']; ?>">
			<?php echo $this->Form->error('Podcast.itunes_u_url'); ?>
		</div>
	
		<div class="text">
			<label for="PodcastCourseCode">Course Code</label>
			<input type="text" size="10" id="PodcastCourseCode" value="<?php echo $this->data['Podcast']['course_code']; ?>" name="data[Podcast][course_code]">
			<span class="tip-text">Enter Course code that the Collection was derived from (if applicable).</span>
			<?php echo $this->Form->error('Podcast.course_code'); ?>
		</div>
		<div class="select">
			<label for="PodcastCourseType">Course Type</label>
			<select name="data[Podcast][course_type]" id="PodcastCourseType">
			<?php foreach( $course_types as $course_type ) : ?>
				<option value="<?php echo $course_type; ?>" <?php echo strtoupper( $this->data['Podcast']['course_type'] ) == $course_type ? 'selected="selected"' : ''; ?>><?php echo $course_type; ?></option>
			<?php endforeach; ?>
			</select>
			<span class="tip-text">Select Course level that the Collection was derived from (if applicable).</span>
			<?php echo $this->Form->error('Podcast.course_type'); ?>
		</div>
		<div class="checkbox">
			<label for="PodcastOpenlearnEpub">OpenLearn ePub</label>
			<input type="hidden" value="N" id="PodcastOpenlearnEpub_" name="data[Podcast][openlearn_epub]">
			<input type="checkbox" id="PodcastOpenlearnEpub" value="Y" <?php echo $this->data['Podcast']['openlearn_epub'] == 'Y' ? 'checked="checked"' : ''; ?> name="data[Podcast][openlearn_epub]">
			<span class="tip-text">If collection contains an OpenLearn ePub (if applicable). SPECIALIZED USE ONLY.</span>
			<?php echo $this->Form->error('Podcast.openlearn_epub'); ?>
		</div>
	</div>

	<div class="collection_input"><!--date metadata-->
	
		<div class="text">
			<label for="PodcastPublishItunesDate">iTunes U Publish Date</label>
			<input type="hidden" value="" id="PodcastPublishItunesDate_" name="data[Podcast][publish_itunes_date]">
			<input type="text" size="60" id="PodcastPublishItunesDate" value="<?php echo (int)$this->data['Podcast']['publish_itunes_date'] ? $this->data['Podcast']['publish_itunes_date'] : ''; ?>" class="datepicker" name="data[Podcast][publish_itunes_date]">
			<span class="tip-text">Set to the date that this Collection was FIRST PUBLISHED on iTunes U.</br>Used to create RSS feeds of Published iTunes U Collections.</span>
			<?php echo $this->Form->error('Podcast.publish_itunes_date'); ?>
		</div>
		<div class="text">
			<label for="PodcastUpdateItunesDate">iTunes U Updated Date</label>
			<input type="hidden" value="" id="PodcastUpdateItunesDate_" name="data[Podcast][update_itunes_date]">
			<input type="text" size="60" id="PodcastUpdateItunesDate" value="<?php echo (int)$this->data['Podcast']['update_itunes_date'] ? $this->data['Podcast']['update_itunes_date'] : ''; ?>" class="datepicker" name="data[Podcast][update_itunes_date]">
			<span class="tip-text">Set to the date that this Collection was LAST UPDATED on iTunes U.</br>Use the same date as first Published if never updated.</br>Used to create RSS feeds of Published iTunes U Collections.</span>
			<?php echo $this->Form->error('Podcast.update_itunes_date'); ?>
		</div>
	</div>
	<!--/end of meta-->

	<div class="collection_input"><!--artwork-->
		<div class="file">
			<div class="image">
				<div class="float_right text_right">
					<img src="<?php echo $this->Attachment->getMediaImage( $this->data['Podcast']['image_logoless'], $this->data['Podcast']['custom_id'], RESIZED_IMAGE_EXTENSION); ?>" title="thumbnail image" />
					<?php if( !empty( $this->data['Podcast']['image_logoless'] ) ) : ?>
					<div class="clear">
					</div>
						<a class="button delete" href="/podcasts/delete_image/image_logoless/<?php echo $this->data['Podcast']['id']; ?>" title="delete collection image" onclick="return confirm('Are you sure you wish to delete the iTunes logoless image?')">delete</a>
					<?php endif; ?>
				</div>
				<div class="text">
					<label for="PodcastNewImageLogoless">Logoless image</label>
					<input type="file" id="PodcastNewImageLogoless" name="data[Podcast][new_image_logoless]">
					<input type="hidden" id="PodcastImageLogoless" name="data[Podcast][image_logoless]" value="<?php echo $this->data['Podcast']['image_logoless']; ?>">
					<span class="tip-text">JPG or GIF only. Suggested size 1280 x 720 pixels.</span>
				</div>
				<?php echo $this->Form->error('Podcast.image_logoless'); ?>
				<div class="clear">
				</div>
			</div>
		</div>

		<div class="file">
			<div class="image">
				<div class="float_right text_right">
					<img src="<?php echo $this->Attachment->getMediaImage( $this->data['Podcast']['image_wide'], $this->data['Podcast']['custom_id'], RESIZED_IMAGE_EXTENSION); ?>" title="thumbnail image" />
					<?php if( !empty( $this->data['Podcast']['image_wide'] ) ) : ?>
					<div class="clear">
					</div>
					<a class="button delete" href="/podcasts/delete_image/image_wide/<?php echo $this->data['Podcast']['id']; ?>" title="delete collection image" onclick="return confirm('Are you sure you wish to delete the iTunes wide image?')">delete</a>
					<?php endif; ?>
				</div>
				<div class="float_left">
					<label for="PodcastNewImageWide">Widescreen Image</label>
					<input type="file" id="PodcastNewImageWide" name="data[Podcast][new_image_wide]">
					<input type="hidden" id="PodcastImageWide" name="data[Podcast][image_wide]" value="<?php echo $this->data['Podcast']['image_wide']; ?>">
					<span class="tip-text">JPG or GIF only. Suggested size 1280 x 720 pixels.</span>
				</div>
				<?php echo $this->Form->error('Podcast.image_wide'); ?>
				<div class="clear">
				</div>
			</div>
		</div>

		<div class="text">
			<label for="PodcastImageLlCopyright">Copyright/credit</label>
			<input type="text" size="100" id="PodcastImageLlCopyright" name="data[Podcast][image_ll_copyright]" value="<?php echo $this->data['Podcast']['image_ll_copyright']; ?>">
			<span class="tip-text">Any copyright or credit statement related to poster image.</span>
			<?php echo $this->Form->error('Podcast.image_ll_copyright'); ?>
		</div>

		<div class="file">
			<label for="PodcastNewArtworkFile">Artwork File</label>
			<input type="file" id="PodcastNewArtworkFile" name="data[Podcast][new_artwork_file]">
			<input type="hidden" id="PodcastArtworkFile" name="data[Podcast][artwork_file]" value="<?php echo $this->data['Podcast']['artwork_file']; ?>">
			<span class="tip-text">ZIP file containing a layered Photoshop file of cover artwork.</span>
			<?php echo $this->Form->error('Podcast.artwork_file'); ?>
		</div>

	</div><!--/end of artwork-->

	<!--INsert-->
	<div class="collection_input"><!--option transfers itunes u-->

		<div class="wrapper" id="ituneu_categories_container">

			<div class="float_left_list">
				<div class="select">
					<label for="iTuneCategories">Selected iTunes U Categories</label>
					<input type="hidden" name="data[iTuneCategories]" value="" id="iTuneCategories_" />
					<select name="data[iTuneCategories][]" class="selected" multiple="multiple" id="iTuneCategories">
						<?php if( isSet( $this->data['iTuneCategories'] ) && is_array( $this->data['iTuneCategories'] ) ) : ?>
						<?php foreach( $this->data['iTuneCategories'] as $category ) : ?>
						<option value="<?php echo $category['id']; ?>"><?php echo $category['code_title']; ?></option>
						<?php endforeach; ?>
						<?php endif; ?>
					</select>
					<?php echo $this->Form->error('Podcast.iTuneCategories'); ?>
					<div class="multiple-button">
						<div class="move float_right" data-source="iTuneCategories" data-target="PodcastAlliTuneCategories"><img src="/img/multiple-button-right.png" alt="Move right" class="icon" /></div>
					</div>
					<div class="clear"></div>
				</div><!--/select-->
			</div><!--/float_left-->

			<div class="float_left_list">
				<div class="select">
					<label for="PodcastAlliTuneCategories">All iTunes U Categories</label>
					<input type="hidden" name="data[Podcast][PodcastAlliTuneCategories]" value="" id="PodcastAlliTuneCategories_" />
					<select name="data[Podcast][PodcastAlliTuneCategories][]" multiple="multiple" id="PodcastAlliTuneCategories">
						<?php foreach( $itunes_categories as $id => $value ) : ?>
						<option value="<?php echo $id; ?>"><?php echo $value; ?></option>
						<?php endforeach; ?>
					</select>

					<div class="multiple-button">
						<div class="move float_left_list" data-source="PodcastAlliTuneCategories" data-target="iTuneCategories"><img src="/img/multiple-button-left.png" alt="Move left" class="icon" /></div>
					</div>
					<div class="clear"></div>
				</div><!--/select-->
			</div><!--/float_left-->

		</div><!--/end of ituneu categories container-->
		<div class="clear"></div>
	
	</div><!--/end of option transfers itunes u-->
	<div class="clear"></div>
	<!--/insert-->
</div>

