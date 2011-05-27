<?php
class Podcast extends AppModel {

    var $name = 'Podcast';
    var $backup_table = 'podcasts_backup';
    
    var $validate = array(

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
        'title' => array(
            'Rule1' => array(
                'rule' => 'notempty',
                'allowEmpty' => false,
                'message' => 'Please provide a title for your feed.'
            )
        ),
        'summary' => array(
            'Rule1' => array(
                'rule' => 'notempty',
                'allowEmpty' => true,
                'message' => 'Please provide a short description for your feed.'
            )
        ),
        'link' => array(
            'Rule1' => array(
                'rule' => 'url',
                'allowEmpty' => true,
                'message' => 'Please provide a valid web address for the feed.'
            )
        ),
        'owner_email' => array(
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
            'rule' => array('multiple', array( 'min' => 1, 'max' => 4 ) ),
            'allowEmpty' => true,
            'message' => 'Please select between 1 and 4 nodes.'
        ),
        'Categories' => array(
            'rule' => array('multiple', array( 'min' => 1, 'max' => 3 ) ),
            'allowEmpty' => true,
            'message' => 'Please select between 1 and 3 iTunes categories.'
        ),
        'iTuneCategories' => array(
            'rule' => array('multiple', array( 'min' => 1, 'max' => 3 ) ),
            'allowEmpty' => true,
            'message' => 'You cannot select more than 3 iTunes U categories.'
        )
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
                PodcastItems.published_flag, PodcastItems.itunes_flag, PodcastItems.youtube_flag, PodcastItems.created, PodcastItems.created_when'
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
            'joinTable' => 'podcasts_Nodes',
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
     function getUserPodcasts( $user_id ) {

        
        $data = $this->find('all',array(
            'fields'=>array(
                'DISTINCT(Podcast.id)'
                ),
            'conditions'=> array(
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
                )
            ),
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
}
?>

