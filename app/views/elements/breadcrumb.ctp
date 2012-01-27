<ul id="breadcrumb">

    <?php $x = 0; foreach( $breadcrumbs as $breadcrumb ) : ?>

        <?php $x++; if( $x == count( $breadcrumbs ) ) : ?>
        
        	<li>
    	        <!--&rarr; -->
	            <a href="/<?php echo $this->params['url']['url']; ?>" title="<?php echo $breadcrumb['Breadcrumb']['title']; ?>">
        	        <?php echo $breadcrumb['Breadcrumb']['title']; ?>
            	</a>
            </li>
            
        <?php else : ?>

            <li>
               <!--&rarr; -->
               
               <?php if( empty( $breadcrumb['Breadcrumb']['url'] ) ) : ?>
	               <a href="<?php echo '/'.$breadcrumb['Breadcrumb']['controller'].'/'.$breadcrumb['Breadcrumb']['action']; ?>" title="<?php echo $breadcrumb['Breadcrumb']['title']; ?>">
	                   <?php echo $breadcrumb['Breadcrumb']['title']; ?>
	               </a>
               <?php else : ?>
	               <a href="<?php echo $breadcrumb['Breadcrumb']['url']; ?>" title="<?php echo $breadcrumb['Breadcrumb']['title']; ?>">
	                   <?php echo $breadcrumb['Breadcrumb']['title']; ?>
	               </a>
               <?php endif; ?>
            </li>
            
            
        <?php endif; ?>
        
    <?php endforeach; ?>
   
</ul>
