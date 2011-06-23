<fieldset>
    <legend><?php echo $this->data['Podcast']['title'];?></legend>
    <?php echo $this->element('../podcasts/_view'); ?>
    <div class="clear"></div>
    <?php echo $this->element('../podcast_items/_index'); ?>
</fieldset>