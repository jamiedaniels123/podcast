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