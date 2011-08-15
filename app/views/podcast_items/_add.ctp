<fieldset class="podcasts index">
    
    <legend><h3>Add Media</h3></legend>
    
    <p class="leader">
        Upload a new media file or document for this collection.
    </p>
    
    <img src="/img/upload-collection-large.png" width="45" height="33" />
    
    <p style="margin: 20px 0;">
        You can upload files up to 20Gb in size. Media will automatically be converted, as necessary, into MP3 (audio) or M4V (video).
        Please ensure your filenames end with the correct extension. See below for supported formats.
    </p>
    

    <?php require(WWW_ROOT."upload/call_fc.php"); ?>
    
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
                <li>AMR (.amr) <em>Narrow Band Only (AMR-NB)</em></li>
            </ul>
            <h4>Documents</h4>
            <ul>
                <li>PDF (.pdf)</li>
            </ul>
        </div>
    </div>
    <div class="clear"></div>
</fieldset>