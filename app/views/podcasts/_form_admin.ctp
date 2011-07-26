<div class="clear"></div>
<?php if( $this->Permission->isAdminRouting( $this->params ) ) : ?>
 	
	<div class="input select">
	    <label for="PodcastMediaLocation">Media Location</label>
	    <select name="data[Podcast][media_location]" id="PodcastMediaLocation">
	        <option value="local" <?php echo ( $this->data['Podcast']['media_location'] == 'local' ) ? 'selected="true"' : '';?>>Local Hosting</option>
	        <option value="s3nonOU" <?php echo ( $this->data['Podcast']['media_location'] == 's3nonOU' ) ? 'selected="true"' : '';?>>Amazon S3 (Non OU)</option>
	        <option value="s3all" <?php echo ( $this->data['Podcast']['media_location'] == 's3all' ) ? 'selected="true"' : '';?>>Amazon S3 (All)</option>                                        
	    </select>
	    <?php echo $this->Form->error('Podcast.media_location'); ?>
	</div>
	
<?php else : ?>

	<input type="hidden" name="data[Podcast][media_location]" id="PodcastMediaLocation" value="<?php echo $this->data['Podcast']['media_location']; ?>" />

<?php endif; ?>       
