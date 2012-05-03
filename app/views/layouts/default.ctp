<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $title_for_layout; ?>
    </title>
	<meta http-equiv="Accept-Encoding" content="gzip, deflate" />

<link rel="stylesheet" type="text/css" href="/includes/headers-footers/ou-header.css" />
<script type="text/javascript" src="/includes/headers-footers/ou-header.js"></script>
 
<meta name="viewport" content="width=device-width; initial-scale=1" />
  
<link rel="stylesheet" type="text/css" href="/includes/ouice/3/mobile.css" media="only screen and (max-device-width:640px)" />
<link rel="stylesheet" type="text/css" href="/includes/ouice/3/mobile.css" media="only screen and (max-width:640px)" />
  
<!-- <link rel="alternate stylesheet" href="/includes/ouice/3/mobile.css" title="ou-mobile" /> -->
 
<script type="text/javascript" src="/includes/headers-footers/ou-header.js"></script>
		
    <?php
    echo $this->Javascript->link('/js/jquery.js');
    echo $this->Javascript->link('/js/jquery-ui.js');
    echo $this->Javascript->link('/js/jquery-form.js');
    echo $this->Javascript->link('/cgi-bin/filechucker.cgi?js');
    echo $this->Javascript->link('/js/jquery.cookie.js');
    echo $this->Javascript->link('/js/application.js');
    echo $this->Html->meta('icon');
    echo $this->Html->meta('rss', '/podcasts/rss.rss');
    echo $this->Html->css('/css/cake.generic');
    echo $this->Html->css('/css/jquery-ui');
    echo $this->Html->css('/css/podcast-server');
    echo $this->Html->css('/css/ou-header');
    // BH 20120503 disabled as there doesn't appear to be a type.css file and it is causing CakePHP to then load index.php due to rewrite rules
    //    echo $this->Html->css('/css/type');  
    echo $this->Html->css('/css/interface');
    echo $this->Html->css('/css/items_interface');
    echo $scripts_for_layout;
    ?>
    
    <!--[if IE]>
        <link rel="stylesheet" type="text/css" href="/css/all-ie-only.css" />
        <link rel="stylesheet" type="text/css" href="/css/interface_ie.css" />
	<![endif]-->




    
</head>
<?php flush(); ?>
<body class="ou-ia-community">


    <!--display OU Header-->
	<?php echo $this->element('header'); ?>
    <!--/display OU Header-->
    

    
    <div id="container">
    
        <div id="header">
            <h1 class="sitename">OU Podcast Server</h1>
            <p class="strapline">For the management of podcast collections</p><div class="clear"></div>

            <?php echo $this->element('breadcrumb', array('breadcrumbs' => $breadcrumbs ) ); ?>
            
        </div>
        

        
        <div id="content">
            <?php echo $this->Session->flash(); ?>
            <?php echo $this->Session->flash('email'); ?>
            <?php echo $this->element('error'); ?>
            <div class="collection_wrapper">
	            <?php echo $content_for_layout; ?>
               </div>
        </div>
         
        <div id="footer">
            &nbsp;
        </div>
    </div>
    
    <!--display OU Footer-->
	<?php echo $this->element('footer'); ?>
    <!--/display OU Footer-->
    
	<?php echo $this->element('sql_dump'); ?>
    <div id="modal"></div>
    <script>
    // Hack to make the screen scroll back to the top after it has jumped down to the tabs.  It works but interferes with filechucker as it doesn't like onloads
    //window.onload = function() {
    //    // short timeout
    //    setTimeout(function() {
    //        $(document.body).scrollTop(0);
    //   }, 15);
    //};
    </script>
</body>
</html>