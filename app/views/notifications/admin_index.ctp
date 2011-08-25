<fieldset class="notifications index">
    <legend><h3>Notifications</h3></legend>
    
    <div class="clear"></div>
    <form method="post" action="">
        <table>
            <thead>
                <tr>
                    <th class="checkbox">Select</th>
                    <th class="type"><?php echo $this->Paginator->sort('Type','type');?></th>
                    <th class="title"><?php echo $this->Paginator->sort('Subject','title');?></th>
                    <th class="created"><?php echo $this->Paginator->sort('Created','created');?></th>                
                </tr>
            </thead>
            <?php foreach( $this->data['Notifications'] as $notification ) : ?>
                <tr>
                    <td class="checkbox">
                        <input type="checkbox" name="data[Notification][Checkbox][<?php echo $notification['Notification']['id']; ?>]" class="notification_selection" id="NotificationCheckbox<?php echo $notification['Notification']['id']; ?>">
                    </td>
                    <td><?php echo $notification['Notification']['type']; ?></td>
                    <td><?php echo $notification['Notification']['title']; ?></td>
                    <td><?php echo $this->Time->getPrettyLongDateTime( $notification['Notification']['created'] ); ?></td>                
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="left">
            <a href="/" class="toggler button setting" data-status="unticked">Select/Unselect all</a>
            <a class="button delete multiple_action_button" type="button" href="/admin/notifications/delete" id="delete_multiple_podcasts">Delete</a>
        </div>  
	</form>
        
</fieldset>