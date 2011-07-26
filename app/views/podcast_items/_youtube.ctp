<fieldset class="youtube">
	<legend>Youtube</legend>
	<dl>
	    <dt><a href="/" id="PodcastItemYoutubeToggle" class="youtube_toggler">Toggle</a></dt>
	    <dt>Published: </dt>
	    <dd><img src="/img<?php echo ( $this->data['PodcastItem']['youtube_flag'] == YES ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" /></dd>
    </dl>		
    <div class="wrapper youtube" style="display:none">	
    <dl>
        <dt>Published: </dt>
        <dd><?php echo strtoupper( $this->data['PodcastItem']['youtube_flag'] ) == YES ? 'Yes' : 'No'; ?>&nbsp;</dd>
        <dt>Title: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_title']; ?>&nbsp;</dd>
        <dt>Tags: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_tags']; ?>&nbsp;</dd>
        <dt>Geo Location: </dt>
        <dd><?php echo $this->data['PodcastItem']['geo_location']; ?>&nbsp;</dd>
        <dt>Rights Issues: </dt>
        <dd><?php echo $this->data['PodcastItem']['rights_issues']; ?>&nbsp;</dd>
        <dt>Rights Approved: </dt>
        <dd><?php echo $this->data['PodcastItem']['rights_approved']; ?>&nbsp;</dd>        
    </dl>
</fieldset>