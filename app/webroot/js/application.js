jQuery(document).ready(function($) {

    // The following optional method is called on page load and sets the initial status if the DOM element
    // actually exist. It shows/hides podcast specific elements.
    if( jQuery('#PodcastPodcastFlag').length ) {

        show_hide_podcast_elements();

        jQuery('#PodcastPodcastFlag').live('click',function(e) {

            show_hide_podcast_elements();
        });
    }

    // The following optional method is called on page load and sets the initial status if the DOM element
    // actually exist. It shows/hides podcast specific elements.
    if( jQuery('#PodcastConsiderForItunesu').length ) {

        show_hide_itune_elements();

        jQuery('#PodcastConsiderForItunesu').live('click',function(e) {

            show_hide_itune_elements();
        });
    }

    // These methods are called on every page when a user wishes to inspect
    // the menu options.
    jQuery('.datepicker').datepicker({ dateFormat: 'yy-mm-dd' });

    // The following two events control the multiple select boxes where you can move rows between them.
    jQuery('.move').click( function() {

        var source = jQuery(this).attr('data-source');
        var target = jQuery(this).attr('data-target');

        jQuery("#"+source+" option:selected").each(function()
        {

            jQuery("#"+target).append('<option value="'+this.value+'">'+this.innerHTML+'</option>');
            jQuery(this).remove();
        });
    });

    // When a user submits a form that contains multiple select boxes as described above this routine
    // will capture the choices before the form is actually submitted.
    jQuery('.auto_select_and_submit').click( function(e) {
        
        e.preventDefault();

        var form = jQuery(this).parents('form:first');
        var form_id = form.attr('id');

        jQuery(this).parents('form:first').find(':input.selected').each(function( index ) {

            jQuery(this).find('option').each(function(i) {
                jQuery(this).attr('selected','selected');
            });


        });

        jQuery("#"+form_id).submit();
    });

    // This method shows/hides the iTune elements of the podcast form.
    jQuery('a.itunes').live('click', function(e) {

        e.preventDefault();
        jQuery('div.itunes').toggle('slow');
        return false;
    });

    // Will toggle the notification checkboxes from ticked to unticked
    jQuery('.toggler').click( function(e) {

        e.preventDefault();
        var status = jQuery(this).attr('data-status');
        if( status == 'ticked' ) {

            unTickCheckboxes();
            jQuery(this).attr('data-status', 'unticked');

        } else {

            tickCheckboxes();
            jQuery(this).attr('data-status', 'ticked');
        }
    });

    // This method will set the action of the form used when selecting multiple
    // checkboxes and submitting one of the options such as 'delete' or 'generate rss'.
    jQuery('.multiple_action_button').click( function(e) {

        e.preventDefault();

        if( confirm('Are you sure?') ) {
            var action = jQuery(this).attr('data-form_target');
            jQuery(this).parents('form:first').attr('action',action);
            jQuery(this).closest("form").submit();
        }
    });
});

// Will show or hide the podcast container div depending
// upon the status of the checkbox. Called on page load and when the
// user clicks the checkbox.
function show_hide_podcast_elements() {

    if( jQuery('#PodcastPodcastFlag').is(':checked') ) {

        jQuery('.podcast_container').show('slow');

    } else {

        jQuery('.podcast_container').hide('slow');
    }
}

// Will show or hide the itunes container divs depending
// upon the status of the checkbox. Called on page load and when the
// user clicks the checkbox.
// NOTE: We have to check to see if the iTunes element actually exists on the page. It is possible
// for a podcast to have iTune settings but the user does not have iTunes permissions.
function show_hide_itune_elements() {

    if( jQuery('#PodcastConsiderForItunesu').is(':checked') ) {

        jQuery('.itunes_container').show('slow');

    } else {

        jQuery('.itunes_container').hide('slow');
    }
}

// Will tick all the checkboxes on the dashboard, at time of publication the only
// checkboxes are those associated with the podcast listing.
function tickCheckboxes() {

    jQuery('input[type="checkbox"]').each(function(index) {

        jQuery(this).attr('checked',true);

    });

}

// Will untick all the checkboxes on the dashboard, at time of publication the only
// checkboxes are those associated with the podcast listing.
function unTickCheckboxes() {

    jQuery('input[type="checkbox"]').each(function(index) {

        jQuery(this).attr('checked',false);

    });
}
