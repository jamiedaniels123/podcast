<fieldset id="podcast_media" class="itunes index podcast_items>
    <legend>Podcast Media for Itunes Approval</legend>
	<form method="post" action="">
	    <table>
	    	<thead>
	            <tr>
            		<th>Select</th>
	            	<th>Image</th>
	            	<th>Name</th>
	                <th>Uploaded</th>
	                <th>Processed State</th>
	                <th>Parent Collection</th>
	            	<th class="actions">Actions</th>
	            </tr>
	        </thead>
	        <?php foreach( $this->data['PodcastItems'] as $podcast_item ) : ?>
		        	<tr>
	                    <td width="15px" align="center">
                            <input type="checkbox" name="data[PodcastItem][Checkbox][<?php echo $podcast_item['PodcastItem']['id']; ?>]" class="podcast_item_selection" id="PodcastItemCheckbox<?php echo $podcast_item['PodcastItem']['id']; ?>">
	                    </td>
			            <td>
			             <img src="<?php echo $this->Attachment->getMediaImage( $podcast_item['PodcastItem']['image_filename'].'.jpg',$podcast_item['Podcast']['custom_id'] ,THUMBNAIL_EXTENSION ); ?>" class="thumbnail" />
			            </td>
		                <td><?php echo strlen( $podcast_item['PodcastItem']['title'] ) ? $podcast_item['PodcastItem']['title'] : $podcast_item['PodcastItem']['filename']; ?></td>
		            	<td><?php echo $this->Time->getPrettyLongDate( $podcast_item['PodcastItem']['created'] ); ?></td>
		                <td class="centered"><?php echo $this->Object->getProcessedState( $podcast_item['PodcastItem']['processed_state'] ); ?></td>
		                <td class="centered">
		                	<?php echo $podcast_item['Podcast']['title']; ?>
		                </td>
						<td class="actions">
	                        <a href="/podcast_items/view/<?php echo $podcast_item['PodcastItem']['id']; ?>" title="view media"><span>view</span></a>
	                        <a href="/podcast_items/approve/<?php echo $podcast_item['PodcastItem']['id']; ?>" title="approve media"><span>approve</span></a>
	                        <a href="/podcast_items/reject/<?php echo $podcast_item['PodcastItem']['id']; ?>" title="reject media"><span>reject</span></a>
						</td>	                
		            </tr>
	        <?php endforeach; ?>
	    </table>
	        <a href="/" class="toggler button blue" data-status="unticked">Toggle</a>
	        <a class="button white multiple_action_button" href="/podcast_items/approve" id="PodcastItemsApproveMultiple"><span>approve</span></button>
	        <a class="button white multiple_action_button" href="/itunes/podcast_items/reject" id="PodcastItemsRejectMultiple"><span>reject</span></button>
    </form>
    
</fieldset>