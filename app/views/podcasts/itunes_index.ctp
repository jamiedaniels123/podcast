<fieldset class="podcasts index">
    <legend><span>iTunesU collections</span></legend>
    
    <img src="/img/collection-large.png" />
    
    <p class="leader">
        Below is a list of all itunes collections on the system.
    </p>
    
    <!--This css adds some order to the top of the 'Your collections' page by placing the Add a new collection button to the left and the view filter to the right of the screen-->
    
    <div class="input select">

	    <form name="PodcastItunesUForm" action="/itunes/podcasts" method="post">
            <select name="data[Podcast][filter]" id="PodcastFilter">
				<option value="">Select a filter</option>
				<option value="consideration" <?php echo $filter == 'consideration' ? 'selected=true' : ''; ?>>For Consideration</option>
                <option value="intended" <?php echo $filter == 'intended' ? 'selected=true' : ''; ?>>Approved</option>
                <option value="published" <?php echo $filter == 'published' ? 'selected=true' : ''; ?>>Published</option>
            </select>
            <button type="submit" id="PodcastFilterSubmit"><span>Filter</span></button>
        </form>
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
            <th class="actions">Actions</th>
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
                        <?php echo $podcast['Podcast']['title']; ?>
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
                    	<img src="/img<?php echo $this->Object->intendedForItunes( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" />
                    </td>
                    <td>
                    	<img src="/img<?php echo $this->Object->itunesPublished( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" />
                    </td>
                    <td class="actions">
                    	<a href="/podcasts/view/<?php echo $podcast['Podcast']['id']; ?>">view</a>
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
