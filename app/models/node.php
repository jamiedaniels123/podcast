<?php
class Node extends AppModel {

    var $name = 'Node';
    var $validate = array();

    var $hasAndBelongsToMany = array(

        'Podcasts' => array(
            'className' => 'Podcast',
            'joinTable' => 'podcast_links',
            'foreignKey' => 'node_id',
            'associationForeignKey' => 'podcast_id',
            'unique' => true
        )
    );


}