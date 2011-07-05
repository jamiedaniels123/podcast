<fieldset class="youtube">
	<legend>Youtube Specific</legend>
    <dl>
        <dt>Published: </dt>
        <dd><img src="/img<?php echo ( $this->data['Podcast']['publish_youtube'] == 'Y' ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" />
        <dt>Channel: </dt>
        <dd><?php echo $this->data['Podcast']['youtube_channel']; ?>&nbsp;</dd>
    </dl>    
</fieldset>