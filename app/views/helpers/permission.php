<?php
class PermissionHelper extends AppHelper {

    var $helpers = array('Session','Object');
    
    /*
     * @name : isModerator
     * @description : Accepts an array from a HBTM join table and search through looking for the current user
     * id in the ['id'] column plus a ['moderator'] flag equal to true. Returns a bool.
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function isModerator( $moderators = array() ) {
        
        foreach( $moderators as $moderator ) {
            
            if( $moderator['id'] == $this->Session->read('Auth.User.id') )
                    return true;
        }
        
        return false;
    }

    /*
     * @name : inModeratorGroup
     * @description : Accepts an array from a HBTM join table and search through looking for the current user
     * id in the ['id'] column plus a ['moderator'] flag equal to true. Returns a bool.
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function inModeratorGroup( $moderator_groups = array() ) {

        foreach( $moderator_groups as $moderator_group ) {

            foreach( $moderator_group['Users'] as $user ) {

                if( $user['id'] == $this->Session->read('Auth.User.id') )
                    return true;
            }
        }

        return false;
    }

    /*
     * @name : isAdministrator
     * @description : If set, returns the value of Auth.User.administrator in session else returns false.
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function isAdministrator() {

        if( $this->Session->check('Auth.User.administrator') )
            return $this->Session->read('Auth.User.administrator');

        return false;
    }

    /*
     * @name : isApprover
     * @description : If set, returns the value of Auth.User.approver in session else returns false.
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function isApprover() {

        if( $this->Session->check('Auth.User.approver') )
            return $this->Session->read('Auth.User.approver');

        return false;
    }

    /*
     * @name : isOwner
     * @description : If set, compares the value of Auth.User.id against the owner_id held on the podcast table and returns
     * a bool. If the session is not set return false.
     * @updated : 20th May 2011
     * @by : Charles Jackson
     */
    function isOwner( $user_id = null ) {

        if( $this->Session->check('Auth.User.id') == false )
            return false;

        if( $user_id == $this->Session->read('Auth.User.id') )
            return true;

        return false;
    }

    /*
     * @name : isItunesUser
     * @description : Checks the value held in session and returns a bool
     * @updated : 25th May 2011
     * @by : Charles Jackson
     */
    function isItunesUser() {

        if( strtoupper( $this->Session->read('Auth.User.iTunesU') ) == 'Y' )
            return true;

        return false;
    }

    /*
     * @name : isYouTubeUser
     * @description : Checks the value held in session and returns a bool
     * @updated : 25th May 2011
     * @by : Charles Jackson
     */
    function isYouTubeUser() {

        if( strtoupper( $this->Session->read('Auth.User.YouTube') ) == 'Y' )
            return true;

        return false;
    }

    /*
     * @name : isOpenLearnUser
     * @description : Checks the value held in session and returns a bool
     * @updated : 25th May 2011
     * @by : Charles Jackson
     */
    function isOpenLearnUser() {

        if( strtoupper( $this->Session->read('Auth.User.openlearn_explore') ) == 'Y' )
            return true;

        return false;
    }

    /*
     * @name : isAdminRouting
     * @description : Checks to see if the current URL is an admin page and returns a boolean.
     * @updated : 31st May 2011
     * @by : Charles Jackson
     */
    function isAdminRouting() {

    	
        if( substr( $params['action'], 0, 6 ) == 'admin_' )
            return true;
        
        return false;
    }
    
    /*
     * @name : isItunesRouting
     * @description : Checks to see if the current URL is an itunes specific page and returns a boolean.
     * @updated : 31st May 2011
     * @by : Charles Jackson
     */
    function isItunesRouting() {

        if( substr( $params['action'], 0, 6 ) == 'itunes_' )
            return true;
        
        return false;
    }
    
    /*
     * @name : isYoutubeRouting
     * @description : Checks to see if the current URL is an itunes specific page and returns a boolean.
     * @updated : 31st May 2011
     * @by : Charles Jackson
     */
    function isYoutubeRouting() {

    	
        if( substr( $params['action'], 0, 6 ) == 'youtube_' )
            return true;
        
        return false;
    }
        
    /*
     * @name : youTubePrivileges
     * @description : 
     * @updated : 8th July 2011
     * @by : Charles Jackson
     */    
    function youTubePrivileges( $podcast = array() ) {
  	
    	if( $this->isYoutubeUser() && $this->Object->considerForYoutube( $podcast ) )
    		return true;
    		
    	return false;
    }

    /*
     * @name : iTunesPrivileges
     * @description : 
     * @updated : 8th July 2011
     * @by : Charles Jackson
     */    
    function iTunesPrivileges( $podcast = array() ) {
  	
    	if( $this->isItunesUser() && $this->Object->considerForItunes( $podcast ) )
    		return true;
    		
    	return false;
    }    
}
?>
