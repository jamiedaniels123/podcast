<fieldset class="podcasts index youtube">
    <legend><h3>Youtube collections</h3></legend>
    
    <p class="leader">
        Below is a list of all youtube collections podcasts on the system.
    </p>
    
    <img src="/img/collection-large.png" />
    
    <!--This css adds some order to the top of the 'Your collections' page by placing the Add a new collection button to the left and the view filter to the right of the screen-->
    
    <div class="input select">
		<?php echo $this->element('../podcasts/_itunes_youtube_filter'); ?>
    </div>
    <div class="clear"></div>
    
        <table cellpadding="0" cellspacing="0">
        <tr>
            <th>Image</th>
            <th><?php echo $this->Paginator->sort('title');?></th>
            <th><?php echo $this->Paginator->sort('Owner', 'user_id');?></th>
            <th><?php echo $this->Paginator->sort('Created');?></th>
            <th><?php echo $this->Paginator->sort('Media',count('PodcastItems') );?></th>
            <th>Approved</th>                
            <th>Published</th>
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
                        <img src="<?php echo $this->Attachment->getMediaImage( $podcast['Podcast']['image'], $podcast['Podcast']['custom_id'], THUMBNAIL_EXTENSION ); ?>" class="thumbnail" title="podcast image" />
                    </td>
                    <td>
                        <a href="#"><?php echo $podcast['Podcast']['title']; ?></a>
                    </td>
                    <td>
                        <span class="podcast-owner">Owned by <?php echo $podcast['Owner']['full_name']; ?></span>
                    </td>
                    <td>
                        <span class="podcast-owner"><?php echo $this->Time->getPrettyShortDate( $podcast['Podcast']['created'] ); ?></span>
                    </td>
                    <td>
                        <?php echo count( $podcast['PodcastItems'] ); ?>
                    </td>
                    <td>
                    	<img src="/img<?php echo $this->Object->intendedForYoutube( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" />
                    </td>
                    <td>
                    	<img src="/img<?php echo $this->Object->youtubePublished( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" />
                    </td>
                    <td class="actions">
						<?php if( $this->Object->waitingYoutubeApproval( $podcast['Podcast'] ) ) : ?>                    
                       		<a href="/podcasts/justification/<?php echo $podcast['Podcast']['id']; ?>" id="view_podcast_<?php echo $podcast['Podcast']['id']; ?>">view</a>
                       	<?php else : ?>
                        	<a href="/podcasts/view/<?php echo $podcast['Podcast']['id']; ?>">view</a>
                        <?php endif; ?>
                        <a href="/feeds/add/<?php echo $podcast['Podcast']['id']; ?>">refresh rss</a>
                        <a href="/podcasts/edit/<?php echo $podcast['Podcast']['id']; ?>">edit</a>
                        <a href="/podcast_items/index/<?php echo $podcast['Podcast']['id']; ?>">media</a>
                    </td>
                </tr>
    <?php
            endforeach;
    endif; ?>
    </table>
    
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
