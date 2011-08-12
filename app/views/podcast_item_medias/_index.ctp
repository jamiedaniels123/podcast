<fieldset id="podcast_media">
    <legend>Flavours</legend>
    <table>
    	<thead>
            <tr>
            	<th>Flavour</th>
            	<th>Filename</th>
                <th>Processed State</th>
                <?php if( $this->Permission->isAdminRouting( $this->params ) ) : ?>
                	<th>Actions</th>
                <?php endif; ?>
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
                <?php if( $this->Permission->isAdminRouting( $this->params ) ) : ?>
                	<td>
	                    <a class="button white" href="/admin/podcast_item_medias/delete/<?php echo $media['id']; ?>" onclick="return confirm('Are you sure you wish to delete this flavour of media?');" id="PodcastItemMediaDelete">Delete</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</fieldset>