<fieldset>
<!--<legend><span>Dashboard</span></legend>-->
<div id="dashboard" class="wrapper">
    <!--<p>Hello <?php echo $this->Session->read('Auth.User.firstname'); ?>,</p>
    <p>And welcome to your dashboard. On this page you will find ...</p>-->

    <div class="float_right">
        <ul>
            <li style="list-style:none;"><a href="/podcasts" class="button white"><img src="/img/information.png" alt="Information" class="icon" />You own <?php echo count( $this->data['Podcasts'] ); ?> podcasts.</a></li>
            <li style="list-style:none;"><a href="/user_groups" class="button white"><img src="/img/information.png" alt="Information" class="icon" />You are a member of <?php echo count( $this->data['UserGroups'] ); ?> user groups.</a></li>
            <?php if( $this->Permission->isItunesUser() ) : ?>
                <li style="list-style:none;"><img src="/img/information.png" alt="Information" class="icon" /><a href="/itunes/podcasts">iTunes Collections</a></li>
            <?php endif; ?>
            <?php if( $this->Permission->isYouTubeUser() ) : ?>
                <li style="list-style:none;"><img src="/img/information.png" alt="Information" class="icon" /><a href="/youtube/podcasts">Youtube Collections</a></li>
            <?php endif; ?>

        </ul>
    </div>
    <div class="float_left">
        <ul class="dashboard">
            <li><a href="/podcasts"><img src="../img/your-collections.png" alt="Your Podcasts" /></a></li>
            <li><a href="/podcasts/add"><img src="../img/create-new-collections.png" alt="Create New Podcast" /></a></li>
         </ul>
         <ul class="dashboard">
            <li><a href="/user_groups"><img src="../img/your-usergroups.png" alt="Your User Groups" /></a></li>
            <li><a href="/user_groups/add"><img src="../img/create-new-usergroups.png" alt="Create New User Group" /></a></li>
        </ul>

    </div>
</div>
<div class="clear"></div>
<?php if( $this->Session->read( 'Auth.User.administrator' ) ) : ?>
    <?php echo $this->element('../users/_admin_panel'); ?>
<?php endif; ?>
</fieldset>
