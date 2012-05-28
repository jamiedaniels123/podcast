<div id="FormPodcastItunesContainer" <?php echo isSet($edit_mode) == false ? 'style="display:none"' : ''; ?> class="float_left two_columnn">

	<div class="text">
		<label for="PodcastItunesuSite">iTunes Site</label>
		<span>Private</span>
		<span class="tip-text">You can only change site if you have access permissions</br>to both Public and Private iTunes U sites.</span>
	</div>

	<div class="text">
		<label for="PodcastCourseCode">Course Code</label>
		<input type="text" size="60" id="PodcastCourseCode" value="<?php echo $this->data['Podcast']['course_code']; ?>" name="data[Podcast][course_code]">
		<?php echo $this->Form->error('Podcast.course_code'); ?>
	</div>

	<div class="select">
		<label for="PodcastCourseType">Course Type</label>
		<select name="data[Podcast][course_type]" id="PodcastCourseType">
			<?php foreach( $course_types as $course_type ) : ?>
			<option value="<?php echo $course_type; ?>" <?php echo strtoupper( $this->data['Podcast']['course_type'] ) == strtoupper($course_type) ? 'selected="selected"' : ''; ?>><?php echo $course_type; ?></option>
			<?php endforeach; ?>
		</select>
		<?php echo $this->Form->error('Podcast.course_type'); ?>
	</div>
		
  <div class="clear"></div>
</div>

