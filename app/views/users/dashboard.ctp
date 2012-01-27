<?php echo $this->Session->flash(); ?>

<fieldset>
<!--<legend><span>Dashboard</span></legend>-->
<div id="dashboard" class="wrapper">
    <!--<p>Hello <?php echo $this->Session->read('Auth.User.firstname'); ?>,</p>
    <p>And welcome to your dashboard. On this page you will find ...</p>-->
    
	<div class="float_right_dash dashboard-user-panel">
    
   		<div>
   			
    			<p class="dashboard-user-panel-title">
			
					<?php echo $this->Session->read('Auth.User.full_name'); ?></p>
            <img src="/img/temp-avatar.png" />
					<!--LOGOUT BUTTON-->
					<?php if( $this->Session->check('Backup.User.id') ) : ?>
            		<br /><a href="/users/pseudo" title="logout link" style="margin-left:10px;" class="button orange"  id="logout_link">Psuedo Logout <!--<?php echo $this->Session->read('Auth.User.full_name'); ?>--></a>
					<?php elseif( $this->Session->check('Auth.User.id') ) : ?>
            		<br /><a href="/users/logout" title="logout link" style="margin-left:10px;" class="button orange"  id="logout_link">Logout <!--<?php echo $this->Session->read('Auth.User.full_name'); ?>--></a>
            		<?php endif; ?>
           			 <!--/LOGOUT BUTTON-->
                     
                     
  				
        
        </div>
   <div style="clear:both;"></div>
            
            
            
        <ul>
            <!-- <li style="display:block;line-height: 22px; background-image: url(/img/information.png);background-repeat: no-repeat;background-position: 0px 4px;padding-left: 22px;"><a href="/podcasts" class="button">You own <?php echo count( $this->data['Podcasts'] ); ?> collections.</a></li>
            <li style="display:block;line-height: 22px; background-image: url(/img/information.png);background-repeat: no-repeat;background-position: 0px 4px;padding-left: 22px;"><a href="/user_groups" class="button">You are a member of <?php echo count( $this->data['UserGroups'] ); ?> user groups.</a></li> -->
			<?php if( $this->Permission->isItunesUser() ) : ?>
	            <li style="display:block;line-height: 22px; background-image: url(/img/icon-16-itunes.png);background-repeat: no-repeat;background-position: 0px 4px;padding-left: 22px;"><a href="/itunes/podcasts" class="button">Itunes collections</a></li>
    		<?php endif; ?>
			<?php if( $this->Permission->isYoutubeUser() ) : ?>
	            <li style="display:block;line-height: 22px; background-image: url(/img/icon-16-youtube.png);background-repeat: no-repeat;background-position: 0px 4px;padding-left: 22px;"><a href="/youtube/podcasts" class="button">Youtube collections</a></li>
			<?php endif; ?>	            
			<?php if( $this->Permission->isVleUser() ) : ?>
	            <li style="display:block;line-height: 22px; background-image: url(/img/icon-16-youtube.png);background-repeat: no-repeat;background-position: 0px 4px;padding-left: 22px;"><a href="/vle/podcasts" class="button">Vle collections</a></li>
			<?php endif; ?>	            

        </ul>
    </div>
    

    
    
    <div class="float_left_list">
        <ul class="dashboard">
            <li><a href="/podcasts"><img src="/img/your-collections.png" alt="Your Podcasts" /></a></li>
            <li><a href="/podcasts/add"><img src="/img/create-new-collections.png" alt="Create New Podcast" /></a></li>
         </ul>
         <ul class="dashboard">
            <li><a href="/user_groups"><img src="/img/your-usergroups.png" alt="Your User Groups" /></a></li>
            <li><a href="/user_groups/add"><img src="/img/create-new-usergroups.png" alt="Create New User Group" /></a></li>
        </ul>
    </div>
</div>
<div class="clear"></div>
<?php if( $this->Session->read( 'Auth.User.administrator' ) ) : ?>
    <?php echo $this->element('../users/_admin_panel'); ?>
<?php endif; ?>
</fieldset>