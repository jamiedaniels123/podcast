<form accept-charset="utf-8" action="/admin/user_groups/edit" method="post" id="UserGroupEditForm">
    <input type="hidden" name="data[UserGroup][id]" id="UserGroupId" value="<?php echo $this->data['UserGroup']['id']; ?>">
    <fieldset>
        <legend>Update User Group</legend>
        <p>
            Use the form below to update this user group and select a list of members and moderators
            using the options below.
        </p>
        <?php echo $this->element('../user_groups/_form'); ?>
        <button id="update_user_group" type="submit" class="auto_select_and_submit">update user group</button>
    </fieldset>
</form>