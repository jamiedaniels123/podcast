<div id="PodcastItemItunesContainer"  class="preview" >
    <dl>
        <dt>ePub ISBN: </dt>
        <dd><?php echo $this->data['PodcastItem']['epub_isbn']; ?>&nbsp;</dd>
        <dt>ePub Study Hours: </dt>
        <dd><?php echo $this->data['PodcastItem']['epub_study_hours']; ?>&nbsp;</dd>
        <dt>ePub Study Level: </dt>
        <dd><?php echo $this->data['PodcastItem']['epub_study_level']; ?>&nbsp;</dd>
        <dt>Tags: </dt>
        <dd><?php echo $this->data['PodcastItem']['itunes_tags']; ?>&nbsp;</dd>
        <dt>Explicit: </dt>
        <dd><?php echo $this->data['PodcastItem']['explicit']; ?>&nbsp;</dd>
        <dt>Rights Issues: </dt>
        <dd><?php echo $this->data['PodcastItem']['rights_issues']; ?>&nbsp;</dd>
        <dt>Rights Approved: </dt>
        <dd><?php echo $this->data['PodcastItem']['rights_approved']; ?>&nbsp;</dd>        
    </dl>
</div>
<?php
if( $this->Permission->toUpdate( $this->data['Podcast'] ) ) : ?>
	<div class="action_buttons">
		<ul>
			<li>
				<button class="jquery_display save"  type="button" data-source="PodcastItemItunesContainer" data-target="FormPodcastItemItunesContainer" id="PodcastItemItunesButton"><span>edit</span></button>
			</li>
		</ul>
	</div>            
<?php endif; ?>  