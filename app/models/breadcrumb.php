<?php
class Breadcrumb extends AppModel {

	var $name = 'Breadcrumb';
	var $actsAs = array('Containable');
    var $current_breadcrumb = array(); // Holds details of the currently loaded page
    var $breadcrumb = array();
    var $breadcrumbs = array(); // Holds the final array of breadcrumbs
	var $parent_id = null;
	var $params;
     
	/*
	 * @name : build
	 * @description : Builds the breadcrumb trail
	 * @updated : 18th August 2011
	 * @by : Charles Jackson
	 */
	function build( $params = array(), $data = array() ) {

		$this->params = $params;
		$this->data = $data;
        $this->recursive = -1;	
		
        if( isSet( $this->params['url']['url'] ) ) {
            
            $this->current_breadcrumb =

            $this->find('first', array(
                'conditions' => array(
                    'OR' => array (
                        array(
                            'Breadcrumb.controller' => $this->params['controller'],
                            'Breadcrumb.action' => $this->params['action']
                            ),
                        array( 'Breadcrumb.url' => $this->params['url']['url'] )
						)
                    ),
                    'order' => 'Breadcrumb.id DESC'
                )
            );
			
            $this->parent_id = $this->current_breadcrumb['Breadcrumb']['parent_id'];

			$this->current_breadcrumb = $this->setTitle( $this->current_breadcrumb );
			
            $this->breadcrumbs[] = $this->current_breadcrumb;
			
            while( (int)$this->parent_id ) {
	                            	
                $this->breadcrumb =

	                $this->find('first', array(
	                    'conditions' => array(
	                        'Breadcrumb.id' => $this->parent_id,
	                        )
	                    )
	                );

				$this->breadcrumb = $this->setTitle( $this->breadcrumb );
				$this->appendId();
				
				
	                
				$this->breadcrumbs[] = $this->breadcrumb;
				$this->parent_id = $this->breadcrumb['Breadcrumb']['parent_id'];
            }

            return array_reverse( $this->breadcrumbs );
        }
	}

	/*
	 * @name : setTitle
	 * @description : If a bespoke title is available replace the default title of the breadcrumb
	 * @updated : 18th August 2011
	 * @by : Charles Jackson
	 */
	function setTitle( $breadcrumb = array() ) {

		if( in_array( strtolower( $breadcrumb['Breadcrumb']['url'] ), array( '/podcasts/view/','/admin/podcasts/view/', '/podcasts/edit/','/admin/podcasts/edit/' ) ) ) {
			
			if( isSet( $this->data['Podcast']['title'] ) && !empty( $this->data['Podcast']['title'] ) )
				$breadcrumb['Breadcrumb']['title'] = $this->data['Podcast']['title'];

			
		} elseif( in_array( strtolower( $breadcrumb['Breadcrumb']['url'] ), array( '/podcast_items/view/','/admin/podcast_items/view/', '/podcast_items/edit/' ) ) ) {

			if( isSet( $this->data['PodcastItem']['title'] ) && !empty( $this->data['PodcastItem']['title'] ) )
				$breadcrumb['Breadcrumb']['title'] = $this->data['PodcastItem']['title'];
			
		} elseif( in_array( strtolower( $breadcrumb['Breadcrumb']['url'] ), array( '/admin/users/edit/' ) ) ) {

			if( !empty( $this->data['User']['full_name'] ) )
				$breadcrumb['Breadcrumb']['title'] = $this->data['User']['full_name'];
				
		} elseif( in_array( strtolower( $breadcrumb['Breadcrumb']['url'] ), array( '/admin/user_groups/edit/', '/admin/user_groups/view/', '/user_groups/edit/', '/user_groups/view/' ) ) ) {

			if( !empty( $this->data['UserGroup']['group_title'] ) )
				$breadcrumb['Breadcrumb']['title'] = $this->data['UserGroup']['group_title'];
		}
		
		return $breadcrumb;
	}

	/*
	 * @name : appendId
	 * @description : We dynamically append database ID numbers to individual breadcrumbs using this method. For example, when viewing
	 * an item of media we need to append the associated podcast_id to the breadcrumb element that points to the parent collection. All
	 * that magic happens here.
	 * @updated : 18th August 2011
	 * @by : Charles Jackson
	 */	
	function appendId() {
		
		if( in_array( strtolower( $this->current_breadcrumb['Breadcrumb']['url'] ), array( '/admin/podcast_items/view/', '/podcast_items/view/','/podcast_items/edit/', '/podcast_items/add/' ) ) && in_array( $this->breadcrumb['Breadcrumb']['url'], array( '/podcasts/view/','/podcasts/edit/', '/admin/podcasts/view/','/admin/podcasts/edit/' ) ) ) {

			if( isSet( $this->data['PodcastItem']['podcast_id'] ) ) {
					
				$this->breadcrumb['Breadcrumb']['url'] .= $this->data['PodcastItem']['podcast_id'];
					
			} else {
					
				$this->breadcrumb['Breadcrumb']['url'] .= $this->data['Podcast']['id'];
			}
		}
	}
}
?>
