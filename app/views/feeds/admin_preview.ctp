<form accept-charset="utf-8" method="post" id="FeedAddForm">
    <fieldset>
        <legend>Preview Podcast RSS</legend>
        <p>
            Use the options below to preview the RSS feed that will be created.
        </p>
        <div class="input select">
            <label for="PodcastId">Please select a podcast</label>
            <select name="data[Podcast][id]" id="PodcastId">
                <?php foreach( $this->data['Podcasts'] as $podcast ) : ?>
                    <option value="<?php echo $podcast['Podcast']['id']; ?>"><?php echo $podcast['Podcast']['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input select">
            <label for="PodcastMediaType">Please select a media type</label>
            <select name="data[Podcast][media_type]" id="PodcastMediaType">
                <?php foreach( $this->data['MediaTypes'] as $key => $value  ) : ?>
                    <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input select">
            <label for="PodcastItunesComplete">Itunes Complete</label>
            <select name="data[Podcast][itunes_complete]" id="PodcastItunesComplete">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>
        <div class="input select">
            <label for="PodcastInterlace">Interlace</label>
            <select name="data[Podcast][interlace]" id="PodcastInterlace">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="input hidden">
        	<input type="hidden" name="data[Podcast][rss_filename]" id="PodcastInterlace" value="<?php DEFAULT_RSS_FILENAME ?>" />
        </div>
        <button id="PodcastPreview" type="submit">preview rss</button>
    </fieldset>
<form>