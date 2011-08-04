<form accept-charset="utf-8" action="/podcasts/add" method="post" id="PodcastAddForm" enctype="multipart/form-data">
    <fieldset>
        <legend><h3>Create Podcast</h3></legend>
        <p>
            Use the form below to create a new podcast container
        </p>
        <?php echo $this->element('../podcasts/_form'); ?>
        <button id="create_podcast" type="submit" class="auto_select_and_submit">create podcast</button>
    </fieldset>
<form>