<fieldset class="podcasts index">
    <legend>Your Podcasts</legend>
    <p>
        Below is a list of all podcasts on the system to which you have access. You can filter using the options below and
        sort by column headings.
    </p>
    <?php echo $this->element('../podcasts/_filter'); ?>
    <p>
        <?php
            echo $this->Paginator->counter(array(
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
            ));
        ?>
    </p>
    <form method="post" action="/podcasts/delete">
        <a href="/" class="toggler" data-status="unticked">Toggle</a>
        <button type="submit" onclick="return confirm('Are you sure you wish to delete all these podcasts and associated media?')"><span>delete</span></button>

            <table cellpadding="0" cellspacing="0">
            <tr>
                <th>Select</th>
                <th>Image</th>
                <th><?php echo $this->Paginator->sort('Owner', 'user_id');?></th>
                <th><?php echo $this->Paginator->sort('title');?></th>
                <th><?php echo $this->Paginator->sort('Created');?></th>

                <th class="actions"><?php __('Actions');?></th>
            </tr>
            <?php
            // Check to see if there is an incremental count on this->data, the ['Meta'] exists so just looking for integer count
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
                            <?php if( $this->Permission->isOwner( $podcast['Owner']['id'] ) ) : ?>
                                <input type="checkbox" name="data[Podcast][Checkbox][<?php echo $podcast['Podcast']['id']; ?>]" class="podcast_selection" id="PodcastCheckbox<?php echo $podcast['Podcast']['id']; ?>">
                            <?php else : ?>
                                Not Available
                            <?php endif; ?>
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
                        <td class="actions">
                            <a href="/podcasts/view/<?php echo $podcast['Podcast']['id']; ?>">view</a>
                            <?php if( $this->Permission->isOwner( $podcast['Owner']['id'] ) ) : ?>
                                <a href="/podcasts/edit/<?php echo $podcast['Podcast']['id']; ?>">edit</a>
                                <a href="/podcasts/delete/<?php echo $podcast['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to delete this podcast and associated media?');">delete</a>
                                <a href="/podcast_items/index/<?php echo $podcast['Podcast']['id']; ?>">media</a>
                            <?php elseif( $this->Permission->isModerator( $podcast['Moderators'] ) || $this->Permission->inModeratorGroup( $podcast['ModeratorGroups'] ) ) : ?>
                                <a href="/podcasts/edit/<?php echo $podcast['Podcast']['id']; ?>">moderate</a>
                                <a href="/podcast_items/index/<?php echo $podcast['Podcast']['id']; ?>">media</a>
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