<fieldset class="podcasts index">
    <legend><h3>VLE <?php echo COLLECTION; ?>s</h3></legend>
    

    
    <p class="leader">
        Below is a list of all VLE <?php echo COLLECTION; ?>s on the system.
    </p>    
    
    <img src="/img/collection-large.png" />
    
    <!--This css adds some order to the top of the 'Your collections' page by placing the Add a new collection button to the left and the view filter to the right of the screen-->
    
    <?php echo $this->element('../podcasts/_table'); ?>
</fieldset>
