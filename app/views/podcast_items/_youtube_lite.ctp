<fieldset class="youtube">
	<legend><h3>YouTube</h3></legend>
    
    <img src="/img/collection-youtube-large.png" width="45" height="34" />
    <img src="/img<?php echo $this->Object->getApprovalStatus( $this->data['PodcastItem'], 'youtube' ); ?>" />

   <div class="wrapper ">
       <ul class="youtube">
            <li>
				<a href="/" id="PodcastItemYoutubeToggle" data-target="PodcastItemYoutubeContainer" class="button white juggle"><img class="icon" alt="Edit this record" src="/img/icon-16-open.png">View</a>
			</li>
        </ul>
   </div>
   <div class="clear"></div>
    <div class="youtube" id="PodcastItemYoutubeContainer" style="display:none">
        <div class="float_right images_container">
        	&nbsp;
        </div>   
        <div class="float_left two_column" > 
            <dl>
                <dt>Published: </dt>
                <dd><?php echo strtoupper( $this->data['PodcastItem']['youtube_flag'] ) == YES ? 'Yes' : 'No'; ?>&nbsp;</dd>
                <dt>Title: </dt>
                <dd><?php echo $this->data['PodcastItem']['youtube_title']; ?>&nbsp;</dd>
                <dt>Description: </dt>
                <dd><?php echo nl2br( $this->data['PodcastItem']['youtube_description'] ); ?>&nbsp;</dd>
                <dt>Subject Playlists: </dt>
                <dd>
                    <?php foreach( $this->data['YoutubeSubjectPlaylists'] as $playlist ) : ?>
                        &nbsp;<?php echo $playlist['title']; ?>,
                    <?php endforeach; ?>
                    &nbsp;
                </dd>
                <dt>Openlearn Link: </dt>
                <dd>
                    <a href="<?php echo $this->data['PodcastItem']['youtube_openlearn_link']; ?>" title="open learn link" target="blank"><?php echo $this->data['PodcastItem']['youtube_openlearn_link']; ?></a>&nbsp;
                </dd>
                <dt>Additional Link (1): </dt>
                <dd>
                    <a href="<?php echo $this->data['PodcastItem']['youtube_link_1']; ?>" title="additional link 1" target="blank"><?php echo $this->data['PodcastItem']['youtube_link_1']; ?></a>&nbsp;
                </dd>
                <dt>Additional Link (2): </dt>
                <dd>
                    <a href="<?php echo $this->data['PodcastItem']['youtube_link_2']; ?>" title="additional link 2" target="blank"><?php echo $this->data['PodcastItem']['youtube_link_2']; ?></a>&nbsp;
                </dd>
                <dt>Additional Link (3): </dt>
                <dd>
                    <a href="<?php echo $this->data['PodcastItem']['youtube_link_3']; ?>" title="additional link 3" target="blank"><?php echo $this->data['PodcastItem']['youtube_link_3']; ?></a>&nbsp;
                </dd>
                <dt>Tags: </dt>
                <dd><?php echo $this->data['PodcastItem']['youtube_tags']; ?>&nbsp;</dd>
                <dt>Geo Location: </dt>
                <dd><?php echo $this->data['PodcastItem']['geo_location']; ?>&nbsp;</dd>
            </dl>
		</div>
	</div>    
</fieldset>
