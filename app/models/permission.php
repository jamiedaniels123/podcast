<?php
class Permission extends AppModel {

    var $name = 'Permission';
    
    var $validate = array(

        'title' => array(
            'Rule1' => array(
                'rule' => 'isUnique',
                'allowEmpty' => false,
                'message' => 'There is already a permissions with the same description.'
            )
        )
    );

    var $hasAndBelongsToMany = array(

        'Permissions' => array(
            'className' => 'Permission',
            'joinTable' => 'permission_groups_permissions',
            'foreignKey' => 'user_group_id',
            'associationForeignKey' => 'permission_id',
            'unique' => true
        )
    );

}
?>
