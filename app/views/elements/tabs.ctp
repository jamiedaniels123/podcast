<div id="outer-content">
    <h3><?php echo $podcast['title']; ?></h3>
    <p>
    <?php echo nl2br( $podcast['summary'] ); ?>
    </p>
</div>    
<div class="tab-zone">
    <div class="tabs">
         <div id="summary"><a href="/podcasts/edit/<?php echo $podcast['id']; ?>/summary#summary"><span class="collection_tab_summary-icon">Summary</span></a>
         </div><!--/summary-->
    
         <div id="tracks"><a href="/podcast_items/index/<?php echo $podcast['id']; ?>#tracks"><span class="collection_tab_track-icon">Tracks</span></a>
         </div><!--Tracks-->

         <div id="sharing"><a href="/podcasts/edit/<?php echo $podcast['id']; ?>/sharing#sharing"><span class="collection_tab_track-icon">Sharing &amp; Ownership</span></a>
         </div><!--YouTube-->
		<?php if( $this->Object->isPodcast( $podcast['podcast_flag'] ) ) : ?>    
         <div id="youtube"><a href="/podcasts/edit/<?php echo $podcast['id']; ?>/youtube#youtube"><span class="collection_tab_youtube-icon">YouTube</span></a>
         </div><!--YouTube-->
         
          <div id="itunes"><a href="/podcasts/edit/<?php echo $podcast['id']; ?>/itunes#itunes"><span class="collection_tab_itunes-icon">iTunes U</span></a>
         </div><!--iTunes U-->
         <?php endif; ?>
         <?php if( $this->Permission->toUpdate( $this->data ) ) : ?>
              <div id="media"><a href="/podcast_items/add/<?php echo $podcast['id']; ?>#media"><span class="collection_tab_media-icon">Add Media</span></a>
             </div><!--Preview-embed-->                     
        <?php endif ;?>
    
    </div><!--/tabs-->

</div><!--/tab-zone-->
