<form action="" method="post" id="UserFilter">
    <div class="input text">
    	<input type="text" id="UserSearch" name="data[User][search]" value="<?php echo $search_criteria; ?>" />
    </div>
	<div class="input submit">
		<button id="UserFilterButton" type="submit" class="button white"><img src="/img/change-view.png" alt="Change view" class="icon" /><span>Filter</span></button>
	</div>    
</form>