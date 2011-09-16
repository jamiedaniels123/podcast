<div id="outer-content">
    <h3><?php echo $podcast['title']; ?></h3>
    <p>
    <?php echo nl2br( $podcast['summary'] ); ?>
    </p>
</div>    
<div id="tab-zone" class="tab-zone">
    <div class="tabs">
		 <?php if( $this->Permission->isAdminRouting( $this->params ) ) : ?>

             <div id="sharing"><a class="tab_link" href="/admin/podcasts/edit/<?php echo $podcast['id']; ?>/sharing#sharing"><span class="collection_tab_track-icon">Sharing &amp; Ownership</span></a>
             </div><!--YouTube-->
             
             <div id="tracks"><a class="tab_link" href="/admin/podcast_items/index/<?php echo $podcast['id']; ?>#tracks"><span class="collection_tab_track-icon">Tracks</span></a>
             </div><!--Tracks-->
             
		<?php else : ?>
        
             <div id="summary"><a class="tab_link" href="/podcasts/edit/<?php echo $podcast['id']; ?>/summary#summary"><span class="collection_tab_summary-icon">Summary</span></a>
             </div><!--/summary-->
             <div id="tracks"><a class="tab_link" href="/podcast_items/index/<?php echo $podcast['id']; ?>#tracks"><span class="collection_tab_track-icon">Tracks</span></a>
             </div><!--Tracks-->
             
			 <?php if( $this->Permission->isAdminRouting( $this->params ) == false ) : ?>
         
                 <div id="sharing"><a class="tab_link" href="/podcasts/edit/<?php echo $podcast['id']; ?>/sharing#sharing"><span class="collection_tab_sharing-icon">Sharing &amp; Ownership</span></a>
                 </div><!--YouTube-->
                 
                <?php if( $this->Object->isPodcast( $podcast['podcast_flag'] ) ) : ?>    
                
                     <div id="youtube"><a class="tab_link" href="/podcasts/edit/<?php echo $podcast['id']; ?>/youtube#youtube"><span class="collection_tab_youtube-icon">YouTube</span></a>
                     </div><!--YouTube-->
                     
                      <div id="itunes"><a class="tab_link" href="/podcasts/edit/<?php echo $podcast['id']; ?>/itunes#itunes"><span class="collection_tab_itunes-icon">iTunes U</span></a>
                     </div><!--iTunes U-->
             
	             <?php endif; ?>
             
				 <?php if( $this->Permission->toUpdate( $this->data ) ) : ?>
                 
                      <div id="media"><a class="tab_link" href="/podcast_items/add/<?php echo $podcast['id']; ?>#media"><span class="collection_tab_media-icon">Add Media</span></a>
                     </div><!--Preview-embed-->                     
                      <div id="rss"><a class="tab_link" href="/feeds/add/<?php echo $podcast['id']; ?>#rss" onclick="return confirm('Are you sure?');"><span class="collection_tab_rss-icon">RSS Refresh</span></a>
                     </div><!--Preview-embed-->                     
                     
				<?php endif ;?>
            
			<?php endif ;?>

		<?php endif ;?>    
        
    </div><!--/tabs-->
</div><!--/tab-zone-->
