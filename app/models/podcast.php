<?php
class Podcast extends AppModel {
	

    const AVAILABLE = 9;
    
    var $name = 'Podcast';
	var $order = 'Podcast.id DESC';
    
    var $validate = array(

        'title' => array(
            'Rule1' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => 'Please provide a title for your feed.'
            )
        ),
        'summary' => array(
            'rule' => array('ifPodcast'),
            'message' => 'If you wish to convert this collection into a podcast you must provide a short description.'
        ),
        'link' => array(
            'Rule1' => array(
                'rule' => array('ifPodcast'),
                'message' => 'If you wish to convert this collection into a podcast you must provide a valid URL.'
            ),
            'Rule2' => array(
                'rule' => 'url',
                'allowEmpty' => true,
                'message' => 'Please provide a valid web address for the feed.'
            )
        ),
        'contact_email' => array(
            'Rule1' => array(
                'rule' => array( 'email', true),
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid email address.'
            )
        ),
        'owner_id' => array(
            'Rule1' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => 'You must select an owner for this podcast.'
            )
        ),
        'Nodes' => array(
            'Rule1' => array(
                'rule' => array('ifPodcast'),
                'message' => 'If you wish to convert this collection into a podcast you must select at least 1 node.'
            ),
            'Rule2' => array(
                'rule' => array('multiple', array( 'min' => 1, 'max' => 4 ) ),
                'allowEmpty' => true,
                'message' => 'Please select between 1 and 4 nodes.'
            )
        ),
        'Categories' => array(
            'rule' => array('multiple', array( 'min' => 1, 'max' => 3 ) ),
            'allowEmpty' => true,
            'message' => 'Please select between 1 and 3 iTunes categories.'
        ),
        'private' => array(
            'Rule1' => array(
                'rule' => array('privateUntilPublishedMedia'),
                'message' => 'This collection must remain private until you publish associated media.'
            )
        ),
        'iTuneCategories' => array(
            'rule' => array('multiple', array( 'min' => 1, 'max' => 3 ) ),
            'allowEmpty' => true,
            'message' => 'You cannot select more than 3 iTunes U categories.'
        ),
        'publish_itunes_date' => array(
            'Rule1' => array(
                'rule' => 'date',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD for publish iTunnesU date.'
            )
        ),
        'update_itunes_date' => array(
            'Rule1' => array(
                'rule' => 'date',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD for update iTunesU date.'
            )
        ),
        'target_itunesu_date' => array(
            'Rule1' => array(
                'rule' => 'date',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD target iTunesU date.'
            )
        ),
        'production_date' => array(
            'Rule1' => array(
                'rule' => 'date',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD for production date.'
            )
        ),
        'rights_date' => array(
            'Rule1' => array(
                'rule' => 'date',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD for rights date.'
            )
        ),
        'metadata_date' => array(
            'Rule1' => array(
                'rule' => 'date',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD for meta data date.'
            )
        ),
        'itunes_u_url' => array(
            'Rule1' => array(
                'rule' => 'url',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid web address for the iTunesU URL.'
            )
        ),
        'youtube_series_playlist_link' => array(
			'rule' => 'url',
			'allowEmpty' => true,
			'message' => 'If entered, you must provide a valid web address for the youtube series playlist link.'
        ),		
    );

    var $belongsTo = array(

        'Language' => array(
            'className' => 'Language',
            'foreignKey' => 'language'
        ),
        'Owner' => array(
            'className' => 'User',
            'foreignKey' => 'owner_id',
            'fields' => 'Owner.id, Owner.full_name, Owner.email, Owner.firstname, Owner.lastname'
        ),
        'PreferredNode' => array(
            'className' => 'Nodes',
            'foreignKey' => 'preferred_node',
            'fields' => 'PreferredNode.id,PreferredNode.title'
		)		
    );

    var $hasMany = array(

        'PodcastLinks' => array(
            'className' => 'PodcastLink',
            'foreignKey' => 'podcast_id'
        ),
		'MediaCount' => array(
            'className' => 'PodcastItem',
            'foreignKey' => 'podcast_id',
			'conditions' => 'MediaCount.deleted = 0',
			'fields' => 'MediaCount.id'
		),
        'PodcastItems' => array(
            'className' => 'PodcastItem',
            'foreignKey' => 'podcast_id',
            'fields' => 'PodcastItems.id, PodcastItems.podcast_id, PodcastItems.title, PodcastItems.summary, PodcastItems.filename,
                PodcastItems.published_flag, PodcastItems.itunes_flag, PodcastItems.youtube_flag, PodcastItems.created, PodcastItems.image_filename, PodcastItems.deleted, PodcastItems.processed_state, PodcastItems.duration',
            'order' => 'PodcastItems.publication_date DESC',
        ),
        'PublishedPodcastItems' => array(
            'className' => 'PodcastItem',
            'foreignKey' => 'podcast_id',
            'conditions' => 'PublishedPodcastItems.published_flag = "Y"', 'PublishedPodcastItems.processed_state = 9', 'PublishedPodcastItems.title IS NOT NULL', 'PublishedPodcastItems.media_type != "transcript"'
        ),
        'PodcastModerators' => array(
            'className' => 'UserPodcasts',
            'foreignKey' => 'podcast_id',
        ),
        'ModeratorUserGroups' => array(
            'className' => 'UserGroupPodcasts',
            'foreignKey' => 'podcast_id'
        )
    );

    var $hasAndBelongsToMany = array(

        'Categories' => array(
            'className' => 'Category',
            'joinTable' => 'podcasts_categories',
            'foreignKey' => 'podcast_id',
            'associationForeignKey' => 'category_id',
            'unique' => true
        ),
        'Nodes' => array(
            'className' => 'Node',
            'joinTable' => 'podcast_links',
            'foreignKey' => 'podcast_id',
            'associationForeignKey' => 'node_id',
            'order' => 'Nodes.title ASC',
            'unique' => true
        ),
        'iTuneCategories' => array(
            'className' => 'ItunesuCategory',
            'joinTable' => 'podcasts_itunesu_categories',
            'foreignKey' => 'podcast_id',
            'associationForeignKey' => 'itunesu_category_id',
            'unique' => true
        ),
        'ModeratorGroups' => array(
            'className' => 'UserGroup',
            'joinTable' => 'user_group_podcasts',
            'foreignKey' => 'podcast_id',
            'associationForeignKey' => 'user_group_id',
            'conditions' => array( 'UserGroupPodcast.moderator' => true ),
            'unique' => true
        ),
        'MemberGroups' => array(
            'className' => 'UserGroup',
            'joinTable' => 'user_group_podcasts',
            'foreignKey' => 'podcast_id',
            'associationForeignKey' => 'user_group_id',
            'conditions' => array( 'UserGroupPodcast.moderator' => false ),
            'unique' => true
        ),
        'Members' => array(
            'className' => 'User',
            'joinTable' => 'user_podcasts',
            'foreignKey' => 'podcast_id',
            'associationForeignKey' => 'user_id',
            'conditions' => array( 'UserPodcast.moderator' => false ),
            'unique' => true,
            'fields' => 'Members.id, Members.full_name'
        ),
        'Moderators' => array(
            'className' => 'User',
            'joinTable' => 'user_podcasts',
            'foreignKey' => 'podcast_id',
            'associationForeignKey' => 'user_id',
            'conditions' => array( 'UserPodcast.moderator' => true ),
            'unique' => true,
            'fields' => 'Moderators.id, Moderators.full_name'
        )
    );

    var $hasOne = array(

        'UserPodcast' => array(
            'className' => 'UserPodcast',
            'foreignKey' => 'podcast_id',
            'fields' => 'UserPodcast.id,UserPodcast.user_id'
		)
    );

    /*
     * @name : ifPodcast
     * @description : Custom validation method called from the validation array. If the user has chosen to
     * turn this row into a podcast, signified by the podcast_flag field being equal to 1 (true), then the field must
     * be populated.
     * NOTE: The $check array will contain an associative array eg: array( 'field-name' => field-value )
     * @updated : 27th May 2011
     * @by : Charles Jackson
     */
    function ifPodcast( $check = array() ) {
		
        // It is not a podcast so no need for field to be populated.
        if( $this->data['Podcast']['podcast_flag'] == true ) {

            // get the value of the field being passed
            $value = array_shift( $check );

            if( empty( $value ) )
                return false;
        }

        return true;
    }

    /*
     * @name : privateUntilPublishedMedia
     * @description : A podcast must remain private untill it has associated published media. This method is
     * called by the validation array and returns a count of published media.
     * @updated : 27th May 2011
     * @by : Charles Jackson
     */
    function privateUntilPublishedMedia( $check = array() ) {

        // get the value of the field being passed
        $private = array_shift( $check );

        if( !isSet( $this->data['private'] ) || $private == YES )
            return true;

        $podcastItem = ClassRegistry::init('PodcastItem');

        return $podcastItem->find( 'count', array('conditions' => array('PodcastItem.podcast_id' => $this->data['Podcast']['id'], 'PodcastItem.published_flag' => 1 ) ) );
    }

    /*
     * @name : beforeSave
     * @description : Magic method automatically called after validation and before data is saved.
     * At time of publication I am using it to check the "explicit" value by reading through all associated
     * media.
     * @updated : 3rd June 2011
     * @by : Charles Jackson
     */
    function beforeSave() {

        $this->data['Podcast']['explicit'] = $this->__checkExplicitStatus();
        return true;
    }

    /*
     * @name : __checkExplicitStatus
     * @description : Called directly before model data is saved, it reads through all associated media
     * and looks at the value of explicit. Depending upon results will set the appropriate value at
     * podcast level.
     * @updated : 3rd June 2011
     * @by : Charles Jackson
     */
    function __checkExplicitStatus() {

		if( !isSet( $this->data['Podcast']['id'] ) || empty( $this->data['Podcast']['id'] ) )
			return 'clean';

        $this->PodcastItem = ClassRegistry::init('PodcastItem');
        $data = $this->PodcastItem->find('all', array(
            'conditions' => array(
                'PodcastItem.published_flag' => YES,
                'PodcastItem.podcast_id' => $this->data['Podcast']['id'],
                'PodcastItem.processed_state' => self::AVAILABLE
                ),
            'fields' => array(
                'PodcastItem.explicit'
                )
            )
        );

        if( in_array( 'yes', $data ) )
            return 'yes';
        if( in_array( 'no', $data ) )
            return 'no';

        return 'clean';
    }
    
    /*
     * @name : beforeValidate
     * @description : A current CakePHP limitation of validating HBTM data requires us to copy
     * the HBTM data into the current model so it can be validated using the rules defined in this model.
     * In effect moving this->data['Categories']['Categories'] into this->data['Podcast']['Categories']
     * @updated : 9th May 2011
     * @by : Charles Jackson
     */
    function beforeValidate() {

        foreach( $this->hasAndBelongsToMany as $k => $v ) {

            if( isSet( $this->data[$k] ) )
                $this->data[$this->alias][$k] = $this->data[$k];
        }

        // OK, now empty the date fields if they contain a null date.
        foreach( $this->data[$this->alias] as $key => $value ) {

            if( in_array( $key, array('publish_itunes_date','update_itunes_date','target_itunesu_date','production_date','rights_date', 'metadata_date' ) ) ) {

                if( (int)$value == false ) {
                    $this->data[$this->alias][$key] = null;
                }
            }

        }
        return true;
    }

    /*
     * @name : deleteExistingModerators
     * @description : We have a unique situation here whereas the "HBTM Moderator & ModeratorUserGroup" arrays are used to read back a list
     * of moderators(user_groups) but never used to save them. This is because we have to set the "moderator" flag to true on the magic
     * join tables user_user_groups user_group_podcasts and this is not possible when using HBTM. We therefore create an alias
     * "hasMany GroupModerators & ModeratorUserGrouops" where we can set the "moderator" flag to true. However, we must first delete any existing
     * rows on the magic tables.
     * @updated : 23rd May 2011
     * @by : Charles Jackson
     */
    function deleteExistingAssociations() {

        $this->deletePodcastIndividualAssociations( $this->data['Podcast']['id'] );
        $this->deleteGroupAssociations( $this->data['Podcast']['id'] );
    }


    /*
     * @name : deletePodcastIndividualAssociations
     * @description : Before we save the new moderators and members we must delete the existing
     * rows in the table.
     * @updated : 23rd May 2011
     * @by : Charles Jackson
     */
    function deletePodcastIndividualAssociations( $podcast_id = null ) {

        // Now we must delete all rows in the magic join table user_user_groups.
        $PodcastIndividual = ClassRegistry::init('UserPodcast');

        $PodcastIndividual->recursive = -1;
        $individuals = $PodcastIndividual->find( 'all', array( 'conditions' => array( 'podcast_id' => $podcast_id ) ) );


        $PodcastIndividual->begin();

        foreach( $individuals as $individual ) {

            if( $PodcastIndividual->delete( $individual['UserPodcast']['id'] ) == false ) {
                $PodcastIndividual->rollback();
                return false;
            }
        }

        $PodcastIndividual->commit();

        // The "HBTM Moderator" array is used for reading only, they are saved under the
        // "hasMany PodcastModerator" respectively. We do this so we can
        // set the additonal moderator flag to true on the join table. (not possible in HBTM).
        $this->unBindModel( array( 'hasAndBelongsToMany' => array('Moderators' ) ) );

        return true;
    }

    /*
     * @name : deleteGroupAssociations
     * @description : Before we save the usergroups we must delete the existing
     * rows in the table.
     * @updated : 23rd May 2011
     * @by : Charles Jackson
     */
    function deleteGroupAssociations( $podcast_id = null ) {

        // Now we must delete all rows in the magic join table user_user_groups that belong
        // to this usergroup.
        $UserGroup = ClassRegistry::init('UserGroupPodcast');

        $UserGroup->recursive = -1;
        $usergroups = $UserGroup->find( 'all', array( 'conditions' => array( 'podcast_id' => $podcast_id ) ) );


        $UserGroup->begin();

        foreach( $usergroups as $usergroup ) {

            if( $UserGroup->delete( $usergroup['UserGroupPodcast']['id'] ) == false ) {
                $UserGroup->rollback();
                return false;
            }
        }

        $UserGroup->commit();

        // The "HBTM ModeratorGroups" array is used for reading only, they are saved under the
        // "hasMany ModeratoruserGroups" respectively. We do this so we can
        // set the additonal moderator flag to true on the join table. (not possible in HBTM).
        $this->unBindModel( array( 'hasAndBelongsToMany' => array('ModeratorGroups' ) ) );

        return true;
    }

    /*
     * @name : rebuildSelection
     * @description : If  user submits an updated podcast form and it fails validation we must rebuild the contents
     * of the 'Nodes', 'Categories' and 'iTunes Categories' select boxes using the ids they submitted else, when we redisplay the
     * form they will merely contain id numbers.
     * @updated : 12th May 2011
     * @by : Charles Jackson
     */
    function rebuildSelection( $ids = array(), $class ) {

        $data = array();
        $elements = array();

        if( isSet( $ids[$class] ) && is_array( $ids[$class] ) && ( count( $ids[$class] ) ) ) {
            
            $this->Class = ClassRegistry::init($class);
            $this->Class->recursive = -1;
            $data = $this->Class->find('all', array('conditions' => array( "$class.id" => $ids[$class] ) ) );

            // The data retrieved is not in the correct format, need to massage it here.
            foreach( $data as $element ) {
                $elements[] = $element[$class];
            }
        }

        return $elements;
    }

    /*
     * @name : userHasPermission
     * @description : Checks to see if the currently logged in user has permission to edit
     * the podcast container.
     * @updated : 17th May 2011
     * @by : Charles Jackson
     */
     function userHasPermission( $data = array(), $current_user = array() ) {

         if( $data['Owner']['id'] == $current_user['id'] )
             return true;

         foreach( $data['PodcastModerators'] as $moderator ) {
             if( $moderator['id'] == $current_user['id'] )
                 return true;
         }
         
         return false;
     }

     /*
      * @name : createPodcastModerators
      * @description : Add the moderators using a "hasMany PodcastModerators" relationship saved to the same HBTM joining 
      * table user_podcasts so we may set the "moderator" flag to true.
      * @updated : 17th May 2011
      * @by : Charles Jackson
      */
    function createPodcastModerators() {

        $data['PodcastModerators'] = array();

        if( isSet( $this->data['Moderators'] ) && is_array( $this->data['Moderators'] ) ) {

            $x = 0;
            // We need to add the moderators using a hasMany relationship so we may set the value of the
            // moderator flag to TRUE. Not possible using the HBTM relationship.
            foreach( $this->data['Moderators'] as $moderator_id ) {


                if( (int)$moderator_id ) {
                    
                    $this->data['PodcastModerators'][$x]['user_id'] = $moderator_id;
                    $this->data['PodcastModerators'][$x]['moderator'] = true;
                }
                
                $x++;
            }
            
            unset( $this->data['Moderators'] );
        }
     }

     /*
      * @name : createModeratorUserGroups
      * @description : Add the moderator usergroups using a "hasMany ModeratorUserGroups" relationship saved to the same HBTM joining
      * table user_groups_podcasts so we may set the "moderator" flag to true.
      * @updated : 23rd May 2011
      * @by : Charles Jackson
      */
    function createModeratorUserGroups() {

        $data['ModeratorUserGroups'] = array();

        if( isSet( $this->data['ModeratorGroups'] ) && is_array( $this->data['ModeratorGroups'] ) ) {

            $x = 0;
            // We need to add the moderators using a hasMany relationship so we may set the value of the
            // moderator flag to TRUE. Not possible using the HBTM relationship.
            foreach( $this->data['ModeratorGroups'] as $moderator_id ) {

                if( (int)$moderator_id ) {
                    
                    $this->data['ModeratorUserGroups'][$x]['user_group_id'] = $moderator_id;
                    $this->data['ModeratorUserGroups'][$x]['moderator'] = true;
                }
                
                $x++;
            }
            
            unset( $this->data['ModeratorGroups'] );
        }
     }

     /*
      * @name : rebuild
      * @description : When a user submits a podcast form and it fails validation this method will
      * rebuild the contents of the dynamic select boxes as they exist when posted. If they are not rebuilt
      * they will merely contain ID numbers.
      * @updated : 17th May 2011
      * @by : Charles Jackson
      */
     function rebuild() {

        $this->data['Nodes'] = $this->rebuildSelection( $this->data, 'Nodes' );
        $this->data['Categories'] = $this->rebuildSelection( $this->data, 'Categories' );
        $this->data['iTuneCategories'] = $this->rebuildSelection( $this->data, 'iTuneCategories' );
        $this->data['UserGroups'] = $this->rebuildSelection( $this->data, 'UserGroups' );
        $this->data['Members'] = $this->rebuildSelection( $this->data, 'Members' );
        $this->data['Moderators'] = $this->rebuildSelection( $this->data, 'Moderators' );
        $this->data['ModeratorGroups'] = $this->rebuildSelection( $this->data, 'ModeratorGroups' );
        $this->data['MemberGroups'] = $this->rebuildSelection( $this->data, 'MemberGroups' );

        return $this->data;
     }

     /*
      * @name : getItunesUserPodcasts
      * @description : We are using the ORM for this complex SQL. It will return all podcasts to which the currently
      * logged in user has access as follows :
      * 1) Are they the owner?
      * 2) Are they a moderator?
      * 3) Are they a member?
      * 4) Are they a member of an associated moderator group?
      * 5) Are they a member of an associated user group?	  
      * @updated : 24th May 2011
      * @by : Charles Jackson
      */
     function getUserPodcasts( $user_id = null, $podcast = null ) {

       $this->recursive = -1;

        $list = array();
        $conditions = $this->buildConditions(  $user_id );
        $conditions = $this->buildFilters( $podcast, $conditions );

        $data = $this->find('all',array(
            'fields' => array(
                'DISTINCT(Podcast.id)',
                ),
            'conditions'=> $conditions,
            'joins' => array(
                array(
                    'table' => 'users',
                    'alias' => 'Owner',
                    'type' => 'INNER',
                    'conditions' => array(
                		array( 'OR' => array(
	                        array(
	                        	'Owner.iTunesU' => 'Y',
	                        	'Podcast.intended_itunesu_flag' => 'N',
	                        	'Podcast.owner_id = Owner.id'
                        		),
	                        array(
	                        	'Owner.YouTube' => 'Y',
	                        	'Podcast.intended_youtube_flag' => 'N',
	                        	'Podcast.owner_id = Owner.id'
                        		),                        		
	                        array(
	                        	'Owner.iTunesU' => 'N',
	                        	'Owner.YouTube' => 'N',
	                        	'Podcast.owner_id = Owner.id'
                        		)
                        	)
                        )
                    )
                ),
                array(
                    'table'=>'user_podcasts',
                    'alias'=>'UserPodcasts',
                    'type'=>'LEFT',
                    'conditions'=>array(
                        'UserPodcasts.podcast_id = Podcast.id'
                        )
                    ),
                array(
                    'table'=>'user_group_podcasts',
                    'alias'=>'UserGroupPodcasts',
                    'type'=>'LEFT',
                    'conditions'=>array(
                        'UserGroupPodcasts.podcast_id = Podcast.id'
                        )
                    ),
                array(
                    'table'=>'user_user_groups',
                    'alias'=>'UserUserGroups',
                    'type'=>'LEFT',
                    'conditions'=>array(
                        'UserUserGroups.user_group_id = UserGroupPodcasts.user_group_id'
                        )
                    )
                ),
            'order'=>array('Podcast.id DESC')
            )
        );

        // Create a simple array of ID numbers.
        foreach( $data as $podcast ) {

            $list[] = $podcast['Podcast']['id'];
        }

        return $list;
     }
     
    /*
     * @name : buildConditions
     * @description : Exploited from the "/podcasts/index" URL, it defines the rules that only retrieve
     * podcasts belonging to the currently logged in user.
     * @updated : 31st May 2011
     * @by : Charles Jackson
     */
    function buildConditions( $user_id = false ) {

        $conditions = array(
            array('OR' => array(
                array(
                    'UserPodcasts.user_id' => $user_id
                    ),
                array(
                    'UserUserGroups.user_id' => $user_id
                    ),
                array(
                    'Podcast.owner_id' => $user_id
                    )
                )
            ),
            'Podcast.deleted' => 0
        );
        
        return $conditions;
    }


    /*
     * @name : buildFilters
     * @description : Exploited from the "/podcasts/index" and "/admin/podcasts/index" URL, it builds the filters
     * that can be selected via the dropdown.
     * @updated : 31st May 2011
     * @by : Charles Jackson
     */
    function buildFilters( $podcast, $conditions = array() ) {

        switch( $podcast['filter'] ) {
            case PUBLIC_ITUNEU_PODCAST:
                $conditions['Podcast.intended_itunesu_flag'] = 'Y';
                $conditions['Podcast.itunesu_site'] = 'public';
                $conditions['Podcast.deleted'] = 0;
                break;
            case UNPUBLISHED_ITUNEU_PODCAST:
                $conditions['Podcast.intended_itunesu_flag'] = 'Y';
                $conditions['Podcast.itunesu_site'] = 'public';
                $conditions['Podcast.publish_itunes_u'] = 'N';
                $conditions['Podcast.openlearn_epub'] = 'N';
                $conditions['Podcast.deleted'] = 0;
                break;
            case PUBLISHED_ITUNEU_PODCAST:
                $conditions['Podcast.intended_itunesu_flag'] = 'Y';
                $conditions['Podcast.itunesu_site'] = 'public';
                $conditions['Podcast.publish_itunes_u'] = 'Y';
                $conditions['Podcast.deleted'] = 0;
                break;
            case OPENLEARN_PODCAST:
                $conditions['Podcast.intended_itunesu_flag'] = 'Y';
                $conditions['Podcast.itunesu_site'] = 'public';
                $conditions['Podcast.openlearn_epub'] = 'Y';
                $conditions['Podcast.deleted'] = 0;
                break;
            case PRIVATE_ITUNEU_PODCAST:
                $conditions['Podcast.intended_itunesu_flag'] = 'Y';
                $conditions['Podcast.itunesu_site'] = 'private';
                $conditions['Podcast.deleted'] = 0;
                break;
            case DELETED_PODCAST:
                $conditions['Podcast.deleted'] = 1;
        }

         if( !empty( $podcast['search'] ) && ( $podcast['search'] != INPUT_GREETING ) ) {
     		
	        $conditions[] = array(
	            array('OR' => array(
	                array(
	                    'Podcast.title LIKE ' => '%'.$podcast['search'].'%'
	                    ),
	                array(
	                    'Podcast.summary LIKE ' => '%'.$podcast['search'].'%'
	                    ),
	                array(
	                    'Owner.firstname LIKE ' => '%'.$podcast['search'].'%'
	                    ),
	                array(
	                    'Owner.lastname LIKE ' => '%'.$podcast['search'].'%'
	                    )
                    )
	            )
	        );
     	}
     	        
        return $conditions;
     }
     
    /*
     * @name : buildiTunesFilters
     * @description : Exploited from the "/itunes/podcasts/index" URL, it builds the filters
     * that can be selected via the dropdown.
     * @updated : 8th July 2011
     * @by : Charles Jackson
     */
    function buildiTunesFilters( $filter = null ) {
    	    	
        switch( strtolower( $filter ) ) {
            case 'all':
	            return array('OR' => array(
	                array(
	                    'Podcast.consider_for_itunesu' => true
	                    ),
	                array(
	                    'Podcast.intended_itunesu_flag' => 'Y'
	                    ),
	                array(
	                    'Podcast.publish_itunes_u' => 'Y'
	                    )
                    ),
                    'Podcast.deleted' => 0
	            );
                break;
            case 'consideration':
                return array( 
					'Podcast.consider_for_itunesu' => true,
					'Podcast.intended_itunesu_flag != ' => 'Y',
                	'Podcast.publish_itunes_u != ' => 'Y',
	                'Podcast.deleted' => 0 
                );
                break;
			case 'intended':
                return array( 
					'Podcast.intended_itunesu_flag' => 'Y',
                	'Podcast.publish_itunes_u != ' => 'Y',
	                'Podcast.deleted' => 0 
                );
                break;
            case 'openlearn':
            	return array('OR' => array(
					array(
		                'Podcast.publish_itunes_u' => 'Y',
		                'Podcast.openlearn_epub' => 'Y',
		                'Podcast.deleted' => 0
						),
					array(
		                'Podcast.intended_itunesu_flag' => 'Y',
		                'Podcast.openlearn_epub' => 'Y',
		                'Podcast.deleted' => 0
						),
					array(
		                'Podcast.intended_itunesu_flag' => 'Y',
		                'Podcast.openlearn_epub' => 'Y',
		                'Podcast.deleted' => 0
						),
					)
            	);
                break;
            case 'published':
            default :
            	return array(
	                'Podcast.publish_itunes_u' => 'Y',
	                'Podcast.deleted' => 0
            	);
                break;
        }
     }

    /*
     * @name : buildYoutubeFilters
     * @description : Exploited from the "/youtube/podcasts/index" URL, it builds the filters
     * that can be selected via the dropdown.
     * @updated : 8th July 2011
     * @by : Charles Jackson
     */
    function buildYoutubeFilters( $filter = null ) {

        switch( strtolower( $filter ) ) {
            case 'all':
	            return array('OR' => array(
	                array(
	                    'Podcast.consider_for_youtube' => true
	                    ),
	                array(
	                    'Podcast.intended_youtube_flag' => 'Y'
	                    ),
	                array(
	                    'Podcast.publish_youtube' => 'Y'
	                    )
                    ),
                    'Podcast.deleted' => 0
	            );
                break;        	
            case 'consideration':
                return array( 
					'Podcast.consider_for_youtube' => true,
					'Podcast.intended_youtube_flag != ' => 'Y',
                	'Podcast.publish_youtube != ' => 'Y',
	                'Podcast.deleted' => 0 
                );
                break;
            case 'intended':
                return array( 
	                'Podcast.intended_youtube_flag' => 'Y',
                	'Podcast.publish_youtube !=' => 'Y',
	                'Podcast.deleted' => 0 
                );
                break;
            case 'publish':
            default:
            	return array(
	                'Podcast.publish_youtube' => 'Y',
	                'Podcast.deleted' => 0
            	);
                break;
        }
     }
     
    /*
     * @name : unconfirmedChangeOfOwnership
     * @description : Called when somebody updates a podcast. It checks to see if there has been a change of ownership and if that
     * change has been confirmed by the user. Returns a bool.
     * updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function unconfirmedChangeOfOwnership() {

        if(
            ( isSet( $this->data['Podcast']['confirmed'] ) && ( $this->data['Podcast']['confirmed'] == false ) )
            &&
            ( isSet( $this->data['Podcast']['current_owner_id'] ) && ( $this->data['Podcast']['current_owner_id'] != $this->data['Podcast']['owner_id'] ) ) )
        {
            return true;
        }

        return false;
    }

    /*
     * @name : getPreferredNode
     * @description : We set the value of preferred node to equal the value of the first node choosen when editing a podcast.
     * @updated : 23rd June 2011
     * @by : Charles Jackson
     */
    function setPreferredNode() {
		
		if( isSet( $this->data['Nodes'] ) && is_array( $this->data['Nodes'] ) && count( $this->data['Nodes'] ) ) {
			
			$this->data['Podcast']['preferred_node'] = $this->data['Nodes'][0];
			
		} else {
			
			$this->data['Podcast']['preferred_node'] = null;
		}
			
        return true;
    }

    /*
     * @name : setPreferredCategory
     * @description : We set the value of preferred category to equal the value of the first category choosen when editing a podcast.
     * @updated : 7th July 2011
     * @by : Charles Jackson
     */
    function setPreferredCategory() {

		if( isSet( $this->data['Categories'] ) && is_array( $this->data['Categories'] ) && count( $this->data['Categories'] ) ) {    	

			$this->data['Podcast']['preferred_category'] = $this->data['Categories'][0];
			
		} else {
			
			$this->data['Podcast']['preferred_category'] = null;
		}
			
        return true;
    }

    /*
     * @name : setPreferredItunesuCategory
     * @description : We set the value of preferred category to equal the value of the first category choosen when editing a podcast.
     * @updated : 7th July 2011
     * @by : Charles Jackson
     */
    function setPreferredItunesuCategory( $itunesu_categories = array() ) {

		if( isSet( $this->data['iTuneCategories'] ) && is_array( $this->data['iTuneCategories'] ) && count( $this->data['iTuneCategories'] ) ) {    	

			$this->data['Podcast']['preferred_itunesu_category'] = $this->data['iTuneCategories'][0];
			
		} else {
			
			$this->data['Podcast']['preferred_itunesu_category'] = null;
		}
			
        return true;
    }
		
	/* 
	 * @name : deleteImages
	 * @description : Will create an array containing the 3 image names (original, resized and thumbnail) that can be passed
	 * to the API for deletion. At time of creatiion called from the "delete_image" method in the podcasts controller.
	 * @updated : 28th June 2011
	 * @by : Charles Jackson
	 */	
	function deleteImages( $podcast = array(), $image_type = null ) {


		if( !isSet( $podcast[$image_type] ) )
			return false;

			
		$media_images = array();
		
		$media_images[] = array( 
			'destination_path' => $podcast['custom_id'].'/',
			'destination_filename' => $podcast[$image_type]
			);
		$media_images[] = array( 
			'destination_path' => $podcast['custom_id'].'/',
			'destination_filename' => $this->getStandardImageName( $podcast[$image_type] )
			);
		$media_images[] = array( 
			'destination_path' => $podcast['custom_id'].'/',
			'destination_filename' => $this->getThumbnailImageName( $podcast[$image_type] )
			);
			
		return $media_images;
	}
	
	/* 
	 * @name : stripJoinsByAction
	 * @description : There are a lot of joins in this model and we do not wish to retrieve all information
	 * every time we load a page. As well as using the "recursive" command and the "containable" to limit how much info 
	 * any "find" statement retrieve we also use this method to unset many of the joins dynamically further reducing the 
	 * overhead on the database.  
	 * NOTE: The "containable" method makes a distinct SQL select statement for every join hence I have resorted to this
	 * method due to the volume of data involved.
	 * @updated : 19th June 2011
	 * @by : Charles Jackson
	 */	
	function stripJoinsByAction( $action = null ) {
		
		switch ( $action ) {
			case 'index':
		        // Unset this join else we will get duplicate rows on the various joins.
		        unset( $this->hasOne['UserPodcast'] );
		        unset( $this->hasMany['PublishedPodcastItems'] );
				unset( $this->hasMany['PodcastItems'] );
		        unset( $this->hasMany['PodcastLinks'] );
				unset( $this->belongsTo['Language'] );
				unset( $this->Owner->hasMany['Podcasts'] );				
				unset( $this->hasAndBelongsToMany['Categories'] );
				unset( $this->hasAndBelongsToMany['Nodes'] );
		        unset( $this->hasMany['ModeratorUserGroups'] );
		        unset( $this->hasMany['PodcastModerators'] );				
				break;
			case 'admin_index':
		        // Unset this join else we will get duplicate rows on the various joins.
		        unset( $this->hasOne['UserPodcast'] );
		        // Unset the rest to prevent a recursive loop on the models creating huge amounts of data
		        unset( $this->hasMany['PublishedPodcastItems'] );
				unset( $this->hasMany['PodcastItems'] );
		        unset( $this->hasMany['PodcastLinks'] );
		        unset( $this->hasMany['PodcastModerators'] );
		        unset( $this->hasMany['ModeratorUserGroups'] );
				unset( $this->hasAndBelongsToMany['Categories'] );
				unset( $this->hasAndBelongsToMany['Nodes'] );
				unset( $this->hasAndBelongsToMany['iTuneCategories'] );
				unset( $this->hasAndBelongsToMany['ModeratorGroups'] );
				unset( $this->hasAndBelongsToMany['MemberGroups'] );
				unset( $this->hasAndBelongsToMany['Members'] );
				unset( $this->hasAndBelongsToMany['Moderators'] );
				break;
			case 'itunes_index':
			case 'youtube_index':
		        // Unset this join else we will get duplicate rows on the various joins.
		        unset( $this->hasOne['UserPodcast'] );
		        // Unset the rest to prevent a recursive loop on the models creating huge amounts of data
		        unset( $this->hasMany['PublishedPodcastItems'] );
				unset( $this->hasMany['PodcastItems'] );				
		        unset( $this->hasMany['PodcastLinks'] );
		        unset( $this->hasMany['PodcastModerators'] );
		        unset( $this->hasMany['ModeratorUserGroups'] );
				unset( $this->hasAndBelongsToMany['Categories'] );
				unset( $this->hasAndBelongsToMany['Nodes'] );
				unset( $this->hasAndBelongsToMany['iTuneCategories'] );
				unset( $this->hasAndBelongsToMany['ModeratorGroups'] );
				unset( $this->hasAndBelongsToMany['MemberGroups'] );
				unset( $this->hasAndBelongsToMany['Members'] );
				unset( $this->hasAndBelongsToMany['Moderators'] );
				unset( $this->Owner->hasMany['Podcasts'] );
				break;
			default:
				break;	
		}
	}
	
	/*
	 * @name : softDelete
	 * @description : Builds the array that is passed to the API when building a soft delete
	 * by writing a htaccess file or when restoring a podcast by the same method ( ie: overwriting the
	 * existing .htaccess file )
	 * @updated : 26th July 2011
	 * @by : Charles Jackson
	 */
	function softDelete( $podcast = array() ) {
		
		$data = array();
		
		$data[] = array( 
			
			'source_path' => $podcast['Podcast']['custom_id'].'/',
			'destination_path' => $podcast['Podcast']['custom_id'].'/', 
			'source_filename' => 'htaccess',
			'destination_filename' => '.htaccess' 
		);
		
		return $data;
	}	

    /*
     * @name : copy
     * @description : Will make a copy of the podcast contained within the class property data and return a boolean.
     * @updated : 27th July 2011
     * @by : Charles Jackson
     */ 	
	function copy( $user_id = null ) {

		$original_podcast_id = $this->data['Podcast']['id'];
		$original_custom_id = $this->data['Podcast']['custom_id'];
		$this->data['Podcast']['id'] = null;
		
		// Make a local copy.
		$data = $this->data;
		
		// Start a transaction
		$this->begin();
		
		// We only pass a user_id when it is being called using the "copy" method in the
		// podcast controller. If being called by the VLE we do not update ownership.
		if( !empty( $user_id ) )
			$this->data['Podcast']['owner_id'] = $user_id;
			
		// Now reset any flags ensuring it is not published on iTunes or Youtube
		$this->data['Podcast']['publish_youtube_date'] = null;
		$this->data['Podcast']['publish_itunes_date'] = null;		
		$this->data['Podcast']['publish_itunes_u'] = 'N';		
		$this->data['Podcast']['publish_youtube'] = 'N';				
		$this->data['Podcast']['intended_itunesu_flag'] = 'N';				
		$this->data['Podcast']['intended_youtube_flag'] = 'N';
		$this->data['Podcast']['consider_for_youtube'] = false;
		$this->data['Podcast']['consider_for_itunesu'] = false;
				
		$this->set( $this->data );
		
		// Because we have unset the majority of association force a save without validation else it will cause
		// errors on the automagical 'function before***' methods.
		$this->save( $this->data, array('validate' => false ) );
		
		// Now we need to copy the data back in the class property from our local copy because it has been wiped by the
		// set/save combination above.
		$this->data = $data;

		$this->data['Podcast']['id'] = $this->getLastInsertId();
		$data['Podcast']['id'] = $this->getLastInsertId();

		if( isSet( $this->data['PodcastItems'] ) && count( $this->data['PodcastItems'] ) ) {
			
			$PodcastItem = ClassRegistry::init('PodcastItem');
			
			foreach( $this->data['PodcastItems'] as $podcast_item ) {

				if( $podcast_item['processed_state'] == self::AVAILABLE ) {				
				
					$podcast_item['id'] = null;
					$podcast_item['youtube_flag'] = 'N';
					$podcast_item['itunes_flag'] = 'N';
					$podcast_item['podcast_id'] = $this->data['Podcast']['id'];
					$PodcastItem->set( $podcast_item ); 
					$PodcastItem->save();
					$podcast_item_id = $PodcastItem->getLastInsertId();
					
					foreach( $podcast_item['PodcastMedia'] as $podcast_media ) {
						
						$podcast_media['id'] = null;
						$podcast_media['podcast_item'] = $podcast_item_id;
						$this->PodcastItems->PodcastMedia->set( $podcast_media );
						$this->PodcastItems->PodcastMedia->save();
					}
				}
			}
		}
		
		// We need to unset the PodcastItems array else we will steal the PodcastItems from the original
		// podcast when we use the saveAll command.
		unset( $this->data['PodcastItems'] );
		
		if( isSet( $this->data['iTuneCategories'] ) && count( $this->data['iTuneCategories'] ) )
			$this->data['iTuneCategories'] = $this->copyAssociations('iTuneCategories' );
			
		if( isSet( $this->data['Nodes'] ) && count( $this->data['Nodes'] ) )			
			$this->data['Nodes'] = $this->copyAssociations('Nodes' );
			
		if( isSet( $this->data['Categories'] ) && count( $this->data['Categories'] ) )			
			$this->data['Categories'] = $this->copyAssociations('Categories' );
			
		$this->data['Podcast']['custom_id'] = str_replace( $original_podcast_id . '_', $this->data['Podcast']['id'] . '_', $this->data['Podcast']['custom_id'] );
		$this->data['Podcast']['title'] .= ' (COPY)';
		$this->set( $this->data );	
		
		//Wrapped in two arrays so we create a multidimensional solution inline with all API commands.
		$api_information = array( array(
			'source_path' => $original_custom_id,
			'destination_path' => $this->data['Podcast']['custom_id']
		) );
			
		if ( $this->saveAll( $this->data, array('validate' => false ) ) ) {
			
			$this->data = $data;
			$this->commit();
			
			return $api_information;
			
		} else {
			
			$this->rollback();
			return false;
		}
	}

    /*
     * @name : copyAssociations
     * @description : When we are copying a podcast we need to copy certain associated data specifically,
     * iTunesCategories, Nodes and Categories.
     * @updated : 28th July 2011
     * @by : Charles Jackson
     */ 	
	function copyAssociations( $key ) {
		
		$data = array();
		
		foreach( $this->data[$key] as $association ) {

			$this->data[$key][] = $association['id'];
		}
	}
	
	/*
	 * @name : edit
	 * @description : Exploits the "containable" behaviour to limit the data being retrieved. It is called from the
	 * podcasts controller on the edit and admin_edit methods. It can be further refined by limitinng the columns
	 * retrieved and not just the relationships.
	 * @updated : 6th September 2011
	 * @by : Charles Jackson
	 */
	function edit( $id ) {
		
		$this->Behaviors->attach('Containable');
		
		return $this->find('first', array(
			'conditions' => array('Podcast.id' => $id ),
			'fields' => array( 'Podcast.*' ),
			'contain' => array(
				'Moderators' => array(
					'fields' => array(
						'Moderators.*'
					)
				),
				'Members' => array(
					'fields' => array(
						'Members.*'
					)
				),
				'ModeratorGroups' => array(
					'fields' => array(
						'ModeratorGroups.*'
					),
					'Users' => array(
						'fields' => array(
							'Users.*'
						)
					)				
				),
				'MemberGroups' => array(
					'fields' => array(
						'MemberGroups.*'
					),
					'Users' => array(
						'fields' => array(
							'Users.*'
						)
					)				
				),
				'PreferredNode' => array(
					'fields' => array(
						'PreferredNode.*'
					)
				),
				'Owner' => array(
					'fields' => array(
						'Owner.*'
					)
				),
				'Categories' => array(
					'fields' => array(
						'Categories.*'
					)
				),
				'Nodes' => array(
					'fields' => array(
						'Nodes.*'
					)
				),
				'iTuneCategories' => array(
					'fields' => array(
						'iTuneCategories.*'
					)
				)
			)
		) );
	}

	/*
	 * @name : view
	 * @description : Exploits the "containable" behaviour to limit the data being retrieved. It is called from the
	 * podcasts controller on the view and admin_view methods. It can be further refined by limiting the columns
	 * retrieved and not just the relationships.
	 * @NOTE: This method retrieves MORE data then the "edit" method directly above.
	 * @updated : 6th September 2011
	 * @by : Charles Jackson
	 */
	function view( $id ) {
		
		$this->Behaviors->attach('Containable');
		
		return $this->find('first', array(
			'conditions' => array('Podcast.id' => $id ),
			'fields' => array( 'Podcast.*' ),
			'contain' => array(
				'Moderators' => array(
					'fields' => array(
						'Moderators.*'
					)
				),
				'Members' => array(
					'fields' => array(
						'Members.*'
					)
				),
				'ModeratorGroups' => array(
					'fields' => array(
						'ModeratorGroups.*'
					),
					'Users' => array(
						'fields' => array(
							'Users.*'
						)
					)				
				),
				'MemberGroups' => array(
					'fields' => array(
						'MemberGroups.*'
					),
					'Users' => array(
						'fields' => array(
							'Users.*'
						)
					)				
				),
				'PreferredNode' => array(
					'fields' => array(
						'PreferredNode.*'
					)
				),
				'Owner' => array(
					'fields' => array(
						'Owner.*'
					)
				),
				'Categories' => array(
					'fields' => array(
						'Categories.*'
					)
				),
				'Nodes' => array(
					'fields' => array(
						'Nodes.*'
					)
				),
				'iTuneCategories' => array(
					'fields' => array(
						'iTuneCategories.*'
					)
				),
				'PodcastItems' => array(
					'fields' => array(
						'PodcastItems.id',
						'PodcastItems.title',
						'PodcastItems.image_filename',
						'PodcastItems.created',
						'PodcastItems.processed_state',
						'PodcastItems.published_flag',
						'PodcastItems.deleted',
					)
				),
				'Language' => array(
					'fields' => array(
						'Language.*'
					)
				)
			)
		) );
	}

	/*
	 * @name : statusUpdate
	 * @description : Exploits the "containable" behaviour to limit the data being retrieved. It is called from the
	 * podcasts controller when updating the statuus value between "consider", "intended" and "published" for both
	 * iTunes and Youtube
	 * @updated : 6th September 2011
	 * @by : Charles Jackson
	 */
	function statusUpdate( $id ) {
		
		$this->Behaviors->attach('Containable');
		
		return $this->find('first', array(
			'conditions' => array('Podcast.id' => $id ),
			'fields' => array( '
				Podcast.id, 
				Podcast.title, 
				Podcast.summary, 
				Podcast.consider_for_itunesu, 
				Podcast.intended_itunesu_flag,
				Podcast.publish_itunes_u,
				Podcast.publish_itunes_date,
				Podcast.consider_for_youtube,
				Podcast.intended_youtube_flag,
				Podcast.publish_youtube,
				Podcast.publish_youtube_date' 
			),
			'contain' => array(
				'Moderators' => array(
					'fields' => array(
						'Moderators.id'
					)
				),
				'Members' => array(
					'fields' => array(
						'Members.id'
					)
				),
				'ModeratorGroups' => array(
					'fields' => array(
						'ModeratorGroups.*'
					),
					'Users' => array(
						'fields' => array(
							'Users.id'
						)
					)				
				),
				'MemberGroups' => array(
					'fields' => array(
						'MemberGroups.*'
					),
					'Users' => array(
						'fields' => array(
							'Users.id'
						)
					)				
				),
				'Owner' => array(
					'fields' => array(
						'Owner.id',
						'Owner.first_name',
						'Owner.last_name'
					)
				)
			)
		) );
	}

	/*
	 * @name : all
	 * @description : Exploits the "containable" behaviour to limit the data being retrieved. It is called from the
	 * podcasts controller on the copy method and retrieves all data relating to a podcast.
	 * @updated : 6th September 2011
	 * @by : Charles Jackson
	 */
	function all( $id ) {
		
		$this->Behaviors->attach('Containable');
		
		return $this->find('first', array(
			'conditions' => array('Podcast.id' => $id ),
			'fields' => array( 'Podcast.*' ),
			'contain' => array(
				'Moderators' => array(
					'fields' => array(
						'Moderators.*'
					)
				),
				'Members' => array(
					'fields' => array(
						'Members.*'
					)
				),
				'ModeratorGroups' => array(
					'fields' => array(
						'ModeratorGroups.*'
					),
					'Users' => array(
						'fields' => array(
							'Users.*'
						)
					)				
				),
				'MemberGroups' => array(
					'fields' => array(
						'MemberGroups.*'
					),
					'Users' => array(
						'fields' => array(
							'Users.*'
						)
					)				
				),
				'PreferredNode' => array(
					'fields' => array(
						'PreferredNode.*'
					)
				),
				'Owner' => array(
					'fields' => array(
						'Owner.*'
					)
				),
				'Categories' => array(
					'fields' => array(
						'Categories.*'
					)
				),
				'Nodes' => array(
					'fields' => array(
						'Nodes.*'
					)
				),
				'iTuneCategories' => array(
					'fields' => array(
						'iTuneCategories.*'
					)
				),
				'PodcastItems' => array(
					'fields' => array(
						'PodcastItems.id',
						'PodcastItems.title',
						'PodcastItems.image_filename',
						'PodcastItems.created',
						'PodcastItems.processed_state',
						'PodcastItems.published_flag',
						'PodcastItems.deleted',
					),
					'PodcastMedia' => array(
						'fields' => array(
							'PodcastMedia.*'
						)
					)
				),
				'Language' => array(
					'fields' => array(
						'Language.*'
					)
				)
			)
		) );
	}
	
	/*
	 * @name : rss
	 * @description : Exploits the "containable" behaviour to limit the data being retrieved. It is called from the
	 * feeds/add controller/method when generating rss feeds.
	 * @updated : 6th September 2011
	 * @by : Charles Jackson
	 */
	function rss( $conditions = array() ) {
		
		$this->Behaviors->attach('Containable');
		
		return $this->find('first', array(
			'conditions' => $conditions,
			'fields' => array( 
				'Podcast.*',
			),
			'contain' => array(
				'PlayerItems' => array(
					'fields' => array(
						'PlayerItems.*'
					),
					'PodcastMedia' => array(
						'fields' => array(
							'PodcastMedia.*'
						)
					),
					'Transcript' => array(
						'fields' => array(
							'Transcript.*'
						)
					)
				),
				'PublishedPodcastItems ' => array(
					'fields' => array(
						'PublishedPodcastItems .*'
					),
					'PodcastMedia' => array(
						'fields' => array(
							'PodcastMedia.*'
						)
					),
					'Transcript' => array(
						'fields' => array(
							'Transcript.*'
						)
					)
				),
				'iTuneCategories' => array(
					'fields' => array(
						'iTuneCategories.*'
						)
					)
				)				
			)
		);
	}

}
