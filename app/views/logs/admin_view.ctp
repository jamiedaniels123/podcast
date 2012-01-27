<fieldset>
    <legend>#<?php echo $this->data['Log']['id'];?> ( <?php echo $this->Time->getPrettyLongDateTime( $this->data['Log']['timestamp'] ); ?> )</legend>
    
<div class="wrapper">

    <div class="clear"></div>
    <fieldset>
    	<legend>JSON Encoded</legend>
        <dl id="json">
            <dt>Command (JSON): </dt>
            <dd><?php echo $this->data['Log']['message']; ?>&nbsp;</dd>
            <dt>Reply (JSON): </dt>
            <dd><?php echo $this->data['Log']['reply']; ?>&nbsp;</dd>
            <dt>Result Data (JSON): </dt>
            <dd><?php echo $this->data['Log']['result_data']; ?>&nbsp;</dd>
            <dt>Debug (JSON): </dt>
            <dd><?php echo $this->data['Log']['debug']; ?>&nbsp;</dd>
            <dt>Destination: </dt>
            <dd><?php echo $this->data['Log']['dest']; ?>&nbsp;</dd>
        </dl>
    </fieldset>
	<fieldset>
    	<legend>JSON Decoded</legend>
        <dl id="json_decoded">
            <dt>Command : </dt>
            <dd><?php print_r ( json_decode( $this->data['Log']['message'], 1 ) ); ?>&nbsp;</dd>
            <dt>Reply : </dt>
            <dd><?php print_r ( json_decode( $this->data['Log']['reply'] ) ); ?>&nbsp;</dd>
            <dt>Result Data: </dt>
            <dd><?php print_r ( json_decode( $this->data['Log']['result_data'] ) ); ?>&nbsp;</dd>
            <dt>Debug : </dt>
            <dd><?php print_r ( json_decode(  $this->data['Log']['debug'] ) ); ?>&nbsp;</dd>
            <dt>Destination: </dt>
            <dd><?php echo $this->data['Log']['dest']; ?>&nbsp;</dd>
        </dl>
    </fieldset>

</div>
</fieldset>