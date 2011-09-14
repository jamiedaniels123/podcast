<div class="preview">
	<?php $embedstring="<iframe src=\"".DEFAULT_MEDIA_URL."player/embed/pod/".$this->data['Podcast']['custom_id']."/".$this->data['PodcastItem']['shortcode']. "\" height=\"320\" width=\"480\" frameborder=\"0\" allowfullscreen></iframe>"; ?>
    <?php print $embedstring; ?>
    <p>Embed code:</p>
    <textarea rows="5" cols="55"><?php print $embedstring; ?></textarea>
</div>