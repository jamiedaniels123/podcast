<fieldset class="podcasts index">
    <legend><h3>iTunes U <?php echo COLLECTION; ?>s</h3></legend>
    <p class="leader">
        Below is a list of all iTunes U <?php echo COLLECTION; ?>s on the system that you can access.
    </p>    
    <img src="/img/collection-large.png" />
    
    <!--This css adds some order to the top of the 'Your collections' page by placing the Add a new collection button to the left and the view filter to the right of the screen-->
    
        <div class="collection-top">
    <div class="class="right"">
		<?php echo $this->element('../podcasts/_itunes_filter'); ?>
    </div>
        </div>
    <div class="clear"></div>
    <?php echo $this->element('../podcasts/_table'); ?>
</fieldset>
