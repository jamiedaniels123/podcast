<div class="wrapper">
    <div class="float_right">
            <?php echo $this->Attachment->getPodcastStandardImage( $this->data ); ?>
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
<?php if( $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) || $this->Permission->isModerator( $this->data['PodcastModerators'] ) || $this->Permission->inModeratorGroup( $this->data['ModeratorGroups'] ) || $this->Permission->isAdministrator() ) : ?>

    <?php if( $this->Permission->isAdminRouting() ) : ?>
        <a href="/admin/podcasts/edit/<?php echo $this->data['Podcast']['id'];?>" title="edit">edit</a>
        <a href="/admin/podcast_items/index/<?php echo $this->data['Podcast']['id'];?>" title="edit">media</a>
    <?php else : ?>
        <a href="/podcasts/edit/<?php echo $this->data['Podcast']['id'];?>" title="edit">edit</a>
        <a href="/podcast_items/index/<?php echo $this->data['Podcast']['id'];?>" title="edit">media</a>
    <?php endif; ?>

<?php endif; ?>

<?php if( $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) || $this->Permission->isAdministrator() ) : ?>

    <?php if( $this->Permission->isAdminRouting() ) : ?>
        <a href="/admin/podcasts/delete/<?php echo $this->data['Podcast']['id'];?>" title="delete" onclick="return confirm('Are you sure you wish to perform a HARD DELETE this podcast?');" >delete</a>
    <?php else : ?>
        <a href="/podcasts/delete/<?php echo $this->data['Podcast']['id'];?>" title="delete" onclick="return confirm('Are you sure you wish to delete this podcast?');" >delete</a>
    <?php endif; ?>

<?php endif; ?>