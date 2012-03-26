<fieldset class="logs index">
   <legend>Admin API</legend>
    <div class="clear"></div>
    <p>
        Below is a list of entries on the api_log table. The most recent commands are listed first.
    </p>
    <div class="clear"></div>
    <table>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('#','id');?></th>
                <th><?php echo $this->Paginator->sort('Command','message');?></th>                
                <th><?php echo $this->Paginator->sort('Destination','destination');?></th>                                    
                <th><?php echo $this->Paginator->sort('Created','created');?></th>                                    
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <?php foreach( $this->data['Logs'] as $log ) : ?>
            <tbody>    
                <tr>
                    <td><?php echo $log['Log']['id']; ?></td>
                    <td><?php echo substr( $log['Log']['message'],0,strpos( $log['Log']['message'], ',' ) ); ?></td>
                    <td><?php echo $log['Log']['dest']; ?></td>                        
                    <td><?php echo $this->Time->getPrettyLongDateTime( $log['Log']['timestamp'] ); ?></td>
                    <td class="actions">
                    	<a href="/admin/logs/view/<?php echo $log['Log']['id']; ?>" title="view log">view</a></td>
                    </td>
                </tr>    
            </tbody>
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