<fieldset class="itunes">
	<legend>iTunes Specific</legend>
   	<dl>
        <dt>Published: </dt>
        <dd><?php echo strtoupper( $this->data['PodcastItem']['itunes_flag'] ) == YES ? 'Yes' : 'No'; ?>&nbsp;</dd>
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
	</dl>    
</fieldset>