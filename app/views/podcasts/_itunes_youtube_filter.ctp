<form name="PodcastFilterForm" method="post">
	<div class="input select">
        <select name="data[Podcast][filter]" id="PodcastFilter">
			<option value="">Select a filter</option>
			<option value="consideration" <?php echo $filter == 'consideration' ? 'selected=true' : ''; ?>>For Consideration</option>
            <option value="intended" <?php echo $filter == 'intended' ? 'selected=true' : ''; ?>>Approved</option>
            <option value="published" <?php echo $filter == 'published' ? 'selected=true' : ''; ?>>Published</option>
        </select>
    </div>
    <div class="input submit">
    	<button type="submit" id="PodcastFilterSubmit"><span>Filter</span></button>
	</div>
</form>

<div class="clear"></div>
