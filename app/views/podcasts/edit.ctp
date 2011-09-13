<?php echo $this->element('tabs'); ?>
<div class="content">
	<form accept-charset="utf-8" action="/podcasts/edit/<?php echo $this->data['Podcast']['id']; ?>#<?php echo $element; ?>" method="post" id="PodcastEditForm" enctype="multipart/form-data">
		<?php echo $this->element('../podcasts/_edit'); ?>
    </form>
</div>