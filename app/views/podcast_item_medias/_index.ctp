<div class="wrapper">
    <table class="flavours">
    	<thead>
            <tr>
            	<th>Flavour</th>
            	<th>Filename</th>
                <th>Processed State</th>
               	<th>Actions</th>
            </tr>
        </thead>
        <?php foreach( $this->data['PodcastMedia'] as $media ) : ?>
        	<tr>
        		<td><?php echo ucfirst( $media['media_type'] ); ?></td>
                <?php if( strtoupper( $media['media_type'] ) == TRANSCRIPT ) : ?>
    	            <td><?php echo $this->Attachment->getTranscriptLink( $this->data['Podcast']['custom_id'], $media['filename'] ); ?></td>
                <?php else : ?>
	                <td>
                    <?php echo $this->Attachment->getMediaLink( $this->data['Podcast']['custom_id'], $media ); ?></td>
                <?php endif; ?>
                <td class="centered"><?php echo $this->Object->getProcessedState( $media['processed_state'] ); ?></td>
               	<td>
                    <a class="delete button ajax_link" href="/admin/podcast_item_medias/delete/<?php echo $media['id']; ?>" id="PodcastItemMediaDelete"><span>Delete</span></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>