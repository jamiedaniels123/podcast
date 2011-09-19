<div class="track_float_left track_two_column">

    <h4>Preview</h4>
    <?php $embedstring="<iframe src=\"".DEFAULT_MEDIA_URL."player/embed/pod/".$this->data['Podcast']['custom_id']."/".$this->data['PodcastItem']['shortcode']. "\" height=\"320\" width=\"480\" frameborder=\"0\" allowfullscreen></iframe>"; ?>
    <?php print $embedstring; ?>


</div>
<div class="code">
    <h4>Embed code</h4>

    <textarea style="background-color: #1a1a1a; color: #eee; border: 0;padding: 0.3em;" rows="5" cols="55"><?php print $embedstring; ?></textarea>
    

</div>


    

    
