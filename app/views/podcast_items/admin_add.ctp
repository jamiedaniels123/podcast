<fieldset class="podcast_items add">
    <legend><?php echo $this->data['Podcast']['title']; ?> Podcast Media</legend>
    <p>
        Use this form to add and manage media for a podcast. We recommend that you avoid using a PDF document as the most recent
        (top of the list) item in a podcast.
    </p>
    <p>
        <em>EMBED :</em> Individual tracks can now be embeded into other web pages via HTML snipets. To access this snipet click on
        the icon in the Media filename column and from the resulting popup window there is a button called 'EMBED OPTIONS' to access
        the embed interface.
    </p>
    <p>
        The 'embed' interface will be improved and better intergrated into the admin. At present this option is only available to administrators
        of podcasts. Embeding tracks from Podcasts restricted to the OU (SAMS only) will only work on OU sites and when a user has logged in.
    </p>
    <?php echo $this->element('../podcast_items/_index'); ?>
    <hr />
    <p>
        <em>Upload a new media file or document for this podcast</em>
    </p>
    <p>
        You may upload files up to 20Gb in size. Media will be transcoded, as necessary, into MP3 (audio) or M4V (video).
        Please ensure your filenames end with the correct extension. Supported formats include:
    </p>
    <div class="wrapper">
        <div class="float_right">
            <h4>Video Files</h4>
            <ul>
                <li>AVI (.avi) <em>Limited codec support</em></li>
                <li>MPEG 1 &amp; 2 (.mpg) <em>Not all mpeg movie encodings supported</em></li>
                <li>MPEG 4 (.mp4 .m4v)</li>
                <li>QuickTime (.mov)</li>
                <li>Windows Media (.wmv) <em>Only standard video codecs supported</em></li>
                <li>Mobile 3gp (.3gp .3g2)</li>
            </ul>
        </div>
        <div class="float_left">
            <h4>Audio Files</h4>
            <ul>
                <li>MP3 (.mp3)</li>
                <li>WAV (.wav)</li>
                <li>AIF (.aif)</li>
                <li>AAC (.m4a)</li>
                <li>AMR (.amr) <em>Narrow Band Only (AMR-NB)</li>
            </ul>
            <h4>Documents</h4>
            <ul>
                <li>PDF (.pdf)</li>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
    <?php require(WWW_ROOT . "/upload/call_fc.php"); ?>
</fieldset>