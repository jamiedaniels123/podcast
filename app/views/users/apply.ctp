<form id="UserApplyForm" method="post" action="/users/apply" accept-charset="utf-8">
    <fieldset id="register_fieldset">
        <legend><h3>Apply for Access</h3></legend>
        <p class="leader">
            Currently you must apply to use our podcast solution. Please complete the form below
        </p>
        
        <img src="/img/apply-user-large.png" width="45" height="33" />
        
        <div class="input">
            <label for="UserFirstName">First name</label>
            <input type="input" name="data[User][firstname]" id="UserFirstName" value="<?php echo @$this->data['User']['firstname']; ?>">
        </div>
        <div class="input">
            <label for="UserLastName">Last name</label>
            <input type="input" name="data[User][lastname]" id="UserLastName" value="<?php echo @$this->data['User']['lastname']; ?>">
        </div>
        <div class="input">
            <label for="UserOucu">Your OUCU</label>
            <input type="input" name="data[User][oucu]" id="UserContactOucu" value="<?php echo @$this->data['User']['oucu']; ?>">
        </div>
        <div class="input">
            <label for="UserEmail">Your contact email</label>
            <input type="input" name="data[User][email]" id="UserEmail" value="<?php echo @$this->data['User']['email']; ?>">
        </div>
        <div class="input textarea">
            <label for="UserJustification">Reason for applying</label>
            <textarea name="data[User][justification]" id="UserJustification"><?php echo @$this->data['User']['justification']; ?></textarea>
        </div>
        
        <button type="submit" class="button blue" id="apply_button"><span>Apply</span></button>
        
    </fieldset>
</form>