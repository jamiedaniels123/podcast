<div id="item-content">
    <ul class="item-tab-zone">
        <li class="active" data-id="summary">
             <a href="/" class="PodcastItemPreviewLink">Summary</a>
        </li>
        <li data-id="youtube">
             <a href="/" class="PodcastItemPreviewLink">Youtube</a>
        </li>
        <li data-id="itunes">
             <a href="/" class="PodcastItemPreviewLink">iTunes</a>
        </li>
        <li data-id="embed">
             <a href="/" class="PodcastItemPreviewLink">Embed</a>
        </li>
    </ul>
	<?php echo $this->Session->flash(); ?>
    <?php echo $this->element('error'); ?>
    <?php echo $content_for_layout; ?>
</div>