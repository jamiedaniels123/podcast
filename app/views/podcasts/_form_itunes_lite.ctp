<div id="FormPodcastItunesContainer"
<?php echo isSet($edit_mode) == false ? 'style="display:none"' : ''; ?>>
	<!-- fields only for both private and public sites -->
	<div class="select">
		<label for="PodcastItunesuSite">iTunes Site</label> <select
			name="data[Podcast][itunesu_site]" id="PodcastItunesuSite">
			<option value="Private"
			<?php echo strtoupper( $this->data['Podcast']['itunesu_site'] ) == 'PRIVATE' ? 'selected="selected"' : ''; ?>>Private</option>
			<option value="Public"
			<?php echo strtoupper( $this->data['Podcast']['itunesu_site'] ) == 'PUBLIC' ? 'selected="selected"' : ''; ?>>Public</option>
		</select>
		<?php echo $this->Form->error('Podcast.itunes_site'); ?>
	</div>
	<div class="text">
		<label for="PodcastCourseCode">Course Code</label> <input type="text"
			size="60" id="PodcastCourseCode"
			value="<?php echo $this->data['Podcast']['course_code']; ?>"
			name="data[Podcast][course_code]">
		<?php echo $this->Form->error('Podcast.course_code'); ?>
	</div>
	<div class="select">
		<label for="PodcastCourseType">Course Level</label> <select
			name="data[Podcast][course_type]" id="PodcastCourseType">
			<?php foreach( $course_types as $course_type ) : ?>
			<option value="<?php echo $course_type; ?>"
			<?php echo strtoupper( $this->data['Podcast']['course_type'] ) == $course_type ? 'selected="selected"' : ''; ?>>
				<?php echo $course_type; ?>
			</option>
			<?php endforeach; ?>
		</select>
		<?php echo $this->Form->error('Podcast.course_type'); ?>
	</div>




	<!-- fields only for public site -->
	<?php if( $this->Permission->isItunesUser() ) : ?>
	<div class="file">
		<div class="image thumbnail wrapper">
			<div class="float_right text_right">
				<img
					src="<?php echo $this->Attachment->getMediaImage( $this->data['Podcast']['image_logoless'], $this->data['Podcast']['custom_id'], RESIZED_IMAGE_EXTENSION); ?>"
					title="thumbnail image" />
				<?php if( !empty( $this->data['Podcast']['image_logoless'] ) ) : ?>
				<div class="clear"></div>
				<a class="button delete"
					href="/podcasts/delete_image/image_logoless/<?php echo $this->data['Podcast']['id']; ?>"
					title="delete collection image"
					onclick="return confirm('Are you sure you wish to delete the iTunes logoless image?')">delete</a>
				<?php endif; ?>
			</div>
			<div class="float_left">
				<label for="PodcastNewImageLogoless">Logoless image</label> <input
					type="file" id="PodcastNewImageLogoless"
					name="data[Podcast][new_image_logoless]"> <input type="hidden"
					id="PodcastImageLogoless" name="data[Podcast][image_logoless]"
					value="<?php echo $this->data['Podcast']['image_logoless']; ?>"> <span
					class="tip-text">JPG or GIF only. PNGs not yet supported! 100 pixel
					square</span>
			</div>
			<?php echo $this->Form->error('Podcast.image_logoless'); ?>
			<div class="clear"></div>
		</div>
	</div>
	<div class="text">
		<label for="PodcastImageLlCopyright">Copyright/credit</label> <input
			type="text" size="60" id="PodcastImageLlCopyright"
			name="data[Podcast][image_ll_copyright]"
			value="<?php echo $this->data['Podcast']['image_ll_copyright']; ?>">
		<?php echo $this->Form->error('Podcast.image_ll_copyright'); ?>
	</div>
	<div class="file">
		<div class="image thumbnail wrapper">
			<div class="float_right text_right">
				<img
					src="<?php echo $this->Attachment->getMediaImage( $this->data['Podcast']['image_wide'], $this->data['Podcast']['custom_id'], RESIZED_IMAGE_EXTENSION); ?>"
					title="thumbnail image" />
				<?php if( !empty( $this->data['Podcast']['image_wide'] ) ) : ?>
				<div class="clear"></div>
				<a class="button delete"
					href="/podcasts/delete_image/image_wide/<?php echo $this->data['Podcast']['id']; ?>"
					title="delete collection image"
					onclick="return confirm('Are you sure you wish to delete the iTunes wide image?')">delete</a>
				<?php endif; ?>
			</div>
			<div class="float_left">
				<label for="PodcastNewImageWide">Widescreen Image</label> <input
					type="file" id="PodcastNewImageWide"
					name="data[Podcast][new_image_wide]"> <input type="hidden"
					id="PodcastImageWide" name="data[Podcast][image_wide]"
					value="<?php echo $this->data['Podcast']['image_wide']; ?>"> <span
					class="tip-text">JPG or GIF only. PNGs not yet supported! 100 pixel
					square</span>
			</div>
			<?php echo $this->Form->error('Podcast.image_wide'); ?>
			<div class="clear"></div>
		</div>
	</div>
	<div class="text">
		<label for="PodcastImageWideCopyright">Copyright/credit</label> <input
			type="text" size="60" id="PodcastImageWideCopyright"
			name="data[Podcast][image_wide_copyright]"
			value="<?php echo $this->data['Podcast']['image_wide_copyright']; ?>">
		<?php echo $this->Form->error('Podcast.image_wide_copyright'); ?>
	</div>
	<div class="file">
		<label for="PodcastNewArtworkFile">Artwork File</label> <input
			type="file" id="PodcastNewArtworkFile"
			name="data[Podcast][new_artwork_file]"> <input type="hidden"
			id="PodcastArtworkFile" name="data[Podcast][artwork_file]"
			value="<?php echo $this->data['Podcast']['artwork_file']; ?>">
		<?php echo $this->Form->error('Podcast.artwork_file'); ?>
	</div>
	<div class="text">
		<label for="PodcastAuthor">Author</label> <input type="text" size="60"
			id="PodcastAuthor"
			value="<?php echo $this->data['Podcast']['author']; ?>"
			name="data[Podcast][author]">
		<?php echo $this->Form->error('Podcast.author'); ?>
	</div>
	<div class="select">
		<label for="PodcastExplicit">Explicit</label> <select
			name="data[Podcast][explicit]" id="PodcastExplicit">
			<option value="clean">Clean</option>
		</select>
		<?php echo $this->Form->error('Podcast.explicit'); ?>
	</div>


	<div class="checkbox">
		<label for="PodcastOpenlearnEpub">Open Learn ePub</label> <input
			type="hidden" value="N" id="PodcastOpenlearnEpub_"
			name="data[Podcast][openlearn_epub]"> <input type="checkbox"
			id="PodcastOpenlearnEpub" value="Y"
			<?php echo $this->data['Podcast']['openlearn_epub'] == 'Y' ? 'checked="checked"' : ''; ?>" name="data[Podcast][openlearn_epub]">
		<?php echo $this->Form->error('Podcast.openlearn_epub'); ?>
	</div>


	<div class="clear"></div>
	<div class="wrapper" id="ituneu_categories_container">
		<div class="float_left">
			<div class="select">
				<label for="iTuneCategories">Podcast iTunes U Categories</label> <input
					type="hidden" name="data[iTuneCategories]" value=""
					id="iTuneCategories_" /> <select name="data[iTuneCategories][]"
					class="selected" multiple="multiple" id="iTuneCategories">
					<?php if( isSet( $this->data['iTuneCategories'] ) && is_array( $this->data['iTuneCategories'] ) ) : ?>
					<?php foreach( $this->data['iTuneCategories'] as $category ) : ?>
					<option value="<?php echo $category['id']; ?>">
						<?php echo $category['code_title']; ?>
					</option>
					<?php endforeach; ?>
					<?php endif; ?>
				</select>
				<?php echo $this->Form->error('Podcast.iTuneCategories'); ?>
				<div class="multiple-button">
					<div class="move float_right" data-source="iTuneCategories"
						data-target="PodcastAlliTuneCategories">
						<img src="/img/multiple-button-right.png" alt="Move right"
							class="icon" />
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<div class="float_left">
			<div class="select">
				<label for="PodcastAlliTuneCategories">All iTunes U Categories</label>
				<input type="hidden" name="data[Podcast][PodcastAlliTuneCategories]"
					value="" id="PodcastAlliTuneCategories_" /> <select
					name="data[Podcast][PodcastAlliTuneCategories][]"
					multiple="multiple" id="PodcastAlliTuneCategories">
					<?php foreach( $itunes_categories as $id => $value ) : ?>
					<option value="<?php echo $id; ?>">
						<?php echo $value; ?>
					</option>
					<?php endforeach; ?>
				</select>
				<div class="multiple-button">
					<div class="move float_left"
						data-source="PodcastAlliTuneCategories"
						data-target="iTuneCategories">
						<img src="/img/multiple-button-left.png" alt="Move right"
							class="icon" />
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
