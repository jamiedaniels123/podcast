<form name="PodcastItunesFilterForm" method="post">
	<div class="input select">
        <select name="data[Podcast][filter]" id="PodcastFilter">
			<option value="">Select a filter</option>
			<option value="all" <?php echo $filter == 'all' ? 'selected=true' : ''; ?>>All</option>
			<option value="consideration" <?php echo $filter == 'consideration' ? 'selected=true' : ''; ?>>For Consideration</option>
            <option value="intended" <?php echo $filter == 'intended' ? 'selected=true' : ''; ?>>Unpublished (only)</option>
            <option value="published" <?php echo $filter == 'published' ? 'selected=true' : ''; ?>>Published (only - excludes OpenLearn)</option>
            <option value="openlearn" <?php echo $filter == 'openlearn' ? 'selected=true' : ''; ?>>OpenLearn (only)</option>
        </select>
    </div>
    <div class="input submit">
    	<button type="submit" class="button blue" id="PodcastFilterSubmit"><span>Filter</span></button>
	</div>
</form>

<div class="clear"></div>
