<input type="hidden" id="PodcastDeleted" name="data[Podcast][deleted]" value="<?php echo $this->data['Podcast']['deleted']; ?>">
<div class="input text">
    <label for="PodcastTitle">Title</label>
    <input type="hidden" value="" id="PodcastTitle_" name="data[Podcast][title]">
    <input type="text" id="PodcastTitle" value="<?php echo $this->data['Podcast']['title']; ?>" name="data[Podcast][title]">
    <?php echo $this->Form->error('Podcast.title'); ?>
</div>
<?php if( isSet( $this->data['Podcast']['id'] ) && (int)$this->data['Podcast']['id'] ) : ?>
    <div class="clear"></div>
    <div class="input checkbox">
        <input type="hidden" value="0" id="PodcastPodcastFlag_" name="data[Podcast][podcast_flag]">
        <input type="checkbox" id="PodcastPodcastFlag" value="1" <?php echo $this->data['Podcast']['podcast_flag'] ? 'checked="checked"' : '';?> name="data[Podcast][podcast_flag]">
        <label for="PodcastPodcastFlag">Make into Podcast</label>
        <?php echo $this->Form->error('Podcast.podcast_flag'); ?>
    </div>
    <div class="clear"></div>
    <div class="podcast_container" style="display:none;">
        <div class="input textarea">
            <label for="summary">Summary</label>
            <input type="hidden" value="" id="PodcastSummary_" name="data[Podcast][summary]">
            <textarea id="summary" rows="6" cols="30" name="data[Podcast][summary]"><?php echo $this->data['Podcast']['summary']; ?></textarea>
            <?php echo $this->Form->error('Podcast.summary'); ?>
        </div>
        <div class="input file">
            <label for="PodcastNewImage">Podcast image</label>
            <input type="file" id="PodcastNewImage" name="data[Podcast][new_image]">
            <input type="hidden" id="PodcastImage" name="data[Podcast][image]" value="<?php echo $this->data['Podcast']['image']; ?>">
            <?php echo $this->Form->error('Podcast.image'); ?>
        </div>
        <div class="image thumbnail">
           <img src="<?php echo $this->Attachment->getMediaImage( $this->data['Podcast']['image'], $this->data['Podcast']['custom_id'], THUMBNAIL_EXTENSION ); ?>" title="thumbnail image" />
            <a href="/podcasts/delete_image/image/<?php echo $this->data['Podcast']['id']; ?>" title="delete podcast image" onclick="return confirm('Are you sure you wish to delete the podcast image?')">delete</a>
        </div>
        <div class="input text">
            <label for="PodcastImageCopyright">Image Copyright</label>
            <input type="text" id="PodcastImageCopyright" value="<?php echo $this->data['Podcast']['image_copyright']; ?>" name="data[Podcast][image_copyright]">
            <?php echo $this->Form->error('Podcast.image_copyright'); ?>
        </div>
        <div class="input select">
            <label for="PodcastLanguage">Language</label>
            <select name="data[Podcast][language]" id="PodcastLanguage">
                <?php foreach( $languages as $language_code => $language_description ) : ?>
                    <option value="<?php echo $language_code; ?>" <?php echo $this->data['Podcast']['language'] == $language_code ? 'selected="true"' : ''; ?>><?php echo $language_description; ?></option>
                <?php endforeach; ?>
            </select>
            <?php echo $this->Form->error('Podcast.language'); ?>
        </div>
        <div class="input text">
            <label for="PodcastKeywords">Keywords</label>
            <input type="text" id="PodcastKeywords" value="<?php echo $this->data['Podcast']['keywords']; ?>" name="data[Podcast][keywords]">
            <?php echo $this->Form->error('Podcast.keywords'); ?>
        </div>
        <div class="input text">
            <label for="PodcastContactName">Contact Name (RSS Feed)</label>
            <input type="text" id="PodcastContactName" value="<?php echo $this->data['Podcast']['contact_name']; ?>" name="data[Podcast][contact_name]">
            <?php echo $this->Form->error('Podcast.contact_name'); ?>
        </div>
        <div class="input text">
            <label for="PodcastContactEmail">Contact Email (RSS Feed)</label>
            <input type="text" id="PodcastContactEmail" value="<?php echo $this->data['Podcast']['contact_email']; ?>" name="data[Podcast][contact_email]">
            <?php echo $this->Form->error('Podcast.contact_email'); ?>
        </div>
        <div class="input text">
            <label for="PodcastLink">Web URL</label>
            <input type="text" id="PodcastLink" value="<?php echo $this->data['Podcast']['link']; ?>" name="data[Podcast][link]">
            <?php echo $this->Form->error('Podcast.link'); ?>
        </div>
        <div class="input text">
            <label for="PodcastLinkText">Web link text</label>
            <input type="text" id="PodcastLinkText" value="<?php echo $this->data['Podcast']['link_text']; ?>" name="data[Podcast][link_text]">
            <?php echo $this->Form->error('Podcast.link_text'); ?>
        </div>
        <div class="input text">
            <label for="PodcastCopyright">Copyright</label>
            <input type="text" id="PodcastCopyright" value="<?php echo $this->data['Podcast']['copyright']; ?>" name="data[Podcast][copyright]">
            <?php echo $this->Form->error('Podcast.copyright'); ?>
        </div>
        <div class="input checkbox">
            <input type="hidden" value="N" id="PodcastPrivate_" name="data[Podcast][private]">
            <input type="checkbox" id="PodcastPrivate" value="Y" <?php echo $this->data['Podcast']['private'] == 'Y' ? 'checked="checked"' : '';?> name="data[Podcast][private]">
            <label for="PodcastPrivate">Private</label>
            <?php echo $this->Form->error('Podcast.private'); ?>
        </div>
        <div class="input checkbox">
            <input type="hidden" value="N" id="PodcastIntranetOnly_" name="data[Podcast][intranet_only]">
            <input type="checkbox" id="PodcastIntranetOnly" value="Y" <?php echo $this->data['Podcast']['intranet_only'] == 'Y' ? 'checked="checked"' : '';?>  name="data[Podcast][intranet_only]">
            <label for="PodcastIntranetOnly">Intranet (SAMS) only</label>
            <?php echo $this->Form->error('Podcast.intranet_only'); ?>
        </div>
        <div class="clear"></div>
        <div class="wrapper" id="nodes_container">
            <div class="float_left">
                <div class="input select">
                    <span class="move" data-source="Nodes" data-target="PodcastAllNodes">Move --></span>
                    <label for="Nodes">Podcast Nodes</label>
                    <input type="hidden" name="data[Nodes]" value="" id="Nodes_" />
                    <select name="data[Nodes][]" class="selected" multiple="multiple" id="Nodes">
                        <?php if( isSet( $this->data['Nodes'] ) && is_array( $this->data['Nodes'] ) ) : ?>
                            <?php foreach( $this->data['Nodes'] as $node ) : ?>
                                <option value="<?php echo $node['id']; ?>"><?php echo $node['title']; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <?php echo $this->Form->error('Podcast.Nodes'); ?>
                </div>
            </div>
            <div class="float_left">
                <div class="input select">
                    <span class="move" data-source="PodcastAllNodes" data-target="Nodes"><-- Move</span>
                    <label for="PodcastAllNodes">All Nodes</label>
                    <input type="hidden" name="data[Podcast][AllNodes]" value="" id="PodcastAllNodes_" />
                    <select name="data[Podcast][AllNodes][]" multiple="multiple" id="PodcastAllNodes">
                        <?php foreach( $nodes as $id => $value ) : ?>
                            <option value="<?php echo $id; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="wrapper" id="user_groups_container">
            <div class="float_left">
                <div class="input select">
                    <span class="move" data-source="ModeratorGroups" data-target="MemberGroups">Move --> </span>
                    <label for="Moderators">Moderator Groups</label>
                    <input type="hidden" name="data[ModeratorGroups][]" value="" id="ModeratorGroups_" />
                    <select id="ModeratorGroups" multiple="multiple" class="selected" name="data[ModeratorGroups][]">
                        <?php foreach( $this->data['ModeratorGroups'] as $moderator ) : ?>
                            <option value="<?php echo $moderator['id']; ?>"><?php echo $moderator['group_title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo $this->Form->error('Podcast.ModeratorGroups'); ?>
                </div>
            </div>
            <div class="float_left">
                <div class="input select">
                    <span class="move" data-source="MemberGroups" data-target="ModeratorGroups"><-- Move</span>
                    <span class="move" data-source="MemberGroups" data-target="UserGroups">Move --></span>
                    <label for="MemberGroups">Member Groups</label>
                    <input type="hidden" name="data[MemberGroups]" value="" id="MemberGroups_" />
                    <select id="MemberGroups" multiple="multiple" class="selected" name="data[MemberGroups][]">
                        <?php foreach( $this->data['MemberGroups'] as $member ) : ?>
                            <option value="<?php echo $member['id']; ?>"><?php echo $member['group_title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo $this->Form->error('Podcast.MemberGroups'); ?>
                </div>
            </div>
            <div class="float_left">
                <div class="input select">
                    <span class="move" data-source="UserGroups" data-target="MemberGroups"><-- Move</span>
                    <label for="UserGroups">All User Groups</label>
                    <input type="hidden" name="data[UserGroups]" value="" id="UserGroups_" />
                    <select name="data[UserGroups][]" class="selected" multiple="multiple" id="UserGroups">
                        <?php foreach( $user_groups as $key => $value ) : ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo $this->Form->error('Podcast.UserGroups'); ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="wrapper" id="moderator_container">
            <div class="float_left">
                <div class="input select">
                    <span class="move" data-source="Moderators" data-target="Members">Move --> </span>
                    <label for="Moderators">Podcast Moderators</label>
                    <input type="hidden" name="data[Moderators][]" value="" id="Moderators_" />
                    <select id="Moderators" multiple="multiple" class="selected" name="data[Moderators][]">
                        <?php foreach( $this->data['Moderators'] as $moderator ) : ?>
                            <option value="<?php echo $moderator['id']; ?>"><?php echo $moderator['full_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo $this->Form->error('Podcast.Moderators'); ?>
                </div>
            </div>
            <div class="float_left">
                <div class="input select">
                    <span class="move" data-source="Members" data-target="Moderators"><-- Move</span>
                    <span class="move" data-source="Members" data-target="UsersUsers">Move --></span>
                    <label for="Members">Podcast Members</label>
                    <input type="hidden" name="data[Members]" value="" id="Members_" />
                    <select id="Members" multiple="multiple" class="selected" name="data[Members][]">
                        <?php foreach( $this->data['Members'] as $member ) : ?>
                            <option value="<?php echo $member['id']; ?>"><?php echo $member['full_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo $this->Form->error('Podcast.Members'); ?>
                </div>
            </div>
            <div class="float_left">
                <div class="input select">
                    <span class="move" data-source="UsersUsers" data-target="Members"><-- Move</span>
                    <label for="UsersUsers">All Users</label>
                    <select id="UsersUsers" multiple="multiple" name="data[Users][Users][]">
                        <?php foreach( $users as $key => $value ) : ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php if( $this->Miscellaneous->isAdminRouting() || ( $this->Object->editing( $this->data['Podcast'] ) && $this->Permission->isOwner( $this->data['Podcast']['owner_id'] ) ) || ( $this->Object->changeOfOwnership( $this->data['Podcast'] ) && $this->Permission->isOwner( $this->data['Podcast']['current_owner_id'] ) ) ) : ?>
        
            <div class="input text">
                <label for="PodcastOwnerId">Podcast Owner</label>
                <?php if( $this->Object->changeOfOwnership( $this->data['Podcast'] ) ) : ?>
                    <input type="hidden" name="data[Podcast][current_owner_id]" value="<?php echo $this->data['Podcast']['current_owner_id']; ?>" id="PodcastCurrentOwnerId" />
                    <input type="hidden" name="data[Podcast][confirmed]" value="<?php echo isSet( $this->data['Podcast']['confirmed'] ) ? '1' : '0'; ?>" id="PodcastConfirmed" />
                <?php endif; ?>
                
                <select name="data[Podcast][owner_id]" id="PodcastOwnerId">
                    <option value="">Please select</option>
                    <?php foreach( $all_users as $user_id => $name ) : ?>
                        <option value="<?php echo $user_id; ?>" <?php echo $this->data['Podcast']['owner_id'] == $user_id ? 'selected="true"' : ''; ?>><?php echo $name; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo $this->Form->error('Podcast.owner_id'); ?>
            </div>
        <?php endif; ?>
        
        <?php if( $this->Miscellaneous->isAdminRouting() ) : ?>
        
	        <?php echo $this->element('../podcasts/_form_admin'); ?>
        
        <?php else : ?>
        
	        <input type="hidden" id="PodcastMediaLocation" name="data[Podcast][media_location]" value="<?php echo $this->data['Podcast']['media_location']; ?>">
            
        <?php endif; ?>
        
        <?php if( $this->Object->intendedForItunes( $this->data['Podcast'] ) ) : ?>
        
	        <?php echo $this->element('../podcasts/_form_itunes'); ?>
            
        <?php else : ?>
        
        	<?php echo $this->element('../podcasts/_form_itunes_apply'); ?>
            
		<?php endif; ?>
            
        <?php if( $this->Object->intendedForYoutube( $this->data['Podcast'] ) ) : ?>
        
	        <?php echo $this->element('../podcasts/_form_youtube'); ?>
        
        <?php else : ?>
        
        	<?php echo $this->element('../podcasts/_form_youtube_apply'); ?>
            
		<?php endif; ?>
       
    </div>
<?php endif; ?>