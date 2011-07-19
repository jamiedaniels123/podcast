<form action="" method="post" id="UserFilter">
    <div class="input select"><h3>View: </h3> 
        <select id="UserFilter" name="data[User][filter]">
            <option value=""></option>
            <option value="ADMINISTRATOR" <?php echo strtoupper( $filter ) == 'ADMINISTRATOR' ? 'selected="selected"' : ''; ?>>Administrators</option>
            <option value="ITUNES" <?php echo strtoupper( $filter ) == 'ITUNES' ? 'selected="selected"' : ''; ?>>Itunes</option>
            <option value="YOUTUBE" <?php echo strtoupper( $filter ) == 'YOUTUBE' ? 'selected="selected"' : ''; ?>>Youtube</option>
            <option value="OPEN_LEARN" <?php echo strtoupper( $filter ) == 'OPEN_LEARN' ? 'selected="selected"' : ''; ?>>Open Learn</option>
        </select>
    </div>
    <div class="input text">
    	<input type="text" id="UserSearch" name="data[User][search]" value="<?php echo $search_criteria; ?>" />
    </div>
	<div class="input submit">
		<button id="UserFilterButton" type="submit" class="button white"><img src="/img/change-view.png" alt="Change view" class="icon" /><span>Filter</span></button>
	</div>    
</form>