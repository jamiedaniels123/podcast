<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php __('CakePHP: the rapid development php framework:'); ?>
        <?php echo $title_for_layout; ?>

    </title>
    <link rel="stylesheet" type="text/css" media="all" href="/cgi-bin/filechucker.cgi?css" />
    <?php
        echo $this->Javascript->link('jquery.js');
        echo $this->Javascript->link('jquery-ui.js');
        echo $this->Javascript->link('application.js');
        echo $this->Javascript->link('/cgi-bin/filechucker.cgi?js');

        echo $this->Html->meta('icon');
        echo $this->Html->css('cake.generic');
        echo $this->Html->css('jquery-ui');
        echo $scripts_for_layout;
        
    ?>
    
</head>
<body>
    <div id="container">
        <div id="header">
            <h1>Podcasts</h1>
            <?php if( $this->Session->check('Auth.User.id') ) : ?>

            <ol>
                <li><a href="/users/logout" title="logout link" id="logout_link">Logout <?php echo $this->Session->read('Auth.User.full_name'); ?></a></li>
                <li><a href="/users/dashboard" title="dashboard link" id="dashboard_link">Dashboard</a></li>
            <?php endif; ?>
        </div>
        <div id="content">
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->element('error'); ?>
            <?php echo $content_for_layout; ?>
        </div>
        <div id="footer">
            &nbsp;
        </div>
    </div>
    <?php echo $this->element('sql_dump'); ?>
</body>
</html>