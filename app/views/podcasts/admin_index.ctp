<fieldset class="podcasts index">
    <legend><h3>Podcasts : Administration</h3></legend>
    <p>
        Below is a list of all podcasts on the system.
    </p>
    <?php echo $this->element('../podcasts/_filter'); ?>
    <div class="clear"></div>
	<?php echo $this->element('../podcasts/_table'); ?>
</fieldset>