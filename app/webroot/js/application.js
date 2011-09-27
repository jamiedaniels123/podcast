jQuery(document).ready(function($) {

	// Disbale caching of any ajax calls.
	jQuery.ajaxSetup({
		
		cache: false
	});

	if( jQuery('#PodcastSearch').length ) {
		
		jQuery('#PodcastSearch').val(' ');
		jQuery('#PodcastSearch').focus();
	}
 
	// Creates the animated 'flash' that occurs when displaying a success message (green banner)
	if( jQuery('#flashMessage.success').length ) {
		jQuery('#flashMessage.success').effect('highlight', { color: '#00c500' }, 2000 );
	}

	// Creates the animated 'flash' that occurs when displaying an error message (red banner)
	if( jQuery('#flashMessage.error .error_message').length ) {
		jQuery('#flashMessage.error .error_message').effect('highlight', { color: '#ff0000' }, 2000 );
	}


	// This is a fix for internet explorer. 
	// If the user is viewing a tabbed page this will remove the background image from the
	// currently active tab. In all other browsers this is taken care of by CSS.
	// Bl**dy silly IE.
	if ( jQuery('#tab-zone').length > 0 ) { 

		var element = jQuery('#PodcastElement').val();
		if ( jQuery('#' + element ).length > 0 ) { 

			jQuery( '#' + element ).find('a:first').removeClass('tab_link');

			//alert( jQuery( '#' + element + ':first-child' ).attr('href') );
		}
	};
	
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
    jQuery('.move').live('click', function() {

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
    jQuery('.auto_select_and_submit').live('click', function(e) {
        
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

    // When a user submits a form that contains multiple select boxes as described above this routine
    // will capture the choices before the form is actually submitted.
    jQuery('.auto_select').live('click', function(e) {
        
        e.preventDefault();

        var form = jQuery(this).parents('form:first');
        var form_id = form.attr('id');

        jQuery(this).parents('form:first').find(':input.selected').each(function( index ) {

            jQuery(this).find('option').each(function(i) {
                jQuery(this).attr('selected','selected');
            });


        });
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
	
	// Enables peeps to jump from the preview to the input screen of any tabbed menu	
	jQuery('.jquery_display').live('click',function(e) {
		
		e.preventDefault();
		var source = jQuery(this).attr('data-source');
		var target = jQuery(this).attr('data-target');
		jQuery('#'+source).slideUp('fast');
		jQuery(this).parents('.action_buttons').hide();
		jQuery('#'+target).slideDown('fast');
		jQuery('#PodcastUpdateButtonContainer').show();
	});

	// Open the modal and makes an ajax call when peeps wish to view/edit a podcast item
	jQuery('.podcast_item_update').live('click',function(e) {

		e.preventDefault();
		var id = jQuery(this).attr('data-id');
		var podcast_item_title = jQuery(this).html();
		jQuery('#modal').dialog({ width: 1000, autoOpen: false, modal: true, title : podcast_item_title });
		jQuery('#modal').dialog('open');
		jQuery('.ui-widget-overlay').click(function() { $("#modal").dialog("close"); });
		getPodcastItem( id, 'summary' ); // specify the podcast_item ID and the element we wish to display onload.
	});

	// Changes the active tab when clicked at podcast_item ( track ) level.
	jQuery('.tab_link').live('click',function(e) {
		
		if( jQuery('#PodcastUpdateButton').is(":visible") ) {

			if( confirm('You will lose any unsaved changes. Are you sure you wish to continue?') ) {
				
				return true;
			}
			
			e.preventDefault(); // Stop the link from loading			
		}
			
	});
	
	// Changes the active tab when clicked at podcast_item ( track ) level.
	jQuery('.PodcastItemPreviewLink').live('click',function(e) {
		
		e.preventDefault(); // Stop the link from loading

		// Checxk to see if the user id on the input screen (as opposed to the preview screen) by checking
		// to see if the form button is visible. If true, prompt the user to save their changes before
		// continuing.
		if( jQuery('#PodcastItemSubmitButton').is(":visible") ) {
			
			if( confirm('You will lose any unsaved changes. Are you sure you wish to continue?') ) {
				
				var id = jQuery(this).parent('li').attr('data-id'); // Grab the podcast_item_id
				var element = jQuery(this).parent('li').attr('data-element'); // Grab the associated element
				
				getPodcastItem( id, element );				
			}
			
		// They are on the preview screen, therefore no changes to save. Carry-on as normal.
		} else {
		
			// Remove "active" class from existing tab
			jQuery( "li.active" ).each( function() {
				var hide = jQuery(this).attr('data-element'); // Grab the associated element
				jQuery('.'+hide).hide(); // hide the associated element
				jQuery(this).removeClass('active');	// remove the active class
			})
	
			jQuery('#flashMessage').hide(); // Hide flash messages associated to previous tab.
			jQuery('#flashMessage').hide(); // Hide errors associated to previous tab.
			
			jQuery(this).parent('li').addClass('active'); // Make current tab active by adding class
	
			var show = jQuery(this).parent('li').attr('data-element'); // Grab the associated element
			jQuery('.'+show).show(); // show the associated element		
			jQuery('#PodcastUpdateButtonContainer').hide(); // add the active class
		}
	});
	
	
	// When a user clicks the "Cancel" link it will submit an ajax request and retrieve details of the current
	// podcast_item refreshes all details held on screen.
	jQuery('.cancel').live('click', function(e) {
		
		e.preventDefault();
		if( confirm('Are you sure you wish to cancel all changes?') ) {
			
			var id = jQuery(this).attr('data-id');
			getPodcastItem( id, 'summary' );
		}
		
	});
	
	jQuery('.ajax_link').live('click', function(e) {
		
		e.preventDefault();
		if( confirm('Are you sure you wish to delete?') ) {
		
			var url = jQuery(this).attr('href');
			ajaxCall( url );
		}
		
	});
	
	// Enables a user to cancel any form input by reloading the page.
	jQuery('#PodcastCancelButton').click( function(e) {
		
		e.preventDefault();
		if( confirm('WARNING! You will lose all your changes.') ) {

			var url = window.location.pathname;
			window.location = url;
			
		}
		
		return false;
	});
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

// Will get details of the podcast item passed as a parameter and display in a modal. 
// Then binds the form to an ajax submit.
function getPodcastItem( id, element ) {

	
	jQuery.ajax(
	{
		type: "GET",
		url: "/podcast_items/edit/" + id + '/' + element,
		success:
			function( responseData ) {
				
				jQuery('#modal').html(responseData);
				
				// Bind the podcast_item form to an ajax query
				var options = {
					target: '#modal',
					replaceTarget: false
				};
				
				jQuery('#PodcastItemSubmitButton').live('click', function() { 

					jQuery('#PodcastItemEditForm').ajaxSubmit(options);		
				});
			},
		error:
			function( responseData ) {
				
				jQuery('#modal').html('It would appear you have been logged out');
			}
	});		
}


// Used to convert various links in an ajax solution so they don't reload the page when clicked from
// inside a modal
function ajaxCall( url ) {
	
	jQuery.ajax(
	{
		type: "GET",
		url: url,
		success:
			function( responseData ) {
				
				jQuery('#modal').html(responseData);
				
				// Bind the podcast_item form to an ajax query
				var options = {
					target: '#modal',
					replaceTarget: false
				};
				
				jQuery('#PodcastItemSubmitButton').live('click', function() { 

					jQuery(this).closest('form').ajaxSubmit(options);		
				});
			},
		error:
			function( responseData ) {
				
				jQuery('#modal').html('It would appear you have been logged out');
			}
	});		
}
	
