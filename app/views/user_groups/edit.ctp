<form accept-charset="utf-8" action="/user_groups/edit" method="post" id="UserGroupEditForm">
    <input type="hidden" name="data[UserGroup][id]" id="UserGroupId" value="<?php echo $this->data['UserGroup']['id']; ?>">
    <fieldset>
        <legend><h3>Update User Group</h3></legend>
        <p class="leader">
            Use the form below to update this user group and select a list of members and moderators
            using the options below.
        </p>
        
        <img src="/img/create-usergroups-large.png" width="45" height="33" />
        
        <?php echo $this->element('../user_groups/_form'); ?>
        
        <button id="update_user_group" type="submit" class="button blue auto_select_and_submit">Update usergroup</button>
    </fieldset>
</form>