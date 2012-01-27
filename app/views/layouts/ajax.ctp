<div id="item-content">
    <ul class="item-tab-zone">
        <li <?php echo $element == 'summary' ? 'class="active"' : '';?> data-element="summary" data-id="<?php echo $this->data['PodcastItem']['id']; ?>">
             <a href="/" class="PodcastItemPreviewLink">Summary</a>
        </li>
        <li <?php echo $element == 'youtube' ? 'class="active"' : '';?> data-element="youtube" data-id="<?php echo $this->data['PodcastItem']['id']; ?>">
             <a href="/" class="PodcastItemPreviewLink">Youtube</a>
        </li>
        <li <?php echo $element == 'itunes' ? 'class="active"' : '';?> data-element="itunes" data-id="<?php echo $this->data['PodcastItem']['id']; ?>">
             <a href="/" class="PodcastItemPreviewLink">iTunes</a>
        </li>
        <li <?php echo $element == 'embed' ? 'class="active"' : '';?> data-element="embed" data-id="<?php echo $this->data['PodcastItem']['id']; ?>">
             <a href="/" class="PodcastItemPreviewLink">Embed</a>
        </li>
        
        <?php if($this->Permission->isItunesUser() ||  $this->Permission->isYouTubeUser() || $this->Permission->isAdministrator()):?>
        <li <?php echo $element == 'flavours' ? 'class="active"' : '';?> data-element="flavours" data-id="<?php echo $this->data['PodcastItem']['id']; ?>">
             <a href="/" class="PodcastItemPreviewLink">Flavours</a>
        </li>
        <?php endif;?>

    </ul>
	<?php echo $this->Session->flash(); ?>
    <?php echo $this->element('error'); ?>
    <?php echo $content_for_layout; ?>
</div>