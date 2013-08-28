// http://mikejolley.com/2012/12/using-the-new-wordpress-3-5-media-uploader-in-plugins
// https://github.com/ubc/session-stream/blob/master/module/slideshow/admin-slideshow.js

var CTLT_Espresso_File_Upload = {

	frame_output: null,
	attachment_target: null,

	onReady: function() {
		jQuery( '.ctlt-espresso-upload-button' ).on( 'click', CTLT_Espresso_File_Upload.fileUpload );
	},

	fileUpload: function( event ) {
		event.preventDefault();

		CTLT_Espresso_File_Upload.frame_output = jQuery(this).siblings('.ctlt-espresso-upload');
		CTLT_Espresso_File_Upload.attachment_target = jQuery(this).siblings('.ctlt-espresso-target-attachment-id');

		// create that frame, if you're so great (i mean when it isn't already created)
		if( !wp.media.frames.ctlt_frame ) {
			// create the frame here
			var frame = wp.media( {
				title: "Choose a file",
				button: { text: "Upload" },
				//library: { type: ['image', 'pdf'] },
				multiple: false, // set to true to allow multiple files to be selected
			} );

			// Select file -> run callback
			frame.on( 'select', function() {
				// We set multiple to false so only get one image from the uploader
				attachment = frame.state().get('selection').first().toJSON();

				// Do something with attachment.id and/or attachment.uri here
				CTLT_Espresso_File_Upload.frame_output.val(attachment.url);
				CTLT_Espresso_File_Upload.attachment_target.val(attachment.id);				

			} );

			// assign here
			wp.media.frames.ctlt_frame = frame;
		}

		// Finally, open the modal
		wp.media.frames.ctlt_frame.open();
	}
}

jQuery(document).ready( CTLT_Espresso_File_Upload.onReady );