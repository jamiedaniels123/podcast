<fieldset>
    <legend> <?php echo $this->data['PodcastItem']['title'];?> Media : Administration </legend>
    <a href="/admin/podcast_items/edit/<?php echo $this->data['PodcastItem']['id'];?>" title="edit">edit</a>
    <a href="/admin/podcasts/view/<?php echo $this->data['Podcast']['id'];?>" title="edit">collection</a>
    <a href="/admin/podcast_items/delete/<?php echo $this->data['PodcastItem']['id'];?>" title="delete" onclick="return confirm('Are you sure you wish to perform a HARD DELETE this media?');" >delete</a>
    <div class="clear"></div>
    <?php echo $this->element('../podcast_items/_view'); ?>
</fieldset>