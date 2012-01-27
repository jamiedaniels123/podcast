<h2>Request for Youtube Consideration</h2>
<p>
	<?php echo $user['full_name']; ?> has submitted the following <?php echo COLLECTION; ?> for consideration.
</p>

<h3><?php echo ucfirst( $data['Podcast']['title'] ); ?></h3>
<p>
    <i><?php echo nl2br( $data['Podcast']['summary'] ); ?></i>
</p>    
<a href="<?php echo APPLICATION_URL ?>/podcasts/edit/<?php echo $data['Podcast']['id']; ?>/youtube" title="link to <?php echo COLLECTION; ?>">
click here to view <?php echo COLLECTION; ?></a>
<hr />

<p>
	Please contact the user for any further information and too let them know of your decision. You can respond to this email directly.
</p>

