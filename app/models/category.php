<?php
class Category extends AppModel {

    var $name = 'Category';
    var $useTable = 'categories';
    var $validate = array();

    var $hasAndBelongsToMany = array(

        'Podcasts' => array(
            'className' => 'Podcast',
            'joinTable' => 'podcasts_categories',
            'foreignKey' => 'category_id',
            'associationForeignKey' => 'podcast_id',
            'unique' => true
        )
    );


    var $belongsTo = array(

        'ParentCategory' => array(
            'className' => 'Category',
            'foreignKey' => 'parent_id'
        )
    );
}