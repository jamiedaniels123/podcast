<form name="PodcastYoutubeFilterForm" method="post">
	<div class="input select">
        <select name="data[Podcast][filter]" id="PodcastFilter">
			<option value="">Select a filter</option>
			<option value="all" <?php echo $filter == 'all' ? 'selected=true' : ''; ?>>All</option>
			<option value="consideration" <?php echo $filter == 'consideration' ? 'selected=true' : ''; ?>>For Consideration</option>
            <option value="intended" <?php echo $filter == 'intended' ? 'selected=true' : ''; ?>>Unpublished (only, yet to be uploaded )</option>
            <option value="published" <?php echo $filter == 'published' ? 'selected=true' : ''; ?>>Published (only, has been uploaded )</option>
        </select>
    </div>
    <div class="input submit">
    	<button type="submit" button="button blue" id="PodcastFilterSubmit"><span>Filter</span></button>
	</div>
</form>

<div class="clear"></div>
