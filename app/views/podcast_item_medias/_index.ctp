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
                <td><a href="<?php echo $this->Attachment->getMediaLink( $this->data['Podcast']['custom_id'], $media ); ?>" title="link to media"><?php echo $media['filename']; ?></a></td>
                <td class="centered"><?php echo $this->Object->getProcessedState( $media['processed_state'] ); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</fieldset>