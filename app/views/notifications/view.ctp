<fieldset>
    <legend><h3><?php echo $this->data['Podcast']['title'];?></h3></legend>
    
            <img src="/img/collection-large.png" width="45" height="34" />
            
            
    <?php echo $this->element('../podcasts/_view'); ?>
    <div class="clear"></div>
    <?php echo $this->element('../podcast_items/_index'); ?>
</fieldset>