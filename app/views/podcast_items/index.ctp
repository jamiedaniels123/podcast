<?php echo $this->element('tabs'); ?>
<div class="content">
	<form method="post" action="">
		<table>
			<thead>
				<tr>
<?php if( $this->Permission->toUpdate( $this->data ) ) : ?>
				<th class="checkbox">Select</th>
<?php endif; ?>
				<th class="thumbnail">Poster Image</th>
				<th class="collection-title">Track Title</th>
				<th class="icon-col">Media Available</th>
				
				<?php if( $this->Permission->isItunesPublicUser() ) : ?>
					<th class="icon-col">iTunes U SD Media<br/>(ipod-all)</th>
					<th class="icon-col">iTunes U HD Media<br/>(desktop-all)</th>
				<?php 	endif; ?>
				<?php if( $this->Permission->isItunesPrivateUser() ) : ?>
					<th class="icon-col">Watermarked<br/>Media</th>
				<?php 	endif; ?>
				<?php if( $this->Permission->isYoutubeUser() ) : ?>
					<th class="icon-col">YouTube<br/>Media</th>
				<?php 	endif; ?>
				<th class="icon-col">Duration (H:M:S)</th>
				<th class="icon-col">Track Published (RSS)</th>
				<th class="">Publish Date (RSS)</th>
				<?php if( $this->Permission->isYoutubeUser() ) : ?>
					<th class="icon-col">YouTube</th>
                    <th class="icon-col"></th>
				<?php 	endif; ?>
				</tr>
			</thead>
			<tbody>
<?php $i = 0;
			foreach( $this->data['PodcastItems'] as $podcast_item ) :
				$class = null;
				if ($i++ % 2 == 0) :
					$class = 'class="altrow"';
				endif;
				if( $this->Object->isDeleted( $podcast_item['PodcastItem'] ) == false ) : ?>
				<tr <?php echo $class; ?>>
<?php 		if( $this->Permission->toUpdate( $this->data ) && $this->Permission->isAdminRouting( $this->params ) == false ) : ?>
				<td width="15px" align="center">
				<input type="checkbox" name="data[PodcastItem][Checkbox][<?php echo $podcast_item['PodcastItem']['id']; ?>]" class="podcast_item_selection" id="PodcastItemCheckbox<?php echo $podcast_item['PodcastItem']['id']; ?>">
				</td>
<?php 		endif; ?>
				<td  class="thumbnail">
				<img src="<?php echo $this->Attachment->getMediaImage( $podcast_item['PodcastItem']['image_filename'].'.jpg',$this->data['Podcast']['custom_id'] ,THUMBNAIL_EXTENSION ); ?>" class="thumbnail" />
				</td>
				<td  class="collection-title"><a href="/podcast_items/edit/<?php echo $podcast_item['PodcastItem']['id']; ?>" class="podcast_item_update" data-id="<?php echo $podcast_item['PodcastItem']['id']; ?>"><?php echo strlen( $podcast_item['PodcastItem']['title'] ) ? $podcast_item['PodcastItem']['title'] : 'Untitled '.MEDIA; ?></a></td>
<?php		if (isset($podcast_item['PodcastMedia'])) :
					$mediaFlavours = $this->Object->getMediaFlavours($podcast_item['PodcastMedia']); ?>

				<td class="icon-col available">
				<?php
				echo $this->Object->getProcessedState( $podcast_item['PodcastItem']['processed_state'] );
				// see if HD flavour available - don't both with errors though
				if (isset($mediaFlavours['720']['processed_state'])) {
					if ($mediaFlavours['720']['processed_state'] == 9) {
						echo "<span style='color:red; font-size:70%'>HD</span>";
					}
				} elseif (isset($mediaFlavours['540']['processed_state'])) {
					if ($mediaFlavours['540']['processed_state'] == 9) {
						echo "<span style='color:red; font-size:70%'>HD</span>";
					}
				} 
				?>
				</td>
					
		<?php	if (isset($mediaFlavours['ipod-all']['processed_state']) && $this->Permission->isItunesPublicUser()) : ?>
					<td class="icon-col available"><?php echo $this->Object->getProcessedState( $mediaFlavours['ipod-all']['processed_state'] ); ?></td>
		<?php	else : ?>
					<td class="icon-col available">n/a</td>
		<?php	endif;
					if (isset($mediaFlavours['desktop-all']['processed_state']) && $this->Permission->isItunesPublicUser()) : ?>
					<td class="icon-col available"><?php echo $this->Object->getProcessedState( $mediaFlavours['desktop-all']['processed_state'] ); ?></td>
		<?php	else : ?>
					<td class="icon-col available">n/a</td>
		<?php	endif;
					if (isset($mediaFlavours['wm-default']['processed_state']) && $this->Permission->isItunesPrivateUser()) : ?>
					<td class="icon-col available"><?php echo $this->Object->getProcessedState( $mediaFlavours['wm-default']['processed_state'] ); ?></td>
		<?php	else : ?>
					<td class="icon-col available">n/a</td>
		<?php	endif;
					if (isset($mediaFlavours['youtube']['processed_state']) && $this->Permission->isYoutubeUser()) : ?>
					<td class="icon-col available"><?php echo $this->Object->getProcessedState( $mediaFlavours['youtube']['processed_state'] ); ?></td>
		<?php	else : ?>
					<td class="icon-col available">n/a</td>
		<?php	endif; ?>	
	<?php	else : ?>	
				<td class="icon-col available"><?php echo $this->Object->getProcessedState( $podcast_item['PodcastItem']['processed_state'] ); ?></td>
		<?php	if ($this->Permission->isItunesPublicUser()) : ?>
					<td class="icon-col available">-</td>
					<td class="icon-col available">-</td>
		<?php	endif;
					if ($this->Permission->isItunesPrivateUser()) : ?>
					<td class="icon-col available">-</td>
		<?php	endif;
					if ($this->Permission->isYoutubeUser()) : ?>
					<td class="icon-col available">-</td>
		<?php	endif; ?>
	<?php	endif; ?>

				<td class="icon-col"><?php echo $this->Time->getTimeSMPTE( $podcast_item['PodcastItem']['duration'] ); ?></td>
				<td class="icon-col available"><img src="/img<?php echo $this->Object->isPublished( $podcast_item['PodcastItem']['published_flag'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" class="icon" /></td>
				<td><?php echo $this->Time->getPrettyLongDateTime( $podcast_item['PodcastItem']['publication_date'] ); ?></td>
<?php if( $this->Permission->isYoutubeUser() ) : ?>
				<td class="icon-col">
	<?php	if( $this->Object->intendedForYoutube( $this->data['Podcast'] ) && $this->Object->hasYoutubeFlavour( $podcast_item ) ) : ?>
				<img src="/img/<?php echo $this->Object->getApprovalStatus( $podcast_item['PodcastItem'], 'youtube' ); ?>" class="icon">
	<?php	else : ?>
				<img src="/img/icon-16-youtube-unavailable.png" alt="Not available" />
	<?php	endif; ?>
				</td>
<?php 	endif; ?>
				</tr>
<?php 	endif; ?>
<?php endforeach; ?>
			</tbody>
		</table>
<?php echo $this->element('pagination'); ?>
<?php if( $this->Permission->toUpdate( $this->data ) ) : ?>
		<div class="track_save_cancel">
		<a href="/" class="toggler button select_all" data-status="unticked">Select/deselect all</a>
		<a class="button delete multiple_action_button" href="/podcast_items/delete" id="delete_multiple_podcast_items">Delete</a>
<?php if( $this->Object->isPodcast( $this->data['Podcast']['podcast_flag'] ) ) : ?>
		<a class="button publish multiple_action_button" href="/podcast_items/publish" id="publish_multiple_podcast_items">Publish</a>
		<a class="button publish multiple_action_button" href="/podcast_items/unpublish" id="publish_multiple_podcast_items">Unpublish</a>
<?php endif; ?>
<?php if( $this->Permission->isAdministrator() && $this->Object->isPodcast( $this->data['Podcast']['podcast_flag'] ) ) : ?>
		<a class="button itunes-icon multiple_action_button" href="/itunes/podcast_items/approve" id="PodcastItemItunesApprove">iTunes include</a>
		<a class="button itunes-icon multiple_action_button" href="/itunes/podcast_items/reject" id="PodcastItemItunesReject">iTunes exclude</a>
<?php endif; ?>
<?php if( $this->Permission->isYoutubeUser() ) : ?>
<?php if( $this->Object->intendedForYoutube( $this->data['Podcast'] ) ) : ?>
		<a class="button youtube-icon multiple_action_button" href="/youtube/podcast_items/upload" id="PodcastItemYoutubeUpload">YouTube upload</a>
		<a class="button youtube-icon multiple_action_button" href="/youtube/podcast_items/refresh" id="PodcastItemYoutubeRefresh">YouTube refresh</a>
		</div>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>
	</form>
</div>