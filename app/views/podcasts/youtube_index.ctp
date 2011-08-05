<fieldset class="podcasts index youtube">
    <legend><h3>Youtube collections</h3></legend>
    
    <p class="leader">
        Below is a list of all youtube collections podcasts on the system.
    </p>
    
    <img src="/img/collection-large.png" />
    
    <!--This css adds some order to the top of the 'Your collections' page by placing the Add a new collection button to the left and the view filter to the right of the screen-->
    
    <div class="input select">
		<?php echo $this->element('../podcasts/_itunes_youtube_filter'); ?>
    </div>
    <div class="clear"></div>
    <?php echo $this->element('../podcasts/_table'); ?>
</fieldset>
