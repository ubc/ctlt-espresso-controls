<?php

class CTLT_Espresso_Saving extends CTLT_Espresso_Metaboxes {
	
	static $meta_data = array(null);
	static $file_upload = null;

	static public function insert( $event_id ) {
		self::upload_file();
		self::assigning();
		self::insert_to_db( $event_id );
	}

	static public function update( $event_id ) {
		self::upload_file();
		self::assigning();
		self::update_to_db( $event_id );
	}

	/**
	 * upload_file function
	 * This function will handle uploading handout files to the WordPress media library
	 */
	static private function upload_file() {

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

	/**
	 * assigning function
	 * This function will assign the values to be inserted into the db to an array
	 */
	static private function assigning() {
		self::$meta_data = array(
			CTLT_Espresso_Handouts::$radios_arr['id'] => !empty( $_POST[CTLT_Espresso_Handouts::$radios_arr['id']] ) ? $_POST[CTLT_Espresso_Handouts::$radios_arr['id']] : 'N/A',
			CTLT_Espresso_Handouts::$handout_file['id'] => !empty( $_FILES[CTLT_Espresso_Handouts::$handout_file['id']]['name'] ) ? self::$file_upload : '',
			CTLT_Espresso_Room_Setup::$rooms['id'] => !empty( $_POST[CTLT_Espresso_Room_Setup::$rooms['id']] ) ? $_POST[CTLT_Espresso_Room_Setup::$rooms['id']] : 'Open Space',
			CTLT_Espresso_Additional_Requirements::$computers['id'] => !empty( $_POST[CTLT_Espresso_Additional_Requirements::$computers['id']] ) ? $_POST[CTLT_Espresso_Additional_Requirements::$computers['id']] : 'None',
			CTLT_Espresso_Additional_Requirements::$cables['id'] => !empty( $_POST[CTLT_Espresso_Additional_Requirements::$cables['id']] ) ? $_POST[CTLT_Espresso_Additional_Requirements::$cables['id']] : 'None',
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

		foreach( CTLT_Espresso_Additional_Requirements::$equipment['options'] as $option ) {
			self::$meta_data[$option['id']] = isset( $_POST[$option['id']] ) && $_POST[$option['id']] ? 'yes' : 'no';
		}

		foreach( CTLT_Espresso_Additional_Requirements::$misc_computer_stuff['options'] as $option ) {
			self::$meta_data[$option['checkbox']['id']] = isset( $_POST[$option['checkbox']['id']] ) && $_POST[$option['checkbox']['id']] ? 'yes' : 'no';
			if( isset( $option['textbox']['id'] ) ) {
				for( $i = 0; $i < count( $option['textbox']['id'] ); $i++ ) {
					self::$meta_data[$option['textbox']['id'][$i]] = isset( $_POST[$option['textbox']['id'][$i]] ) ? $_POST[$option['textbox']['id'][$i]] : '';
				}
			}
		}
			
	//static $misc_computer_stuff = null;
	}

	/**
	 * insert_to_db function
	 * This function will take the event id as a parameter and insert data into the events_meta table
	 * @param int (event_id)
	 */
	static private function insert_to_db( $event_id ) {
		// $meta_data contains all the information that we wish to save to the db
		// event_id = int; meta_key = varchar(255); meta_value = longtext; date_added = datetime

		// verify the nonce
		/*if( !self::verify_nonce() )
			return;*/
		// check autosave
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;
		// check permissions
		// use capabilities here
		/*if( !current_user_can( 'edit_event' ) )
			return;*/

		global $wpdb;

		$date = date( "Y-m-d H:i:s", time() );

		foreach( self::$meta_data as $key => $value ) {
			$sql = "INSERT INTO " . CTLT_ESPRESSO_EVENTS_META . " (event_id, meta_key, meta_value, date_added) 
			VALUES(%d, %s, %s, %s);";
			// int, string, string, string

			if( !$wpdb->query( $wpdb->prepare( $sql, $event_id, $key, $value, $date ) ) ) {
				// error goes here
			}
		}

	}

	/**
	 * update_to_db function
	 * This function will take the event id as a paramter and update the data in the events_meta table
	 * @param int (event_id)
	 */
	static private function update_to_db( $event_id ) {
		// before doing the saving, verify the nonce, make sure autosave is not enabled
		// verify the nonce
		/*if( !self::verify_nonce() )
			return;*/
		// check autosave
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;
		// check permissions
		// use capabilities here
		/*if( !current_user_can( 'edit_event' ) )
			return;*/

		global $wpdb;

		foreach( self::$meta_data as $key => $value ) {
			$sql = "UPDATE " . CTLT_ESPRESSO_EVENTS_META . " SET meta_value='%s' WHERE event_id='%d' AND meta_key='%s';";

			if( !$wpdb->query( $wpdb->prepare( $sql, $value, $event_id, $key ) ) ) {
				// error goes here
			}
		}

	}

	/**
	 * get_from_db function
	 * This function grabs the data from the events meta table and returns an associative array
	 * where the key = value of meta_key column and it's value = value of meta_value column
	 * i.e. array( '_ctlt_espresso_handouts_radio' => 'Expected' ) will be a map in the array
	 * @param int (event_id)
	 * @return array
	 */
	static public function get_from_db( $event_id ) {
		global $wpdb;

		$sql = "SELECT meta_key, meta_value 
		FROM " . CTLT_ESPRESSO_EVENTS_META . " 
		WHERE event_id='" . $event_id . "';";  

		$results = $wpdb->get_results( $wpdb->prepare( $sql, null ), ARRAY_A );
		return array_column( $results, 'meta_value', 'meta_key' );
	}

	/**
	 * verify_nonce function
	 * This function checks to see if the nonce has expired
	 */
	static public function verify_nonce() {
		if( !wp_verify_nonce( $_POST[self::$prefix . CTLT_ESPRESSO_CONTROLS_BASENAME], CTLT_ESPRESSO_CONTROLS_BASENAME ) ) {
			return false;	
		}
		return true;
	}
}
