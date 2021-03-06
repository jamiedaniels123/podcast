
<div class="text form_title" id="content">
    <label for="PodcastTitle">Title <span class="required">(Required)</span></label>
    <input type="hidden" value="" id="PodcastTitle_" name="data[Podcast][title]">
    <input type="text" size="60" class="fieldrequired" id="PodcastTitle" value="<?php echo $this->data['Podcast']['title']; ?>" name="data[Podcast][title]">
    <?php echo $this->Form->error('Podcast.title'); ?>
</div>

<?php if( isSet( $this->data['Podcast']['id'] ) && (int)$this->data['Podcast']['id'] ) : ?>
    <div class="clear"></div>
    
    <div class="link">
    	<?php if( $this->Object->syndicated( $this->data['Podcast']['syndicated'] ) == false ) : ?>
			<a href="/" id="PodcastFlagLink" class="button white juggle" data-target="data[Podcast][podcast_flag]"><img src="/img/icon-16-open.png" alt="sharing - ownership" class="icon" />Syndicate this <?php echo PODCAST; ?></a>
		<?php endif; ?>
    	<input type="hidden" id="PodcastPodcastFlag" value="<?php echo trim( $this->data['Podcast']['podcast_flag'] );?>" name="data[Podcast][podcast_flag]">
	</div>
    
    <div class="clear"></div>
    <div id="PodcastSyndicationContainer" class="podcast_container" style="display:none;">
        <div class="input textarea">
            <label for="summary">Summary <span class="required">(Required)</span></label>
            <input type="hidden" value="" id="PodcastSummary_" name="data[Podcast][summary]">
            <textarea id="PodcastSummary" class="fieldrequired" rows="6" cols="60" name="data[Podcast][summary]"><?php echo $this->data['Podcast']['summary']; ?></textarea>
            
            <span class="tip-text">4000 characters max. No HTML allowed</span>
            
            <?php echo $this->Form->error('Podcast.summary'); ?>
        </div>
        <div class="input file">
            <div class="image thumbnail wrapper">
                <div class="float_right text_right">
                    <img src="<?php echo $this->Attachment->getMediaImage( $this->data['Podcast']['image'], $this->data['Podcast']['custom_id'], RESIZED_IMAGE_EXTENSION ); ?>" title="thumbnail image" />
                    <?php if( !empty( $this->data['Podcast']['image'] ) ) : ?>
                    	<div class="clear"></div>
                        <a class="button delete" href="/podcasts/delete_image/image/<?php echo $this->data['Podcast']['id']; ?>" title="delete collection image" onclick="return confirm('Are you sure you wish to delete the Collection image?')">delete</a>
                    <?php endif; ?>
			    </div>
				<div class="float_left">
                    <label for="PodcastNewImage">Image</label>
                    <input type="file" size="60" id="PodcastNewImage" name="data[Podcast][new_image]">
                    <input type="hidden" id="PodcastImage" name="data[Podcast][image]" value="<?php echo $this->data['Podcast']['image']; ?>">
                    <span class="tip-text">JPG or GIF only. PNGs not yet supported! 100 pixel square</span>
				</div>            
        	    <?php echo $this->Form->error('Podcast.image'); ?>
		        <div class="clear"></div>
			</div>
		</div>

        
        
        <div class="input select">
            <label for="PodcastLanguage">Language</label>
            <select name="data[Podcast][language]" id="PodcastLanguage">
            
            <span class="tip-text"></span>
            
                <?php foreach( $languages as $language_code => $language_description ) : ?>
                    <option value="<?php echo $language_code; ?>" <?php echo $this->data['Podcast']['language'] == $language_code ? 'selected="true"' : ''; ?>><?php echo $language_description; ?></option>
                <?php endforeach; ?>
            </select>
            <?php echo $this->Form->error('Podcast.language'); ?>
        </div>
        <div class="input text">
            <label for="PodcastKeywords">Keywords</label>
            <input type="text" size="60" id="PodcastKeywords" value="<?php echo $this->data['Podcast']['keywords']; ?>" name="data[Podcast][keywords]">
            
            <span class="tip-text">Enter a list of words, separated by a comma</span>
            
            
            <?php echo $this->Form->error('Podcast.keywords'); ?>
        </div>
        <div class="input text">
            <label for="PodcastContactName">Contact Name <img src="/img/icon-16-rss.png" alt="RSS Feed" /></label>
            <input type="text" size="60" id="PodcastContactName" value="<?php echo $this->data['Podcast']['contact_name']; ?>" name="data[Podcast][contact_name]">
            
            <span class="tip-text">Enter a contact name</span>
            
            <?php echo $this->Form->error('Podcast.contact_name'); ?>
        </div>
        <div class="input text">
            <label for="PodcastContactEmail">Contact Email <img src="/img/icon-16-rss.png" alt="RSS Feed" /></label>
            <input type="text" size="60" id="PodcastContactEmail" value="<?php echo $this->data['Podcast']['contact_email']; ?>" name="data[Podcast][contact_email]">
            
            <span class="tip-text">Enter a contact email</span>
            
            <?php echo $this->Form->error('Podcast.contact_email'); ?>
        </div>
        <div class="input text">
            <label for="PodcastLink">Web URL <span class="required">(Required)</span></label>
            <input type="text" size="60" class="fieldrequired" id="PodcastLink" value="<?php echo $this->data['Podcast']['link']; ?>" name="data[Podcast][link]">
            
            <span class="tip-text">Optional URL of a web page you want linked to this particular track</span>
            
            <?php echo $this->Form->error('Podcast.link'); ?>
        </div>
        <div class="input text">
            <label for="PodcastLinkText">Web link text</label>
            <input type="text" size="60" id="PodcastLinkText" value="<?php echo $this->data['Podcast']['link_text']; ?>" name="data[Podcast][link_text]">
            
            <span class="tip-text">Optional text for above link</span>
            
            <?php echo $this->Form->error('Podcast.link_text'); ?>
        </div>
        <div class="input text">
            <label for="PodcastCopyright">Copyright</label>
            <input type="text" size="60" id="PodcastCopyright" value="<?php echo $this->data['Podcast']['copyright']; ?>" name="data[Podcast][copyright]">
            
            <span class="tip-text">Who owns the copyright for this collection?</span>
            
            <?php echo $this->Form->error('Podcast.copyright'); ?>
        </div>
        <div class="input checkbox">
            <input type="hidden" value="N" id="PodcastPrivate_" name="data[Podcast][private]">
           	<label for="PodcastPrivate">Private</label>
            <input type="checkbox" id="PodcastPrivate" value="Y" <?php echo $this->data['Podcast']['private'] == 'Y' ? 'checked="checked"' : '';?> name="data[Podcast][private]">
            <br />
            <?php echo $this->Form->error('Podcast.private'); ?>
        </div>
        <div class="input checkbox">
            <input type="hidden" value="N" id="PodcastIntranetOnly_" name="data[Podcast][intranet_only]">
            <input type="checkbox" id="PodcastIntranetOnly" value="Y" <?php echo $this->data['Podcast']['intranet_only'] == 'Y' ? 'checked="checked"' : '';?>  name="data[Podcast][intranet_only]">
            <label for="PodcastIntranetOnly">Intranet (SAMS) only</label><br />
            <?php echo $this->Form->error('Podcast.intranet_only'); ?>
        </div>
        <div class="clear"></div>
        <div class="wrapper" id="nodes_container">
            <div class="float_left">
                <div class="input select">
                    
                    <label for="Nodes">Nodes <span class="required">(Required)</span></label>
                    <input type="hidden" name="data[Nodes]" value="" id="Nodes_" />
                    <select name="data[Nodes][]" class="selected" multiple="multiple" id="Nodes"  class="fieldrequired">
                        <?php if( isSet( $this->data['Nodes'] ) && is_array( $this->data['Nodes'] ) ) : ?>
                            <?php foreach( $this->data['Nodes'] as $node ) : ?>
                                <option value="<?php echo $node['id']; ?>"><?php echo $node['title']; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?php echo $this->Form->error('Podcast.Nodes'); ?>
                    
                    
                    <div class="multiple-button">
                    <div class="move float_right" data-source="Nodes" data-target="PodcastAllNodes"><img src="/img/multiple-button-right.png" alt="Move right" class="icon" /></div>
                    </div>
                    <div class="clear"></div>
 
                </div>
            </div>
            <div class="float_left">
                <div class="input select">
                    
                    <label for="PodcastAllNodes">All Nodes</label>
                    <input type="hidden" name="data[Podcast][AllNodes]" value="" id="PodcastAllNodes_" />
                    <select name="data[Podcast][AllNodes][]" multiple="multiple" id="PodcastAllNodes">
                        <?php foreach( $nodes as $id => $value ) : ?>
                            <option value="<?php echo $id; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                    
                    <div class="multiple-button">
                    <div class="move float_left" data-source="PodcastAllNodes" data-target="Nodes"><img src="/img/multiple-button-left.png" alt="Move left" class="icon" /></div>
                    </div>
                	<div class="clear"></div>
                    
                </div>
            </div>
        </div>
        <?php echo $this->element('../podcasts/_form_admin'); ?>
        
        <?php //if( $this->Permission->isItunesUser() ) : ?>
			
			<?php //echo $this->element('../podcasts/_form_itunes'); ?>
			
        <?php //else : ?>
        
			<?php //echo $this->element('../podcasts/_form_itunes_lite'); ?>
			
		<?php //endif; ?>

		<?php //echo $this->element('../podcasts/_form_youtube'); ?>
            
    </div>
<?php endif; ?>
