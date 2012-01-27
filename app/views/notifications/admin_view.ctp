<fieldset id="notification">
    <legend><?php echo $this->data['User']['full_name'].' : '.$this->data['Notification']['title'];?></legend>
    <div class="clear"></div>
	<div>
    	<?php echo nl2br( $this->data['Notification']['message'] ); ?>
    </div>
    <div id="created">
	    <?php echo $this->Time->getPrettyLongDateTime( $this->data['Notification']['created'] ); ?>
    </div>
    <div class="actions">
    	<a href="/admin/notifications/delete/<?php echo $this->data['Notification']['id']; ?>" title="delete this notification" class="button delete" onclick="return confirm('Are you sure you want to delete this notification');">Delete</div>
    </div>
</fieldset>