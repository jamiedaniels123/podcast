<fieldset class="podcasts index">
    <legend><h3>iTunesU collections</h3></legend>
    
    <img src="/img/collection-large.png" />
    
    <p class="leader">
        Below is a list of all itunes collections on the system.
    </p>
    
    <!--This css adds some order to the top of the 'Your collections' page by placing the Add a new collection button to the left and the view filter to the right of the screen-->
    
    <div class="input select">
		<?php echo $this->element('../podcasts/_itunes_youtube_filter'); ?>
    </div>
    <div class="clear"></div>
    <?php echo $this->element('../podcasts/_table'); ?>
</fieldset>
