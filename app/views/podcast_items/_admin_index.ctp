<fieldset id="podcast_media">
    <legend>Podcast Media Administration</legend>
    <table>
    	<thead>
            <tr>
            	<th>&nbsp;</th>
            	<th>Name</th>
                <th>Uploaded</th>
                <th>Processed State</th>
            	<th>iTunes</th>                
            	<th>U Tube</th>     
            	<th>Actions</th>                                                
            </tr>
        </thead>
        <?php 
			$i = 0;
			foreach( $this->data['PodcastItems'] as $podcast_item ) :
				if( $this->Object->hardDeleted( $podcast_item ) == false ) :
                    $class = null;
                    if ($i++ % 2 == 0) :
						if( $podcast_item['deleted'] ) :					
	                        $class = ' class="altrow deleted"';
						else :
							$class = ' class="altrow"';
						endif;
                    elseif( $podcast_item['deleted'] ) :
						$class = ' class="deleted"';
					endif;
         ?>        
        	<tr<?php echo $class;?>>
            <td>
             <img src="<?php echo $this->Attachment->getMediaImage( $podcast_item['image_filename'],$podcast_item['Podcast']['custom_id'] ,THUMBNAIL_EXTENSION ); ?>" />
            </td>
            <td><?php echo strlen( $podcast_item['title'] ) ? $podcast_item['title'] : $podcast_item['filename']; ?></td>
           	<td><?php echo $this->Time->getPrettyLongDate( $podcast_item['created'] ); ?></td>
            <td class="centered"><?php echo $this->Object->getProcessedState( $podcast_item['processed_state'] ); ?></td>
           	<td class="centered"><img src="/img/<?php echo $this->Attachment->getStatusImage( $podcast_item['itunes_flag'] ); ?>" class="icon"></td>
           	<td class="centered"><img src="/img/<?php echo $this->Attachment->getStatusImage( $podcast_item['youtube_flag'] ); ?>" class="icon"></td>
            <td>
				<a href="/admin/podcast_items/view/<?php echo $podcast_item['id']; ?>" title="view media details"><span>view</span></a>
                <a href="/admin/podcast_items/edit/<?php echo $podcast_item['id']; ?>" title="edit media details"><span>edit</span></a>
                <?php if( (int)$podcast_item['deleted'] == 1 ) : ?>
		            <a href="/admin/podcast_items/restore/<?php echo $podcast_item['id']; ?>" title="restore media" onclick="return confirm('Are you sure you wish to restore this media?');"><span>restore</span></a>                    
                <?php else : ?>
		            <a href="/admin/podcast_items/delete/<?php echo $podcast_item['id']; ?>" title="delete media" onclick="return confirm('Are you sure you wish to permanently delete this media? This action cannot be undone.');"><span>delete</span></a>                    
                <?php endif; ?>
            </td>                                                
          </tr>
          <?php endif; ?>
        <?php endforeach; ?>
    </table>
</fieldset>