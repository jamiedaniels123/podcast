<ul id="breadcrumb">
    <li>You are here</li>

    <?php $x = 0; foreach( $breadcrumbs as $breadcrumb ) : ?>

        <?php $x++; if( $x == count( $breadcrumbs ) ) : ?>
            > <a href="/<?php echo $this->params['url']['url']; ?>" title="<?php echo $breadcrumb['Breadcrumb']['title']; ?>">
                <?php echo $breadcrumb['Breadcrumb']['title']; ?>
            </a>
        <?php else : ?>

            <li>
                <?php if( isSet( $this->data['PodcastItem']['podcast_id'] ) && ( $breadcrumb['Breadcrumb']['action'] != 'index' ) ) : ?>
                    > <a href="/podcasts/edit/<?php $this->data['PodcastItem']['podcast_id']; ?>" title="<?php echo $breadcrumb['Breadcrumb']['title']; ?>">
                        <?php echo $breadcrumb['Breadcrumb']['title']; ?>
                    </a>
                <?php else : ?>
                    > <a href="<?php echo $breadcrumb['Breadcrumb']['url']; ?>" title="<?php echo $breadcrumb['Breadcrumb']['title']; ?>">
                        <?php echo $breadcrumb['Breadcrumb']['title']; ?>
                    </a>
                <?php endif; ?>
            </li>

        <?php endif; ?>
    <?php endforeach; ?>
</ul>


