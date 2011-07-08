<fieldset class="podcasts index">
    <legend><span>iTunes U Collections</span></legend>
    
    <img src="/img/collection-large.png" />
    
    <p class="leader">
        Below is a list of all podcasts on the system to which you have access. You can filter using the options below and
        sort by column headings.
    </p>
    
    <!--This css adds some order to the top of the 'Your collections' page by placing the Add a new collection button to the left and the view filter to the right of the screen-->
    
    <div class="collection-top">
    	<div class="left"><h3><a href="/podcasts/add">Add a new collection</a></h3><a href="#"><img src="/img/add-new.png" alt="Add a new collection" width="16" height="16" class="icon" /></a></div>
    	<div class="right"><?php echo $this->element('../podcasts/_filter'); ?></div>
    </div>
    <div class="clear"></div>
    
    
    <form method="post" action="">

            <table cellpadding="0" cellspacing="0">
            <tr>
                <th>Select</th>
                <th>Image</th>
                <th><?php echo $this->Paginator->sort('title');?></th>
                <th><?php echo $this->Paginator->sort('Owner', 'user_id');?></th>
                <th><?php echo $this->Paginator->sort('Created');?></th>
                <th><?php echo $this->Paginator->sort('Media',count('PodcastItems') );?></th>                
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
                        <td width="15px">
                            <?php if( $this->Permission->isOwner( $podcast['Owner']['id'] ) ) : ?>
                                <input type="checkbox" name="data[Podcast][Checkbox][<?php echo $podcast['Podcast']['id']; ?>]" class="podcast_selection" id="PodcastCheckbox<?php echo $podcast['Podcast']['id']; ?>">
                            <?php endif; ?>
                        </td>
                        <td>
                            <img src="<?php echo $this->Attachment->getMediaImage( $podcast['Podcast']['image'], $podcast['Podcast']['custom_id'], THUMBNAIL_EXTENSION ); ?>" class="thumbnail" title="podcast image" />
                        </td>
                        <td>
                            <a href="#"><?php echo $podcast['Podcast']['title']; ?></a>
                        </td>
                        <td>
                            <span class="podcast-owner">Created by <?php echo $podcast['Owner']['full_name']; ?></span>
                            <!--<?php echo $podcast['Owner']['full_name']; ?>-->
                        </td>
                        <td>
                            <span class="podcast-owner"><?php echo $this->Time->getPrettyShortDate( $podcast['Podcast']['created'] ); ?></span>
                        </td>
                        <td>
                            <?php echo count( $podcast['PodcastItems'] ); ?>
                        </td>
                        <td class="actions">
                            <a href="/podcasts/view/<?php echo $podcast['Podcast']['id']; ?>">view</a>
                            <?php if( $this->Permission->isOwner( $podcast['Owner']['id'] ) ) : ?>
                                <a href="/feeds/add/<?php echo $podcast['Podcast']['id']; ?>">refresh rss</a>
                                <a href="/podcasts/edit/<?php echo $podcast['Podcast']['id']; ?>">edit</a>
                                <a href="/podcasts/delete/<?php echo $podcast['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to delete this podcast and associated media?');">delete</a>
                                <a href="/podcast_items/index/<?php echo $podcast['Podcast']['id']; ?>">media</a>
                            <?php elseif( $this->Permission->isModerator( $podcast['Moderators'] ) || $this->Permission->inModeratorGroup( $podcast['ModeratorGroups'] ) ) : ?>
                                <a href="/feeds/add/<?php echo $podcast['Podcast']['id']; ?>">generate rss</a>
                                <a href="/podcasts/edit/<?php echo $podcast['Podcast']['id']; ?>">moderate</a>
                                <a href="/podcast_items/index/<?php echo $podcast['Podcast']['id']; ?>">media</a>
                            <?php endif; ?>
                        </td>
                    </tr>
        <?php
                endforeach;
        endif; ?>
        </table>
        
        <a href="/" class="toggler button blue" data-status="unticked">Toggle</a>
        <button class="button white multiple_action_button" type="button" data-form_target="/podcasts/delete" id="delete_multiple_podcasts"><span>delete</span></button>
        <button class="button white multiple_action_button" type="button" data-form_target="/feeds/add" id="generate_rss_multiple_podcasts"><span>refresh rss</span></button>
       
    </form>
    <div class="paging">
    
     <p>
        <?php
            echo $this->Paginator->counter(array(
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
            ));
        ?>
    </p>    
       <div class="page-controls">
	   	<?php echo $this->Paginator->prev(''.__('previous', true), array(), null, array('class'=>'disabled previous'));?>
     | 	<?php echo $this->Paginator->numbers();?>
        <?php echo $this->Paginator->next(__('next', true).'', array(), null, array('class'=>'disabled next'));?>
        </div>
    </div>
</fieldset>