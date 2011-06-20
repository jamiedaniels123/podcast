<fieldset class="podcasts index">
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
    <form method="post" action="/admin/podcasts/delete">
        <a href="/" class="toggler" data-status="unticked">Toggle</a>
        <button type="submit" onclick="return confirm('Are you sure you wish to delete all these podcasts and associated media?')"><span>delete</span></button>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th>Select</th>
                <th>Image</th>
                <th><?php echo $this->Paginator->sort('Owner', 'user_id');?></th>
                <th><?php echo $this->Paginator->sort('title');?></th>
                <th><?php echo $this->Paginator->sort('created');?></th>
                <th><?php echo $this->Paginator->sort('Intended for iTunes U','intended_itunesu_flag');?></th>
                <th><?php echo $this->Paginator->sort('Intended for Youtube','intended_youtube_flag');?></th>
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
                        <td>
                            <input type="checkbox" name="data[Podcast][Checkbox][<?php echo $podcast['Podcast']['id']; ?>]" class="podcast_selection" id="PodcastCheckbox<?php echo $podcast['Podcast']['id']; ?>">
                        </td>
                        <td>
                            <?php echo $this->Attachment->getPodcastThumbnail( $podcast ); ?>
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
                        <td>
                            <?php echo $podcast['Podcast']['intended_itunesu_flag']; ?>
                        </td>
                        <td>
                            <?php echo $podcast['Podcast']['intended_youtube_flag']; ?>
                        </td>
                        <td class="actions">
                            <a href="/podcasts/view/<?php echo $podcast['Podcast']['id']; ?>" id="view_podcast_<?php echo $podcast['Podcast']['id']; ?>">view</a>
                            <?php if( $this->Object->intendedForItunes( $podcast['Podcast'] ) ) : ?>
                                <a href="/approve/podcasts/approve/itunes/<?php echo $podcast['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to approve this podcast for itunesu?');" id="approve_itunes_podcast_<?php echo $podcast['Podcast']['id']; ?>">itunes approve</a>
                                <a href="/approve/podcasts/reject/itunes/<?php echo $podcast['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to reject this podcast for itunesu?');" id="reject_itunes_podcast_<?php echo $podcast['Podcast']['id']; ?>">itunes reject</a>
                            <?php endif; ?>
                            <?php if( $this->Object->intendedForYoutube( $podcast['Podcast'] ) ) : ?>
                                <a href="/approve/podcasts/approve/youtube/<?php echo $podcast['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to approve this podcast for youtube?');" id="approve_youtube_podcast_<?php echo $podcast['Podcast']['id']; ?>">youtube approve</a>
                                <a href="/approve/podcasts/reject/youtube/<?php echo $podcast['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to reject this podcast for youtube?');" id="reject_youtube_podcast_<?php echo $podcast['Podcast']['id']; ?>">youtube reject</a>
                            <?php endif; ?>
                        </td>
                    </tr>
            <?php
                endforeach;
            endif; ?>
        </table>
    </form>
    <div class="paging">
            <?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
     | 	<?php echo $this->Paginator->numbers();?>
            <?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
    </div>
</fieldset>