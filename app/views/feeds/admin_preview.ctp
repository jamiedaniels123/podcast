<form accept-charset="utf-8" method="post" id="FeedAddForm">
    <fieldset>
        <legend>Preview Podcast RSS</legend>
        <p>
            Use the options below to preview the RSS feed that will be created.
        </p>
        <div class="input select">
            <label for="podcast">Please select a podcast</label>
            <select name="data[Podcast][id]" id="PodcastId">
                <?php foreach( $this->data['Podcasts'] as $podcast ) : ?>
                    <option value="<?php echo $podcast['Podcast']['id']; ?>"><?php echo $podcast['Podcast']['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input select">
            <label for="media_type">Please select a media type</label>
            <select name="data[Podcast][media_type]" id="PodcastMediaType">
                <?php foreach( $this->data['MediaTypes'] as $key => $value  ) : ?>
                    <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="input">
            <label for="rss_filename">Enter a specific RSS filename else leave blank.</label>
            <input type="input" name="data[Podcast][rss_filename]" id="PodcastRssFilename">
        </div>
        <div class="input select">
            <label for="itunes_complete">Itunes Complete</label>
            <select name="data[Podcast][itunes_complete]" id="PodcastItunesComplete">
                <option value="0">No</option>
                <option value="1">Yes</option>
            </select>
        </div>
        <div class="input select">
            <label for="interlace">Interlace</label>
            <select name="data[Podcast][interlace]" id="PodcastInterlaceComplete">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <button id="preview_rss" type="submit">preview rss</button>
    </fieldset>
<form>