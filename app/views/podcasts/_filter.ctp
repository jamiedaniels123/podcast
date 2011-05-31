
<form action="" method="post" id="PodcastFilter">
    <div class="input select">
        <select id="PodcastFilter" name="data[Podcast][filter]">
            <option value=""></option>
            <option value="<?php echo PUBLIC_ITUNEU_PODCAST; ?>" <?php echo $this->data['Podcast']['filter'] == PUBLIC_ITUNEU_PODCAST ? 'selected="selected"' : ''; ?>>Public iTunes U</option>
            <option value="<?php echo PUBLISHED_ITUNEU_PODCAST; ?>" <?php echo $this->data['Podcast']['filter'] == PUBLISHED_ITUNEU_PODCAST ? 'selected="selected"' : ''; ?>> - Published</option>
            <option value="<?php echo UNPUBLISHED_ITUNEU_PODCAST; ?>" <?php echo $this->data['Podcast']['filter'] == UNPUBLISHED_ITUNEU_PODCAST ? 'selected="selected"' : ''; ?>> - Unpublished</option>
            <option value="<?php echo PRIVATE_ITUNEU_PODCAST; ?>" <?php echo $this->data['Podcast']['filter'] == PRIVATE_ITUNEU_PODCAST ? 'selected="selected"' : ''; ?>>Private iTunes U</option>
            <option value="<?php echo OPENLEARN_PODCAST; ?>" <?php echo $this->data['Podcast']['filter'] == OPENLEARN_PODCAST ? 'selected="selected"' : ''; ?>>Open Learn</option>
            <?php if( $this->Permission->isAdminRouting() ) : ?>
                <option value="<?php echo DELETED_PODCAST; ?>" <?php echo $this->data['Podcast']['filter'] == DELETED_PODCAST ? 'selected="selected"' : ''; ?>>Other Users Podcasts</option>
            <?php endif; ?>
        </select>
    </div>
    <button id="filter_button" type="submit">filter</button>
</form>