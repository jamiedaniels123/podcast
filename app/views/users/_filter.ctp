
<form action="" method="post" id="UserFilter">
    
    <div class="input-filter select"><h3>View: </h3> 
        <select id="UserFilter" name="data[User][filter]">
            <option value="Select">Select from the list</option>
            <option value="ADMINISTRATOR" <?php echo strtoupper( $filter ) == 'ADMINISTRATOR' ? 'selected="selected"' : ''; ?>>Administrators</option>
            <option value="ITUNES" <?php echo strtoupper( $filter ) == 'ITUNES' ? 'selected="selected"' : ''; ?>>iTunes</option>
            <option value="YOUTUBE" <?php echo strtoupper( $filter ) == 'YOUTUBE' ? 'selected="selected"' : ''; ?>>YouTube</option>
            <option value="OPEN_LEARN" <?php echo strtoupper( $filter ) == 'OPEN_LEARN' ? 'selected="selected"' : ''; ?>>OpenLearn</option>
        </select>
    </div>
    
    <div class="input-filter text">
    	<h3>Search: </h3>
        <input type="text" id="UserSearch" title="Enter your search here" class="input_greeting" name="data[User][search]" value="<?php echo $search_criteria; ?>" /><button id="filter_button" type="submit" class="button white"><img src="../../webroot/img/icon-16-link.png" alt="Search" width="16" height="16" class="icon" />Search</button>
    </div> 
       
</form>