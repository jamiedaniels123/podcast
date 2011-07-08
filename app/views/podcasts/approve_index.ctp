<fieldset class="podcasts approval">
    <legend>Podcasts Waiting Approval</legend>
    <p>
        Below is a list of all podcasts on the system that are awaiting approval.
    </p>
    <p>
        <?php
            echo $this->Paginator->counter(array(
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
            ));
        ?>
    </p>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th>Image</th>
                <th><?php echo $this->Paginator->sort('Owner', 'user_id');?></th>
                <th><?php echo $this->Paginator->sort('title');?></th>
                <th><?php echo $this->Paginator->sort('created');?></th>
                <th class="status"><?php echo $this->Paginator->sort('Consider for iTunesU','consider_for_itunesu');?></th>
                <th class="status"><?php echo $this->Paginator->sort('Consider for Youtube','consider_for_youtube');?></th>
                <th class="actions"><?php __('Actions');?></th>
            </tr>
            <?php
            if( isSet( $this->data['Podcasts'] ) ) :
                $i = 0;
                foreach ($this->data['Podcasts'] as $podcast ) :

                    $class = null;
                    if ($i++ % 2 == 0) :
                        $class = ' class="altrow"';
                    endif;
            ?>
                    <tr<?php echo $class;?>>
                        <td class="image thumbnail">
                            	<img src="<?php echo $this->Attachment->getMediaImage( $podcast['Podcast']['image'], $podcast['Podcast']['custom_id'], THUMBNAIL_EXTENSION); ?>" class="thumbnail" title="thumbnail image" />
                        </td>
                        <td>
                            	<?php echo $podcast['Owner']['full_name']; ?>
                        </td>
                        <td>
                            	<?php echo $podcast['Podcast']['title']; ?>
                        </td>
                        <td>
                            	<?php echo $this->Time->getPrettyShortDate( $podcast['Podcast']['created'] ); ?>
                         </td>
                        <td class="status">
                        	<img src="/img<?php echo $this->Object->waitingItunesApproval( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="waiting itunes approval" class="status_image" />
                        </td>
                        <td class="status">
                        	<img src="/img<?php echo $this->Object->waitingYoutubeApproval( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="waiting youtube approval" class="status_image" />
                        </td>
                        <td class="actions">

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