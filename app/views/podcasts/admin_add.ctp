<form accept-charset="utf-8" action="/admin/podcasts/add" method="post" id="PodcastAddForm" enctype="multipart/form-data">
    <fieldset>
        <legend><h3>Create Collection</h3></legend>
        <p class="leader">
            Use the form below to create a new podcast container
        </p>
        
        <img src="/img/collection-large.png" width="45" height="34" />
        
        <?php echo $this->element('../podcasts/_form'); ?>
        <button id="create_podcast" type="submit" class="button blue auto_select_and_submit">Create collection</button>
    </fieldset>
<form>