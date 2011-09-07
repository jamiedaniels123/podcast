<fieldset class="notifications index">
    <legend>Notifications</legend>
    <div class="clear"></div>
    <p>
    	Are created by the system to alert administrators when something unexpected has occurred. They do not always signal
        a problem, merely a scenario that may need investigating. Unread notifications are in <span class="unread">bold</span>.
    </p>    
    <div class="clear"></div>
    <form method="post" action="">
        <table>
            <thead>
                <tr>
                    <th class="checkbox">Select</th>
                    <th class="type"><?php echo $this->Paginator->sort('Type','type');?></th>
                    <th class="title"><?php echo $this->Paginator->sort('Subject','title');?></th>
                    <th class="created"><?php echo $this->Paginator->sort('Created','created');?></th>                
                    <th class="actions">Actions</th>
                </tr>
            </thead>
            <?php foreach( $this->data['Notifications'] as $notification ) : ?>
                <tr <?php echo $notification['Notification']['unread'] ? 'class="unread"' : '' ; ?>>
                    <td class="checkbox">
                        <input type="checkbox" name="data[Notification][Checkbox][<?php echo $notification['Notification']['id']; ?>]" class="notification_selection" id="NotificationCheckbox<?php echo $notification['Notification']['id']; ?>">
                    </td>
                    <td><?php echo $notification['Notification']['type']; ?></td>
                    <td><?php echo $notification['Notification']['title']; ?></td>
                    <td><?php echo $this->Time->getPrettyLongDateTime( $notification['Notification']['created'] ); ?></td>                
                    <td class="actions">
                    	<a href="/admin/notifications/view/<?php echo $notification['Notification']['id']; ?>" class="button edit" title="view details">view</a>
                    	<a href="/admin/notifications/delete/<?php echo $notification['Notification']['id']; ?>" class="button delete" title="view details" onclick="return confirm('Are you sure you wish to delete this notification');">delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="left">
            <a href="/" class="toggler button setting" data-status="unticked">Select/Unselect all</a>
            <a class="button delete multiple_action_button" type="button" href="/admin/notifications/delete" id="delete_multiple_podcasts">Delete</a>
        </div>  
        <div class="clear"></div>
	</form>
    <div class="clear"></div>
<div class="paging">

 <p>
    <?php
        echo $this->Paginator->counter(array(
        'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
    ?>
</p>    
   <div class="page-controls">
   	<?php echo $this->Paginator->prev(''.__('previous', true), array(), null, array('class'=>'disabled previous'));?>
 | 	<?php echo $this->Paginator->numbers();?>
    <?php echo $this->Paginator->next(__('next', true).'', array(), null, array('class'=>'disabled next'));?>
    </div>
</div>
        
</fieldset>