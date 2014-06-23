// Simulates clicks on all Event Espresso event editing postboxes to minimize them
jQuery(document).ready( function() {

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
    
} );