<form accept-charset="utf-8" action="/podcasts/edit/<?php echo $this->data['Podcast']['id']; ?>" method="post" id="PodcastEditForm" enctype="multipart/form-data">
    <input type="hidden" id="PodcastId" name="data[Podcast][id]" value="<?php echo $this->data['Podcast']['id']; ?>">
    <fieldset>
        <legend>Update Podcast</legend>
        <p>
            Use the form below to create a new podcast container
        </p>
        <?php echo $this->element('../podcasts/_form'); ?>
        <button id="update_podcast" type="submit" class="auto_select_and_submit">update podcast</button>
    </fieldset>
<form>