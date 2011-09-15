<div id="PodcastItemYoutubeContainer" class="preview" >
    <dl>
        <dt>Title: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_title']; ?>&nbsp;</dd>
        <dt>Description: </dt>
        <dd><?php echo nl2br( $this->data['PodcastItem']['youtube_description'] ); ?>&nbsp;</dd>
        <dt>Subject Playlists: </dt>
        <dd>
            <?php foreach( $this->data['YoutubeSubjectPlaylists'] as $playlist ) : ?>
                &nbsp;<?php echo $playlist['title']; ?>,
            <?php endforeach; ?>
            &nbsp;
        </dd>
        <dt>Openlearn Link: </dt>
        <dd>
            <a href="<?php echo $this->data['PodcastItem']['youtube_openlearn_link']; ?>" title="open learn link" target="blank"><?php echo $this->data['PodcastItem']['youtube_openlearn_link']; ?></a>&nbsp;
        </dd>
        <dt>Additional Link (1): </dt>
        <dd>
            <a href="<?php echo $this->data['PodcastItem']['youtube_link_1']; ?>" title="additional link 1" target="blank"><?php echo $this->data['PodcastItem']['youtube_link_1']; ?></a>&nbsp;
        </dd>
        <dt>Additional Link (2): </dt>
        <dd>
            <a href="<?php echo $this->data['PodcastItem']['youtube_link_2']; ?>" title="additional link 2" target="blank"><?php echo $this->data['PodcastItem']['youtube_link_2']; ?></a>&nbsp;
        </dd>
        <dt>Additional Link (3): </dt>
        <dd>
            <a href="<?php echo $this->data['PodcastItem']['youtube_link_3']; ?>" title="additional link 3" target="blank"><?php echo $this->data['PodcastItem']['youtube_link_3']; ?></a>&nbsp;
        </dd>
        <dt>Tags: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_tags']; ?>&nbsp;</dd>
        <dt>Geo Location: </dt>
        <dd><?php echo $this->data['PodcastItem']['geo_location']; ?>&nbsp;</dd>
    </dl>
</div>
    <?php
    if( $this->Permission->toUpdate( $this->data['Podcast'] ) ) : ?>
        <div class="action_buttons">
            <ul>
                <li>
                    <button class="jquery_display save"  type="button" data-source="PodcastItemYoutubeContainer" data-target="FormPodcastItemYoutubeContainer" id="PodcastItemYoutubeButton"><span>edit</span></button>
                </li>
            </ul>
        </div>            
    <?php endif; ?>  