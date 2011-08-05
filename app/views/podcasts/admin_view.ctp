<fieldset>
    <legend><h3><?php echo $this->data['Podcast']['title'];?> : Administration</h3></legend>
    <?php echo $this->element('../podcasts/_view'); ?>
    <div class="clear"></div>
    <?php echo $this->element('../podcast_items/_admin_index' ); ?>
</fieldset>