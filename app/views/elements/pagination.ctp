<div class="paging">

 <p>
 
 <div class="page-controls">
   	<?php echo $this->Paginator->prev(''.__('previous', true), array(), null, array('class'=>'disabled previous'));?>
 | 	<?php echo $this->Paginator->numbers();?>
    <?php echo $this->Paginator->next(__('next', true).'', array(), null, array('class'=>'disabled next'));?>
</div>    
    
    
    <?php
        echo $this->Paginator->counter(array(
        'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
        ));
    ?>

</p>    
   
</div>	
