<h2>New Registration</h2>
<p>
	The following user has registered with the podcast server.
</p>
<table>
    <tr>
        <td>
            NAME :
        </td>
        <td>
            <?php echo $data['User']['firstname']; ?> <?php echo $data['User']['lastname']; ?>
        </td>
    </tr>
    <tr>
        <td>
            OUCU :
        </td>
        <td>
            <?php echo $data['User']['oucu']; ?>
        </td>
    </tr>
    <tr>
        <td>
            CONTACT EMAIL :
        </td>
        <td>
            <?php echo $data['User']['email']; ?>
        </td>
    </tr>
    <tr>
        <td>
            REASON :
        </td>
        <td>
            <?php echo nl2br( $data['User']['justification'] ); ?>
        </td>
    </tr>

</table>


