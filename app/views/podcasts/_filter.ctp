
<form action="" method="post" id="PodcastFilter">
    
    <div class="input-filter select"><h3>Filter: </h3> 
        <select id="PodcastFilter" name="data[Podcast][filter]">
            <option value="Select">Select from the list</option>
            <option value="<?php echo PUBLIC_ITUNEU_PODCAST; ?>" <?php echo $filter == PUBLIC_ITUNEU_PODCAST ? 'selected="selected"' : ''; ?>>Public iTunes U</option>
            <option value="<?php echo PUBLISHED_ITUNEU_PODCAST; ?>" <?php echo $filter == PUBLISHED_ITUNEU_PODCAST ? 'selected="selected"' : ''; ?>> - Published</option>
            <option value="<?php echo UNPUBLISHED_ITUNEU_PODCAST; ?>" <?php echo $filter == UNPUBLISHED_ITUNEU_PODCAST ? 'selected="selected"' : ''; ?>> - Unpublished</option>
            <option value="<?php echo PRIVATE_ITUNEU_PODCAST; ?>" <?php echo $filter == PRIVATE_ITUNEU_PODCAST ? 'selected="selected"' : ''; ?>>Private iTunes U</option>
            <option value="<?php echo OPENLEARN_PODCAST; ?>" <?php echo $filter == OPENLEARN_PODCAST ? 'selected="selected"' : ''; ?>>OpenLearn</option>
            <?php if( $this->Permission->isAdminRouting() ) : ?>
                <option value="<?php echo DELETED_PODCAST; ?>" <?php echo $filter == DELETED_PODCAST ? 'selected="selected"' : ''; ?>>Deleted Podcasts</option>
            <?php endif; ?>
        </select>
    </div>
    
    <div class="input-filter text">
    	<h3>Search: </h3><input type="text" title="Enter your search here" id="PodcastSearch" name="data[Podcast][search]" class="input_greeting" value="<?php echo $search_criteria; ?>" />
        
        
        <button id="filter_button" type="submit" class="button white"><img src="../../webroot/img/icon-16-link.png" alt="Search" width="16" height="16" class="icon" />Search</button>
        
        
    </div>

     
</form>