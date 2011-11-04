<form accept-charset="utf-8" action="/user_groups/add" method="post" id="UserGroupAddForm">
    <fieldset>
        <legend><h3>Create User Group</h3></legend>
        <p class="leader">
            Use the form below to create a new user group. You will automatically be assigned as the moderator.
        </p>
        
        <img src="/img/create-usergroups-large.png" width="45" height="33" />
        
        
        <div id="content" class="text form_title">
            <label for="title">Title</label>
            <input type="text" size="60" id="UserGroupTitle" name="data[UserGroup][group_title]" value="<?php echo $this->data['UserGroup']['group_title']; ?>">
        </div>
        <button id="create_user_group" class="button blue" type="submit">create user group</button>
    </fieldset>
</form>