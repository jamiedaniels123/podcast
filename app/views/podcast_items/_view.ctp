<div class="wrapper">
    <div class="float_right">
            <img src="<?php echo $this->Attachment->getMediaImage( $this->data['PodcastItem']['image_filename'], $this->data['Podcast']['custom_id'], RESIZED_IMAGE_EXTENSION ); ?>" title="podcast image" />
    </div>
    <div class="float_left">
        <dl>
            <dt>Title: </dt>
            <dd><?php echo $this->data['PodcastItem']['title']; ?>&nbsp;</dd>
            <dt>Summary: </dt>
            <dd><?php echo nl2br( $this->data['PodcastItem']['summary'] ); ?>&nbsp;</dd>
            <dt>Created: </dt>
            <dd><?php echo $this->data['PodcastItem']['created'] ? $this->Time->getPrettyShortDate( $this->data['PodcastItem']['created'] ) : $this->Time->getPrettyShortDate( $this->data['PodcastItem']['created_when'] ); ?>&nbsp;</dd>
        </dl>
    </div>
</div>
<div class="clear"></div>
<?php if( $this->Permission->isAdminRouting() || $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) || $this->Permission->isModerator( $this->data['Podcast']['PodcastModerators'] ) || $this->Permission->inModeratorGroup( $this->data['Podcast']['ModeratorGroups'] ) ) : ?>

    <?php if( $this->Permission->isAdminRouting() ) : ?>
        <a href="/admin/podcast_items/edit/<?php echo $this->data['PodcastItem']['id'];?>" title="edit">edit</a>
        <a href="/admin/podcasts/view/<?php echo $this->data['Podcast']['id'];?>" title="edit">collection</a>
    <?php else : ?>
        <a href="/podcast_items/edit/<?php echo $this->data['PodcastItem']['id'];?>" title="edit">edit</a>
        <a href="/podcasts/view/<?php echo $this->data['Podcast']['id'];?>" title="edit">collection</a>
    <?php endif; ?>

<?php endif; ?>

<?php if( $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) || $this->Permission->isAdministrator() ) : ?>

    <?php if( $this->Permission->isAdminRouting() ) : ?>
        <a href="/admin/podcast_items/delete/<?php echo $this->data['PodcastItem']['id'];?>" title="delete" onclick="return confirm('Are you sure you wish to perform a HARD DELETE this media?');" >delete</a>
    <?php else : ?>
        <a href="/podcastitems/delete/<?php echo $this->data['PodcastItem']['id'];?>" title="delete" onclick="return confirm('Are you sure you wish to delete this media?');" >delete</a>
    <?php endif; ?>

<?php endif; ?>