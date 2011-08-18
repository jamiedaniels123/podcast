<form accept-charset="utf-8" action="/admin/podcasts/edit/<?php echo $this->data['Podcast']['id']; ?>" method="post" id="PodcastEditForm" enctype="multipart/form-data">
    <input type="hidden" id="PodcastId" name="data[Podcast][id]" value="<?php echo $this->data['Podcast']['id']; ?>">
    <input type="hidden" id="PodcastCustomId" name="data[Podcast][custom_id]" value="<?php echo $this->data['Podcast']['custom_id']; ?>">
    <fieldset>
        <legend><h3>Update <?php echo PODCAST; ?></h3></legend>
        <p class="leader" >
            Use the form below to create a new <?php echo PODCAST; ?>.
        </p>
        
        <img src="/img/collection-large.png" width="45" height="34" />
        
        <?php echo $this->element('../podcasts/_form'); ?>
        <button id="update_podcast" type="submit" class="button blue auto_select_and_submit">Update <?php echo PODCAST; ?></button>
    </fieldset>
<form>