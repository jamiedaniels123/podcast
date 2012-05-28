<div id="PersonaliseContainer">
	<a href="/" class="button setting juggle" data-target="PersonaliseForm">Personalise your table</a>
	
	

    <form action="" method="post" id="PersonaliseForm" style="display:none;margin-top:10px;">
	
	    <div class="checkbox" >
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
            
            <li><input type="checkbox" name="data[Podcast][itunes_u_url]" class="personalise" data-target="itunes_u_url" <?php echo $this->Miscellaneous->columnActive($active_columns, 'itunes_u_url'); ?>>iTunes U URL</li>
            
            
            <li><input type="checkbox" name="data[Podcast][language]" class="personalise" data-target="language" <?php echo $this->Miscellaneous->columnActive($active_columns, 'language'); ?>>Language</li>
            <li><input type="checkbox" name="data[Podcast][media]" class="personalise" data-target="media" <?php echo $this->Miscellaneous->columnActive($active_columns, 'media'); ?>>media</li>
            <li><input type="checkbox" name="data[Podcast][owner]" class="personalise" data-target="owner" <?php echo $this->Miscellaneous->columnActive($active_columns, 'owner'); ?>>Owner</li>
            <li><input type="checkbox" name="data[Podcast][preferred_node]" class="personalise" data-target="preferred_node" <?php echo $this->Miscellaneous->columnActive($active_columns, 'preferred_node'); ?>>Preferred Node</li>
			<li><input type="checkbox" name="data[Podcast][preferred_url]" class="personalise" data-target="preferred_url" <?php echo $this->Miscellaneous->columnActive($active_columns, 'preferred_url'); ?>>Preferred URL</li>
			<li><input type="checkbox" name="data[Podcast][title]" class="personalise" data-target="title" <?php echo $this->Miscellaneous->columnActive($active_columns, 'title'); ?>>Title</li>
			<li><input type="checkbox" name="data[Podcast][podcast_flag]" class="personalise" data-target="podcast_flag" <?php echo $this->Miscellaneous->columnActive($active_columns, 'podcast_flag'); ?>>Podcast</li>
			
			<li><input type="checkbox" name="data[Podcast][consider_for_itunes]" class="personalise" data-target="consider_for_itunes" <?php echo $this->Miscellaneous->columnActive($active_columns, 'consider_for_itunes'); ?>>Consider iTunes U</li>
			<li><input type="checkbox" name="data[Podcast][intended_itunesu_flag]" class="personalise" data-target="intended_itunesu_flag" <?php echo $this->Miscellaneous->columnActive($active_columns, 'intended_itunesu_flag'); ?>>iTunes U Collection</li>
			<li><input type="checkbox" name="data[Podcast][itunesu_site]" class="personalise" data-target="itunesu_site" <?php echo $this->Miscellaneous->columnActive($active_columns, 'itunesu_site'); ?>>iTunes U Site</li>
			
			<li><input type="checkbox" name="data[Podcast][publish_itunes_u]" class="personalise" data-target="publish_itunes_u" <?php echo $this->Miscellaneous->columnActive($active_columns, 'publish_itunes_u'); ?>>iTunes U Published</li> 

			<li><input type="checkbox" name="data[Podcast][consider_for_youtube]" class="personalise" data-target="consider_for_youtube" <?php echo $this->Miscellaneous->columnActive($active_columns, 'consider_for_youtube'); ?>>Consider YouTube</li>
			<li><input type="checkbox" name="data[Podcast][intended_youtube_flag]" class="personalise" data-target="intended_youtube_flag" <?php echo $this->Miscellaneous->columnActive($active_columns, 'intended_youtube_flag'); ?>>YouTube Collection</li>
			<li><input type="checkbox" name="data[Podcast][publish_youtube]" class="personalise" data-target="publish_youtube" <?php echo $this->Miscellaneous->columnActive($active_columns, 'publish_youtube'); ?>>Youtube Published</li> 
			<li><input type="checkbox" name="data[Podcast][openlearn_epub]" class="personalise" data-target="openlearn_epub" <?php echo $this->Miscellaneous->columnActive($active_columns, 'openlearn_epub'); ?>>Open Learn</li>
			</ul>
            
            
		</div><!--/input checkbox-->
        
	</form> 
</div><!--/PersonaliseContainer-->
