<fieldset class="youtube">
	<legend>Youtube</legend>
	<dl>
	    <dt><a href="/" id="PodcastItemYoutubeToggle" class="youtube_toggler">Toggle</a></dt>
	    <dt>Published: </dt>
	    <dd><img src="/img<?php echo ( $this->data['Podcast']['publish_itunes_u'] == 'Y' ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" /></dd>
    </dl>	
    <div class="wrapper youtube" style="display:none">
	    <dl>
	        <dt>Channel: </dt>
	        <dd><?php echo $this->data['Podcast']['youtube_channel']; ?>&nbsp;</dd>
	    </dl>
	</div>	
</fieldset>
<?php if( $this->Miscellaneous->isAdminRouting() ) : ?>

    <?php echo $this->element('../podcasts/_form_admin'); ?>

<?php else : ?>

    <input type="hidden" id="PodcastMediaLocation" name="data[Podcast][media_location]" value="<?php echo $this->data['Podcast']['media_location']; ?>">
   
<?php endif; ?>
    