<fieldset id="podcast_media">
    <legend>Podcast Media</legend>
	<form method="post" action="">
	    <table>
	    	<thead>
	            <tr>
	            	<th>Select</th>
	            	<th>Image</th>
	            	<th>Name</th>
	                <th>Uploaded</th>
	                <th>Processed State</th>
	            	<th>iTunes</th>                
	            	<th>U Tube</th>
					<?php if( $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) || $this->Permission->isModerator( $this->data['PodcastModerators'] ) || $this->Permission->inModeratorGroup( $this->data['ModeratorGroups'] ) ) : ?>
		            	<th>Actions</th>
	            	<?php endif; ?>     
	            </tr>
	        </thead>
	        <?php foreach( $this->data['PodcastItems'] as $podcast_item ) : ?>
	        	<?php if( $this->Object->isDeleted( $podcast_item ) == false ) : ?>
		        	<tr>
						<?php if( $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) || $this->Permission->isModerator( $this->data['PodcastModerators'] ) || $this->Permission->inModeratorGroup( $this->data['ModeratorGroups'] ) ) : ?>
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
		            	<td class="centered"><img src="/img/<?php echo $this->Attachment->getStatusImage( $podcast_item['itunes_flag'] ); ?>" class="icon"></td>
		            	<td class="centered"><img src="/img/<?php echo $this->Attachment->getStatusImage( $podcast_item['youtube_flag'] ); ?>" class="icon"></td>
						<td>
	                        <a href="/podcast_items/view/<?php echo $podcast_item['id']; ?>" title="view media details"><span>view</span></a>
							<?php if( $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) || $this->Permission->isModerator( $this->data['PodcastModerators'] ) || $this->Permission->inModeratorGroup( $this->data['ModeratorGroups'] ) ) : ?>
		                        <a href="/podcast_items/edit/<?php echo $podcast_item['id']; ?>" title="edit media details"><span>edit</span></a>
		                        <?php if( $podcast_item['processed_state'] == MEDIA_AVAILABLE ) : ?>
		                        	<a href="/podcast_items/delete/<?php echo $podcast_item['id']; ?>" title="delete media" onclick="return confirm('Are you sure you wish to delete this media?');"><span>delete</span></a>
		                       	<?php else : ?>
									<a href="/podcast_items/delete/<?php echo $podcast_item['id']; ?>" title="delete media" onclick="alert('You cannot delete this media until it has finished transcoding?'); return false;"><span>delete</span></a>                       	
		                       	<?php endif; ?>
			                <?php endif; ?>
						</td>	                
		            </tr>
		    	<?php endif; ?>
	        <?php endforeach; ?>
	    </table>
	    
        <a href="/" class="toggler button blue" data-status="unticked">Toggle</a>
        <a class="button white multiple_action_button" type="button" href="/podcast_items/delete" id="delete_multiple_podcast_items"><span>delete</span></button>
    </form>
    
</fieldset>