<?php
class UserGroup extends AppModel {

    var $name = 'UserGroup';
    
    var $validate = array(

        'group_title' => array(
            'Rule1' => array(
                'rule' => 'notEmpty',
                'message' => 'Please provide a title for this user group.'
            )
        ),
        'GroupModerators' => array(
            'rule' => array( 'multiple', array( 'min' => 1 ) ),
            'allowEmpty' => false,
            'message' => 'You must select at least 1 moderator for this user group.'
        )
    );

    var $hasAndBelongsToMany = array(

        'Members' => array(
            'className' => 'User',
            'joinTable' => 'user_user_groups',
            'foreignKey' => 'user_group_id',
            'associationForeignKey' => 'user_id',
            'conditions' => array( 'UserUserGroup.moderator' => false ),
            'unique' => true,
            'fields' => 'Members.id,Members.full_name'
        ),
        'Users' => array(
            'className' => 'User',
            'joinTable' => 'user_user_groups',
            'foreignKey' => 'user_group_id',
            'associationForeignKey' => 'user_id',
            'unique' => true,
            'fields' => 'Users.id,Users.full_name'
        ),
        'Moderators' => array(
            'className' => 'User',
            'joinTable' => 'user_user_groups',
            'foreignKey' => 'user_group_id',
            'associationForeignKey' => 'user_id',
            'conditions' => array( 'UserUserGroup.moderator' => true ),
            'unique' => true,
            'fields' => 'Moderators.id,Moderators.full_name'
        ),
        'Podcasts' => array(
            'className' => 'Podcast',
            'joinTable' => 'user_group_podcasts',
            'foreignKey' => 'user_group_id',
            'associationForeignKey' => 'podcast_id',
			'fields' => 'Podcasts.id,Podcasts.title',
            'unique' => true
        )
    );

    var $hasMany = array(

        'GroupModerators' => array(
            'className' => 'UserUserGroup',
            'foreignKey' => 'user_group_id'
        )
    );

    var $hasOne = array(

        'UserUserGroup' => array(
            'className' => 'UserUserGroup',
            'foreignKey' => 'user_group_id'
        )
    );

    /*
     * @name : beforeValidate
     * @description : We need to copy the value of the hasMany GroupModerator array into the UserGroup
     * model so that it is properly validated using the rules above. No possible to validate CakePHP HBTM
     * data any other way. Trust me, I've goggled it...
     * @updated : 9th May 2011
     * @by : Charles Jackson
     */
    function beforeValidate() {

        if( isSet( $this->data['GroupModerators'] ) ) {

            $this->data[$this->alias]['GroupModerators'] = $this->data['GroupModerators'];

        } else {

            $this->data[$this->alias]['GroupModerators'] = array();
        }
    }

    /*
     * @name : beforeSave
     * @description : We have a unique situation here whereas the "HBTM Moderator" array is used to read back a list
     * of moderators but never used to save them. This is because we have to set the "moderator" flag on the magic
     * user_user_groups join table to true and this is not possible when using HBTM. We therefore create an alias
     * "hasMany GroupModerators" where we can set the "moderator" flag to true. However, we must first delete any existing
     * moderators using the method below.
     * but never
     * @updated : 12th May 2011
     * @by : Charles Jackson
     */
    function beforeSave() {
        
        // Now we must delete all rows in the magic join table user_user_groups that belong
        // to this usergroup and have a moderator flag set  to true.
        $GroupModerator = ClassRegistry::init('UserUserGroup');

        $GroupModerator->recursive = -1;
        $group_moderators = $GroupModerator->find( 'all', array( 'conditions' => array( 'user_group_id' => $this->data['UserGroup']['id'], 'moderator' => true ) ) );

        
        $GroupModerator->begin();
        
        foreach( $group_moderators as $group_moderator ) {

            if( $GroupModerator->delete( $group_moderator['UserUserGroup']['id'] ) == false ) {
                $GroupModerator->rollback();
                return false;
            }
        }

        $GroupModerator->commit();

        // The "HBTM Moderator" array is used for reading only, they are saved under the "hasMany GroupModerator" array
        // so we may set the additonal moderator flag to true on the join table. (not possible in  HBTM).
        unset( $this->data['Moderators'] );

        return true;
    }

    /*
     * @name : rebuildSelection
     * @description : If  user submits an updated user group form and it fails validation we must rebuild the contents
     * of the 'Members' and 'Moderators' select box using the user_ids they submitted else, when we redisplay the
     * form they will merely contain user_id numbers.
     * @updated : 12th May 2011
     * @by : Charles Jackson
     */
    function rebuildSelection( $user_ids ) {

        $data = array();
        $users = array();
        
        $User = ClassRegistry::init('User');
		$User->recursive = -1;
		
        $data = $User->find('all', array('conditions' => array( 'User.id' => $user_ids ) ) );

        // The data retrieved is not in the correct format, need to massage it here.
        foreach( $data as $user ) {
            
            $users[] = $user['User'];
        }
        
        return $users;
    }

     /*
      * @name : createUserGroupModerators
      * @description : Add the moderators using a "hasMany GroupModerators" relationship saved to the same HBTM joining
      * table user_user_groups so we may set the "moderator" flag to true.
      * @updated : 17th May 2011
      * @by : Charles Jackson
      */
    function createUserGroupModerators( $data = array() ) {

        // Add the moderators using a "hasMany GroupModerators" relationship saved to the same HBTM joining table
        // user_user_groups so we may set the "moderator" flag to true.
        $data['GroupModerators'] = array();

        if( isSet( $data['Moderators'] ) && is_array( $data['Moderators'] ) ) {

            $x = 0;
            // We need to add the moderators using a hasMany relationship so we may set the value of the
            // moderator flag to TRUE. Not possible using the HBTM relationship.
            foreach( $data['Moderators'] as $moderator_id ) {

                $data['GroupModerators'][$x]['user_id'] = $moderator_id;
                $data['GroupModerators'][$x]['moderator'] = true;
                
                $x++;
            }
        }

        return $data;

    }

     /*
      * @name : getUserUserGroups
      * @description : We are using the ORM for this complex SQL. It will return all podcasts to which the currently
      * logged in user has access as follows :
      * 1) Are they the owner?
      * 2) Are they a moderator?
      * 3) Are they a member?
      * 4) Are they a member of an associated user group?
      * @updated : 24th May 2011
      * @by : Charles Jackson
      */
     function getUserUserGroups( $user_id ) {

        $list = array();
        
        $data = $this->find('all',array(
            'fields'=>array(
                'DISTINCT(UserGroup.id)'
                ),
            'conditions'=> array(
                        'Users.user_id' => $user_id
                ),
            'joins' => array(
                array(
                    'table'=>'user_user_groups',
                    'alias'=>'Users',
                    'type'=>'INNER',
                    'conditions'=>array(
                        'Users.user_group_id = UserGroup.id'
                            )
                        )
                    ),
            'order' => array('UserGroup.id DESC')
            )
        );

        // Create a simple array of ID numbers.
        foreach( $data as $user_group ) {

            $list[] = $user_group['UserGroup']['id'];
        }

        return $list;
     }

    /*
     * @name : buildFilters
     * @description : Builds the filters for the admin_index method.
     * @updated : 19th July 2011
     * @by : Charles Jackson
     */
    function buildFilters( $user = array() ) {
    	
    	$conditions = array();
    	
         if( !empty( $user['search'] ) ) {
     		
	        $conditions[] = array(
	            array('OR' => array(
	                array(
	                    'UserGroup.group_title LIKE ' => '%'.$user['search'].'%'
	                    )
                    )
	            )
	        );
     	}
     	
     	return $conditions;
    }     
	
	/* 
	 * @name : stripJoinsByAction
	 * @description : There are a lot of joins in this model and we do not wish to retrieve all information
	 * every time we load a page. As well as using the "recursive" command to set how deep any "find" statement will
	 * dig we also use this method to unset many of the joins dynamically further reducing the overhead on the
	 * database.  
	 * @updated : 19th June 2011
	 * @by : Charles Jackson
	 */	
	function stripJoinsByAction( $action = null ) {
		
		switch ( $action ) {
			case 'index':
				// We must unbind this relationship else we will get dupliate entries on the join.
				unset( $this->hasOne['UserUserGroup'] );
				unset( $this->Members->hasMany['Podcasts'] );
				unset( $this->Moderators->hasMany['Podcasts'] );
				unset( $this->Users->hasMany['Podcasts'] );
				unset( $this->hasAndBelongsToMany['Podcasts'] );
				break;
			default:
				break;	
		}
	}
	
}