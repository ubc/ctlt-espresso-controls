// Simulates clicks on all Event Espresso event editing postboxes to minimize them
jQuery(document).ready( function() {

    if( !jQuery( 'body' ).hasClass( 'event-espresso_page_events' ) ){
        return;
    }

    var postboxesToClose = new Array();

    postboxesToClose.push(document.getElementById( 'event-pricing' ));
    postboxesToClose.push(document.getElementById( 'event-handouts' ));
    postboxesToClose.push(document.getElementById( 'event-additional-information' ));
    postboxesToClose.push(document.getElementById( 'event-costs' ));
    postboxesToClose.push(document.getElementById( 'event-meta' ));
    postboxesToClose.push(document.getElementById( 'confirmation-email' ));
    postboxesToClose.push(document.getElementById( 'event-post' ));
    postboxesToClose.push(document.getElementById( 'featured-image-options' ));
    postboxesToClose.push(document.getElementById( 'member-options' ));
    postboxesToClose.push(document.getElementById( 'event-discounts' ));
    postboxesToClose.push(document.getElementById( 'event-questions' ));
    postboxesToClose.push(document.getElementById( 'event-questions-additional' ));
    postboxesToClose.push(document.getElementById( 'recurring_event_wrapper' ));
    
    // Sets all postboxes with the specified IDs to be closed by default
    if(postboxesToClose[0]) {
        for ( var i=0; i<postboxesToClose.length; i++ ){
            if(postboxesToClose[i]) {
                postboxesToClose[i].className = "postbox closed";
            }
        }
    }
    
    var create_post_option = document.getElementsByName('create_post');
    create_post_option = create_post_option[0];
    // Disabled until further notice - event posts created for draft events
    // if( create_post_option != null ) {
        // create_post_option.value = "Y";
    // }
    
    jQuery('#event-location').insertBefore('#event-pricing');
    jQuery('#add-register-times > legend').text("Registration Times");
    jQuery( 'label[for="add-reg-start"]' ).text( 'Registration Start Time (i.e. 9:00 AM)' );
    jQuery( 'label[for="registration_endT"]' ).text( 'Registration End Time (i.e. 5:30 PM)' );
    jQuery( 'label[for="add-start-time"]' ).text( 'Event Start Time (i.e. 10:30 AM)' );
    jQuery( 'label[for="add-end-time"]' ).text( 'Event Start Time (i.e. 4:45 PM)' );

    // Tidy up, make reg dates and reg times equal height
    var regDateHeight = jQuery( '#add-reg-dates' ).height();
    jQuery( '#add-register-times' ).css( 'height', regDateHeight );

    jQuery( '#event_reg_theme > h2' ).html( 'Event Overview <span class="title-note-square">&nbsp;</span><span class="title-note-text"> &nbsp; indicates recommended (but not required) fields.</span>' );
    
} );

(function($) {
    
    if( !$( 'body' ).hasClass( 'event-espresso_page_events' ) ){
        return;
    }

    if( !$( '#end_date' ).length ){
        return;
    }

    // Prevent the registration end date from being after when the event has finished
    $( '#end_date, #registration_end, #registration_start, #start_date' ).datepicker({

        onClose: function( selectedDate ){
            
            var eventEndInput               = jQuery( '#end_date' );
            var registrationEndInput        = jQuery( '#registration_end' );

            var eventEndDate                = eventEndInput[0].value;
            var registrationEndDate         = registrationEndInput[0].value;

            if( !eventEndDate || eventEndDate == '' || !registrationEndDate || registrationEndDate == '' ){
                return;
            }

            var dateObjectOfEventEnd        = new Date( eventEndDate );
            var dateObjectOfRegistrationEnd = new Date( registrationEndDate );

            if( dateObjectOfRegistrationEnd > dateObjectOfEventEnd ){
                eventEndInput.parent().addClass( 'error' );
                registrationEndInput.parent().addClass( 'error' );
            }else{
                eventEndInput.parent().removeClass( 'error' );
                registrationEndInput.parent().removeClass( 'error' );
            }

        }

    });

})(jQuery);