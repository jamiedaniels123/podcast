<form accept-charset="utf-8" action="/podcasts/edit/<?php echo $this->data['Podcast']['id']; ?>" method="post" id="PodcastEditForm" enctype="multipart/form-data">
    <input type="hidden" id="PodcastId" name="data[Podcast][id]" value="<?php echo $this->data['Podcast']['id']; ?>">
    <input type="hidden" id="PodcastCustomId" name="data[Podcast][custom_id]" value="<?php echo $this->data['Podcast']['custom_id']; ?>">
	<input type="hidden" id="PodcastDeleted" name="data[Podcast][deleted]" value="<?php echo $this->data['Podcast']['deleted']; ?>">
	<input type="hidden" value="<?php echo $this->data['Podcast']['intended_itunesu_flag']; ?>" id="PodcastIntendedItunesuFlag" name="data[Podcast][intended_itunesu_flag]">
	<input type="hidden" value="<?php echo $this->data['Podcast']['intended_youtube_flag']; ?>" id="PodcastIntendedYoutubeFlag" name="data[Podcast][intended_youtube_flag]">    
    <fieldset>
        <legend>Update Podcast</legend>
        <p>
            Use the form below to create/update a new podcast container
        </p>
		        
		<?php echo $this->element('../podcasts/_form'); ?>
        	
        <button id="PodcastUpdateButton" type="submit" class="auto_select_and_submit">update podcast</button>
    </fieldset>
<form>
