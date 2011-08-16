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
    
        <div class="footer-panel">
        	<fieldset id="admin_panel">
        <div class="float_right">
            
            <h4>Video Files</h4>
            <ul style="list-style:none;">
                <li class="admin_panel_list" style="background: url(/img/icon-16-avi.png) no-repeat;background-position: 0px 4px;">AVI (.avi) <span class="tip">Limited codec support</span></li>
                <li class="admin_panel_list" style="background: url(/img/icon-16-mpg.png) no-repeat;background-position: 0px 4px;">MPEG 1 &amp; 2 (.mpg) <span class="tip">Not all mpeg movie encodings supported</span></li>
                <li class="admin_panel_list" style="background: url(/img/icon-16-mpg.png) no-repeat;background-position: 0px 4px;">MPEG 4 (.mp4 .m4v)</li>
                <li class="admin_panel_list" style="background: url(/img/icon-16-quicktime.png) no-repeat;background-position: 0px 4px;">QuickTime (.mov)</li>
                <li class="admin_panel_list" style="background: url(/img/icon-16-windows-media.png) no-repeat;background-position: 0px 4px;">Windows Media (.wmv) <span class="tip">Only standard video codecs supported</span></li>
                <li class="admin_panel_list" style="background: url(/img/icon-16-3gp.png) no-repeat;background-position: 0px 4px;">Mobile 3gp (.3gp .3g2)</li>
            </ul>
        </div>
        
        
        
        
        <div class="float_left">
            
            <h4>Audio Files</h4>
            <ul style="list-style:none;">
                <li class="admin_panel_list" style="background: url(/img/icon-16-mp3.png) no-repeat;background-position: 0px 4px;">MP3 (.mp3)</li>
                <li class="admin_panel_list" style="background: url(/img/icon-16-wav.png) no-repeat;background-position: 0px 4px;">WAV (.wav)</li>
                <li class="admin_panel_list" style="background: url(/img/icon-16-aif.png) no-repeat;background-position: 0px 4px;">AIF (.aif)</li>
                <li class="admin_panel_list" style="background: url(/img/icon-16-aac.png) no-repeat;background-position: 0px 4px;">AAC (.m4a)</li>
                <li class="admin_panel_list" style="background: url(/img/icon-16-amr.png) no-repeat;background-position: 0px 4px;">AMR (.amr) <span class="tip">Narrow Band Only (AMR-NB)</span></li>
            </ul>
         </div>
         
         <div class="float_left">
         <h4>Documents</h4>
            <ul style="list-style:none;">
                <li class="admin_panel_list" style="background: url(/img/icon-16-pdf.png) no-repeat;background-position: 0px 4px;">PDF (.pdf)</li>
            </ul>
           </div> 
            
          </fieldset>  
    </div><!--/footer-panel-->
    <div class="clear"></div>
</fieldset>