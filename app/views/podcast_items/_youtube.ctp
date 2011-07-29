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
        <dt>Description: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_description']; ?>&nbsp;</dd>
        <dt>Subject Playlists: </dt>
        <dd>
			<?php foreach( $this->data['YoutubeSubjectPlaylist'] as $playlist ) : ?>
				&nbsp;<?php echo $playlist['title']; ?>,
			<?php endforeach; ?>
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
        <dt>Rights Issues: </dt>
        <dd><?php echo $this->data['PodcastItem']['rights_issues']; ?>&nbsp;</dd>
        <dt>Rights Approved: </dt>
        <dd><?php echo $this->data['PodcastItem']['rights_approved']; ?>&nbsp;</dd>        
    </dl>
</fieldset>
