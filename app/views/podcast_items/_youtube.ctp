<div id="PodcastItemYoutubeContainer"  class="preview" >
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
    <h4>Management</h4>
    <dl>
        <dt>Privacy: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_privacy']; ?>&nbsp;</dd>        
        <dt>License: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_license']; ?>&nbsp;</dd>        
        <dt>Comments: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_comments']; ?>&nbsp;</dd>
        <dt>Voting: </dt>
        <dd><?php echo $this->Miscellaneous->yesNo( $this->data['PodcastItem']['youtube_voting'] ); ?>&nbsp;</dd>
        <dt>Video Response: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_video_response']; ?>&nbsp;</dd>
        <dt>Ratings: </dt>
        <dd><?php echo $this->Miscellaneous->yesNo( $this->data['PodcastItem']['youtube_ratings'] ); ?>&nbsp;</dd>
        <dt>Embedding: </dt>
        <dd><?php echo $this->Miscellaneous->yesNo( $this->data['PodcastItem']['youtube_embedding'] ); ?>&nbsp;</dd>
        <dt>Syndication: </dt>
        <dd><?php echo $this->Miscellaneous->yesNo( $this->data['PodcastItem']['youtube_syndication'] ); ?>&nbsp;</dd>
        <dt>Direct Link: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_direct_link']; ?>&nbsp;</dd>
        <dt>Date Uploaded: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_date_uploaded']; ?>&nbsp;</dd>
        <dt>Rights: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_rights_cleared']; ?>&nbsp;</dd>
        <dt>Advertising Overlay: </dt>
        <dd><?php echo $this->Miscellaneous->yesNo( $this->data['PodcastItem']['youtube_advertising_overlay'] ); ?>&nbsp;</dd>
        <dt>Contributor Forms: </dt>
        <dd><?php echo $this->Miscellaneous->yesNo( $this->data['PodcastItem']['youtube_contributor_forms_included'] ); ?>&nbsp;</dd>
        <dt>Produced By: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_produced_by']; ?>&nbsp;</dd>
        <dt>Academic Contact: </dt>
        <dd><?php echo $this->data['PodcastItem']['youtube_academic_contact']; ?>&nbsp;</dd>
        <dt>Notes: </dt>
        <dd><?php echo nl2br( $this->data['PodcastItem']['youtube_notes'] ); ?>&nbsp;</dd>
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