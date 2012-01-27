<div class="track_float_left track_two_column">

	<div class="input">
    
    <div class="code">
        <h4>Preview</h4>
        <?php $embedstring="<iframe src=\"".DEFAULT_PLAYER_URL."player/embed/pod/".$this->data['Podcast']['custom_id']."/".$this->data['PodcastItem']['shortcode']."?theme=basic"."\" height=\"270\" width=\"480\" frameborder=\"0\" allowfullscreen></iframe>"; ?>
        <?php print $embedstring; ?>
	</div>

    <div class="code">
   		<h4>Embed code</h4>
    	<textarea id="embedcode" class="code-snip" rows="5" cols="50"><?php print $embedstring; ?></textarea>
        
        <h4 style="margin-top:20px;">Embed size options (Optional)</h4>
        <?php if($this->data['PodcastItem']['fileformat'] == 'mp3'): ?>
        	<div id="embedvidsizes">   
        		<p><input type="checkbox" id="useposter" checked onclick="javascript:audiochangesize('embedcode',270,480);" /> use poster image for audio</p>
        	</div>
        <?php else: ?>
        	<div id="embedvidsizes">            
                <a href="#" onclick="javascript:changesize('embedcode',270,480,this.id);" id="embedvidvsmall">480x270</a>
                <a href="#" onclick="javascript:changesize('embedcode',315,560,this.id);" id="embedvidsmall">560x315</a>
                <a href="#" onclick="javascript:changesize('embedcode',360,640,this.id);" id="embedvidmed">640x360</a>
                <a href="#" onclick="javascript:changesize('embedcode',480,848,this.id);" id="embedvidlarge">848x480</a>
			</div>
        	<p style="margin-top:20px;">Click on one of the 4 options above.</p>
        <?php endif ; ?> 
    </div>


    <div class="clear"></div>
    
    </div>
    
</div>  
  


    

    
