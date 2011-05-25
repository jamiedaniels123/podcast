<form accept-charset="utf-8" action="/user_groups/add" method="post" id="UserGroupAddForm">
    <fieldset>
        <legend>Create User Group</legend>
        <p>
            Use the form below to create a new user group. You will automatically be assigned
            as the moderator.
        </p>
        <div class="input text">
            <label for="title">Title</label>
            <input type="text" id="UserGroupTitle" name="data[UserGroup][group_title]" value="<?php echo $this->data['UserGroup']['group_title']; ?>">
        </div>
        <button id="create_user_group" type="submit">create user group</button>
    </fieldset>
</form>