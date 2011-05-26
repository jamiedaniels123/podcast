<?php
echo $rss->header();

$channel = $this->Rss->channel(array(), $channelData, $content_for_layout);

echo $rss->document(array(),$channel);
?>