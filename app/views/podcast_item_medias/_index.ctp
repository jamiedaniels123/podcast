<fieldset id="podcast_media">
    <legend>Flavours</legend>
    <table>
    	<thead>
            <tr>
            	<th>Flavour</th>
            	<th>Name</th>
                <th>Processed State</th>
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
            </tr>
        <?php endforeach; ?>
    </table>
</fieldset>