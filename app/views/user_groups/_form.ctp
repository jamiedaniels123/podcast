<div class="wrapper">

<div id="content" class="text form_title">
    
        <div class="user_input text" style="margin: 30px 0;">
            <label for="title">Title</label>
            <input type="text" size="60" id="UserGroupTitle" name="data[UserGroup][group_title]" value="<?php echo $this->data['UserGroup']['group_title']; ?>">
            <?php echo $this->Form->error('UserGroup.group_title'); ?>
        </div>

                                                
                                                
												<div class="wrapper">
													<?php if( isSet( $this->data['Moderators'] ) && is_array( $this->data['Moderators'] ) && count( $this->data['Moderators'] ) ) : ?>
                                                    <div id="moderators_container" class="float_left_list update_user_group_block">
                                                        <label for="Moderators">Moderators</label>
                                                        <ul class="update_user_group_list">
                                                            <?php foreach( $this->data['Moderators'] as $moderator ) : ?>
                                                                <li><?php echo $moderator['full_name']; ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                    
                                                    
                                                    <div id="members_container" class="float_left_list update_user_group_block">
                                                        <label for="Members">Members</label>
                                                        <ul class="update_user_group_list">
                                                            <?php foreach( $this->data['Members'] as $member ) : ?>
                                                                <li><?php echo $member['full_name']; ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                    
                                                    <div id="podcast_container" class="float_left_list update_user_group_block">
                                                        <label for="Podcasts">Podcasts</label>
                                                        <ul class="update_user_group_list">
                                                            <?php foreach( $this->data['Podcasts'] as $podcast ) : ?>
                                                                <li><?php echo $podcast['title']; ?> <a class="button delete" href="/user_groups/remove_podcast/<?php echo $this->data['UserGroup']['id'];?>/<?php echo $podcast['id'];?>" title="remove from usergroup" onclick="return confirm('Are you sure you wish to remove this podcast from the user group?');"><span>Remove</span></a></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    </div>
                                                    <div class="clear"></div>
                                                <?php endif; ?>
                                                </div>
                                                
                                            
                                            
                                                                             
    
    <div id="applications_users_moderators">
    <div class="float_left_list"> 
        <div class="select">
        	<label for="UsersUsers">Application Users</label>
            
            <select id="UsersUsers" multiple="multiple" name="data[Users][Users][]">
                <?php foreach( $users as $key => $value ) : ?>
                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php endforeach; ?>
            </select>
            
            <div class="multiple-button">
            	<div class="move float_right" data-source="UsersUsers" data-target="Members"><img src="/img/multiple-button-right.png" alt="Move right" class="icon" /></div>
            </div>
        </div>
    </div>
    
    
    
    <div class="float_left_list">
        <div class="select">
        	<label for="Members">Members</label>
            
            <input type="hidden" name="data[Members][]" value="" id="Members_" />
            <select id="Members" multiple="multiple" class="selected" name="data[Members][]">
                <?php foreach( $this->data['Members'] as $member ) : ?>
                    <option value="<?php echo $member['id']; ?>"><?php echo $member['full_name']; ?></option>
                <?php endforeach; ?>
            </select>
            
            <div class="multiple-button">
                <div class="move float_left_list" data-source="Members" data-target="UsersUsers"><img src="/img/multiple-button-left.png" alt="Move left" class="icon" /></div>
                <div class="move float_right" data-source="Members" data-target="Moderators"><img src="/img/multiple-button-right.png" alt="Move right" class="icon" /></div>
            </div>            
        </div>
    </div>
    
    <div class="float_left_list">
    <div class="select">
    	<label for="Moderators">Moderators</label>
            
            
            <input type="hidden" name="data[Moderators]" value="" id="Moderators_" />
            <select id="Moderators" multiple="multiple" class="selected" name="data[Moderators][]">
                <?php foreach( $this->data['Moderators'] as $moderator ) : ?>
                    <option value="<?php echo $moderator['id']; ?>"><?php echo $moderator['full_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php echo $this->Form->error('UserGroup.GroupModerators'); ?>
            
            <div class="multiple-button">
           		<div class="move float_left_list" data-source="Moderators" data-target="Members"><img src="/img/multiple-button-left.png" alt="Move left" class="icon" /></div>
            </div>
            
        </div>  
    </div>
    <div class="clear"></div>
    </div>
    
    </div>
</div>
<div class="clear"></div>