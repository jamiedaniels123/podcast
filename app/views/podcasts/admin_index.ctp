<fieldset class="podcasts index">
    <legend><h3><?php echo COLLECTION; ?> : Administration</h3></legend>
    <p class="leader">
        Below is a list of all <?php echo COLLECTION; ?>s on the system.
    </p>
	<img src="/img/collection-large.png" width="45" height="34" />
    <?php echo $this->element('../podcasts/_filter'); ?>
    <div class="clear"></div>
	<?php echo $this->element('../podcasts/_table'); ?>
</fieldset>