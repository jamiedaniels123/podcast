<div class="wrapper">
    <div class="float_right">
    	<img src="<?php echo $this->Attachment->getMediaImage( $this->data['Podcast']['image'], $this->data['Podcast']['custom_id'], RESIZED_IMAGE_EXTENSION); ?>" title="podcast image" />
    </div>
    <div class="float_left">
        <dl>
            <dt>Title: </dt>
            <dd><?php echo $this->data['Podcast']['title']; ?>&nbsp;</dd>
            <dt>Summary: </dt>
            <dd><?php echo nl2br( $this->data['Podcast']['summary'] ); ?>&nbsp;</dd>
            <dt>Created: </dt>
            <dd><?php echo $this->data['Podcast']['created'] ? $this->Time->getPrettyShortDate( $this->data['Podcast']['created'] ) : $this->Time->getPrettyShortDate( $this->data['Podcast']['created_when'] ); ?>&nbsp;</dd>
            <dt>Owned By: </dt>
            <dd><?php echo $this->data['Owner']['full_name']; ?>&nbsp;</dd>
            <dt>Copyright: </dt>
            <dd><?php echo $this->data['Podcast']['copyright']; ?>&nbsp;</dd>
        </dl>
    </div>
</div>
<div class="clear"></div>
<?php if( $this->Miscellaneous->isAdminRouting() || $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) || $this->Permission->isModerator( $this->data['PodcastModerators'] ) || $this->Permission->inModeratorGroup( $this->data['ModeratorGroups'] ) ) : ?>

    <?php if( $this->Miscellaneous->isAdminRouting() ) : ?>
        <a href="/admin/podcasts/edit/<?php echo $this->data['Podcast']['id'];?>" title="edit">edit</a>
        <a href="/admin/podcast_items/index/<?php echo $this->data['Podcast']['id'];?>" title="edit">media</a>
    <?php else : ?>
        <a href="/podcasts/edit/<?php echo $this->data['Podcast']['id'];?>" title="edit">edit</a>
        <a href="/podcast_items/index/<?php echo $this->data['Podcast']['id'];?>" title="edit">media</a>
    <?php endif; ?>

<?php endif; ?>

<?php if( $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) || $this->Miscellaneous->isAdminRouting() ) : ?>

    <?php if( $this->Miscellaneous->isAdminRouting() ) : ?>
        <?php if( $this->Object->isDeleted( $this->data['Podcast'] ) ) : ?>
	        <a href="/admin/podcasts/restore/<?php echo $this->data['Podcast']['id'];?>" title="restore" onclick="return confirm('Are you sure you wish to restore this podcast?');" >restore</a>
        <?php else : ?>
	        <a href="/admin/podcasts/delete/<?php echo $this->data['Podcast']['id'];?>" title="delete" onclick="return confirm('Are you sure you wish to perform a HARD DELETE this podcast?');" >delete</a>
        <?php endif; ?>
    <?php else : ?>
        <a href="/podcasts/delete/<?php echo $this->data['Podcast']['id'];?>" title="delete" onclick="return confirm('Are you sure you wish to delete this podcast?');" >delete</a>
    <?php endif; ?>

<?php endif; ?>