<form accept-charset="utf-8" action="/admin/podcasts/edit/<?php echo $this->data['Podcast']['id']; ?>" method="post" id="PodcastEditForm" enctype="multipart/form-data">
    <input type="hidden" id="PodcastId" name="data[Podcast][id]" value="<?php echo $this->data['Podcast']['id']; ?>">
    <input type="hidden" id="PodcastCustomId" name="data[Podcast][custom_id]" value="<?php echo $this->data['Podcast']['custom_id']; ?>">
    <fieldset>
        <legend><h3>Update Podcast</h3></legend>
        <p>
            Use the form below to create a new podcast container
        </p>
        <?php echo $this->element('../podcasts/_form'); ?>
        <button id="update_podcast" type="submit" class="auto_select_and_submit">update podcast</button>
    </fieldset>
<form>