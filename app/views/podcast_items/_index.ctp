<fieldset>
    <legend>Current Media</legend>
    <?php
        echo $this->Paginator->counter(array(
        'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
    ?>

    <table cellpadding="0" cellspacing="0">
    <tr>
        <th><?php echo $this->Paginator->sort('filename');?></th>
        <th><?php echo $this->Paginator->sort('Published', 'published_flag');?></th>
        <th><?php echo $this->Paginator->sort('iTunes', 'itunes_flag');?></th>
        <th><?php echo $this->Paginator->sort('YouTube', 'youtube_flag');?></th>
        <th><?php echo $this->Paginator->sort('Date Added');?></th>
        <th class="actions"><?php __('Actions');?></th>
    </tr>
    <?php
    // Check to see if there is an incremental count on this->data, the ['Meta'] exists so just looking for integer count
    if( isSet( $this->data['PodcastItems'] ) ) :

        $i = 0;
        foreach ($this->data['PodcastItems'] as $podcast_item ) :

            $class = null;
            if ($i++ % 2 == 0) :
                $class = ' class="altrow"';
            endif;
?>
            <tr<?php echo $class;?>>
                <td>
                    <?php echo $podcast_item['filename']; ?>
                </td>
                <td>
                    <?php echo $this->Attachment->getTickByText( $podcast_item['published_flag'] ); ?>
                </td>
                <td>
                    <?php echo $this->Attachment->getTickByText( $podcast_item['itunes_flag'] ); ?>
                </td>
                <td>
                    <?php echo $this->Attachment->getTickByText( $podcast_item['youtube_flag'] ); ?>
                </td>
                <td>
                    <?php echo $podcast_item['created'] ? $this->Time->getPrettyShortDate( $podcast_item['created'] ) : $this->Time->getPrettyShortDate( $podcast_item['created_when'] ); ?>
                </td>
                <td class="actions">
                    <?php echo $this->Html->link('edit',array('action' => 'edit', $podcast_item['id'] ) ); ?>
                    <?php echo $this->Html->link('delete',array('action' => 'delete', $podcast_item['id'] ), null, 'Are you sure you wish to delete this podcast media?' ); ?>
                </td>
            </tr>
<?php
        endforeach;
endif; ?>
</table>
<div class="paging">
        <?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
        <?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
</fieldset>
