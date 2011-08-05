<div id="PersonaliseContainer">
	<a href="/" class="button blue juggle" data-target="PersonaliseForm">Personalise your table</a>
	
	<form action="" method="post" id="PersonaliseForm" style="display:none;">
	
	    <div class="input checkbox">
		    <ul id="PodcastColumnOptions">
            
            <li><input type="checkbox" name="data[Podcast][author]" class="personalise" data-target="author" <?php echo $this->Miscellaneous->columnActive($active_columns, 'author'); ?>>Author</li>
            <li><input type="checkbox" name="data[Podcast][copyright]" class="personalise" data-target="copyright" <?php echo $this->Miscellaneous->columnActive($active_columns, 'copyright'); ?>>Copyright</li>
            <li><input type="checkbox" name="data[Podcast][contact_name]" class="personalise" data-target="contact_name" <?php echo $this->Miscellaneous->columnActive($active_columns, 'contact_name'); ?>>Contact Name</li>
            <li><input type="checkbox" name="data[Podcast][course_code]" class="personalise" data-target="course_code" <?php echo $this->Miscellaneous->columnActive($active_columns, 'course_code'); ?>>Course Code</li>
            <li><input type="checkbox" name="data[Podcast][created]" class="personalise" data-target="created" <?php echo $this->Miscellaneous->columnActive($active_columns, 'created'); ?>>Created</li>
            <li><input type="checkbox" name="data[Podcast][explicit]" class="personalise" data-target="explicit" <?php echo $this->Miscellaneous->columnActive($active_columns, 'explicit'); ?>>Explicit</li>
            
            <li><input type="checkbox" name="data[Podcast][thumbnail]" class="personalise" data-target="thumbnail" <?php echo $this->Miscellaneous->columnActive($active_columns, 'thumbnail'); ?>>Image</li>
				<li><input type="checkbox" name="data[Podcast][thumbnail_copyright]" class="personalise" data-target="thumbnail_copyright" <?php echo $this->Miscellaneous->columnActive($active_columns, 'thumbnail_copyright'); ?>>Image Copyright</li>
				<li><input type="checkbox" name="data[Podcast][thumbnail_logoless]" class="personalise" data-target="thumbnail_logoless" <?php echo $this->Miscellaneous->columnActive($active_columns, 'thumbnail_logoless'); ?>>Image Logoless</li>
				<li><input type="checkbox" name="data[Podcast][thumbnail_logoless_copyright]" class="personalise" data-target="thumbnail_logoless_copyright" <?php echo $this->Miscellaneous->columnActive($active_columns, 'thumbnail_logoless_copyright'); ?>>Image Logoless Copyright</li>
				<li><input type="checkbox" name="data[Podcast][thumbnail_wide]" class="personalise" data-target="thumbnail_wide" <?php echo $this->Miscellaneous->columnActive($active_columns, 'thumbnail_wide'); ?>>Image Widescreen</li>
				<li><input type="checkbox" name="data[Podcast][thumbnail_wide_copyright]" class="personalise" data-target="thumbnail_wide_copyright" <?php echo $this->Miscellaneous->columnActive($active_columns, 'thumbnail_wide_copyright'); ?>>Image Widescreen Copyright</li>
            
            <li><input type="checkbox" name="data[Podcast][itunes_u_url]" class="personalise" data-target="itunes_u_url" <?php echo $this->Miscellaneous->columnActive($active_columns, 'itunes_u_url'); ?>>iTunesU URL</li>
            
            
            <li><input type="checkbox" name="data[Podcast][language]" class="personalise" data-target="language" <?php echo $this->Miscellaneous->columnActive($active_columns, 'language'); ?>>Language</li>
            <li><input type="checkbox" name="data[Podcast][media]" class="personalise" data-target="media" <?php echo $this->Miscellaneous->columnActive($active_columns, 'media'); ?>>media</li>
            <li><input type="checkbox" name="data[Podcast][owner]" class="personalise" data-target="owner" <?php echo $this->Miscellaneous->columnActive($active_columns, 'owner'); ?>>Owner</li>
            <li><input type="checkbox" name="data[Podcast][preferred_node]" class="personalise" data-target="preferred_node" <?php echo $this->Miscellaneous->columnActive($active_columns, 'preferred_node'); ?>>Preferred Node</li>
			<li><input type="checkbox" name="data[Podcast][preferred_url]" class="personalise" data-target="preferred_url" <?php echo $this->Miscellaneous->columnActive($active_columns, 'preferred_url'); ?>>Preferred URL</li>
			<li><input type="checkbox" name="data[Podcast][title]" class="personalise" data-target="title" <?php echo $this->Miscellaneous->columnActive($active_columns, 'title'); ?>>Title</li>
 
			</ul>
		</div>
	</form>
</div>