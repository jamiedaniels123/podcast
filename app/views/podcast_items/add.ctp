<?php echo $this->element('tabs'); ?>
<div class="float_left content">
    <p>
        You can upload files up to 1Gb in size. <?php echo ucfirst( MEDIA ); ?> will automatically be converted, as necessary, into MP3 (audio) or M4V (video).
        Please ensure your filenames end with the correct extension. See below for supported formats.
    </p>
    <?php require(WWW_ROOT."upload/call_fc.php"); ?>
    <div class="footer-panel">
        <fieldset id="admin_panel">
            <div class="float_left_list">
                <h4>Video Files</h4>
                <ul style="list-style:none;">
                    <li class="admin_panel_list" style="background: url(/img/icon-16-avi.png) no-repeat;background-position: 0px 4px;">AVI (.avi) <span class="tip">Limited codec support</span></li>
                    <li class="admin_panel_list" style="background: url(/img/icon-16-mpg.png) no-repeat;background-position: 0px 4px;">MPEG 1 &amp; 2 (.mpg) <span class="tip">Not all mpeg movie encodings supported</span></li>
                    <li class="admin_panel_list" style="background: url(/img/icon-16-mpg.png) no-repeat;background-position: 0px 4px;">MPEG 4 (.mp4 .m4v)</li>
                    <li class="admin_panel_list" style="background: url(/img/icon-16-quicktime.png) no-repeat;background-position: 0px 4px;">QuickTime (.mov)</li>
                    <li class="admin_panel_list" style="background: url(/img/icon-16-windows-media.png) no-repeat;background-position: 0px 4px;">Windows Media (.wmv) <span class="tip">Only standard video codecs supported</span></li>
                    <li class="admin_panel_list" style="background: url(/img/icon-16-3gp.png) no-repeat;background-position: 0px 4px;">Mobile 3gp (.3gp .3g2)</li>
                    <li class="admin_panel_list">Flash (.flv)</li>
                </ul>
            </div>
            <div class="float_left_list">
                
                <h4>Audio Files</h4>
                <ul style="list-style:none;">
                    <li class="admin_panel_list" style="background: url(/img/icon-16-mp3.png) no-repeat;background-position: 0px 4px;">MP3 (.mp3)</li>
                    <li class="admin_panel_list" style="background: url(/img/icon-16-wav.png) no-repeat;background-position: 0px 4px;">WAV (.wav)</li>
                    <li class="admin_panel_list" style="background: url(/img/icon-16-aif.png) no-repeat;background-position: 0px 4px;">AIF (.aif)</li>
                    <li class="admin_panel_list" style="background: url(/img/icon-16-aac.png) no-repeat;background-position: 0px 4px;">AAC (.m4a)</li>
                    <li class="admin_panel_list" style="background: url(/img/icon-16-amr.png) no-repeat;background-position: 0px 4px;">AMR (.amr) <span class="tip">Narrow Band Only (AMR-NB)</span></li>
                </ul>
            </div>
            <div class="float_left_list">
                <h4>Documents</h4>
                <ul style="list-style:none;">
                    <li class="admin_panel_list" style="background: url(/img/icon-16-pdf.png) no-repeat;background-position: 0px 4px;">PDF (.pdf)</li>
                </ul>
            </div>
            <div style="clear:both;"></div>
             
        </fieldset>
    </div>
</div>