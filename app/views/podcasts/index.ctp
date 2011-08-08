<fieldset class="podcasts index">
    <legend><h3>Your Collections</h3></legend>
    
    <p class="leader">
        Below is a list of all podcasts on the system to which you have access. You can filter using the options below and sort by column headings.
    </p>
    
    <img src="/img/collection-large.png" />
    
    <!--This css adds some order to the top of the 'Your collections' page by placing the Add a new collection button to the left and the view filter to the right of the screen-->
    
    <div class="collection-top">
    	<div class="left"><h3><a class="button white" href="/podcasts/add"><img src="/img/add-new.png" alt="Add a new collection" width="16" height="16" class="icon" />Add a new collection</a></h3></div>
    	<div class="right"><?php echo $this->element('../podcasts/_filter'); ?></div>
    </div>
    <div class="column_options">
    </div>
    <div class="clear"></div>
	<?php echo $this->element('../podcasts/_table'); ?>
</fieldset>