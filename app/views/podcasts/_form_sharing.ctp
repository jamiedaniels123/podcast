<div id="FormPodcastSharingContainer" <?php echo isSet($edit_mode) == false ? 'style="display:none"' : ''; ?>>
	<div class="wrapper" id="user_groups_container">
        <div class="float_left">
			<div class="input select">
            <label for="Moderators">Moderator Groups</label>
				
				<input type="hidden" name="data[ModeratorGroups][]" value="" id="ModeratorGroups_" />
				<select id="ModeratorGroups" multiple="multiple" class="selected" name="data[ModeratorGroups][]">
					<?php foreach( $this->data['ModeratorGroups'] as $moderator ) : ?>
						<option value="<?php echo $moderator['id']; ?>"><?php echo $moderator['group_title']; ?></option>
					<?php endforeach; ?>
				</select>
                                
				<?php echo $this->Form->error('Podcast.ModeratorGroups'); ?>
                <div class="multiple-button">
                <div class="move float_right" data-source="ModeratorGroups" data-target="MemberGroups"><img src="/img/multiple-button-right.png" alt="Move right" class="icon" /></div>
                </div>
                <div class="clear"></div>
			</div>
         </div>
		
        <div class="float_left">
			<div class="input select">
				<label for="MemberGroups">Member Groups</label>              	
				
				<input type="hidden" name="data[MemberGroups]" value="" id="MemberGroups_" />
				<select id="MemberGroups" multiple="multiple" class="selected" name="data[MemberGroups][]">
					<?php foreach( $this->data['MemberGroups'] as $member ) : ?>
						<option value="<?php echo $member['id']; ?>"><?php echo $member['group_title']; ?></option>
					<?php endforeach; ?>
				</select>
                
				<?php echo $this->Form->error('Podcast.MemberGroups'); ?>
                
                <div class="multiple-button">
                <div class="move float_left" data-source="MemberGroups" data-target="ModeratorGroups"><img src="/img/multiple-button-left.png" alt="Move left" class="icon" /></div>
				<div class="move float_right" data-source="MemberGroups" data-target="UserGroups"><img src="/img/multiple-button-right.png" alt="Move right" class="icon" /></div>
                </div>
                
                <div class="clear"></div>
                
			</div>
		</div>
		
        <div class="float_left">
			<div class="input select">
				<label for="UserGroups">All User Groups</label>
                
				<input type="hidden" name="data[UserGroups]" value="" id="UserGroups_" />
				<select name="data[UserGroups][]" class="selected" multiple="multiple" id="UserGroups">
					<?php foreach( $user_groups as $key => $value ) : ?>
						<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php endforeach; ?>
				</select>
                
				<?php echo $this->Form->error('Podcast.UserGroups'); ?>
                
                <div class="multiple-button">
                <div class="move" data-source="UserGroups" data-target="MemberGroups"><img src="/img/multiple-button-left.png" alt="Move left" class="icon" /></div>
                </div>
                <div class="clear"></div>
			</div>
		</div>
        
	</div>
    
	<div class="clear"></div>
    
	<div class="wrapper" id="moderator_container">
    
		<div class="float_left">
			<div class="input select">
            <label for="Moderators">Moderators</label>
				
				<input type="hidden" name="data[Moderators][]" value="" id="Moderators_" />
                
				<select id="Moderators" multiple="multiple" class="selected" name="data[Moderators][]">
					<?php foreach( $this->data['Moderators'] as $moderator ) : ?>
						<option value="<?php echo $moderator['id']; ?>"><?php echo $moderator['full_name']; ?></option>
					<?php endforeach; ?>
				</select>
                
				<?php echo $this->Form->error('Podcast.Moderators'); ?>
                
                <div class="multiple-button">
                <div class="move float_right" data-source="Moderators" data-target="Members"><img src="/img/multiple-button-right.png" alt="Move right" class="icon" /></div>
                </div>
                <div class="clear"></div>
			</div>
		</div>
        
        
		<div class="float_left">
			<div class="input select">
            <label for="Members">Members</label>
				
				<input type="hidden" name="data[Members]" value="" id="Members_" />
                
				<select id="Members" multiple="multiple" class="selected" name="data[Members][]">                
					<?php foreach( $this->data['Members'] as $member ) : ?>
						<option value="<?php echo $member['id']; ?>"><?php echo $member['full_name']; ?></option>
					<?php endforeach; ?>                    
				</select>
                
				<?php echo $this->Form->error('Podcast.Members'); ?>
                
                <div class="multiple-button">
                <div class="move float_left" data-source="Members" data-target="Moderators"><img src="/img/multiple-button-left.png" alt="Move left" class="icon" /></div>
				<div class="move float_right" data-source="Members" data-target="UsersUsers"><img src="/img/multiple-button-right.png" alt="Move right" class="icon" /></div>
                </div>
                <div class="clear"></div>
			</div>
		</div>
        
        
		<div class="float_left">
			<div class="input select">
            <label for="UsersUsers">All Users</label>
				
				<select id="UsersUsers" multiple="multiple" name="data[Users][Users][]">
					<?php foreach( $users as $key => $value ) : ?>
						<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php endforeach; ?>
				</select>
                
                <div class="multiple-button">
                <div class="move" data-source="UsersUsers" data-target="Members"><img src="/img/multiple-button-left.png" alt="Move left" class="icon" /></div>
                </div>
                <div class="clear"></div>
			</div>
		</div>
        
	</div>
    
	<div class="clear"></div>
    
	<?php if( ( $this->Object->editing( $this->data['Podcast'] ) && $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) ) || ( $this->Object->changeOfOwnership( $this->data['Podcast'] ) && $this->Permission->isOwner( $this->data['Podcast']['current_owner_id'] ) ) ) : ?>
	
        <div class="input text">
			<label for="PodcastOwnerId">Owner</label>
			<?php if( $this->Object->changeOfOwnership( $this->data['Podcast'] ) ) : ?>
				<input type="hidden" name="data[Podcast][current_owner_id]" value="<?php echo $this->data['Podcast']['current_owner_id']; ?>" id="PodcastCurrentOwnerId" />
				<input type="hidden" name="data[Podcast][confirmed]" value="<?php echo isSet( $this->data['Podcast']['confirmed'] ) ? '1' : '0'; ?>" id="PodcastConfirmed" />
			<?php endif; ?>
			
			<select name="data[Podcast][owner_id]" id="PodcastOwnerId">
				<option value="">Please select</option>
				<?php foreach( $all_users as $user_id => $name ) : ?>
					<option value="<?php echo $user_id; ?>" <?php echo $this->data['Podcast']['owner_id'] == $user_id ? 'selected="true"' : ''; ?>><?php echo $name; ?></option>
				<?php endforeach; ?>
			</select>
			<?php echo $this->Form->error('Podcast.owner_id'); ?>
		</div>
	<?php endif; ?>
</div>