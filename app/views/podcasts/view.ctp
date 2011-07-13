<fieldset>
    <legend><span><?php echo $this->data['Podcast']['title'];?></span></legend>
    <?php echo $this->element('../podcasts/_view'); ?>
    <div class="clear"></div>
    <?php echo $this->element('../podcast_items/_index'); ?>
</fieldset>