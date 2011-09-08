<fieldset>
    <legend><h3><?php echo $this->data['PodcastItem']['title'];?> ( <?php echo MEDIA; ?> )</h3></legend>
    <img src="/img/collection-large.png" width="45" height="34" />
    <div class="clear"></div>    
    <?php $embedstring="<iframe src=\"".DEFAULT_MEDIA_URL."player/embed/pod/".$this->data['Podcast']['custom_id']."/".$this->data['PodcastItem']['shortcode']. "\" height=\"320\" width=\"480\" frameborder=\"0\" allowfullscreen></iframe>"; ?>
    <?php print $embedstring; ?>
    <p>Embed code:</p>
    <textarea rows="5" cols="55"><?php print $embedstring; ?></textarea>
    <?php echo $this->element('../podcast_items/_view'); ?>
    <?php echo $this->element('../podcast_item_medias/_index'); ?>
</fieldset>