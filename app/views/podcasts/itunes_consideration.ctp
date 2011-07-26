<fieldset class="podcasts index">
    <legend><span>iTunesU collections</span></legend>
    
    <img src="/img/collection-large.png" />
    
    <p class="leader">
        Below is a list of all itunes collections on the system.
    </p>
    
    <!--This css adds some order to the top of the 'Your collections' page by placing the Add a new collection button to the left and the view filter to the right of the screen-->
    
	<?php echo $this->element('../podcasts/_itunes_youtube_filter'); ?>
    
    <table cellpadding="0" cellspacing="0">
    <tr>
        <th>Image</th>
        <th>Title</th>
        <th>Owner</th>
        <th>Created</th>
        <th>Items For Consideration</th>
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
                        <?php echo count( $podcast['WaitingItunesApproval'] ); ?>
                    </td>
                    <td class="actions">
                    	<a href="/podcasts/view/<?php echo $podcast['Podcast']['id']; ?>">view</a>
                    </td>
                </tr>
    <?php
            endforeach;
    endif; ?>
    </table>
</fieldset>
