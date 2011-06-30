<fieldset id="podcast_media">
    <legend>Podcast Media</legend>
    <table>
    	<thead>
            <tr>
            	<th>&nbsp;</th>
            	<th>Name</th>
                <th>Uploaded</th>
            	<th>iTunes</th>                
            	<th>U Tube</th>     
				<?php if( $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) || $this->Permission->isModerator( $this->data['PodcastModerators'] ) || $this->Permission->inModeratorGroup( $this->data['ModeratorGroups'] ) ) : ?>
	            	<th>Actions</th>                                                
	            <?php endif; ?>
            </tr>
        </thead>
        <?php foreach( $this->data['PodcastItems'] as $podcast_item ) : ?>
        	<tr>
            <td>
             <img src="<?php echo $this->Attachment->getMediaImage( $podcast_item['image_filename'],$podcast_item['Podcast']['custom_id'] ,THUMBNAIL_EXTENSION ); ?>" />
            </td>
                <td><a href="/podcast_items/view/<?php echo $podcast_item['id']; ?>" title="view <?php echo $podcast_item['title']; ?>"><?php echo strlen( $podcast_item['title'] ) ? $podcast_item['title'] : $podcast_item['filename']; ?></a></td>
            	<td><?php echo $this->Time->getPrettyLongDate( $podcast_item['created'] ); ?></td>
            	<td><img src="/img/<?php echo $this->Attachment->getStatusImage( $podcast_item['itunes_flag'] ); ?>" class="icon"></td>
            	<td><img src="/img/<?php echo $this->Attachment->getStatusImage( $podcast_item['youtube_flag'] ); ?>" class="icon"></td>
				<?php if( $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) || $this->Permission->isModerator( $this->data['PodcastModerators'] ) || $this->Permission->inModeratorGroup( $this->data['ModeratorGroups'] ) ) : ?>
                    <td>
                            <a href="/podcast_items/edit/<?php echo $podcast_item['id']; ?>" title="edit media details"><span>edit</span></a>
	                        <a href="/podcast_items/delete/<?php echo $podcast_item['id']; ?>" title="delete media" onclick="return confirm('Are you sure you wish to delete this media?');"><span>delete</span></a>                    
                    </td>                                                
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</fieldset>