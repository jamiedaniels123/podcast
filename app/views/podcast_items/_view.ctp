<div class="wrapper">
    <div class="float_right">
            <img src="<?php echo $this->Attachment->getMediaImage( $this->data['PodcastItem']['image_filename'], $this->data['Podcast']['custom_id'], RESIZED_IMAGE_EXTENSION ); ?>" title="podcast image" />
    </div>
    <div class="float_left">
        <dl>
            <dt>Title: </dt>
            <dd><?php echo $this->data['PodcastItem']['title']; ?>&nbsp;</dd>
            <dt>Summary: </dt>
            <dd><?php echo nl2br( $this->data['PodcastItem']['summary'] ); ?>&nbsp;</dd>
            <dt>Filename: </dt>
            <dd><?php echo $this->data['PodcastItem']['filename']; ?>&nbsp;</dd>
            <dt>Author: </dt>
            <dd><?php echo $this->data['PodcastItem']['author']; ?>&nbsp;</dd>
            <dt>Created: </dt>
            <dd><?php echo $this->data['PodcastItem']['created'] ? $this->Time->getPrettyLongDate( $this->data['PodcastItem']['created'] ) : $this->Time->getPrettyShortDate( $this->data['PodcastItem']['created_when'] ); ?>&nbsp;</dd>
            <dt>Published: </dt>
            <dd><?php echo $this->data['PodcastItem']['published_flag'] == YES ? 'Yes' : 'No'; ?>&nbsp;</dd>
            <?php if( $this->data['PodcastItem']['published_flag'] == YES ) : ?>
				<dt>Published Date: </dt>
				<dd><?php echo (int)$this->data['PodcastItem']['publication_date'] ? $this->Time->getPrettyLongDate( $this->data['PodcastItem']['publication_date'] ) : 'Unknown'; ?>&nbsp;</dd>
            <?php endif; ?>
            <dt>Unit Course</dt>
            <dd><?php echo $this->data['PodcastItem']['unit_course']; ?>&nbsp;</dd>
            <dt>Unit Course Title</dt>
            <dd><?php echo $this->data['PodcastItem']['unit_course_title']; ?>&nbsp;</dd>
            <dt>Target URL</dt>
            <dd><?php echo $this->data['PodcastItem']['target_url']; ?>&nbsp;</dd>
            <dt>Target URL Text</dt>
            <dd><?php echo $this->data['PodcastItem']['target_url_text']; ?>&nbsp;</dd>
            <dt>Transcript</dt>
            <dd><?php echo $this->Attachment->getTranscriptLink( $this->data['Podcast']['custom_id'], $this->data['PodcastItem']['transcript_filename'] ); ?></dd>
        </dl>

		<?php if( $this->Permission->isItunesUser() ) : ?>
            <?php echo $this->element('../podcast_items/_itunes'); ?>
        <?php endif; ?>
        <?php if( $this->Permission->isYoutubeUser() ) : ?>
            <?php echo $this->element('../podcast_items/_youtube'); ?>
        <?php endif; ?>
        <?php if( ( $this->Permission->isYoutubeUser() ) || ( $this->Permission->isItunesUser() ) ) : ?>
            <?php echo $this->element('../podcast_items/_itunes_and_youtube'); ?>
        <?php endif; ?>
    </div>
</div>
