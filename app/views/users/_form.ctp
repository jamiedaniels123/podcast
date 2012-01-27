<div class="wrapper">

<div id="content" class="text form_title">
    <div class="user_input text">
        <label for="UserLastname">Lastname</label>
        <input type="hidden" value="" id="UserLastname_" name="data[User][lastname]">
        <input type="text" size="60" id="UserLastname" value="<?php echo $this->data['User']['lastname']; ?>" name="data[User][lastname]">
        <?php echo $this->Form->error('User.lastname'); ?>
    </div>
    <div class="user_input text">
        <label for="UserFirstname">Firstname</label>
        <input type="hidden" value="" id="UserFirstname_" name="data[User][firstname]">
        <input type="text" size="60" id="UserFirstname" value="<?php echo $this->data['User']['firstname']; ?>" name="data[User][firstname]">
        <?php echo $this->Form->error('User.firstname'); ?>
    </div>

    <div class="user_input text">
        <label for="UserEmail">Email</label>
        <input type="hidden" value="" id="UserEmail_" name="data[User][email]">
        <input type="text" size="60" id="UserEmail" value="<?php echo $this->data['User']['email']; ?>" name="data[User][email]">
        <?php echo $this->Form->error('User.email'); ?>
    </div>

    <div class="user_input checkbox">
        <input type="hidden" value="0" id="UserAdministrator_" name="data[User][administrator]">
        <label for="UserAdministrator">Administrator</label>
        <input type="checkbox" id="UserAdministrator" value="1" <?php echo $this->data['User']['administrator'] == '1' ? 'checked="checked"' : '';?> name="data[User][administrator]"> 
        <?php echo $this->Form->error('User.administrator'); ?>
    </div>
    
    <div class="user_input checkbox">
        <input type="hidden" value="N" id="UserITunesU_" name="data[User][iTunesU]">
        <label for="UserITunesU">iTunes U</label>
        <input type="checkbox" id="UserITunesU" value="Y" <?php echo $this->data['User']['iTunesU'] == 'Y' ? 'checked="checked"' : '';?> name="data[User][iTunesU]">
        <?php echo $this->Form->error('User.iTunesU'); ?>
    </div>
    
    <div class="user_input checkbox">
        <input type="hidden" value="N" id="UserYouTube_" name="data[User][YouTube]">
        <label for="UserYouTube">YouTube</label>
        <input type="checkbox" id="UserYouTube" value="Y" <?php echo $this->data['User']['YouTube'] == 'Y' ? 'checked="checked"' : '';?> name="data[User][YouTube]">
        <?php echo $this->Form->error('User.YouTube'); ?>
    </div>
    
    <div class="user_input checkbox">
        <input type="hidden" value="N" id="UserOpenlearnExplore_" name="data[User][openlearn_explore]">
        <label for="UserOpenlearnExplore">OpenLearn Explore</label>
        <input type="checkbox" id="UserOpenlearnExplore" value="Y" <?php echo $this->data['User']['openlearn_explore'] == 'Y' ? 'checked="checked"' : '';?> name="data[User][openlearn_explore]">
        <?php echo $this->Form->error('User.OpenlearnExplore'); ?>
    </div>
    
    <div class="user_input checkbox">
        <input type="hidden" value="0" id="UserVle_" name="data[User][vle]">
        <label for="UserYouTube">VLE</label>
        <input type="checkbox" id="UserVle" value="Y" <?php echo $this->data['User']['vle'] == true ? 'checked="checked"' : '';?> name="data[User][vle]">
        <?php echo $this->Form->error('User.vle'); ?>
    </div>
    
</div><!--/id="content" class="text form_title-->
</div><!--/wrapper-->
<div class="clear"></div>