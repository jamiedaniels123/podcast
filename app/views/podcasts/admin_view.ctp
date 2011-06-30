<fieldset>
    <legend><?php echo $this->data['Podcast']['title'];?> : Administration</legend>
    <?php echo $this->element('../podcasts/_view'); ?>
    <div class="clear"></div>
    <?php echo $this->element('../podcast_items/_admin_index' ); ?>
</fieldset>