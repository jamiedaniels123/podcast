<fieldset class="users index">
    <legend>All Users</legend>
    <p>
        Below is a list of all users on the system.
    </p>
    <?php echo $this->element('../users/_filter'); ?>
    <p>
        <?php
            echo $this->Paginator->counter(array(
            'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
            ));
        ?>
    </p>
    <table cellpadding="0" cellspacing="0">
    <tr>
	<th><?php echo $this->Paginator->sort('name', 'User.lastname');?></th>
        <th><?php echo $this->Paginator->sort('Last Seen','User.last_login');?></th>
        <th><?php echo $this->Paginator->sort('Active','User.status');?></th>
	<th class="actions"><?php __('Actions');?></th>
    </tr>
    <?php
    if( isSet( $this->data['Users'] ) ) :
	$i = 0;
	foreach ($this->data['Users'] as $user ) :

            $class = null;
            if ($i++ % 2 == 0) :
                $class = ' class="altrow"';
            endif;
?>
            <tr<?php echo $class;?>>
                <td>
                    <?php echo $user['User']['lastname']; ?>, <?php echo $user['User']['firstname']; ?>
                </td>
                <td>
                    <?php echo $this->Time->getPrettyLongDate( $user['User']['last_login'] ); ?>.
                </td>
                <td>
                    <?php echo $user['User']['status'] ? 'Yes' : 'No'; ?>
                 </td>
                <td class="actions">
                    <a href="/admin/users/edit/<?php echo $user['User']['id']; ?>" id="edit_user_<?php echo $user['User']['id']; ?>">edit</a>
                    <a href="/admin/users/status/<?php echo $user['User']['id']; ?>" id="deactivate_user_<?php echo $user['User']['id']; ?>" onclick="return confirm('Are you sure?');"><?php echo $user['User']['status'] ? 'deactivate' : 'activate'; ?></a>
                </td>
            </tr>
<?php
	endforeach;
endif; ?>
</table>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
</fieldset>
