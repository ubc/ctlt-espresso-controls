<?php

class CTLT_Espresso_Saving extends CTLT_Espresso_Metaboxes {
	
    // array of event data to be inserted into/updated with the Event Espresso meta table
	static $meta_data = array(null);

	static public function insert( $event_id ) {
		self::assigning();
		self::insert_to_db( $event_id );
	}

	static public function update( $event_id ) {
		self::assigning();
		self::update_to_db( $event_id );
	}

	/**
	 * assigning function
	 * Assigns the event values to an array to be inserted into the database
     * Event values listed here roughly in the order they appear for the user,
     * single values first, then foreach loops where possible
	 */
	static private function assigning() {

		self::$meta_data = array(
        
            // handouts, signs, and logo fields
			CTLT_Espresso_Handouts::$handout_file['id'] => !empty( $_POST[CTLT_Espresso_Handouts::$handout_file['id']] ) ? $_POST[CTLT_Espresso_Handouts::$handout_file['id']] : '',
            CTLT_Espresso_Handouts::$sign_file['id'] => !empty( $_POST[CTLT_Espresso_Handouts::$sign_file['id']] ) ? $_POST[CTLT_Espresso_Handouts::$sign_file['id']] : '',
            CTLT_Espresso_Handouts::$handout_file['notes'] => !empty( $_POST[CTLT_Espresso_Handouts::$handout_file['notes']] ) ? $_POST[CTLT_Espresso_Handouts::$handout_file['notes']] : '',
            CTLT_Espresso_Handouts::$handout_policy['id'] => !empty( $_POST[CTLT_Espresso_Handouts::$handout_policy['id']] ) ? 'yes' : 'no',
            
            // room setup fields
            CTLT_Espresso_Room_Setup::$rooms['chairs'] => !empty( $_POST[CTLT_Espresso_Room_Setup::$rooms['chairs']] ) ? $_POST[CTLT_Espresso_Room_Setup::$rooms['chairs']] : '',
            CTLT_Espresso_Room_Setup::$rooms['tables'] => !empty( $_POST[CTLT_Espresso_Room_Setup::$rooms['tables']] ) ? $_POST[CTLT_Espresso_Room_Setup::$rooms['tables']] : '',
			CTLT_Espresso_Room_Setup::$rooms['id'] => !empty( $_POST[CTLT_Espresso_Room_Setup::$rooms['id']] ) ? $_POST[CTLT_Espresso_Room_Setup::$rooms['id']] : 'As Is',
            CTLT_Espresso_Room_Setup::$rooms['notes'] => !empty( $_POST[CTLT_Espresso_Room_Setup::$rooms['notes']] ) ? $_POST[CTLT_Espresso_Room_Setup::$rooms['notes']] : '',
            
            // presenter equipment fields
            CTLT_Espresso_Additional_Requirements::$presenter_equipment['id'] => !empty( $_POST[CTLT_Espresso_Additional_Requirements::$presenter_equipment['id']] ) ? 'yes' : 'no',
            CTLT_Espresso_Additional_Requirements::$presenter_equipment['projectors']['textbox']['id'] => !empty( $_POST[CTLT_Espresso_Additional_Requirements::$presenter_equipment['projectors']['textbox']['id']] ) ? $_POST[CTLT_Espresso_Additional_Requirements::$presenter_equipment['projectors']['textbox']['id']] : 'None',
            CTLT_Espresso_Additional_Requirements::$presenter_equipment['speakers']['checkbox']['id'] => !empty( $_POST[CTLT_Espresso_Additional_Requirements::$presenter_equipment['speakers']['checkbox']['id']] ) ? 'yes' : 'no',
			CTLT_Espresso_Additional_Requirements::$cables['id'] => !empty( $_POST[CTLT_Espresso_Additional_Requirements::$cables['id']] ) ? $_POST[CTLT_Espresso_Additional_Requirements::$cables['id']] : 'None',
            CTLT_Espresso_Additional_Requirements::$presenter_equipment['notes'] => !empty( $_POST[CTLT_Espresso_Additional_Requirements::$presenter_equipment['notes']] ) ? $_POST[CTLT_Espresso_Additional_Requirements::$presenter_equipment['notes']] : '',
            
            // conference equipment fields (partial)
            CTLT_Espresso_Additional_Requirements::$conference_misc['video_capture']['checkbox']['id'] => !empty( $_POST[CTLT_Espresso_Additional_Requirements::$conference_misc['video_capture']['checkbox']['id']] ) ? 'yes' : 'no',
            CTLT_Espresso_Additional_Requirements::$conference_misc['notes'] => !empty( $_POST[CTLT_Espresso_Additional_Requirements::$conference_misc['notes']] ) ? $_POST[CTLT_Espresso_Additional_Requirements::$conference_misc['notes']] : '',
            CTLT_Espresso_Additional_Requirements::$misc_computer_stuff['notes'] => !empty( $_POST[CTLT_Espresso_Additional_Requirements::$misc_computer_stuff['notes']] ) ? $_POST[CTLT_Espresso_Additional_Requirements::$misc_computer_stuff['notes']] : '',
            
            // event waitlisting information
			CTLT_Espresso_Additional_Information::$event_waitlisting['id'] => !empty( $_POST[CTLT_Espresso_Additional_Information::$event_waitlisting['id']] ) ? $_POST[CTLT_Espresso_Additional_Information::$event_waitlisting['id']] : 'Automatic Waitlist',
            CTLT_Espresso_Additional_Information::$event_contiguous['id'] => !empty( $_POST[CTLT_Espresso_Additional_Information::$event_contiguous['id']] ) ? 'yes' : 'no'
            
		);
        
        // conference equipment checkboxes
        foreach( CTLT_Espresso_Additional_Requirements::$equipment['options'] as $option ) {
			self::$meta_data[$option['id']] = isset( $_POST[$option['id']] ) && $_POST[$option['id']] ? 'yes' : 'no';
		}

        // conferences notes fields
		foreach( CTLT_Espresso_Additional_Information::$add_info['options'] as $option ) {
			self::$meta_data[$option['id']] = isset( $_POST[$option['id']] ) ? strip_tags( $_POST[$option['id']] ) : '';
		}

        // costs fields
		foreach( CTLT_Espresso_Costs::$costs_arr['options'] as $option ) {
			$_POST[$option['id']] = empty( $_POST[$option['id']] ) ? 0 : $_POST[$option['id']];
			if( isset( $_POST[$option['id']] ) ) {
				self::$meta_data[$option['id']] = is_numeric( $_POST[$option['id']] ) && $_POST[$option['id']] >= 0 ? strip_tags( $_POST[$option['id']] ) : 0;
			}
		}

        // conference equipment fields (partial)
		foreach( CTLT_Espresso_Additional_Requirements::$misc_computer_stuff['options'] as $option ) {
			if( isset( $option['textbox']['id'] ) ) {
				for( $i = 0; $i < count( $option['textbox']['id'] ); $i++ ) {
					self::$meta_data[$option['textbox']['id'][$i]] = isset( $_POST[$option['textbox']['id'][$i]] ) ? $_POST[$option['textbox']['id'][$i]] : '';
				}
			}
		}

        // IT services information
		foreach( CTLT_Espresso_Additional_Requirements::$conference_misc['options'] as $option ) {
			self::$meta_data[$option['checkbox']['id']] = isset( $_POST[$option['checkbox']['id']] ) && $_POST[$option['checkbox']['id']] ? 'yes' : 'no';
			if( isset( $option['textbox']['id'] ) ) {
				for( $i = 0; $i < count( $option['textbox']['id'] ); $i++ ) {
					self::$meta_data[$option['textbox']['id'][$i]] = isset( $_POST[$option['textbox']['id'][$i]] ) ? $_POST[$option['textbox']['id'][$i]] : '';
				}
			}
		}
			
	}

	/**
	 * insert_to_db function
	 * This function will take the event id as a parameter and insert data into the events_meta table
	 * @param int (event_id)
	 */
	static public function insert_to_db( $event_id ) {
		// $meta_data contains all the information that we wish to save to the db
		// event_id = int; meta_key = varchar(255); meta_value = longtext; date_added = datetime

		// verify the nonce
		if( !self::verify_nonce( 'handouts_noncename' ) ) 
			wp_die( 'Nonce for handouts meta box not verified.' );
		if( !self::verify_nonce( 'room_setup_noncename' ) )
			wp_die( 'Nonce for room setup meta box not verified.' );
		if( !self::verify_nonce( 'additional_information_noncename' ) )
			wp_die( 'Nonce for additional information meta box not verified.' );
		if( !self::verify_nonce( 'additional_requirements_noncename' ) )
			wp_die( 'Nonce for additional requirements meta box not verified.' );
		if( !self::verify_nonce( 'costs_noncename' ) )
			wp_die( 'Nonce for costs meta box not verified.' );
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
			VALUES('%d', '%s', '%s', '%s');";
			// int, string, string, string

			if( !$wpdb->query( $wpdb->prepare( $sql, $event_id, $key, $value, $date ) ) ) {
				wp_die( 'Meta data not inserted successfully for ' . $key . '=' . $value );
			}
		}

	}

	/**
	 * update_to_db function
	 * This function will take the event id as a paramter and update the data in the events_meta table
	 * @param int (event_id)
	 */
	static public function update_to_db( $event_id ) {
		// before doing the saving, verify the nonce, make sure autosave is not enabled
		// verify the nonce
		if( !self::verify_nonce( 'handouts_noncename' ) ) 
			wp_die( 'Nonce for handouts meta box not verified.' );
		if( !self::verify_nonce( 'room_setup_noncename' ) )
			wp_die( 'Nonce for room setup meta box not verified.' );
		if( !self::verify_nonce( 'additional_information_noncename' ) )
			wp_die( 'Nonce for additional information meta box not verified.' );
		if( !self::verify_nonce( 'additional_requirements_noncename' ) )
			wp_die( 'Nonce for additional requirements meta box not verified.' );
		if( !self::verify_nonce( 'costs_noncename' ) )
			wp_die( 'Nonce for costs meta box not verified.' );
		// check autosave
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;
		// check permissions
		// use capabilities here
		/*if( !current_user_can( 'edit_event' ) )
			return;*/

		global $wpdb;
		
		// do a comparison with the old data
		foreach( self::$meta_data as $key => $value ) {
			$compare = self::get_single_row( $event_id, $key );
			if( $compare[0] !== $value ) { 
			// compare the 0th index of the returned array with the value of the current array index of meta_data
				$sql = "UPDATE " . CTLT_ESPRESSO_EVENTS_META . " SET meta_value='%s' WHERE event_id='%d' AND meta_key='%s';";

				if( !$wpdb->query( $wpdb->prepare( $sql, $value, $event_id, $key ) ) ) {
					wp_die( 'Meta data not updated successfully for ' . $key . '=' . $value  );
				}
			}
		}

	}

	/**
	 * get_single_row function
	 * This function is a helper function for the update function so that no updates 
	 * are made to input fields that are not changed
	 */
	static private function get_single_row( $event_id, $meta_key ) {
		global $wpdb;
		$sql = "SELECT meta_value FROM " . CTLT_ESPRESSO_EVENTS_META . " WHERE event_id='%d' AND meta_key='%s';";

		$value = $wpdb->get_results( $wpdb->prepare( $sql, $event_id, $meta_key ), ARRAY_A );
		if( !$value ) {
			wp_die( 'failed at id=' . $meta_key );
		}
		return array_column( $value, 'meta_value' );
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
		WHERE event_id='%d';";  

		$results = $wpdb->get_results( $wpdb->prepare( $sql, $event_id ), ARRAY_A );
		return array_column( $results, 'meta_value', 'meta_key' );
	}

	/**
	 * verify_nonce function
	 * This function checks to see if the nonce has expired
	 */
	static private function verify_nonce( $nonce_name ) {
		if( !wp_verify_nonce( $_POST[self::$prefix . $nonce_name], CTLT_ESPRESSO_CONTROLS_BASENAME ) ) {
			return false;	
		}
		return true;
	}
}
