<fieldset class="notifications index">
    <legend><h3>Your notifications</h3></legend>
    
    <p class="leader">
    	Below is a list of notifications for yout attention. Unread notifications are highlighted in red.
    </p>
    
    <div class="clear"></div>
    <table>
        <thead>
            <tr>
	            <th class="checkbox">Select</th>
                <th class="title"><?php echo $this->Paginator->sort('Subject','title');?></th>
                <th class="type"><?php echo $this->Paginator->sort('Type','type');?></th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <?php foreach( $this->data['Notifications'] as $notification ) : ?>
            <tr>
                <td></td>
                <td><?php echo $notification['Notification']['title']; ?></td>
                <td><?php echo $notification['Notification']['type']; ?></td>
                <td><?php echo $this->Time->prettyLongDateTime( $notification['Notification']['created'] ); ?></td>
                <td class="actions">
                    <a class="button rss" href="/notifications/view/<?php echo $notification['Notification']['id']; ?>">View</a>
                    <a class="button rss" href="/notifications/delete/<?php echo $notification['Notification']['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
	</table>
</fieldset>