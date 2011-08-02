
<form action="" method="post" id="PodcastFilter">
    <div class="input select"><h3>View: </h3> 
        <select id="PodcastFilter" name="data[Podcast][filter]">
            <option value=""></option>
            <option value="<?php echo PUBLIC_ITUNEU_PODCAST; ?>" <?php echo $filter == PUBLIC_ITUNEU_PODCAST ? 'selected="selected"' : ''; ?>>Public iTunes U</option>
            <option value="<?php echo PUBLISHED_ITUNEU_PODCAST; ?>" <?php echo $filter == PUBLISHED_ITUNEU_PODCAST ? 'selected="selected"' : ''; ?>> - Published</option>
            <option value="<?php echo UNPUBLISHED_ITUNEU_PODCAST; ?>" <?php echo $filter == UNPUBLISHED_ITUNEU_PODCAST ? 'selected="selected"' : ''; ?>> - Unpublished</option>
            <option value="<?php echo PRIVATE_ITUNEU_PODCAST; ?>" <?php echo $filter == PRIVATE_ITUNEU_PODCAST ? 'selected="selected"' : ''; ?>>Private iTunes U</option>
            <option value="<?php echo OPENLEARN_PODCAST; ?>" <?php echo $filter == OPENLEARN_PODCAST ? 'selected="selected"' : ''; ?>>Open Learn</option>
            <?php if( $this->Permission->isAdminRouting() ) : ?>
                <option value="<?php echo DELETED_PODCAST; ?>" <?php echo $filter == DELETED_PODCAST ? 'selected="selected"' : ''; ?>>Deleted Podcasts</option>
            <?php endif; ?>
        </select>
    </div>
    <div class="input text">
    	<input type="text" id="PodcastSearch" name="data[Podcast][search]" value="<?php echo $search_criteria; ?>" />
    </div>
	<div class="input submit">
		<button id="filter_button" type="submit" class="button white"><img src="/img/change-view.png" alt="Change view" class="icon" /><span>Filter</span></button>
	</div>    
</form>
