<div class="wrapper">
    <div class="float_right">
        <div id="moderators_container">
            <label for="Moderators">Moderators</label>
            <?php if( isSet( $this->data['Moderators'] ) && is_array( $this->data['Moderators'] ) ) : ?>
                <ul>
                    <?php foreach( $this->data['Moderators'] as $moderator ) : ?>
                        <li><?php echo $moderator['full_name']; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <div id="members_container">
            <label for="Members">Members</label>
            <?php if( isSet( $this->data['Members'] ) && is_array( $this->data['Members'] ) ) : ?>
                <ul>
                    <?php foreach( $this->data['Members'] as $member ) : ?>
                        <li><?php echo $member['full_name']; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
    <div class="float_left">
        <div id="podcast_container">
            <label for="Podcasts">Podcasts</label>
            <?php if( isSet( $this->data['Podcasts'] ) && is_array( $this->data['Podcasts'] ) ) : ?>
                <ul>
                    <?php foreach( $this->data['Podcasts'] as $podcast ) : ?>
                        <li><a href="/podcasts/view/<?php echo $podcast['id']; ?>" title="view <?php echo $podcast['title']; ?>"><?php echo $podcast['title']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="clear"></div>