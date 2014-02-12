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
    if( create_post_option != null ) {
        create_post_option.value = "Y";
    }
    
} );