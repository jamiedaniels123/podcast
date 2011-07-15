<fieldset id="podcast_media">
    <legend>Flavours</legend>
    <table>
    	<thead>
            <tr>
            	<th>Name</th>
                <th>Uploaded</th>
                <th>Processed State</th>
            	<th>iTunes</th>                
            	<th>U Tube</th>
            	<th>Actions</th>     
            </tr>
        </thead>
        <?php foreach( $this->data['PodcastItemMedia'] as $media ) : ?>
        	<tr>
                <td><?php echo strlen( $media['title'] ) ? $media['title'] : $media['filename']; ?></td>
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
        <?php endforeach; ?>
    </table>
</fieldset>