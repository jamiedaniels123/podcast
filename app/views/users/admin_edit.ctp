<form accept-charset="utf-8" action="/admin/users/edit/<?php echo $this->data['User']['id']; ?>" method="post" id="UserEditForm">
    <input type="hidden" id="UserId" name="data[User][id]" value="<?php echo $this->data['User']['id']; ?>">
    <fieldset>
        <legend>Update User</legend>
        <p>
            Use the form below to update details of this user.
        </p>
        <?php echo $this->element('../users/_form'); ?>
        <button id="update_user" type="submit" class="auto_select_and_submit">update user</button>
    </fieldset>
<form>