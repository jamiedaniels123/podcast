<fieldset class="podcasts index">
    <legend><h3>Your <?php echo COLLECTION; ?>s</h3></legend>
    
    <p class="leader">Below is a list of all <?php echo COLLECTION; ?>s on the system to which you have access. You can filter using the options below and sort by column headings. An individual <?php echo COLLECTION; ?> is known as a <?php echo PODCAST; ?> and a <?php echo PODCAST; ?> has many <?php echo MEDIA; ?>s.
    </p>
    
    <img src="/img/collection-large.png"  width="45" height="33" />
    
    <!--This css adds some order to the top of the 'Your collections' page by placing the Add a new collection button to the left and the view filter to the right of the screen-->
    
        <div class="collection-top">
            <h3><a class="button white" href="/podcasts/add"><img src="/img/add-new.png" alt="Add a new collection" width="16" height="16" class="icon" />Add a new <?php echo PODCAST; ?></a></h3>
            <div class="right"><?php echo $this->element('../podcasts/_filter'); ?></div>
        </div>
    

    <div class="clear"></div>
	<?php echo $this->element('../podcasts/_table'); ?>
</fieldset>