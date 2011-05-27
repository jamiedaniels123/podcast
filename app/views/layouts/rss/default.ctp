<?php echo $rss->header(); ?>
<?php $channel = $this->Rss->channel(array(), $channelData, $content_for_layout); ?>
<?php echo $rss->document(array(),$channel); ?>