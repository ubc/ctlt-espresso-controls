<?php

class CTLT_Espresso_Saving extends CTLT_Espresso_Metaboxes {
	
	static $meta_data = array(null);
	static $file_upload = null;

	static public function init( $event_id ) {
		//self::upload_file();
		self::assigning();
		self::insert_to_db( $event_id );
	}

	static public function upload_file() {

		if( !empty( $_FILES[CTLT_Espresso_Handouts::$handout_file['id']]['name'] ) ) {
			// setup the array of supported file types
			$supported_types = array( 'application/pdf' );

			// get the file type of the upload
			$arr_file_type = wp_check_filetype( basename( $_FILES[CTLT_Espresso_Handouts::$handout_file['id']]['name'] ) );
			$uploaded_type = $arr_file_type['type'];

			// check if the type is supported. if not, throw an error
			if( in_array( $uploaded_type, $supported_types ) ) {

				// use the WordPress API to upload the file
				$upload = wp_upload_bits( $_FILES[CTLT_Espresso_Handouts::$handout_file['id']]['name'], null, file_get_contents( $_FILES[CTLT_Espresso_Handouts::$handout_file['id']]['tmp_name'] ) );

				if( isset( $upload['error'] ) && $upload['error'] != 0 ) {
					wp_die( 'There was an error uploading your file. The error is: ' . $upload['error'] );
				}
				self::$file_upload = $upload;
			}
			else {
				wp_die( "the file type that you have uploaded is not a PDF." );
			}
		}

	}

	static public function assigning() {
		self::$meta_data = array(
			CTLT_Espresso_Handouts::$radios_arr['id'] => !empty( $_POST[CTLT_Espresso_Handouts::$radios_arr['id']] ) ? $_POST[CTLT_Espresso_Handouts::$radios_arr['id']] : 'N/A',
			CTLT_Espresso_Handouts::$handout_file['id'] => !empty( $_FILES[CTLT_Espresso_Handouts::$handout_file['id']]['name'] ) ? self::$file_upload : '',
			CTLT_Espresso_Room_Setup::$rooms['id'] => !empty( $_POST[CTLT_Espresso_Room_Setup::$rooms['id']] ) ? $_POST[CTLT_Espresso_Room_Setup::$rooms['id']] : '',
		);

		foreach( CTLT_Espresso_Additional_Information::$add_info['options'] as $option ) {
			self::$meta_data[$option['id']] = isset( $_POST[$option['id']] ) ? strip_tags( $_POST[$option['id']] ) : '';
		}

		foreach( CTLT_Espresso_Additional_Information::$checks['options'] as $option ) {
			self::$meta_data[$option['id']] = isset( $_POST[$option['id']] ) && $_POST[$option['id']] ? 'yes' : 'no';
		}

		foreach( CTLT_Espresso_Costs::$costs_arr['options'] as $option ) {
			$_POST[$option['id']] = empty( $_POST[$option['id']] ) ? 0 : $_POST[$option['id']];
			if( isset( $_POST[$option['id']] ) ) {
				self::$meta_data[$option['id']] = is_numeric( $_POST[$option['id']] ) && $_POST[$option['id']] >= 0 ? strip_tags( $_POST[$option['id']] ) : 0;
			}
		}
	}

	static public function insert_to_db( $event_id ) {
		// $meta_data contains all the information that we wish to save to the db
		// event_id = int; meta_key = varchar(255); meta_value = longtext; date_added = datetime
		global $wpdb;

		$date = date( "Y-m-d H:i:s" );

		foreach( self::$meta_data as $key => $value ) {
			$sql = "INSERT INTO " . CTLT_ESPRESSO_EVENTS_META . " (event_id, meta_key, meta_value, date_added) 
			VALUES ('" . $event_id . "', '" . $key . "', '" . $value . "', '" . $date . "')";

			if( !$wpdb->query( $wpdb->prepare( $sql, null ) ) ) {
				// error goes here
			}
		}

	}

	static public function update_to_db() {

	}

	static public function get_from_db() {

	}
}


//$event_desc			= !empty($_REQUEST['event_desc']) ? $_REQUEST['event_desc'] : '';

//$add_attendee_question_groups = empty($_REQUEST['add_attendee_question_groups']) ? '' : $_REQUEST['add_attendee_question_groups'];
