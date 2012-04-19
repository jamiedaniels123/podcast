<div id="PodcastItemItunesContainer"  class="preview" >

<div class="track_float_left track_two_column">
    <dl>
    	<!-- Hide epub fields as we current dont support the uploading of them.  Uncomment when we do 
        <dt>ePub ISBN: </dt>
        <dd><?php echo $this->data['PodcastItem']['epub_isbn']; ?>&nbsp;</dd>
        <dt>ePub Study Hours: </dt>
        <dd><?php echo $this->data['PodcastItem']['epub_study_hours']; ?>&nbsp;</dd>
        <dt>ePub Study Level: </dt>
        <dd><?php echo $this->data['PodcastItem']['epub_study_level']; ?>&nbsp;</dd>
         -->
        <dt>Explicit: </dt>
        <dd><?php echo $this->data['PodcastItem']['explicit']; ?>&nbsp;</dd>
        
        <!-- Commented out as not requoired at the moment.
        <dt>Rights Issues: </dt>
        <dd><?php echo $this->data['PodcastItem']['rights_issues']; ?>&nbsp;</dd>
        <dt>Rights Approved: </dt>
        <dd><?php echo $this->data['PodcastItem']['rights_approved']; ?>&nbsp;</dd>
        <dt>Archive Details: </dt>
        <dd><?php echo $this->data['PodcastItem']['archive_details']; ?>&nbsp;</dd>  
        <dt>Music Details: </dt>
        <dd><?php echo $this->data['PodcastItem']['music_details']; ?>&nbsp;</dd>  
         -->
    </dl>
    </div>
</div>
<?php
if( $this->Permission->toUpdate( $this->data['Podcast'] ) ) : ?>
	<div class="action_buttons track_save_cancel">
		<ul>
			<li>
				<button class="jquery_display button edit_track"  type="button" data-source="PodcastItemItunesContainer" data-target="FormPodcastItemItunesContainer" id="PodcastItemItunesButton"><span>Edit</span></button>
			</li>
		</ul>
	</div>            
<?php endif; ?>  