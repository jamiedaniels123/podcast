<fieldset id="podcast_media">
    <legend><span>Podcast Media</span></legend>
	<form method="post" action="">
	    <table>
	    	<thead>
	            <tr>
					<?php if( $this->Permission->toUpdate( $this->data ) || $this->Permission->isAdminRouting( $this->params ) ) : ?>
	            		<th class="checkbox">Select</th>
            		<?php endif; ?>
	            	<th class="thumbnail">Image</th>
	            	<th class="collection-title">Name</th>
	                <th class="">Uploaded</th>
	                <th class="">Processed State</th>
	            	<th class="">iTunes</th>                
	            	<th class="">YouTube</th>
	            	<th class="actions">Actions</th>
	            </tr>
	        </thead>
	        <?php foreach( $this->data['PodcastItems'] as $podcast_item ) : ?>
	        
	        	<?php if( $this->Object->isDeleted( $podcast_item ) == false ) : ?>
	        	
		        	<tr>
						<?php if( $this->Permission->toUpdate( $this->data ) || $this->Permission->isAdminRouting( $this->params ) ) : ?>
		                    <td width="15px" align="center">
	                            <input type="checkbox" name="data[PodcastItem][Checkbox][<?php echo $podcast_item['id']; ?>]" class="podcast_item_selection" id="PodcastItemCheckbox<?php echo $podcast_item['id']; ?>">
		                    </td>
	                    <?php endif; ?>
			            <td>
			            	<img src="<?php echo $this->Attachment->getMediaImage( $podcast_item['image_filename'].'.jpg',$podcast_item['Podcast']['custom_id'] ,THUMBNAIL_EXTENSION ); ?>" class="thumbnail" />
			            </td>
		                <td><?php echo strlen( $podcast_item['title'] ) ? $podcast_item['title'] : $podcast_item['filename']; ?></td>
		            	<td><?php echo $this->Time->getPrettyLongDate( $podcast_item['created'] ); ?></td>
		                <td class="centered"><?php echo $this->Object->getProcessedState( $podcast_item['processed_state'] ); ?></td>
		            	<td class="centered"><img src="/img/<?php echo $this->Object->getApprovalStatus( $podcast_item, 'itunes' ); ?>" class="icon"></td>
		            	<td class="centered"><img src="/img/<?php echo $this->Object->getApprovalStatus( $podcast_item, 'youtube' ); ?>" class="icon"></td>
						<td class="actions">
						
							<?php if( $this->Permission->toView( $this->data ) || $this->Permission->isAdminRouting( $this->params ) ) : ?>
							
								<a class="button white" href="/podcast_items/view/<?php echo $podcast_item['id']; ?>" title="view media details"><span>view</span></a>
								
								<?php if( $this->Permission->toUpdate( $this->data ) || $this->Permission->isAdminRouting( $this->params ) ) : ?>
								
									<a class="button off-black" href="/podcast_items/edit/<?php echo $podcast_item['id']; ?>" title="edit media details"><span>edit</span></a>
									
									<?php if( ( ( $podcast_item['processed_state'] == MEDIA_AVAILABLE ) && ( $this->Object->isPublished( $podcast_item ) == false ) ) || ( $this->Permission->isAdminRouting( $this->params ) ) ): ?>
									
										<a class="button white" href="/podcast_items/delete/<?php echo $podcast_item['id']; ?>" title="delete media" onclick="return confirm('Are you sure you wish to delete this media?');"><span>delete</span></a>
										
									<?php endif; ?>
									
								<?php endif; ?>
								
							<?php endif; ?>
							
						</td>	
						                
		            </tr>
		            
		    	<?php endif; ?>
		    	
	        <?php endforeach; ?>
	        
	    </table>
	    
	    <?php if( $this->Permission->toUpdate( $this->data ) || $this->Permission->isAdminRouting( $this->params ) ) : ?>
	    
	        <a href="/" class="toggler button blue" data-status="unticked">Toggle</a>
			<a class="button white multiple_action_button" href="/podcast_items/delete" id="delete_multiple_podcast_items"><span><img src="../../webroot/img/icon-16-link-delete.png" alt="Delete" width="16" height="16" class="icon" />Delete</span></button>
		
			<?php if( $this->Permission->isItunesUser() && $this->Object->isPodcast( $this->data['Podcast']['podcast_flag'] ) ) : ?>
				        
		        <a class="button white multiple_action_button" href="/itunes/podcast_items/approve" id="PodcastItemItunesApprove"><span><img src="../../webroot/img/icon-16-itunes.png" alt="iTunes" width="16" height="16" class="icon" />iTunes appprove</span></button>
		        <a class="button white multiple_action_button" href="/itunes/podcast_items/reject" id="PodcastItemItunesReject"><span><img src="../../webroot/img/icon-16-itunes.png" alt="iTunes" width="16" height="16" class="icon" />iTunes reject</span></button>
		        
			<?php endif; ?>
			
			<?php if( $this->Permission->isYoutubeUser() && $this->Object->isPodcast( $this->data['Podcast']['podcast_flag'] ) ) : ?>
				        
		        <a class="button white multiple_action_button" href="/youtube/podcast_items/approve" id="PodcastItemYoutubeApprove"><span><img src="../../webroot/img/icon-16-youtube.png" alt="Youtube" width="16" height="16" class="icon" />YouTube approve</span></button>
		        <a class="button white multiple_action_button" href="/youtube/podcast_items/reject" id="PodcastItemYoutubeReject"><span><img src="../../webroot/img/icon-16-youtube.png" alt="Youtube" width="16" height="16" class="icon" />YouTube reject</span></button>
	        
        	<?php endif; ?>
	        
		<?php endif; ?>
		
    </form>
    
</fieldset>
