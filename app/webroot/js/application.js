jQuery(document).ready(function($) {

	// Creates the animated 'flash' that occurs when displaying a success message (green banner)
	if( jQuery('#flashMessage.success').length ) {
		jQuery('#flashMessage.success').effect('highlight', { color: '#00c500' }, 2000 );
	}

	// Creates the animated 'flash' that occurs when displaying an error message (red banner)
	if( jQuery('#flashMessage.error .error_message').length ) {
		jQuery('#flashMessage.error .error_message').effect('highlight', { color: '#ff0000' }, 2000 );
	}
	
	// The following optional method is called on page load and sets the initial status if the DOM element
    // actually exist. It shows/hides podcast specific elements.
    if( jQuery('#PodcastSyndicated').length > 0 ) {

    	var is_podcast = jQuery('#PodcastPodcastFlag').val();
    	
        show_hide_podcast_elements( is_podcast );

        jQuery('#PodcastFlagLink').live('click',function(e) {
        	
			e.preventDefault();
        	var is_podcast = jQuery('#PodcastPodcastFlag').val();

        	if( is_podcast == 1 ) {
        		
        		jQuery('#PodcastPodcastFlag').val(0);
        		show_hide_podcast_elements( 0 );
        		
        	} else {

        		jQuery('#PodcastPodcastFlag').val(1);
        		show_hide_podcast_elements( 1 );
        	}
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

		var checkboxes = jQuery(this).parents('form:first').find("input[type=checkbox]");
		
		if( checkboxes.filter(':checked').length ) {

			jQuery(this).parents('form:first').attr('action',action);
			if( confirm('Are you sure?') ) {
				var action = jQuery(this).attr('href');
				jQuery(this).parents('form:first').attr('action',action);
				jQuery(this).closest("form").submit();
			}
			
		} else {
			
			alert('You must select at least one object using the checkboxes provided');			
		}
    });

	// Will show or hide a DOM element when a link is clicked.  Probably been better named "toggle"
	// but heyhoo.
    jQuery('.juggle').click( function(e) {
		
		e.preventDefault();
		var target = jQuery(this).attr('data-target');
		jQuery('#'+target).toggle('slow');
	});
	

    // The following 3 methods display a default value in an empty input field and empty/populate using the
    // blur and focus events for any element with a class of input_greeting.
    jQuery('.input_greeting').each( function(e) {
		
        var content = jQuery(this).val();
        if( content.length == 0 ) {
            var title = jQuery(this).attr('title');
            jQuery(this).text(title);
            jQuery(this).val(title);
        }
		
    })
    
	// For those DOM elements with a class of "input_greeting" this routine will
	// clear the input value if it matches the title attribute
    jQuery('.input_greeting').each( function(e) {

		jQuery(this).focus( function () {

			var title = jQuery(this).attr('title');
			var content = jQuery(this).val();

			if( content == title ) {
				jQuery(this).text('');
				jQuery(this).val('');
			}
		});
    });

	// For those DOM elements with a class of "input_greeting" and an empty value
	// this routine will populate with the value of the attribute field.
    jQuery('.input_greeting').each( function(e) {

		jQuery(this).blur( function () {
			var content = jQuery(this).val();	
			
			if( content.length == 0 ) {
				
				var title = jQuery(this).attr('title');
				jQuery(this).text(title);
				jQuery(this).val(title);
			}
		});
	});
    
	// This routine will hide/display the "personalise" element that enables peeps to 
	// dynamically pick which columns they wish to display on any podcast table.
    jQuery('.personalise').live('click',function(e) {

    	var target = jQuery(this).attr('data-target');
    	jQuery('th.'+target).toggle();
    	jQuery('td.'+target).toggle();
    	write_cookie('OpenUniversity');
	});
    
    // When a youtube user wishes to automatically generate a description
    // based on the information provided within the form.
    jQuery('#PodcastItemGenerateYoutubeDescription').live('click', function(e) {

		e.preventDefault();
    	var answer = confirm('You are about to automatically generate a description based on the values held in related form fields. Are you sure?');
    	if( answer ) {
				// Title needs X of Y
				var course_code = jQuery('#PodcastCourseCode').val();
				
    			text = 'Free learning from The Open University http://www.open.ac.uk/openlearn/';
				text += '\n\n---\n\n';
    			text += jQuery('#PodcastItemSummary').val();
    			text += '\n\n';
    			text += '(Part X of Y)';
    			text += '\n\n --- \n\n';
    			
    			if ( course_code.length ) {
					text += 'For more information about ';
					text += jQuery('#PodcastItemTitle').val(); // Should be the same as title
					text += ' visit http://www3.open.ac.uk/study/';
					
					//if first number equals 8 then it's a postgrad course 
					if( course_code.substring(0,1) == 8 ) {
						
						text += 'postgraduate/course/' + course_code +'.htm';
						
					} else {
						
						text += 'undergraduate/course/' + course_code +'.htm';
					}
				}
				
				if( jQuery('#PodcastItemYoutubeLink1').length ) {
					
					text += '\n\n---\n\n';
					text +=	jQuery('#PodcastItemYoutubeLink1Text').val();
					text += '\n';
					text +=	jQuery('#PodcastItemYoutubeLink1').val();
				}
				if( jQuery('#PodcastItemYoutubeLink2').length ) {
					
					text += '\n\n---\n\n';
					text +=	jQuery('#PodcastItemYoutubeLink2Text').val();
					text += '\n';
					text +=	jQuery('#PodcastItemYoutubeLink2').val();
				}
				if( jQuery('#PodcastItemYoutubeLink3').length ) {
					
					text += '\n\n---\n\n';
					text +=	jQuery('#PodcastItemYoutubeLink3Text').val();
					text += '\n';
					text +=	jQuery('#PodcastItemYoutubeLink3').val();
				}
				
		    	jQuery('#PodcastItemYoutubeDescription').val(text);
    	}
    });
	
	// Filechucker 
	// This routine will make an ajax call to determine if the current user is an 
	// iTunes user. If they are not an itunes user it will hide various filechucker form elements.
	// The routine it calls is within the app_controller.
	if( jQuery('.formfield_03').length > 0 ) {


		jQuery.ajax(
		{
			type: "GET",
			url: "/users/itunesuser",
			success:
				function( responseData ) {

					// If false hide various element
					if( responseData == false ) {
						
						jQuery('.formfield_03').hide();
					}
				}
		});		
	}
	
	if( jQuery('#PodcastWizard').length > 0 ) {
		
		jQuery('#PodcastWizard').live('click',function (e) {
			
			e.preventDefault();
			jQuery('#modal').dialog({ width: 500, autoOpen: false, modal: true });
			jQuery('#modal').dialog('open');
		});
	}
	
	
	jQuery('.jquery_display').live('click',function(e) {
		
		e.preventDefault();
		var source = jQuery(this).attr('data-source');
		var target = jQuery(this).attr('data-target');
		jQuery('#'+source).slideUp();
		jQuery('#'+target).slideDown();
		jQuery('#PodcastUpdateButtonContainer').show();
	});
	
	
	// Controls the display of the tabbed menu, setting the active tab and showing all relevant divs.
	//jQuery() {
	//}

});

// Makes an ajax call to a method in the app_controller
// that will write a cookie to the workstation based on the
// checkboxes that have been ticked in the form.
function write_cookie( cookie_name ) {
	
    var form_data = $("#PersonaliseForm").serialize();

    jQuery.ajax(
    {
        type: "POST",
        url: "/podcasts/cookie",
        data: form_data,
        error:
            function()
            {
                    alert('unable to set cookie');
            }
    });
}

// Will show or hide the podcast container div depending
// upon the status of the checkbox. Called on page load and when the
// user clicks the checkbox.
function show_hide_podcast_elements( is_podcast ) {

    if( is_podcast == 1 ) {

        jQuery('#PodcastSyndicationContainer').show('slow');

    } else {

        jQuery('#PodcastSyndicationContainer').hide('slow');
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

// DEPRECIATED - TO BE DELETED WHEN 1111% CERTAIN  ( July 2011 - Charles Jackson )

// Will show or hide the itunes container divs depending
// upon the status of the checkbox. Called on page load and when the
// user clicks the checkbox.
// NOTE: We have to check to see if the iTunes element actually exists on the page. It is possible
// for a podcast to have iTune settings but the user does not have iTunes permissions.
/*function show_hide_itune_elements() {

    if( jQuery('#PodcastConsiderForItunesu').is(':checked') ) {

        jQuery('.itunes_container').show('slow');

    } else {

        jQuery('.itunes_container').hide('slow');
    }
}*/

// Will show or hide the youtube container divs depending
// upon the status of the checkbox. Called on page load and when the
// user clicks the checkbox.
// NOTE: We have to check to see if the Youtube element actually exists on the page. It is possible
// for a podcast to have Youtube settings but the user does not have Youtube permissions.
/*function show_hide_youtube_elements() {

    if( jQuery('#PodcastConsiderForYoutube').is(':checked') ) {

        jQuery('.youtube_container').show('slow');

    } else {

        jQuery('.youtube_container').hide('slow');
    }
}*/
