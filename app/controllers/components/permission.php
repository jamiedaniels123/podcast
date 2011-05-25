<?php
class PermissionComponent extends Object {

   /*
    * @name : PermissionComponent
    * @description : Used to detrmine if the currently logged in user has the necessary permissions to perform the action.
    * @updated : 24th May 2011
    * @by : Charles Jackson
    */

    var $components = array('Session');

    var $controller = null;
    private $errors = array();

    /*
     * @name : toView
     * @description : Take the data array and makes various calls to ensure they have the necessary permissions to view
     * by calling a combination of the generic methods below. Returns a bool.
     * @updated : 24th May 2011
     * @by : Charles Jackson
     */
    function toView( $data = array() ) {

        // Only podcast containers have owners and moderator groups so check they exist before we call the routine
        if( isSet( $data['Owner'] ) && is_array( $data['Owner'] ) ) {

            if( $this->__isOwner( $data['Owner']['id'] ) )
                return true;

            if( $this->__inModeratorGroup( $data['ModeratorGroups'] ) )
                return true;

        }


        if( $this->__isModerator( $data['Moderators'] ) )
            return true;
        if( $this->__isMember( $data['Members'] ) )
            return true;

        // Only podcast containers have member groups so check they exist before we call the routine
        if( isSet( $data['MembersGroups'] ) && is_array( $data['MembersGroups'] ) ) {

            if( $this->__inMemberGroup( $data['MembersGroups'] ) )
                return true;
        }

        return false;
    }

    /*
     * @name : toUpdate
     * @description : Take the data array and makes various calls to ensure they have the necessary permissions to view
     * by calling a combination of the generic methods below. Returns a bool.
     * @updated : 24th May 2011
     * @by : Charles Jackson
     */
    function toUpdate( $data = array() ) {

        // Only podcast containers have owners and moderator groups so check they exist before we call the routine
        if( isSet( $data['Owner'] ) && is_array( $data['Owner'] ) ) {

            if( $this->__isOwner( $data['Owner']['id'] ) )
                return true;

            if( $this->__inModeratorGroup( $data['ModeratorGroups'] ) )
                return true;

        }
        
        if( $this->__isModerator( $data['Moderators'] ) )
            return true;

        return false;
    }

    /*
     * @name : toDelete
     * @description : Take the data array and makes various calls to ensure they have the necessary permissions to delete
     * by calling a combination of the generic methods below. Returns a bool.
     * NOTE: This is used by podcasts only. You only need moderator status to delete a user group.
     * @updated : 24th May 2011
     * @by : Charles Jackson
     */
    function toDelete( $data = array() ) {

        if( $this->__isOwner( $data['Owner']['id'] ) )
            return true;

        return false;
    }

    /*
     * NOTHING TO SEE HERE FOLKS!!!
     * Below this line are the generic methods that are combined by the functions above. They should not need to be touched.
     */

    /*
     * @name : startup
     * @description : Grab the controller reference for later use.
     * @updated : 24th May 2011
     * @by : Charles Jackson
     */
    function startup( & $controller)
    {
       $this->controller = & $controller;
    }
    
    /*
     * @name : __isOwner
     * @description : If set, compares the value of Auth.User.id against the user_id passed as a parameter and returns
     * a bool. If the session is not set return false.
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function __isOwner( $user_id = null ) {

        if( $this->Session->check('Auth.User.id') == false )
            return false;

        if( $user_id == $this->Session->read('Auth.User.id') )
            return true;

        return false;
    }

    /*
     * @name : __isModerator
     * @description : Accepts an array and search through looking for the current user
     * id in the ['id']. Returns a bool.
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function __isModerator( $moderators = array() ) {

        foreach( $moderators as $moderator ) {

            if( $moderator['id'] == $this->Session->read('Auth.User.id') )
                    return true;
        }

        return false;
    }

    /*
     * @name : __inModeratorGroup
     * @description : Accepts an array and performs a recursive search through looking for the current user
     * id in the ['id']. Returns a bool.
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function __inModeratorGroup( $moderator_groups = array() ) {

        foreach( $moderator_groups as $moderator_group ) {

            foreach( $moderator_group['Users'] as $user ) {

                if( $user['id'] == $this->Session->read('Auth.User.id') )
                    return true;
            }
        }

        return false;
    }

    /*
     * @name : __isMember
     * @description : Accepts an array and search through looking for the current user
     * id in the ['id'].
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function __isMember( $members = array() ) {

        foreach( $members as $member ) {

            if( $member['id'] == $this->Session->read('Auth.User.id') )
                    return true;
        }

        return false;
    }

    /*
     * @name : __inMemberGroup
     * @description : Accepts an array and performs a recursive search through looking for the current user
     * id in the ['id'].
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function __inMemberGroup( $members = array() ) {

        foreach( $member_groups as $member_group ) {

            foreach( $member_group['Users'] as $user ) {

                if( $user['id'] == $this->Session->read('Auth.User.id') )
                    return true;
            }
        }

        return false;
    }

    /*
     * @name : getErrors
     * @description : Will create the image names from the parameters passed
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function getErrors() {

        return $this->errors;
    }

    /*
     * @name : hasErrors
     * @description : Will return a count of the number of elements in the array
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function hasErrors() {

        return count( $this->errors );
    }
}

?>
