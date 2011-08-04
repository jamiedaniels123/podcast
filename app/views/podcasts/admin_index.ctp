<fieldset class="podcasts index">
    <legend>Podcasts : Administration</legend>
    <p>
        Below is a list of all podcasts on the system.
    </p>
    <?php echo $this->element('../podcasts/_filter'); ?>
    <div class="clear"></div>
    <p>
        <?php
            echo $this->Paginator->counter(array(
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
            ));
        ?>
    </p>
    <form method="post" action="/admin/podcasts/delete">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th>Select</th>
                <th>Image</th>
                <th class="thumbnail" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail'); ?>>Image</th>
                <th class="thumbnail_copyright" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_copyright'); ?>><?php echo $this->Paginator->sort('Image Copyright','image_copyright');?></th>
                <th class="thumbnail_logoless" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_logoless'); ?>>Image Logoless</th>
                <th class="thumbnail_logoless_copyright" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_logoless_copyright'); ?>><?php echo $this->Paginator->sort('Image Logoless Copyright','image_ll_copyright');?></th>
                <th class="thumbnail_wide" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_wide'); ?>>Image Widescreen</th>
                <th class="thumbnail_widescreen_copyright" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'thumbnail_widescreen_copyright'); ?>><?php echo $this->Paginator->sort('Image Widescreen Copyright','image_wide_copyright');?></th>
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
                <th class="itunesu_url" <?php echo $this->Miscellaneous->columnVisible($active_columns, 'itunesu_url'); ?>><?php echo $this->Paginator->sort('ItunesU Url','itunes_u_url');?></th>                
                <th class="actions"><?php __('Actions');?></th>
            </tr>
            <?php
            if( isSet( $this->data['Podcasts'] ) ) :
                $i = 0;
                foreach ($this->data['Podcasts'] as $podcast ) :

		    if( $this->Object->scheduledForDeletion( $podcast['Podcast'] ) == false ) :

	                    $class = null;
        	            if ($i++ % 2 == 0) :

				if( $this->Object->isDeleted( $podcast['Podcast'] ) ) :
	
		                	$class = ' class="altrow deleted"';
				else :
					$class = ' class="altrow"';
				endif;

	                    elseif( $this->Object->isDeleted( $podcast['Podcast'] ) ) :
	
				$class = ' class="deleted"';

			    endif;
        	    ?>
                    <tr<?php echo $class;?>>
                        <td>
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
                        <td class="actions">
                            <?php if( $this->Object->isDeleted( $podcast['Podcast'] ) ) : ?>
                                <a href="/admin/podcasts/restore/<?php echo $podcast['Podcast']['id']; ?>" onclick="return confirm('Are you sure you wish to restore this podcast?');" id="restore_podcast_<?php echo $podcast['Podcast']['id']; ?>">restore</a>
                            <?php endif; ?>
                            <a href="/admin/podcasts/view/<?php echo $podcast['Podcast']['id']; ?>" id="view_podcast_<?php echo $podcast['Podcast']['id']; ?>">view</a>
                            <a href="/feeds/add/<?php echo $podcast['Podcast']['id']; ?>">refresh rss</a>
                            <a href="/admin/podcasts/delete/<?php echo $podcast['Podcast']['id']; ?>" id="delete_podcast_<?php echo $podcast['Podcast']['id']; ?>" onclick="return confirm('Are you sure you with to delete this podcast and all associated media? This action cannot be undone.');">delete</a>
                        </td>
                    </tr>
            <?php
					endif;
                endforeach;
            endif; ?>
        </table>
        <a href="/" class="toggler button blue" data-status="unticked">Toggle</a>
        <button class="button white multiple_action_button" type="button" data-form_target="/admin/podcasts/delete" id="delete_multiple_podcasts"><span>delete</span></button>
        <button class="button white multiple_action_button" type="button" data-form_target="/feeds/add" id="generate_rss_multiple_podcasts"><span>refresh rss</span></button>
    </form>
    <div class="paging">
            <?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
     | 	<?php echo $this->Paginator->numbers();?>
            <?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
    </div>
    <?php echo $this->element('../podcasts/_personalise'); ?>
</fieldset>