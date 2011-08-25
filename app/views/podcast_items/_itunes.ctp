<fieldset class="itunes">
	<legend><h3>iTunes U</h3></legend>
    
    <img src="/img/collection-itunes-large.png" width="45" height="34" />
    
	<img src="/img<?php echo $this->Object->getApprovalStatus( $this->data['PodcastItem'], 'itunes' ); ?>" />

   <div class="wrapper ">
       <ul class="youtube">
            <li>
				<a href="/" id="PodcastItemItunesToggle" data-target="PodcastItemItuneContainer" class="juggle button white"><img class="icon" alt="Edit this record" src="/img/icon-16-open.png">View</a>
			</li>
        </ul>
   </div>
   <div class="clear"></div>
    <div class="itunes" id="PodcastItemItuneContainer" style="display:none">
		<div class="float_right images_container">&nbsp;</div>
    	<div class="float_left two_column">
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
	</div>
    
    
</fieldset>