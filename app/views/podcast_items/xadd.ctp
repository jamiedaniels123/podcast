<fieldset class="podcast_items index">
    <legend><?php echo $this->data['Podcast']['title']; ?> Podcast Media</legend>
    <p>
        Use this form to add and manage media for a podcast. We recommend that you avoid using a PDF document as the most recent
        (top of the list) item in a podcast.
    </p>
    <p>
        <em>EMBED :</em> Individual tracks can now be embeded into other web pages via HTML snipets. To access this snipet click on
        the icon in the Media filename column and from the resulting popup window there is a button called 'EMBED OPTIONS' to access
        the embed interface.
    </p>
    <p>
        The 'embed' interface will be improved and better intergrated into the admin. At present this option is only available to administrators
        of podcasts. Embeding tracks from Podcasts restricted to the OU (SAMS only) will only work on OU sites and when a user has logged in.
    </p>
    <fieldset>
        <?php
            echo $this->Paginator->counter(array(
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
            ));
        ?>

        <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('filename');?></th>
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
                        <?php echo $this->Time->getPrettyShortDate( $podcast_item['created'] ); ?>
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

    <?php if( $this->Permission->isAdministrator() || $this->Permission->isOwner() || $this->Permission->isModerator() ) : ?>
        <?php echo $this->element('../podcast_items/_add'); ?>
    <?php endif; ?>
</fieldset>