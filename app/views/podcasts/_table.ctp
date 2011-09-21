<form method="post" action="">
    
<table class="collection_table" cellpadding="0" cellspacing="0">
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
        <th class="owner" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'owner'); ?>><?php echo $this->Paginator->sort('Owner', 'Owner.firstname');?></th>
        <th class="created" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'created'); ?>><?php echo $this->Paginator->sort('Created');?></th>
        <th class="author" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'author'); ?>><?php echo $this->Paginator->sort('Author');?></th>
        <th class="media" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'media'); ?>><?php echo $this->Paginator->sort('Media',count('MediaCount') );?></th>
        <th class="course_code" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'course_code'); ?>><?php echo $this->Paginator->sort('Course Code','course_code' );?></th>
        <th class="preferred_node" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'preferred_node'); ?>><?php echo $this->Paginator->sort('Preferred Node','PreferredNode.title');?></th>
        <th class="preferred_url" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'preferred_url'); ?>><?php echo $this->Paginator->sort('Preferred URL','preferred_url');?></th>
        <th class="language" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'language'); ?>><?php echo $this->Paginator->sort('Language');?></th>
        <th class="explicit" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'explicit'); ?>><?php echo $this->Paginator->sort('Explicit');?></th>
        <th class="contact_name" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'contact_name'); ?>><?php echo $this->Paginator->sort('Contact Name','contact_name');?></th>
        <th class="contact_email" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'contact_email'); ?>><?php echo $this->Paginator->sort('Contact Email','contact_email');?></th>
        <th class="itunes_u_url" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'itunesu_url'); ?>><?php echo $this->Paginator->sort('ItunesU Url','itunes_u_url');?></th>                
		<th class="podcast_flag" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'podcast_flag'); ?>><?php echo $this->Paginator->sort('Syndicated','podcast_flag');?></th>        
		<th class="consider_for_itunes" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'consider_for_itunes'); ?>><?php echo $this->Paginator->sort('Consider iTunesU','consider_for_itunes');?></th>        
		<th class="intended_itunesu_flag" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'intended_itunesu_flag'); ?>><?php echo $this->Paginator->sort('Intended iTunesU','intended_itunesu_flag');?></th>
		<th class="publish_itunes_u" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'publish_itunes_u'); ?>><?php echo $this->Paginator->sort('iTunesU Published','publish_itunes_u');?></th>
		<th class="consider_for_youtube" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'consider_for_youtube'); ?>><?php echo $this->Paginator->sort('Consider Youtube','consider_for_youtube');?></th>        
		<th class="intended_youtube_flag" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'intended_youtube_flag'); ?>><?php echo $this->Paginator->sort('Intended Youtube','intended_youtube_flag');?></th>
		<th class="publish_youtube" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'publish_youtube'); ?>><?php echo $this->Paginator->sort('Youtube Published','publish_youtube');?></th>
		<th class="openlearn_epub" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'openlearn_epub'); ?>><?php echo $this->Paginator->sort('Open Learn','openlearn_epub');?></th>
    </tr>
    <?php
    // Check to see if there is an incremental count on this->data, the ['Meta'] exists so just looking for integer count
    if( isSet( $this->data['Podcasts'] ) ) :
        $i = 0;
        foreach ($this->data['Podcasts'] as $podcast ) :

            $class = null;
			if( $podcast['Podcast']['deleted'] ) :
				$class = ' class=" deleted "';
            elseif ($i++ % 2 == 0) :
                $class = ' class=" altrow "';
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
						<?php if( $this->Permission->isAdminRouting( $this->params ) ) : ?>

	                        <a href="/admin/podcasts/edit/<?php echo $podcast['Podcast']['id']; ?>/sharing#sharing"><?php echo $podcast['Podcast']['title']; ?></a>                        <?php else : ?>
	                        <a href="/podcasts/edit/<?php echo $podcast['Podcast']['id']; ?>/summary#summary"><?php echo $podcast['Podcast']['title']; ?></a>
						<?php endif; ?>
                    </td>
                    <td class="copyright" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'copyright'); ?>>
                        <?php echo $podcast['Podcast']['copyright']; ?>
                    </td>
                    <td class="owner" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'owner'); ?>>
                        <span class="podcast-owner"><?php echo $podcast['Owner']['firstname'].' '.$podcast['Owner']['lastname']; ?></span>
                    </td>
                    <td class="created" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'created'); ?>>
                        <span><?php echo $this->Time->getPrettyShortDate( $podcast['Podcast']['created'] ); ?></span>
                    </td>
                    <td class="author" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'author'); ?>>
                        <?php echo $podcast['Podcast']['author']; ?>
                    </td>
                    <td class="media" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'media'); ?>>
                        <?php echo count( $podcast['MediaCount'] ); ?>
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
                    <td class="podcast_flag" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'podcast_flag'); ?>>
                        <img src="/img<?php echo $this->Object->syndicated( $podcast['Podcast']['podcast_flag'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="consider for itunes" />
                    </td>

                    <td class="consider_for_itunes" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'consider_for_itunes'); ?>>
                        <img src="/img<?php echo $this->Object->considerForItunes( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="consider for itunes" />
                    </td>
                    <td class="intended_itunesu_flag" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'intended_itunesu_flag'); ?>>
                        <img src="/img<?php echo $this->Object->intendedForItunes( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="intended for itunes" />
                    </td>
                    <td class="publish_itunes_u" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'publish_itunes_u'); ?>>
                        <img src="/img<?php echo $this->Object->itunesPublished( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="itunes published" />
                    </td>
                    <td class="consider_for_youtube" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'consider_for_youtube'); ?>>
                        <img src="/img<?php echo $this->Object->considerForYoutube( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="consider for youtube" />
                    </td>
                    <td class="intended_youtube_flag" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'intended_youtube_flag'); ?>>
                        <img src="/img<?php echo $this->Object->intendedForYoutube( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="intended for youtube" />
                    </td>
                    <td class="publish_youtube" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'publish_youtube'); ?>>
                        <img src="/img<?php echo $this->Object->youtubePublished( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="youtube published" />
                    </td>
                    <td class="openlearn_epub" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'openlearn_epub'); ?>>
                        <img src="/img/<?php echo $this->Object->isOpenLearn( $podcast['Podcast'] ) ? CORRECT_IMAGE : INCORRECT_IMAGE; ?>" title="openlearn published" />
                    </td>
                </tr>
<?php
        endforeach;
endif; ?>
</table>

<?php echo $this->element('pagination'); ?>    

    <div class="left">
    <a href="/" class="toggler button select_all" data-status="unticked">Select/Unselect all</a>
	<?php if( $this->Permission->isAdminRouting( $this->params ) ) : ?>
		<a class="button rss multiple_action_button" type="button" href="/feeds/add" id="generate_rss_multiple_podcasts">Refresh RSS</a>
		<a class="button delete multiple_action_button" type="button" href="/admin/podcasts/delete" id="delete_multiple_podcasts">Delete</a>    	
		<a class="button restore multiple_action_button" type="button" href="/admin/podcasts/restore" id="restore_multiple_podcasts">Restore</a>    	        
	<?php else : ?>
		<a class="button delete multiple_action_button" type="button" href="/podcasts/delete" id="delete_multiple_podcasts">Delete</a>
	<?php endif; ?>
    </div>  
</form>

<div style="float:right;"><?php echo $this->element('../podcasts/_personalise'); ?></div>