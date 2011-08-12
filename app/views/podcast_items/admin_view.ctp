<fieldset>
    <legend> <?php echo $this->data['PodcastItem']['title'];?> Media : Administration </legend>
    <a href="/admin/podcasts/view/<?php echo $this->data['Podcast']['id'];?>" title="edit">collection</a>
    <div class="clear"></div>
    <?php echo $this->element('../podcast_items/_view'); ?>
    <?php echo $this->element('../podcast_item_medias/_index'); ?>
</fieldset>