<div class="wrapper">
    <div class="float_right">
            <img src="<?php echo $this->Attachment->getMediaImage( $this->data['PodcastItem']['image_filename'], $this->data['Podcast']['custom_id'], RESIZED_IMAGE_EXTENSION ); ?>" title="podcast image" />
    </div>
    <div class="float_left">
        <dl>
            <dt>Summary: </dt>
            <dd><?php echo nl2br( $this->data['PodcastItem']['summary'] ); ?>&nbsp;</dd>
            <dt>Created: </dt>
            <dd><?php echo $this->data['PodcastItem']['created'] ? $this->Time->getPrettyShortDate( $this->data['PodcastItem']['created'] ) : $this->Time->getPrettyShortDate( $this->data['PodcastItem']['created_when'] ); ?>&nbsp;</dd>
            <dt>Author: </dt>
            <dd><?php echo $this->data['PodcastItem']['author']; ?>&nbsp;</dd>
            <dt>Explicit </dt>
            <dd><?php echo $this->data['PodcastItem']['explicit']; ?>&nbsp;</dd>
            <dt>Target URL</dt>
            <dd><?php echo $this->data['PodcastItem']['target_url']; ?>&nbsp;</dd>
            <dt>Target URL Text</dt>
            <dd><?php echo $this->data['PodcastItem']['target_url_text']; ?>&nbsp;</dd>

            <?php //if( $this->Permission->isItunesUser() ) : ?>
                <dt>Itunes Published</dt>
                <dd><?php echo $this->Object->itunesPublished( $this->data['PodcastItem'] ) ? 'Yes' : 'No'; ?>&nbsp;</dd>
                <dt>Title: </dt>
                <dd><?php echo $this->data['PodcastItem']['title']; ?>&nbsp;</dd>
                <dt>Archive Details: </dt>
                <dd><?php echo nl2br( $this->data['PodcastItem']['archive_details'] ); ?>&nbsp;</dd>
                <dt>Music Details: </dt>
                <dd><?php echo nl2br( $this->data['PodcastItem']['music_details'] ); ?>&nbsp;</dd>
                <dt>Cover Art: </dt>
                <dd><?php echo nl2br( $this->data['PodcastItem']['cover_art_suggestions'] ); ?>&nbsp;</dd>
                <dt>ePub ISBN: </dt>
                <dd><?php echo $this->data['PodcastItem']['epub_isbn']; ?>&nbsp;</dd>
                <dt>ePub Study Hours: </dt>
                <dd><?php echo $this->data['PodcastItem']['epub_study_hours']; ?>&nbsp;</dd>
                <dt>ePub Study Level: </dt>
                <dd><?php echo $this->data['PodcastItem']['epub_study_level']; ?>&nbsp;</dd>
                <dt>ePub Study Level: </dt>
                <dd><?php echo $this->data['PodcastItem']['epub_study_level']; ?>&nbsp;</dd>
                <dt>Unit Course: </dt>
                <dd><?php echo $this->data['PodcastItem']['unit_course']; ?>&nbsp;</dd>
                <dt>Unit Course Title: </dt>
                <dd><?php echo $this->data['PodcastItem']['unit_course_title']; ?>&nbsp;</dd>
                <dt>Topic Category: </dt>
                <dd><?php echo $this->data['PodcastItem']['topic_category']; ?>&nbsp;</dd>
                <dt>iTunes Genre: </dt>
                <dd><?php echo $this->data['PodcastItem']['itunes_genre']; ?>&nbsp;</dd>
                <dt>iTunes Album: </dt>
                <dd><?php echo $this->data['PodcastItem']['itunes_album']; ?>&nbsp;</dd>

            <?php //endif; ?>

        </dl>
    </div>
</div>
