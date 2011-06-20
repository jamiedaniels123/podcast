<div class="wrapper">
    <div class="input text float_right">
        <label for="UserLastname">Lastname</label>
        <input type="hidden" value="" id="UserLastname_" name="data[User][lastname]">
        <input type="text" id="UserLastname" value="<?php echo $this->data['User']['lastname']; ?>" name="data[User][lastname]">
        <?php echo $this->Form->error('User.lastname'); ?>
    </div>
    <div class="input text float_left">
        <label for="UserFirstname">Firstname</label>
        <input type="hidden" value="" id="UserFirstname_" name="data[User][firstname]">
        <input type="text" id="UserFirstname" value="<?php echo $this->data['User']['firstname']; ?>" name="data[User][firstname]">
        <?php echo $this->Form->error('User.firstname'); ?>
    </div>
</div>
<div class="clear"></div>
<div class="input text">
    <label for="UserEmail">Email</label>
    <input type="hidden" value="" id="UserEmail_" name="data[User][email]">
    <input type="text" id="UserEmail" value="<?php echo $this->data['User']['email']; ?>" name="data[User][email]">
    <?php echo $this->Form->error('User.email'); ?>
</div>
<div class="clear"></div>
<div class="wrapper">
    <div class="input checkbox float_left">
        <input type="hidden" value="0" id="UserAdministrator_" name="data[User][administrator]">
        <input type="checkbox" id="UserAdministrator" value="1" <?php echo $this->data['User']['administrator'] == '1' ? 'checked="checked"' : '';?> name="data[User][administrator]">
        <label for="UserAdministrator">Administrator</label>
        <?php echo $this->Form->error('User.administrator'); ?>
    </div>
    <div class="input checkbox float_left">
        <input type="hidden" value="0" id="UserApprover_" name="data[User][approver]">
        <input type="checkbox" id="UserApprover" value="1" <?php echo $this->data['User']['approver'] == '1' ? 'checked="checked"' : '';?> name="data[User][approver]">
        <label for="UserApprover">Approver</label>
        <?php echo $this->Form->error('User.approver'); ?>
    </div>
    <div class="input checkbox float_left">
        <input type="hidden" value="N" id="UserITunesU_" name="data[User][iTunesU]">
        <input type="checkbox" id="UserITunesU" value="Y" <?php echo $this->data['User']['iTunesU'] == 'Y' ? 'checked="checked"' : '';?> name="data[User][iTunesU]">
        <label for="UserITunesU">iTunes U</label>
        <?php echo $this->Form->error('User.iTunesU'); ?>
    </div>
    <div class="input checkbox float_left">
        <input type="hidden" value="N" id="UserYouTube_" name="data[User][YouTube]">
        <input type="checkbox" id="UserYouTube" value="Y" <?php echo $this->data['User']['YouTube'] == 'Y' ? 'checked="checked"' : '';?> name="data[User][YouTube]">
        <label for="UserYouTube">You Tube</label>
        <?php echo $this->Form->error('User.YouTube'); ?>
    </div>
    <div class="input checkbox float_left">
        <input type="hidden" value="N" id="UserOpenlearnExplore_" name="data[User][openlearn_explore]">
        <input type="checkbox" id="UserOpenlearnExplore" value="Y" <?php echo $this->data['User']['openlearn_explore'] == 'Y' ? 'checked="checked"' : '';?> name="data[User][openlearn_explore]">
        <label for="UserOpenlearnExplore">Open Learn Explore</label>
        <?php echo $this->Form->error('User.OpenlearnExplore'); ?>
    </div>
</div>
<div class="clear"></div>