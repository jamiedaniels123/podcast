<?php if( is_array( @$errors ) && count( @$errors )) : ?>
    <div id="errors">
        <ul>
            <?php foreach($errors as $error) : ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>