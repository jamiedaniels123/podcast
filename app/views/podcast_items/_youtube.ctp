<fieldset class="youtube">
	<legend>Youtube Specific</legend>
    <dl>
        <dt>Published: </dt>
        <dd><?php echo strtoupper( $this->data['PodcastItem']['youtube_flag'] ) == YES ? 'Yes' : 'No'; ?>&nbsp;</dd>
        <dt>Title: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_title']; ?>&nbsp;</dd>
        <dt>Tags: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_tags']; ?>&nbsp;</dd>
        <dt>Geo Location: </dt>
        <dd><?php echo $this->data['PodcastItem']['geo_location']; ?>&nbsp;</dd>
    </dl>
</fieldset>