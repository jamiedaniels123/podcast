<fieldset class="itunes">
	<legend>iTunes</legend>
	<dl>
	    <dt><a href="/" id="PodcastItemItunesToggle" class="itunes_toggler">Toggle</a></dt>
	    <dt>Published: </dt>
	    <dd><img src="/img<?php echo ( $this->data['PodcastItem']['itunes_flag'] == YES ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" /></dd>
    </dl>		
    <div class="wrapper itunes" style="display:none">
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
</fieldset>