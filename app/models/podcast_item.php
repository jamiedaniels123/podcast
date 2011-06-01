<?php
class PodcastItem extends AppModel {

    var $name = 'PodcastItem';
    var $validate = array(
        
        'podcast_id' => array(
            'Rule1' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => 'Cannot identify the podcast you are trying to associate with this media.'
            )
        ),
        'target_url' => array(
            'Rule1' => array(
                'rule' => 'url',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid item link URL.'
            )
        ),
        'publication_date' => array(
            'Rule1' => array(
                'rule' => 'date',
                'allowEmpty' => true,
                'message' => 'If entered, you must provide a valid date in the format YYYY/MM/DD.'
            )
        )
    );

    var $belongsTo = array(

        'Podcast' => array(
            'className' => 'Podcast',
            'foreignKey' => 'podcast_id',
            'fields' => 'Podcast.id, Podcast.title, Podcast.summary'
        )
    );

    /*
     * @name : createFromUrlVariables
     * @description : Called from the ADD method directly after a successful filechucker upload
     * @updated : 25th May 2011
     * @by : Charles Jackson
     */
    function createFromUrlVariables( $url = array(), $podcast_id = null ) {

        $this->data['PodcastItem']['podcast_id'] = $podcast_id;
        $this->data['PodcastItem']['filename'] = $url['f1name'];
        return $this->data;
    }
}