<?php
class Podcast extends AppModel {

    const AVAILABLE = 9;
    const YES = 'Y';
    
    var $name = 'Podcast';
    var $backup_table = 'podcasts_backup';
    
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
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD.'
            )
        ),
        'update_itunes_date' => array(
            'Rule1' => array(
                'rule' => 'date',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD.'
            )
        ),
        'target_itunesu_date' => array(
            'Rule1' => array(
                'rule' => 'date',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD.'
            )
        ),
        'production_date' => array(
            'Rule1' => array(
                'rule' => 'date',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD.'
            )
        ),
        'rights_date' => array(
            'Rule1' => array(
                'rule' => 'date',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD.'
            )
        ),
        'metadata_date' => array(
            'Rule1' => array(
                'rule' => 'date',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD.'
            )
        ),
        'itunes_u_url' => array(
            'Rule1' => array(
                'rule' => 'url',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid web address.'
            )
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
            'fields' => 'Owner.id, Owner.full_name'
        )
    );

    var $hasMany = array(

        'PodcastLinks' => array(
            'className' => 'PodcastLink',
            'foreignKey' => 'podcast_id'
        ),
        'PodcastItems' => array(
            'className' => 'PodcastItem',
            'foreignKey' => 'podcast_id',
            'fields' => 'PodcastItems.id, PodcastItems.podcast_id, PodcastItems.title, PodcastItems.summary, PodcastItems.filename,
                PodcastItems.published_flag, PodcastItems.itunes_flag, PodcastItems.youtube_flag, PodcastItems.created, PodcastItems.created_when',
            'order' => 'PodcastItems.publication_date DESC'
        ),
        'PublishedPodcastItems' => array(
            'className' => 'PodcastItem',
            'foreignKey' => 'podcast_id',
            'fields' => 'PublishedPodcastItems.id, PublishedPodcastItems.podcast_id, PublishedPodcastItems.title, PublishedPodcastItems.summary, PublishedPodcastItems.filename,
                PublishedPodcastItems.published_flag, PublishedPodcastItems.itunes_flag, PublishedPodcastItems.youtube_flag, PublishedPodcastItems.created, PublishedPodcastItems.created_when,
                PublishedPodcastItems.author, PublishedPodcastItems.image_filename, PublishedPodcastItems.publication_date, PublishedPodcastItems.explicit',
            'conditions' => 'PublishedPodcastItems.published_flag = "Y"', 'PublishedPodcastItems.processed_state = 9', 'PublishedPodcastItems.title IS NOT NULL'
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

        if( $private == self::YES )
            return true;

        $this->PodcastItem = ClassRegistry::init('PodcastItem');

        return $this->PodcastItem->find( 'count', array('conditions' => array('PodcastItem.podcast_id' => $this->data['Podcast']['id'], 'PodcastItem.published_flag' => 1 ) ) );
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
     * @description : Called directly before model data is saved, it read through all associated media
     * and looks at the value of explicit. Depending upon results will set the appropriate value at
     * podcast level.
     * @updated : 3rd June 2011
     * @by : Charles Jackson
     */
    function __checkExplicitStatus() {

        $this->PodcastItem = ClassRegistry::init('PodcastItem');
        $data = $this->PodcastItem->find('all', array(
            'conditions' => array(
                'PodcastItem.published_flag' => self::YES,
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
        foreach( $this->data['Podcast'] as $key => $value ) {

            if( in_array( $key, array('publish_itunes_date','update_itunes_date','target_itunesu_date','production_date','rights_date', 'metadata_date' ) ) ) {

                if( (int)$value == false ) {
                    $this->data['Podcast'][$key] = null;
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
    function deleteExistingModerators( $podcast_id = null ) {

        $this->deletePodcastModerators( $podcast_id );
        $this->deleteModeratorUserGroups( $podcast_id );
    }


    /*
     * @name : deletePodcastModerators
     * @description : Before we save the moderators using a hasMany relationship we must delete the existing
     * rows in the table.
     * @updated : 23rd May 2011
     * @by : Charles Jackson
     */
    function deletePodcastModerators( $podcast_id = null ) {

        // Now we must delete all rows in the magic join table user_user_groups that belong
        // to this usergroup and have a moderator flag set  to true.
        $this->PodcastModerator = ClassRegistry::init('UserPodcast');

        $this->PodcastModerator->recursive = -1;
        $podcast_moderators = $this->PodcastModerator->find( 'all', array( 'conditions' => array( 'podcast_id' => $podcast_id, 'moderator' => true ) ) );


        $this->PodcastModerator->begin();

        foreach( $podcast_moderators as $podcast_moderator ) {

            if( $this->PodcastModerator->delete( $podcast_moderator['UserPodcast']['id'] ) == false ) {
                $this->PodcastModerator->rollback();
                return false;
            }
        }

        $this->PodcastModerator->commit();

        // The "HBTM Moderator" array is used for reading only, they are saved under the
        // "hasMany PodcastModerator" respectively. We do this so we can
        // set the additonal moderator flag to true on the join table. (not possible in HBTM).
        $this->unBindModel( array( 'hasAndBelongsToMany' => array('Moderators' ) ) );

        return true;
    }

    /*
     * @name : deletePodcastModerators
     * @description : Before we save the moderator usergroups using a hasMany relationship we must delete the existing
     * rows in the table.
     * @updated : 23rd May 2011
     * @by : Charles Jackson
     */
    function deleteModeratorUserGroups( $podcast_id = null ) {

        // Now we must delete all rows in the magic join table user_user_groups that belong
        // to this usergroup and have a moderator flag set  to true.
        $this->ModeratorUserGroup = ClassRegistry::init('UserGroupPodcast');

        $this->ModeratorUserGroup->recursive = -1;
        $moderator_usergroups = $this->ModeratorUserGroup->find( 'all', array( 'conditions' => array( 'podcast_id' => $podcast_id, 'moderator' => true ) ) );


        $this->ModeratorUserGroup->begin();

        foreach( $moderator_usergroups as $moderator_usergroup ) {

            if( $this->ModeratorUserGroup->delete( $moderator_usergroup['UserGroupPodcast']['id'] ) == false ) {
                $this->ModeratorUserGroup->rollback();
                return false;
            }
        }

        $this->ModeratorUserGroup->commit();

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
    function createPodcastModerators( $data = array() ) {

        //$data['PodcastModerators'] = array();

        if( isSet( $data['Moderators'] ) && is_array( $data['Moderators'] ) ) {

            $x = 0;
            // We need to add the moderators using a hasMany relationship so we may set the value of the
            // moderator flag to TRUE. Not possible using the HBTM relationship.
            foreach( $data['Moderators'] as $moderator_id ) {


                if( (int)$moderator_id ) {
                    
                    $data['PodcastModerators'][$x]['user_id'] = $moderator_id;
                    $data['PodcastModerators'][$x]['moderator'] = true;
                }
                
                $x++;
            }
        }

        return $data;
     }

     /*
      * @name : createModeratorUserGroups
      * @description : Add the moderator usergroups using a "hasMany ModeratorUserGroups" relationship saved to the same HBTM joining
      * table user_groups_podcasts so we may set the "moderator" flag to true.
      * @updated : 23rd May 2011
      * @by : Charles Jackson
      */
    function createModeratorUserGroups( $data = array() ) {

        //$data['ModeratorUserGroups'] = array();

        if( isSet( $data['ModeratorGroups'] ) && is_array( $data['ModeratorGroups'] ) ) {

            $x = 0;
            // We need to add the moderators using a hasMany relationship so we may set the value of the
            // moderator flag to TRUE. Not possible using the HBTM relationship.
            foreach( $data['ModeratorGroups'] as $moderator_id ) {

                if( (int)$moderator_id ) {
                    
                    $data['ModeratorUserGroups'][$x]['user_group_id'] = $moderator_id;
                    $data['ModeratorUserGroups'][$x]['moderator'] = true;
                }
                
                $x++;
            }
        }
        
        return $data;
     }

     /*
      * @name : rebuild
      * @description : When a user submits a podcast form and it fails validation this method will
      * rebuild the contents of the dynamic select boxes as they exist when posted. If they are not rebuilt
      * they will merely contain ID numbers.
      * @updated : 17th May 2011
      * @by : Charles Jackson
      */
     function rebuild( $data ) {

        $data['Nodes'] = $this->rebuildSelection( $this->data, 'Nodes' );
        $data['Categories'] = $this->rebuildSelection( $this->data, 'Categories' );
        $data['iTuneCategories'] = $this->rebuildSelection( $this->data, 'iTuneCategories' );
        $data['UserGroups'] = $this->rebuildSelection( $this->data, 'UserGroups' );
        $data['Members'] = $this->rebuildSelection( $this->data, 'Members' );
        $data['Moderators'] = $this->rebuildSelection( $this->data, 'Moderators' );
        $data['ModeratorGroups'] = $this->rebuildSelection( $this->data, 'ModeratorGroups' );
        $data['MemberGroups'] = $this->rebuildSelection( $this->data, 'MemberGroups' );

        return $data;

     }

     /*
      * @name : getUserPodcasts
      * @description : We are using the ORM for this complex SQL. It will return all podcasts to which the currently
      * logged in user has access as follows :
      * 1) Are they the owner?
      * 2) Are they a moderator?
      * 3) Are they a member?
      * 4) Are they a member of an associated user group?
      * @updated : 24th May 2011
      * @by : Charles Jackson
      */
     function getUserPodcasts( $user_id = null, $filter = null ) {

       $this->recursive = -1;

        $list = array();
        $conditions = $this->buildConditions(  $user_id );
        $conditions = $this->buildFilters( $filter, $conditions );


        $data = $this->find('all',array(
            'fields'=>array(
                'DISTINCT(Podcast.id)'
                ),
            'conditions'=> $conditions,
            'joins' => array(
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
    function buildFilters( $filter, $conditions = array() ) {

        switch( $filter ) {
            case PUBLIC_ITUNEU_PODCAST:
                $conditions[0]['Podcast.intended_itunesu_flag'] = 'Y';
                $conditions[0]['Podcast.itunesu_site'] = 'public';
                break;
            case UNPUBLISHED_ITUNEU_PODCAST:
                $conditions[0]['Podcast.intended_itunesu_flag'] = 'Y';
                $conditions[0]['Podcast.itunesu_site'] = 'public';
                $conditions[0]['Podcast.publish_itunes_u'] = 'N';
                $conditions[0]['Podcast.openlearn_epub'] = 'N';
                break;
            case PUBLISHED_ITUNEU_PODCAST:
                $conditions[0]['Podcast.intended_itunesu_flag'] = 'Y';
                $conditions[0]['Podcast.itunesu_site'] = 'public';
                $conditions[0]['Podcast.publish_itunes_u'] = 'Y';
                break;
            case OPENLEARN_PODCAST:
                $conditions[0]['Podcast.intended_itunesu_flag'] = 'Y';
                $conditions[0]['Podcast.itunesu_site'] = 'public';
                $conditions[0]['Podcast.openlearn_epub'] = 'Y';
                break;
            case PRIVATE_ITUNEU_PODCAST:
                $conditions[0]['Podcast.intended_itunesu_flag'] = 'Y';
                $conditions[0]['Podcast.itunesu_site'] = 'private';
                break;
            case DELETED_PODCAST:
                $conditions[0]['Podcast.deleted'] = 1;
        }

        return $conditions;
     }


     /*
      * @name : waitingApproval
      * @description : Will build the conditions to find all podcasts that are waiting to be approved.
      * @updated : 20th June 2011
      * @by : Charles Jackson
      */
     function waitingApproval() {

        $conditions = array(
            array('OR' => array(
                array(
                    'Podcast.intended_itunesu_flag' => 'Y',
                    'Podcast.publish_itunes_u' => 'N'
                    ),
                array(
                    'Podcast.intended_youtube_flag' => 'Y',
                    'Podcast.publish_youtube' => 'N'
                    )
                )
            ),
            'Podcast.deleted' => 0
        );

        return $conditions;

     }
}