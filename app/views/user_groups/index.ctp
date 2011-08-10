<fieldset class="user_groups index">
    <legend><h3>Your User Groups</h3></legend>
    
    <p class="leader">
        Below is a list of all user groups of which you are a member.
    </p>
    
    <img src="/img/your-usergroups-large.png" width="45" height="33" />
    
    <p>
        <?php
            echo $this->Paginator->counter(array(
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
            ));
        ?>
    </p>
    <form method="post" action="/user_groups/delete">
        <a href="/" class="toggler" data-status="unticked">Toggle</a>
        <button type="submit" onclick="return confirm('Are you sure you wish to delete all these usergroups?')"><span>delete</span></button>


        <table cellpadding="0" cellspacing="0">
        <tr>
            <th>Select</th>
            <th><?php echo $this->Paginator->sort('Title', 'UserGroup.group_title');?></th>
            <th><?php echo $this->Paginator->sort('Created');?></th>
            <th class="actions"><?php __('Actions');?></th>
        </tr>
        <?php
        // Check to see if there is an incremental count on this->data, the ['Meta'] exists so just looking for integer count
        if( isSet( $this->data['UserGroups'] ) ) :
            $i = 0;
            foreach ($this->data['UserGroups'] as $user_group ) :

                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
    ?>
                <tr<?php echo $class;?>>
                    <td>
                        <?php if( $this->Permission->isModerator( $user_group['Moderators'] ) ) : ?>
                        <input type="checkbox" name="data[UserGroup][Checkbox][<?php echo $user_group['UserGroup']['id']; ?>]" class="usergroup_selection" id="UserGroupCheckbox<?php echo $user_group['UserGroup']['id']; ?>">
                        <?php else : ?>
                            Not Available
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $user_group['UserGroup']['group_title']; ?>
                    </td>
                    <td>
                        <?php echo $user_group['UserGroup']['created'] ? $this->Time->getPrettyShortDate( $user_group['UserGroup']['created'] ) : $this->Time->getPrettyShortDate( $user_group['UserGroup']['created_when'] ); ?>
                    </td>
                    <td class="actions">

                        <a href="/user_groups/view/<?php echo $user_group['UserGroup']['id']; ?>" title="view user group" id="view_user_group_<?php echo $user_group['UserGroup']['id']; ?>" class="view_user_group">view</a>
                        <?php if( $this->Permission->isModerator( $user_group['Moderators'] ) ) : ?>
                            <a href="/user_groups/edit/<?php echo $user_group['UserGroup']['id']; ?>" title="edit user group" id="edit_user_group_<?php echo $user_group['UserGroup']['id']; ?>" class="edit_user_group">moderate</a>
                            <a href="/user_groups/delete/<?php echo $user_group['UserGroup']['id']; ?>" title="delete user group" id="delete_user_group_<?php echo $user_group['UserGroup']['id']; ?>" class="delete_user_group" onclick="return confirm('Are you sure you wish to delete this user group?');">delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
            endforeach;
        endif; ?>
    </table>
    </form>
    <div class="paging">
        <?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
     | 	<?php echo $this->Paginator->numbers();?>
        <?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
    </div>
</fieldset>