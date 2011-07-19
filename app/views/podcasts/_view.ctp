<div class="wrapper">
    <div class="float_right images_container">
        <h2>Collection Image</h2>
        <?php echo !empty( $this->data['Podcast']['image_copyright'] ) ? $this->data['Podcast']['image_copyright'] : 'Copyright Unknown'; ?>
        <div class="clear"></div>
        <img src="<?php echo $this->Attachment->getMediaImage( $this->data['Podcast']['image'], $this->data['Podcast']['custom_id'], RESIZED_IMAGE_EXTENSION); ?>" title="podcast image" />
    </div>
    <div class="float_left two_column">
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
            <dt>Language: </dt>
            <dd><?php echo $this->data['Language']['language']; ?>&nbsp;</dd>
            <dt>Explicit: </dt>
            <dd><?php echo ucfirst( $this->data['Podcast']['explicit'] ); ?>&nbsp;</dd>
            <dt>Keywords: </dt>
            <dd><?php echo $this->data['Podcast']['keywords']; ?>&nbsp;</dd>
            <dt>Contact Name (RSS): </dt>
            <dd><?php echo $this->data['Podcast']['contact_name']; ?>&nbsp;</dd>
            <dt>Contact Email (RSS): </dt>
            <dd><?php echo $this->data['Podcast']['contact_email']; ?>&nbsp;</dd>
            <dt>Web URL: </dt>
            <dd><?php echo $this->data['Podcast']['link']; ?>&nbsp;</dd>
            <dt>Web URL Text: </dt>
            <dd><?php echo $this->data['Podcast']['link_text']; ?>&nbsp;</dd>
            <dt>Private: </dt>
            <dd><img src="/img<?php echo ( $this->data['Podcast']['private'] == YES ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="private status" /></dd>
            <dt>Intranet Only: </dt>            
            <dd><img src="/img<?php echo ( $this->data['Podcast']['intranet_only'] == YES ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="private status" /></dd>
			<dt>Preferred Node</dt>
            <dd><?php echo $this->data['PreferredNode']['title']; ?>&nbsp;</dd>
			<dt>Nodes</dt>
            <dd>
				<?php 
				foreach( $this->data['Nodes'] as $node ) :
					echo $node['title'].'. ';
				endforeach; 
				?>
                &nbsp;
            </dd>
            <dt>Moderators</dt>
            <dd>
				<?php 
				foreach( $this->data['Moderators'] as $moderator ) :
					echo $moderator['full_name'].'. ';
				endforeach; 
				?>
                &nbsp;
            </dd>            
            <dt>Members</dt>
            <dd>
				<?php 
				foreach( $this->data['Members'] as $member ) :
					echo $member['full_name'].'. ';
				endforeach; 
				?>
                &nbsp;
            </dd>            
            <dt>Moderator Groups</dt>
            <dd>
				<?php 
				foreach( $this->data['ModeratorGroups'] as $moderator_group ) :
					echo $moderator_group['group_title'].'. ';
				endforeach; 
				?>
                &nbsp;
            </dd>
            <dt>Member Groups</dt>
            <dd>
				<?php 
				foreach( $this->data['MemberGroups'] as $member_group ) :
					echo $member_group['group_title'].'. ';
				endforeach; 
				?>
                &nbsp;
            </dd>            
        </dl>
    </div>
</div>
<div class="clear"></div>

<div class="two-column-controls">

<?php if( $this->Object->considerForItunes( $this->data['Podcast'] ) ) : ?>
	<?php echo $this->element('../podcasts/_itunes'); ?>
	<div class="clear"></div>
<?php endif; ?>
<?php if( $this->Object->considerForYoutube( $this->data['Podcast'] ) ) : ?>
    <?php echo $this->element('../podcasts/_youtube'); ?>
    <div class="clear"></div>
<?php endif; ?>

<?php if( $this->Miscellaneous->isAdminRouting() || $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) || $this->Permission->isModerator( $this->data['PodcastModerators'] ) || $this->Permission->inModeratorGroup( $this->data['ModeratorGroups'] ) ) : ?>

    <?php if( $this->Miscellaneous->isAdminRouting() ) : ?>
        <a class="button light-blue" href="/admin/podcasts/edit/<?php echo $this->data['Podcast']['id'];?>" title="edit"><img src="/img/icon-16-link.png" alt="Edit" class="icon" />Edit</a>
        <a class="button light-blue" href="/admin/podcast_items/add/<?php echo $this->data['Podcast']['id'];?>" title="edit"><img src="/img/add-new.png" alt="Add media" class="icon" />Add media</a>
    <?php else : ?>
        <a class="button light-blue" href="/podcasts/edit/<?php echo $this->data['Podcast']['id'];?>" title="edit"><img src="/img/icon-16-link.png" alt="Edit" class="icon" />Edit</a>
        <a class="button light-blue" href="/podcast_items/add/<?php echo $this->data['Podcast']['id'];?>" title="edit"><img src="/img/add-new.png" alt="Add media" class="icon" />Add media</a>
    <?php endif; ?>

<?php endif; ?>

<?php if( $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) || $this->Miscellaneous->isAdminRouting() ) : ?>

    <?php if( $this->Miscellaneous->isAdminRouting() ) : ?>
        <?php if( $this->Object->isDeleted( $this->data['Podcast'] ) ) : ?>
	        <a class="button white" href="/admin/podcasts/restore/<?php echo $this->data['Podcast']['id'];?>" title="restore" onclick="return confirm('Are you sure you wish to restore this collection?');" ><img src="/img/icon-16-restore.png" alt="Restore" class="icon" />Restore</a>
        <?php else : ?>
	        <a class="button white" href="/admin/podcasts/delete/<?php echo $this->data['Podcast']['id'];?>" title="delete" onclick="return confirm('Are you sure you wish to perform a HARD DELETE this collection?');" ><img src="/img/icon-16-link-delete.png" alt="Delete" class="icon" />Delete</a>
        <?php endif; ?>
    <?php else : ?>
        <a class="button white" href="/podcasts/delete/<?php echo $this->data['Podcast']['id'];?>" title="delete" onclick="return confirm('Are you sure you wish to delete this collection?');" ><img src="/img/icon-16-link-delete.png" alt="Delete" class="icon" />Delete</a>
        </div>
    <?php endif; ?>

<?php endif; ?>