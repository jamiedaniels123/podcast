<fieldset class="podcast_items index">
    <legend><?php echo $this->data['Podcast']['title']; ?> Podcast Media</legend>
    <p>
        Use this form to add and manage media for a podcast. We recommend that you avoid using a PDF document as the most recent
        (top of the list) item in a podcast.
    </p>
    <p>
        <em>EMBED :</em> Individual tracks can now be embeded into other web pages via HTML snipets. To access this snipet click on
        the icon in the Media filename column and from the resulting popup window there is a button called 'EMBED OPTIONS' to access
        the embed interface.
    </p>
    <p>
        The 'embed' interface will be improved and better intergrated into the admin. At present this option is only available to administrators
        of podcasts. Embeding tracks from Podcasts restricted to the OU (SAMS only) will only work on OU sites and when a user has logged in.
    </p>
    <?php echo $this->element('../podcast_items/_index'); ?>
    <?php echo $this->element('../podcast_items/_add'); ?>
</fieldset>
