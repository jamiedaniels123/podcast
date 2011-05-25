<?php
class CommentsController extends AppController {

    var $components = array( 'papers' );
    var $name = 'Comments';

    function beforeFilter() {
        
        $this->Auth->allow( 'add', 'view' );
        $this->Comment->Behaviors->attach('Containable');
    }

    /*
     * @name : add
     * @desscription : Add a row to the comments table in ajax fashion
     * @name : Charles Jackson
     * @by : 10th Dec 2010
     */
    function add() {

        $this->autoRender = false;
        $this->layout = 'ajax';

        // Save the comment in a seperate var so we can do some validation using
        // $this->data then pass it back to the view if the validation fails.
        $comment = $this->data;
        
        if ( !empty( $this->data ) ) {

            $this->Comment->set($this->data);

            if( ( $this->Comment->create( $this->data ) ) && ( $this->Comment->validates( $this->data ) ) ) {

                if( $this->Comment->save($this->data) ) {

                    // If successfully saved read back the same record so we can send out emails and create notifications.
                    $this->data = $this->Comment->getDetails( array('Comment.id' => $this->Comment->getLastInsertID() ) );

                    // Save the online_test_paper_id so we can use it later when calculating the average star
                    // rating.
                    @$online_test_paper_id = $this->data['OnlineTestPaper']['id'];

                    // If the author of the test paper is the currently logged in user then pre approved the comment.
                    if( $this->data['OnlineTestPaper']['user_id'] == $this->Session->read('Auth.User.id') ) {

                        $this->data['Comment']['approved'] = true;
                        $this->Comment->save( $this->data );
                        $this->calculateAverageStarRating( $online_test_paper_id );
                        
                    } else {

                        // If they are signed up to email notifications send one out
                        if( $this->data['OnlineTestPaper']['User']['Profile']['email_notifications'] )
                            $this->emailTemplates->__sendNewCommentEmail( $this->data );

                        $this->loadModel('Notification');
                        $this->Notification->save( $this->notification->createNewCommentNotification( $this->data ) );

                        // Now read back all comments associated with this exam paper
                        // so we can update the average star rating at umbrella level
                        // in the online_test_paper table.
                        $this->data['Comments'] = $this->Comment->find('all', array(
                            'conditions' => array(
                                'Comment.online_test_paper_id' => $online_test_paper_id
                            ),
                            'fields' => array(
                                'Comment.id',
                                'Comment.star_rating',
                                'Comment.online_test_paper_id'
                                )
                            )
                        );
                    }
                    
                    $this->render('/elements/comment_thankyou');

                } else {

                    // Reassign the value back to this->data so it can be exploited on the comment form if the initial comment
                    // submission failed.
                    $this->set( 'errors', $this->Comment->invalidFields( $this->data ) );
                    $this->render('/elements/comment_add');

                }

            } else {

                // Reassign the value back to this->data so it can be exploited on the comment form if the initial comment
                // submission failed.
                $this->data = $comment;

                $this->set( 'errors', $this->Comment->invalidFields( $comment ) );
                $this->render('/elements/comment_add');

            }
        }
    }


	function view($id = null) {

		$this->layout = 'ajax';
		
		if ($id) {
			$this->data = $this->Comment->read(null, $id);
		}
	}

	function approve($id = null) {

	
                $this->data = $this->Comment->read(null, $id);
                if( $this->data['OnlineTestPaper']['user_id'] == $this->Session->read( 'Auth.User.id' ) ) {
                    
                    $this->data['Comment']['approved'] = true;
                    $this->Comment->save( $this->data['Comment'] );

					$this->calculateAverageStarRating( $this->data['OnlineTestPaper']['id'] );

                    $this->Session->setFlash(__('The comment has now been approved.', true));
                    $this->redirect($this->referer());

		} else {

			$this->Session->setFlash('We could not find the comment you were looking for. Perhaps you have deleted it?', 'default', array(), 'auth');
			$this->redirect('/dashboard');
		}
	}
	
	function delete($id = null) {

		$this->data = $this->Comment->read(null, $id);
		if( $this->data['OnlineTestPaper']['user_id'] == $this->Session->read( 'Auth.User.id' ) ) {
			
			$this->Comment->del($id);
			
			$this->calculateAverageStarRating( $this->data['OnlineTestPaper']['id'] );
			
			$this->Session->setFlash(__('The comment has been successfully deleted.', true));			
			$this->redirect($this->referer());
		} else {
			$this->Session->setFlash('We could not find the comment you were looking for. Perhaps you have already deleted it?', 'default', array(), 'auth');
			$this->redirect('/dashboard');
		}
	}

	private function calculateAverageStarRating( $online_test_paper_id ) {
		
		$this->data['Comments'] = $this->Comment->find( 'all', array(
		
				'conditions' => array(
					'Comment.online_test_paper_id' => $online_test_paper_id,
					'Comment.approved' => 1,
				),
				'fields'=>array(
					'Comment.id',
					'Comment.online_test_paper_id',
					'Comment.star_rating',
					'Comment.approved'
				)
			)
		);

		$this->loadModel('OnlineTestPaper');
		@$this->data['OnlineTestPaper'] = array();
		@$this->data['OnlineTestPaper']['id'] = $online_test_paper_id;
		@$this->data['OnlineTestPaper']['average_star_rating'] = $this->papers->calculateAverageStarRating( $this->data );

		$this->OnlineTestPaper->save( $this->data['OnlineTestPaper'] );
		
		
	}
}
?>
