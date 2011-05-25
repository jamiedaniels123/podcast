<?php
class ItunesuCategory extends AppModel {

    var $name = 'ItunesuCategory';
    var $useTable = 'itunesu_categories';
    var $validate = array();

    var $hasAndBelongsToMany = array(

        'Podcasts' => array(
            'className' => 'Podcast',
            'joinTable' => 'podcasts_itunesu_categories',
            'foreignKey' => 'itunesu_category_id',
            'associationForeignKey' => 'podcast_id',
            'unique' => true
        )
    );
}
?>
