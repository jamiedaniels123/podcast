<fieldset>
    <legend> <?php echo $this->data['PodcastItem']['title'];?> Media : Administration </legend>
    <?php echo $this->element('../podcast_items/_view'); ?>
    <?php echo $this->element('../podcast_item_medias/_index'); ?>
</fieldset>