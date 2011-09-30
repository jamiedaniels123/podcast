<div class="track_float_left track_two_column">
	
	<div class="input">
    
    <div class="code">
        <h4>Preview</h4>
        <?php $embedstring="<iframe src=\"".DEFAULT_PLAYER_URL."player/embed/pod/".$this->data['Podcast']['custom_id']."/".$this->data['PodcastItem']['shortcode']. "\" height=\"320\" width=\"480\" frameborder=\"0\" allowfullscreen></iframe>"; ?>
        <?php print $embedstring; ?>
	</div>
	
    <div class="code">
   		<h4>Embed code</h4>
    	<textarea  class="code-snip" rows="5" cols="50"><?php print $embedstring; ?></textarea>
    </div>
    
    <div class="clear"></div>
    
    </div>
    
</div>  
  


    

    
