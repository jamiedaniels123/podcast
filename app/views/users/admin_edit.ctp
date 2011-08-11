<form accept-charset="utf-8" action="/admin/users/edit/<?php echo $this->data['User']['id']; ?>" method="post" id="UserEditForm">
    <input type="hidden" id="UserId" name="data[User][id]" value="<?php echo $this->data['User']['id']; ?>">
    <fieldset>
        <legend><h3>Update User</h3></legend>
        <p class="leader">
            Use the form below to update details of this user.
        </p>
        
        <img src="/img/your-usergroups-large.png" width="45" height="33" />
        
        <?php echo $this->element('../users/_form'); ?>
        <button id="update_user" type="submit" class="button blue auto_select_and_submit">Update user</button>
    </fieldset>
<form>