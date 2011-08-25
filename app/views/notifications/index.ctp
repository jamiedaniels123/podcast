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
            </tr>
        </thead>
        <?php foreach( $this->data['Notifications'] as $notification ) : ?>
            <tr>
                <td></td>
                <td><?php echo $notification['Notification']['title']; ?></td>
                <td><?php echo $notification['Notification']['type']; ?></td>
            </tr>
        <?php endforeach; ?>
	</table>
</fieldset>