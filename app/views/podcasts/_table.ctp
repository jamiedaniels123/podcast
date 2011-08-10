<form method="post" action="">
    
<table cellpadding="0" cellspacing="0">
    <tr>
        <th class="checkbox">Select</th>
        <th class="thumbnail" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail'); ?>>Image</th>
        <th class="thumbnail_copyright" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_copyright'); ?>><?php echo $this->Paginator->sort('Image Copyright','image_copyright');?></th>
        <th class="thumbnail_logoless" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_logoless'); ?>>Image Logoless</th>
        <th class="thumbnail_logoless_copyright" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_logoless_copyright'); ?>><?php echo $this->Paginator->sort('Image Logoless Copyright','image_ll_copyright');?></th>
        <th class="thumbnail_wide" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_wide'); ?>>Image Widescreen</th>
        <th class="thumbnail_wide_copyright" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_widescreen_copyright'); ?>><?php echo $this->Paginator->sort('Image Widescreen Copyright','image_wide_copyright');?></th>
        <th class="title" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'title'); ?>><?php echo $this->Paginator->sort('title');?></th>
        <th class="copyright" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'copyright'); ?>><?php echo $this->Paginator->sort('copyright');?></th>
        <th class="owner" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'owner'); ?>><?php echo $this->Paginator->sort('Owner', 'user_id');?></th>
        <th class="created" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'created'); ?>><?php echo $this->Paginator->sort('Created');?></th>
        <th class="author" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'author'); ?>><?php echo $this->Paginator->sort('Author');?></th>
        <th class="media" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'media'); ?>><?php echo $this->Paginator->sort('Media',count('PodcastItems') );?></th>
        <th class="course_code" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'course_code'); ?>><?php echo $this->Paginator->sort('Course Code','course_code' );?></th>
        <th class="preferred_node" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'preferred_node'); ?>><?php echo $this->Paginator->sort('Preferred Node','PreferredNode.title');?></th>
        <th class="preferred_url" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'preferred_url'); ?>><?php echo $this->Paginator->sort('Preferred URL','preferred_url');?></th>
        <th class="language" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'language'); ?>><?php echo $this->Paginator->sort('Language');?></th>
        <th class="explicit" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'explicit'); ?>><?php echo $this->Paginator->sort('Explicit');?></th>
        <th class="contact_name" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'contact_name'); ?>><?php echo $this->Paginator->sort('Contact Name','contact_name');?></th>
        <th class="contact_email" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'contact_email'); ?>><?php echo $this->Paginator->sort('Contact Email','contact_email');?></th>
        <th class="itunes_u_url" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'itunesu_url'); ?>><?php echo $this->Paginator->sort('ItunesU Url','itunes_u_url');?></th>                
		<th class="consider_for_itunes" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'consider_for_itunes'); ?>><?php echo $this->Paginator->sort('Consider iTunesU','consider_for_itunes');?></th>        
		<th class="intended_itunesu_flag" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'intended_itunesu_flag'); ?>><?php echo $this->Paginator->sort('Intended iTunesU','intended_itunesu_flag');?></th>
		<th class="publish_itunes_u" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'publish_itunes_u'); ?>><?php echo $this->Paginator->sort('iTunesU Published','publish_itunes_u');?></th>
		<th class="consider_for_youtube" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'consider_for_youtube'); ?>><?php echo $this->Paginator->sort('Consider Youtube','consider_for_youtube');?></th>        
		<th class="intended_youtube_flag" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'intended_youtube_flag'); ?>><?php echo $this->Paginator->sort('Intended Youtube','intended_youtube_flag');?></th>
		<th class="publish_youtube" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'publish_youtube'); ?>><?php echo $this->Paginator->sort('Youtube Published','publish_youtube');?></th>
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
                    <td class="checkbox">
                        <input type="checkbox" name="data[Podcast][Checkbox][<?php echo $podcast['Podcast']['id']; ?>]" class="podcast_selection" id="PodcastCheckbox<?php echo $podcast['Podcast']['id']; ?>">
                    </td>
                    <td class="thumbnail" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail'); ?> >
                        <img src="<?php echo $this->Attachment->getMediaImage( $podcast['Podcast']['image'], $podcast['Podcast']['custom_id'], THUMBNAIL_EXTENSION ); ?>" class="thumbnail" title="podcast image" />
                    </td>
                    <td class="thumbnail_copyright" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_copyright'); ?> >
                        <?php echo $podcast['Podcast']['image_copyright']; ?>
                    </td>
                    <td class="thumbnail_logoless" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_logoless'); ?> >
                        <img src="<?php echo $this->Attachment->getMediaImage( $podcast['Podcast']['image_logoless'], $podcast['Podcast']['custom_id'], THUMBNAIL_EXTENSION ); ?>" class="thumbnail" title="podcast image" />
                    </td>
                    <td class="thumbnail_logoless_copyright" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_logoless_copyright'); ?> >
                        <?php echo $podcast['Podcast']['image_ll_copyright']; ?>
                    </td>                        
                    <td class="thumbnail_wide" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_wide'); ?>>
                        <img src="<?php echo $this->Attachment->getMediaImage( $podcast['Podcast']['image_wide'], $podcast['Podcast']['custom_id'], THUMBNAIL_EXTENSION ); ?>" class="thumbnail" title="podcast image" />
                    </td>
                    <td class="thumbnail_wide_copyright" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_wide_copyright'); ?>>
                        <?php echo $podcast['Podcast']['image_wide_copyright']; ?>
                    </td>                        
                    <td class="title" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'title'); ?>>
                        <a href="/podcasts/view/<?php echo $podcast['Podcast']['id']; ?>"><?php echo $podcast['Podcast']['title']; ?></a>
                    </td>
                    <td class="copyright" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'copyright'); ?>>
                        <?php echo $podcast['Podcast']['copyright']; ?>
                    </td>
                    <td class="owner" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'owner'); ?>>
                        <span class="podcast-owner"><?php echo $podcast['Owner']['full_name']; ?></span>
                    </td>
                    <td class="created" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'created'); ?>>
                        <span><?php echo $this->Time->getPrettyShortDate( $podcast['Podcast']['created'] ); ?></span>
                    </td>
                    <td class="author" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'author'); ?>>
                        <?php echo $podcast['Podcast']['author']; ?>
                    </td>
                    <td class="media" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'media'); ?>>
                        <?php echo count( $podcast['PodcastItems'] ); ?>
                    </td>
                    <td class="course_code" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'course_code'); ?>>
                        <?php echo $podcast['Podcast']['course_code']; ?>
                    </td>
                    <td class="preferred_node" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'preferred_node'); ?>>
                        <?php echo $podcast['PreferredNode']['title']; ?>
                    </td>
                    <td class="preferred_url" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'preferred_url'); ?>>
                        <?php echo $podcast['Podcast']['preferred_url']; ?>
                    </td>
                    <td class="language" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'language'); ?>>
                        <?php echo $podcast['Podcast']['language']; ?>
                    </td>
                    <td class="explicit" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'explicit'); ?>>
                        <?php echo $podcast['Podcast']['explicit']; ?>
                    </td>
                    <td class="contact_name" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'contact_name'); ?>>
                        <?php echo $podcast['Podcast']['contact_name']; ?>
                    </td>
                    <td class="contact_email" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'contact_email'); ?>>
                        <a href="mailto:<?php echo $podcast['Podcast']['contact_email']; ?>"><?php echo $podcast['Podcast']['contact_email']; ?></a>
                    </td>
                    <td class="itunes_u_url" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'itunes_u_url'); ?>>
                        <?php echo $podcast['Podcast']['itunes_u_url']; ?>
                    </td>
                    <td class="consider_for_itunes" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'consider_for_itunes'); ?>>
                        <img src="/img/<?php echo $this->Object->considerForItunes( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="consider for itunes" />
                    </td>
                    <td class="intended_itunesu_flag" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'intended_itunesu_flag'); ?>>
                        <img src="/img/<?php echo $this->Object->intendedForItunes( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="intended for itunes" />
                    </td>
                    <td class="publish_itunes_u" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'publish_itunes_u'); ?>>
                        <img src="/img/<?php echo $this->Object->itunesPublished( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="itunes published" />
                    </td>
                    <td class="consider_for_youtube" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'consider_for_youtube'); ?>>
                        <img src="/img/<?php echo $this->Object->considerForYoutube( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="consider for youtube" />
                    </td>
                    <td class="intended_youtube_flag" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'intended_youtube_flag'); ?>>
                        <img src="/img/<?php echo $this->Object->intendedForYoutube( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="intended for youtube" />
                    </td>
                    <td class="publish_youtube" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'publish_youtube'); ?>>
                        <img src="/img/<?php echo $this->Object->youtubePublished( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="youtube published" />
                    </td>

                    <td class="actions">
                        <?php if( $this->Permission->isAdminRouting( $this->params ) ) : ?>
                        
                            <?php if( $this->Object->isDeleted( $podcast['Podcast'] ) ) : ?>
                                <a href="/admin/podcasts/restore/<?php echo $podcast['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to restore this podcast?');" id="restore_podcast_<?php echo $podcast['Podcast']['id']; ?>">restore</a>
                            <?php endif; ?>
                            <a href="/admin/podcasts/view/<?php echo $podcast['Podcast']['id']; ?>" id="view_podcast_<?php echo $podcast['Podcast']['id']; ?>">view</a>
                            <a href="/feeds/add/<?php echo $podcast['Podcast']['id']; ?>">refresh rss</a>
                            <a href="/admin/podcasts/delete/<?php echo $podcast['Podcast']['id']; ?>" id="delete_podcast_<?php echo $podcast['Podcast']['id']; ?>" onclick="return confirm('Are you sure you with to delete this podcast and all associated media? This action cannot be undone.');">delete</a>

                    	<?php elseif( $this->Permission->isOwner( $podcast['Owner']['id'] ) ) : ?>
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

    <div class="left">
    <a href="/" class="toggler button blue" data-status="unticked">Select/Unselect all</a>
	<a class="button white multiple_action_button" type="button" href="/feeds/add" id="generate_rss_multiple_podcasts"><span><img src="/img/icon-16-rss.png" alt="Refresh RSS" class="icon" />Refresh RSS</span></a>
	<?php if( $this->Permission->isAdminRouting( $this->params ) ) : ?>
		<a class="button white multiple_action_button" type="button" href="/admin/podcasts/delete" id="delete_multiple_podcasts"><span><img src="/img/icon-16-link-delete.png" alt="Delete" class="icon" />Delete</span></a>    	
	<?php else : ?>
		<a class="button white multiple_action_button" type="button" href="/podcasts/delete" id="delete_multiple_podcasts"><span><img src="/img/icon-16-link-delete.png" alt="Delete" class="icon" />Delete</span></a>
	<?php endif; ?>
    </div>  
</form>

<div style="float:right;"><?php echo $this->element('../podcasts/_personalise'); ?></div>    