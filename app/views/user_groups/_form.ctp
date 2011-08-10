<div class="input text" style="margin-top: 30px;">
    <label for="title">Title</label>
    <input type="text" id="UserGroupTitle" name="data[UserGroup][group_title]" value="<?php echo $this->data['UserGroup']['group_title']; ?>">
    <?php echo $this->Form->error('UserGroup.group_title'); ?>
</div>
<div class="wrapper">
    <div class="float_right">
        <?php if( isSet( $this->data['Moderators'] ) && is_array( $this->data['Moderators'] ) && count( $this->data['Moderators'] ) ) : ?>
            <div id="moderators_container">
                <label for="Moderators">Moderators</label>
                <ul>
                    <?php foreach( $this->data['Moderators'] as $moderator ) : ?>
                        <li><?php echo $moderator['full_name']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div id="members_container">
                <label for="Members">Members</label>
                <ul>
                    <?php foreach( $this->data['Members'] as $member ) : ?>
                        <li><?php echo $member['full_name']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div id="podcast_container">
                <label for="Podcasts">Podcasts</label>
                <ul>
                    <?php foreach( $this->data['Podcasts'] as $podcast ) : ?>
                        <li><?php echo $podcast['title']; ?> <a href="/user_groups/remove_podcast/<?php echo $this->data['UserGroup']['id'];?>/<?php echo $podcast['id'];?>" title="remove from usergroup" onclick="return confirm('Are you sure you wish to remove this podcast from the user group?');">remove</a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    <div class="float_left">
        
        <div class="input select">
            <span class="move" data-source="UsersUsers" data-target="Members">Move --></span>
            <label for="UsersUsers">Application Users</label>
            <select id="UsersUsers" multiple="multiple" name="data[Users][Users][]">
                <?php foreach( $users as $key => $value ) : ?>
                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="float_left">
        <div class="input select">
            <span class="move" data-source="Members" data-target="UsersUsers"><-- Move</span>
            <span class="move" data-source="Members" data-target="Moderators">Move --></span>
            <label for="Members">Members</label>
            <input type="hidden" name="data[Members][]" value="" id="Members_" />
            <select id="Members" multiple="multiple" class="selected" name="data[Members][]">
                <?php foreach( $this->data['Members'] as $member ) : ?>
                    <option value="<?php echo $member['id']; ?>"><?php echo $member['full_name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="float_left">
        
        <div class="input select">
            <span class="move" data-source="Moderators" data-target="Members"><-- Move</span>
            <label for="Moderators">Moderators</label>
            <input type="hidden" name="data[Moderators]" value="" id="Moderators_" />
            <select id="Moderators" multiple="multiple" class="selected" name="data[Moderators][]">
                <?php foreach( $this->data['Moderators'] as $moderator ) : ?>
                    <option value="<?php echo $moderator['id']; ?>"><?php echo $moderator['full_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php echo $this->Form->error('UserGroup.GroupModerators'); ?>
        </div>
        
    </div>
</div>
<div class="clear"></div>