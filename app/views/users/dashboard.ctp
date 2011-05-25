<fieldset>
<legend>Dashboard</legend>
<div id="dashboard" class="wrapper">
    <p>Hello <?php echo $this->Session->read('Auth.User.firstname'); ?>,</p>
    <p>And welcome to your dashboard. On this page you will find ...</p>

    <div class="float_right">
        <ul>
            <li><a href="/podcasts">You own <?php echo count( $this->data['Podcasts'] ); ?> podcasts.</a></li>
            <li><a href="/user_groups">You are a member of <?php echo count( $this->data['UserGroups'] ); ?> user groups.</a></li>
        </ul>
    </div>
    <div class="float_left">
        <ul>
            <li><a href="/podcasts">Your Podcasts</a></li>
            <li><a href="/podcasts/add">Create New Podcast</a></li>
            <li><a href="/user_groups">Your User Groups</a></li>
            <li><a href="/user_groups/add">Create New User Group</a></li>
        </ul>

    </div>
</div>
<div class="clear"></div>
<?php if( $this->Session->read( 'Auth.User.administrator' ) ) : ?>
    <?php echo $this->element('../users/_admin_panel'); ?>
<?php endif; ?>
</fieldset>