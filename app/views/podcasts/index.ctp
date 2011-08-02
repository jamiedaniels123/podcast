<fieldset class="podcasts index">
    <legend><span>Your Collections</span></legend>
    
    <img src="/img/collection-large.png" />
    
    <p class="leader">
        Below is a list of all podcasts on the system to which you have access. You can filter using the options below and
        sort by column headings.
    </p>
    
    <!--This css adds some order to the top of the 'Your collections' page by placing the Add a new collection button to the left and the view filter to the right of the screen-->
    
    <div class="collection-top">
    	<div class="left"><h3><a class="button white" href="/podcasts/add"><img src="/img/add-new.png" alt="Add a new collection" width="16" height="16" class="icon" />Add a new collection</a></h3></div>
    	<div class="right"><?php echo $this->element('../podcasts/_filter'); ?></div>
    </div>
    <div class="clear"></div>
    <form method="post" action="">

            <table cellpadding="0" cellspacing="0" border="0">
            <tr>
                <th>Select</th>
                <th width="72px" align="center">Image</th>
                <th><?php echo $this->Paginator->sort('title');?></th>
                <th width="240px"><?php echo $this->Paginator->sort('Owner', 'user_id');?></th>
                <th width="120px"><?php echo $this->Paginator->sort('Created');?></th>
                <th width="15px"><?php echo $this->Paginator->sort('Media',count('PodcastItems') );?></th>                
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
                        <td class="checkbox">
                            <input type="checkbox" name="data[Podcast][Checkbox][<?php echo $podcast['Podcast']['id']; ?>]" class="podcast_selection" id="PodcastCheckbox<?php echo $podcast['Podcast']['id']; ?>">
                        </td>
                        <td class="thumbnail" >
                            <img src="<?php echo $this->Attachment->getMediaImage( $podcast['Podcast']['image'], $podcast['Podcast']['custom_id'], THUMBNAIL_EXTENSION ); ?>" class="thumbnail" title="podcast image" />
                        </td>
                        <td class="collection-title">
                            <a href="/podcasts/view/<?php echo $podcast['Podcast']['id']; ?>"><?php echo $podcast['Podcast']['title']; ?></a>
                        </td>
                        <td class="owner">
                            <span class="podcast-owner">Created by <?php echo $podcast['Owner']['full_name']; ?></span>
                            <!--<?php echo $podcast['Owner']['full_name']; ?>-->
                        </td>
                        <td class="created">
                            <span class="podcast-owner"><?php echo $this->Time->getPrettyShortDate( $podcast['Podcast']['created'] ); ?></span>
                        </td>
                        <td class="media">
                            <?php echo count( $podcast['PodcastItems'] ); ?>
                        </td>
                        <td class="actions">
                            <a href="/podcasts/view/<?php echo $podcast['Podcast']['id']; ?>"><img src="/img/icon-16-link.png" alt="View collection contents" class="icon" />View</a>
                            <?php if( $this->Permission->isOwner( $podcast['Owner']['id'] ) ) : ?>
                                <a href="/feeds/add/<?php echo $podcast['Podcast']['id']; ?>"><img src="/img/icon-16-rss.png" alt="Refresh RSS" class="icon" />Refresh RSS</a>
                                <a href="/podcasts/delete/<?php echo $podcast['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to delete this collection and associated media?');"><img src="/img/icon-16-link-delete.png" alt="Delete" class="icon" />Delete</a>
                            <?php elseif( $this->Permission->isModerator( $podcast['Moderators'] ) || $this->Permission->inModeratorGroup( $podcast['ModeratorGroups'] ) ) : ?>
                                <a href="/feeds/add/<?php echo $podcast['Podcast']['id']; ?>"><img src="/img/icon-16-rss.png" alt="Refresh RSS" class="icon" />Refresh RSS</a>
                            <?php endif; ?>
                        </td>
                    </tr>
        <?php
                endforeach;
        endif; ?>
        </table>
        
        <a href="/" class="toggler button blue" data-status="unticked">Select/Unselect all</a>
		<a class="button white multiple_action_button" type="button" href="/feeds/add" id="generate_rss_multiple_podcasts"><span><img src="/img/icon-16-rss.png" alt="Refresh RSS" class="icon" />Refresh RSS</span></a>
        <a class="button white multiple_action_button" type="button" href="/podcasts/delete" id="delete_multiple_podcasts"><span><img src="/img/icon-16-link-delete.png" alt="Delete" class="icon" />Delete</span></a>
       
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
	   	<?php echo $this->Paginator->prev(''.__('Previous', true), array(), null, array('class'=>'disabled previous'));?>
     | 	<?php echo $this->Paginator->numbers();?>
        <?php echo $this->Paginator->next(__('Next', true).'', array(), null, array('class'=>'disabled next'));?>
        </div>
    </div>
</fieldset>