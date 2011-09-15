<div id="PodcastSharingContainer" <?php echo isSet($edit_mode) ? 'style="display:none"' : ''; ?>>
        <dl>
            <dt>Owned By: &nbsp;</dt>
            <dd><?php echo $this->data['Owner']['full_name']; ?>&nbsp;</dd>
            <dt>Moderators&nbsp;</dt>
            <dd>
				<?php 
				foreach( $this->data['Moderators'] as $moderator ) :
					echo $moderator['full_name'].'. ';
				endforeach; 
				?>
                &nbsp;
            </dd>            
            <dt>Members&nbsp;</dt>
            <dd>
				<?php 
				foreach( $this->data['Members'] as $member ) :
					echo $member['full_name'].'. ';
				endforeach; 
				?>
                &nbsp;
            </dd>            
            <dt>Moderator Groups&nbsp;</dt>
            <dd>
				<?php 
				foreach( $this->data['ModeratorGroups'] as $moderator_group ) :
					echo $moderator_group['group_title'].'. ';
				endforeach; 
				?>
                &nbsp;
            </dd>
            <dt>Member Groups&nbsp;</dt>
            <dd>
				<?php 
				foreach( $this->data['MemberGroups'] as $member_group ) :
					echo $member_group['group_title'].'. ';
				endforeach; 
				?>
                &nbsp;
            </dd>            
        </dl>
    <div class="action_buttons">
    	<ul>
	<?php if( $this->Permission->toUpdate( $this->data ) || $this->Permission->isAdminRouting( $this->params ) ) : ?>
            <li><a href="/" class="jquery_display button blue"  type="button" data-source="PodcastSharingContainer" data-target="FormPodcastSharingContainer" id="PodcastSharingButton"><span>edit</span></a></li>
	    <?php endif; ?>
	    </ul>
	</div>
</div>
