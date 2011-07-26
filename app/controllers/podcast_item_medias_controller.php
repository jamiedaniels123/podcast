<?php
class PodcastItemMediasController extends AppController {

    var $name = 'PodcastItemMedias';
    var $components = array( 'Upload' );

    private $errors = array();

    /*
     * @name : beforeRender
     * @description : The beforeRender action is automatically called after the controller action has been executed and before the screen
     * is rendered.
     * @updated : 5th May 2011
     * @by : Charles Jackson
     */
    function beforeRender() {

        // If there are any errors assign them to the view
        if( count( $this->errors ) )
            $this->set('errors', $this->errors );
            
		parent::beforeRender();
    }

    /*
     * @name : delete
     * @desscription : Enables a user to delete a row on the media table including it's associated file on the media server
     * @name : Charles Jackson
     * @by : 4th July 2011
     */
	function delete( $id ) {
		
        $this->autoRender = false;
		$this->PodcastItemMedia->recursive = 3; // Raise the recursive from the default so we have the necessary data to check permissions.
        $this->data = $this->PodcastItemMedia->findById( $id );
	
        // If we did not find the podcast media then redirect to the referer.
        if( empty( $this->data ) ) {

            $this->Session->setFlash('We could not find the media you were looking for.', 'default', array( 'class' => 'error' ) );

        } else {
			

			if( $this->Api->deleteFileOnMediaServer( 
				array(
						'source_path' => $this->data['PodcastItem']['Podcast']['custom_id'].'/'.$this->data['PodcastItemMedia']['media_type'].'/',  						'filename' => $this->data['PodcastItemMedia']['filename'],  
					)
				) 
			) {

				$this->Session->setFlash('The attachment has been deleted.', 'default', array( 'class' => 'success' ) );
				$this->PodcastItemMedia->delete( $id );
							
			} else {
			
				$this->Session->setFlash('We could not schedule the attachment for deletion. If the problem persists please contact an administrator.', 'default', array( 'class' => 'error' ) );
			}
				
        }
        
		$this->redirect( array( 'controller' => 'podcast_items', 'action' => 'view', $this->data['PodcastItem']['id'] ) );		
		
    }
}
