<fieldset class="podcasts index">
    <legend><h3>Your Collections</h3></legend>
    
    <p class="leader">
        Below is a list of all podcasts on the system to which you have access. You can filter using the options below and sort by column headings.
    </p>
    
    <img src="/img/collection-large.png" />
    
    <!--This css adds some order to the top of the 'Your collections' page by placing the Add a new collection button to the left and the view filter to the right of the screen-->
    
    <div class="collection-top">
    	<div class="left"><h3><a class="button white" href="/podcasts/add"><img src="/img/add-new.png" alt="Add a new collection" width="16" height="16" class="icon" />Add a new collection</a></h3></div>
    	<div class="right"><?php echo $this->element('../podcasts/_filter'); ?></div>
    </div>
    <div class="column_options">
    </div>
    <div class="clear"></div>
    <form method="post" action="">

            <table cellpadding="0" cellspacing="0" border="0">
            <tr>
                <th class="checkbox">Select</th>
                <th class="thumbnail">Image</th>
                <th class="thumbnail_copyright"><?php echo $this->Paginator->sort('Image Copyright','image_copyright');?></th>
                <th class="thumbnail_logoless">Image Logoless</th>
                <th class="thumbnail_logoless_copyright"><?php echo $this->Paginator->sort('Image Logoless Copyright','image_ll_copyright');?></th>
                <th class="thumbnail_wide">Image Widescreen</th>
                <th class="thumbnail_widescreen_copyright"><?php echo $this->Paginator->sort('Image Widescreen Copyright','image_wide_copyright');?></th>
                <th class="collection-title"><?php echo $this->Paginator->sort('title');?></th>
                <th class="copyright"><?php echo $this->Paginator->sort('copyright');?></th>
                <th class="owner"><?php echo $this->Paginator->sort('Owner', 'user_id');?></th>
                <th class="created"><?php echo $this->Paginator->sort('Created');?></th>
                <th class="author"><?php echo $this->Paginator->sort('Author');?></th>
                <th class="media"><?php echo $this->Paginator->sort('Media',count('PodcastItems') );?></th>
                <th class="course_code"><?php echo $this->Paginator->sort('Course Code','course_code' );?></th>
                <th class="preferred_node"><?php echo $this->Paginator->sort('Preferred Node','PreferredNode.title');?></th>
                <th class="preferred_url"><?php echo $this->Paginator->sort('Preferred URL','preferred_url');?></th>
                <th class="language"><?php echo $this->Paginator->sort('Language');?></th>
                <th class="explicit"><?php echo $this->Paginator->sort('Explicit');?></th>
                <th class="contact_name"><?php echo $this->Paginator->sort('Contact Name','contact_name');?></th>
                <th class="contact_email"><?php echo $this->Paginator->sort('Contact Email','contact_email');?></th>
                <th class="itunesu_url"><?php echo $this->Paginator->sort('ItunesU Url','itunes_u_url');?></th>                
                <th class="actions">Actions</th>
            </tr>
            <?php
            // Check to see if there is an incremental count on this->data
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
                        <td class="thumbnail_copyright" >
                            <?php echo $podcast['Podcast']['image_copyright']; ?>
                        </td>
                        <td class="thumbnail_logoless" >
                            <img src="<?php echo $this->Attachment->getMediaImage( $podcast['Podcast']['image_logoless'], $podcast['Podcast']['custom_id'], THUMBNAIL_EXTENSION ); ?>" class="thumbnail" title="podcast image" />
                        </td>
                        <td class="thumbnail_logoless_copyright" >
                            <?php echo $podcast['Podcast']['image_ll_copyright']; ?>
                        </td>                        
                        <td class="thumbnail_wide" >
                            <img src="<?php echo $this->Attachment->getMediaImage( $podcast['Podcast']['image_wide'], $podcast['Podcast']['custom_id'], THUMBNAIL_EXTENSION ); ?>" class="thumbnail" title="podcast image" />
                        </td>
                        <td class="thumbnail_wide_copyright" >
                            <?php echo $podcast['Podcast']['image_wide_copyright']; ?>
                        </td>                        
                        <td class="collection-title">
                            <a href="/podcasts/view/<?php echo $podcast['Podcast']['id']; ?>"><?php echo $podcast['Podcast']['title']; ?></a>
                        </td>
                        <td class="copyright">
                            <?php echo $podcast['Podcast']['copyright']; ?>
                        </td>
                        <td class="owner">
                            <span class="podcast-owner"><?php echo $podcast['Owner']['full_name']; ?></span>
                        </td>
                        <td class="created">
                            <span><?php echo $this->Time->getPrettyShortDate( $podcast['Podcast']['created'] ); ?></span>
                        </td>
                        <td class="author">
                            <?php echo $podcast['Podcast']['author']; ?>
                        </td>
                        <td class="media">
                            <?php echo count( $podcast['PodcastItems'] ); ?>
                        </td>
                        <td class="course_code">
                            <?php echo $podcast['Podcast']['course_code']; ?>
                        </td>
                        <td class="preferred_node">
                            <?php echo $podcast['PreferredNode']['title']; ?>
                        </td>
                        <td class="preferred_url">
                            <?php echo $podcast['Podcast']['preferred_url']; ?>
                        </td>
                        <td class="language">
                            <?php echo $podcast['Podcast']['language']; ?>
                        </td>
                        <td class="explicit">
                            <?php echo $podcast['Podcast']['explicit']; ?>
                        </td>
                        <td class="contact_name">
                            <?php echo $podcast['Podcast']['contact_name']; ?>
                        </td>
                        <td class="contact_email">
                            <a href="mailto:<?php echo $podcast['Podcast']['contact_email']; ?>"><?php echo $podcast['Podcast']['contact_email']; ?></a>
                        </td>
                        <td class="itunes_u_url">
                            <?php echo $podcast['Podcast']['itunes_u_url']; ?>
                        </td>
                        <td class="actions">
                            	
                        	<?php if( $this->Permission->isOwner( $podcast['Owner']['id'] ) ) : ?>
                            	<a class="button off-black" href="/podcasts/edit/<?php echo $podcast['Podcast']['id'];?>" title="edit">Edit</a>
                                <a class="button light-blue" href="/feeds/add/<?php echo $podcast['Podcast']['id']; ?>"><img src="/img/icon-16-rss.png" alt="Refresh RSS" class="icon" />Refresh RSS</a>
                                <a class="button white" href="/podcasts/delete/<?php echo $podcast['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to delete this collection and associated media?');"><img src="/img/icon-16-link-delete.png" alt="Delete" class="icon" />Delete</a>
                            <?php elseif( $this->Permission->toUpdate( $podcast ) ) : ?>
                            	<a class="button white" href="/podcasts/edit/<?php echo $podcast['Podcast']['id'];?>" title="edit"><img src="/img/icon-16-link.png" alt="Edit" class="icon" />Edit</a>
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
	<?php echo $this->element('../podcasts/_personalise'); ?>    
</fieldset>