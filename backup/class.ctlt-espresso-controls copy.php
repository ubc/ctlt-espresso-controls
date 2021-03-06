<?php
/**
 * CTLT Espresso Controls.
 *
 * @package   CTLT_Espresso_Controls
 * @author    Julien <email@example.com>
 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2013 Your Name or Company Name
 */

/**
 * Plugin class.
 *
 * TODO: Rename this class to a proper name for your plugin.
 *
 * @package Espresso_CTLT_Controls
 * @author  Julien <email@example.com>
 */
class CTLT_Espresso_Controls {
	
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = '1.0.0';

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'ctlt-espresso-controls';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	public $test_var = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_scripts') );
        add_action( 'admin_menu', array( $this, 'register_ctlt_espresso_reports_page') );
        add_action( 'admin_menu', array( $this, 'ctlt_espresso_export_to_excel' ) );
		add_action( 'admin_init', array( $this, 'init_ctlt_espresso_controls' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_stylesheets' ) );
	}
    
    /*
    * register_ctlt_espresso_reports_page function
    * Registers the Espresso Reports menu page
    */
    function register_ctlt_espresso_reports_page() {
        add_menu_page( 'Event Reports', 'Event Reports', 'manage_options', 'event-espresso-reports', array ('CTLT_Espresso_Reports', 'reports_menu_page' ) );
    }
    
    /*
    * ctlt_espresso_export_to_excel function
    * checks for POST parameters from Espresso Reports export to excel requests
    */
    function ctlt_espresso_export_to_excel() {
    
        global $wpdb;
        $argument_counter = 0;
        $sql_query;
        $sql_results;
        $distinct_spacer = "";
        
        
        if(isset($_POST['submit']) && ( isset($_REQUEST['attendees_events_id']) || isset($_REQUEST['events_events_id']) || isset($_REQUEST['admin_events_id']) || isset($_REQUEST['person_fname']) ) ) {
            if ( !isset($_POST['ctlt_espresso_nonce_field']) || !wp_verify_nonce($_POST['ctlt_espresso_nonce_field'],'ctlt_espresso_nonce_check') ) {
                print 'Sorry, your nonce did not verify. You do not currently have sufficient privileges to save your edits. Please contact the CTLT support team for further information.';
                exit;
            }
        }
    
        // Attendees Query and Report
        if( isset($_REQUEST['attendees_events_id']) || isset($_REQUEST['attendees_events_start']) || isset($_REQUEST['attendees_events_end']) || isset($_REQUEST['attendees_events_cateogry']) ) {
    
            $filename ="excelreport.xls";
            header('Content-type: application/ms-excel');
            header('Content-Disposition: attachment; filename='.$filename);
    
            if( isset($_REQUEST['attendees_events_unique']) && $_REQUEST['attendees_events_unique'] != '' ) {
                $distinct_spacer = "DISTINCT ";
            }
    
            $sql_query = "SELECT fname as 'First Name', lname as 'Last Name', payment_status as 'Registration Status', CASE WHEN checked_in = 1 THEN '1' ELSE '0' END as 'Attended', Attending_As as 'Attending As', Organization, Faculty, Department, Other_Unit as 'Other Unit', PhoneNumber, email as 'Email', event_name as 'Event Name', category_name as 'First Category Name', start_date as 'Start Date', end_date as 'End Date' FROM (";
            $sql_query .= "SELECT fname, lname, payment_status, Type as 'Attending_As', Organization, Faculty, Department, PhoneNumber, Other_Unit, email, event_name, category_name, start_date, end_date, attendee_id FROM ( ";
    
            $sql_query .= "SELECT " . $distinct_spacer . "fname, lname, payment_status, Type, Organization, Faculty, Department, Other_Unit, PhoneNumber, email, event_name, category_id, start_date, end_date, attendee_id FROM ( ";

            $sql_query .= "SELECT event_id, fname, lname, payment_status, email, Type, MAX(CASE WHEN meta_key = 'event_espresso_organization' THEN meta_value END) as Organization, MAX(CASE WHEN meta_key = 'event_espresso_faculty' THEN meta_value END) as Faculty, MAX(CASE WHEN meta_key = 'event_espresso_department' THEN meta_value END) as Department, MAX(CASE WHEN meta_key = 'event_espresso_other_unit' THEN meta_value END) as Other_Unit, MAX(CASE WHEN meta_key = 'event_espresso_phone_number' THEN meta_value END) as PhoneNumber, attendee_id FROM ( ";

            $sql_query .= "SELECT second_results.event_id, second_results.attendee_id, fname, lname, payment_status, email, Type, user_id FROM ( ";

            $sql_query .= "SELECT event_id, first_results.attendee_id as attendee_id, fname, lname, payment_status, email, MAX(CASE WHEN " . EVENTS_ANSWER_TABLE . ".question_id IN (SELECT id FROM " . EVENTS_QUESTION_TABLE . " WHERE question = 'Attending As') THEN " . EVENTS_ANSWER_TABLE . ".answer END) as Type FROM ( ";

            $sql_query .= "SELECT id as attendee_id, fname, lname, payment_status, email, event_id FROM " . EVENTS_ATTENDEE_TABLE . " ";

            if( $_REQUEST['attendees_events_id'] != '' || $_REQUEST['attendees_events_start'] != '' || $_REQUEST['attendees_events_end'] != '' || $_REQUEST['attendees_events_category'] != '' || $_REQUEST['attendees_events_type'] != '') {
                
                $sql_query .= "WHERE event_id IN (SELECT id FROM " . EVENTS_DETAIL_TABLE . " WHERE ";

                if( $_REQUEST['attendees_events_id'] != '' ) {
                    $sql_query .= $wpdb->prepare( 'id = %d ', $_REQUEST['attendees_events_id'] );
                    $argument_counter++;
                }
                if( $_REQUEST['attendees_events_start'] != '' ) {
                    if($argument_counter > 0) {
                        $sql_query .= "AND ";
                    }
                    $sql_query .= $wpdb->prepare( 'start_date >= %s ', $_REQUEST['attendees_events_start'] );
                    $argument_counter++;
                }
                if( $_REQUEST['attendees_events_end'] != '' ) {
                    if($argument_counter > 0) {
                        $sql_query .= "AND ";
                    }
                    $sql_query .= $wpdb->prepare( 'end_date <= %s ', $_REQUEST['attendees_events_end'] );
                    $argument_counter++;
                }
                if( $_REQUEST['attendees_events_category'] != '' ) {
                    if($argument_counter > 0) {
                        $sql_query .= "AND ";
                    }
                    $sql_category_id = $wpdb->get_results ( $wpdb->prepare( 'SELECT id FROM ' . EVENTS_CATEGORY_TABLE . ' WHERE category_name = %s LIMIT 1 ', $_REQUEST['attendees_events_category'] ) );
                    $sql_query .= "FIND_IN_SET(";
                    $sql_query .= $wpdb->prepare( '%s', $sql_category_id[0]->id );
                    $sql_query .= ", category_id) > 0 ";
                    $argument_counter++;
                }
                if( $_REQUEST['attendees_events_type'] != '' ) {
                    if($argument_counter > 0) {
                        $sql_query .= "AND ";
                    }
                    $sql_query .= $wpdb->prepare( 'event_status = %s ', $_REQUEST['attendees_events_type'] );
                }
                
                $sql_query .= ")";
            }

            $sql_query .= ") AS first_results ";
            $sql_query .= "INNER JOIN " . EVENTS_ANSWER_TABLE . " ON " . EVENTS_ANSWER_TABLE . ".attendee_id = first_results.attendee_id GROUP BY first_results.attendee_id) AS second_results ";
            $sql_query .= "INNER JOIN " . EVENTS_MEMBER_REL_TABLE . " ON " . EVENTS_MEMBER_REL_TABLE . ".attendee_id = second_results.attendee_id ";
            $sql_query .= ") AS third_results ";
            $sql_query .= "INNER JOIN " . $wpdb->prefix . "usermeta ON " . $wpdb->prefix . "usermeta.user_id = third_results.user_id GROUP BY attendee_id ";
            $sql_query .= ") AS fourth_results ";
            $sql_query .= "INNER JOIN " . EVENTS_DETAIL_TABLE . " ON " . EVENTS_DETAIL_TABLE . ".id = fourth_results.event_id ";
            $sql_query .= ") AS fifth_results ";
            $sql_query .= "LEFT JOIN " . EVENTS_CATEGORY_TABLE . " ON " . EVENTS_CATEGORY_TABLE . ".id = fifth_results.category_id ";
            $sql_query .= ") AS sixth_results ";
            $sql_query .= "LEFT JOIN " . $wpdb->prefix . "events_attendee_checkin ON " .  $wpdb->prefix . "events_attendee_checkin.attendee_id = sixth_results.attendee_id ";
            
            $sql_results = $wpdb->get_results( $sql_query, ARRAY_A );

            $flag = false;
            foreach($sql_results as $row) {
                if(!$flag) {
                    echo implode("\t", array_keys($row)) . "\r\n";
                    $flag = true;
                }
                echo implode("\t", array_values($row)) . "\r\n";
            }

            exit();
        }
        
        // Events Summary Query and Report
        if( isset($_REQUEST['events_events_id']) || isset($_REQUEST['events_events_start']) || isset($_REQUEST['events_events_end']) || isset($_REQUEST['events_events_cateogry']) ) {
        
            $filename ="excelreport.xls";
            header('Content-type: application/ms-excel');
            header('Content-Disposition: attachment; filename='.$filename);
            
            $sql_query = "SELECT fourth_results.event_id as 'Event Id', event_name as 'Event Name', category_name as 'First Category Name', fourth_results.start_date as 'Start Date', fourth_results.end_date as 'End Date', fourth_results.registration_start as 'Registration Start', fourth_results.registration_end as 'Registration End', Total_Registrations as 'Total Registrations', total_checked_in as 'Total Attended', (Total_Registrations - COUNT(" . EVENTS_ATTENDEE_TABLE . ".id)) as 'Total Cancelled Registrations', (Total_Registrations - total_checked_in - (Total_Registrations - COUNT(" . EVENTS_ATTENDEE_TABLE . ".id))) as 'Total No-Shows' FROM (";
            $sql_query .= "SELECT third_results.event_id, event_name, category_name, start_date, end_date, registration_start, registration_end, Total_Registrations, COUNT(checked_in) as total_checked_in FROM (";
            $sql_query .= "SELECT event_id, event_name, category_name, second_results.start_date, second_results.end_date, registration_start, registration_end, COUNT(" . EVENTS_ATTENDEE_TABLE . ".id) AS 'Total_Registrations' FROM (";
            $sql_query .= "SELECT first_results.id, event_name, category_name, start_date, end_date, registration_start, registration_end FROM (";
            $sql_query .= "SELECT id, event_name, start_date, end_date, registration_start, registration_end, category_id FROM " . EVENTS_DETAIL_TABLE . " ";
            
            if( $_REQUEST['events_events_id'] != '' || $_REQUEST['events_events_start'] != '' || $_REQUEST['events_events_end'] != '' || $_REQUEST['events_events_category'] != '' || $_REQUEST['events_events_type'] != '') {
                
                $sql_query .= "WHERE ";

                if( $_REQUEST['events_events_id'] != '' ) {
                    $sql_query .= $wpdb->prepare( 'id = %d ', $_REQUEST['events_events_id'] );
                    $argument_counter++;
                }
                if( $_REQUEST['events_events_start'] != '' ) {
                    if($argument_counter > 0) {
                        $sql_query .= "AND ";
                    }
                    $sql_query .= $wpdb->prepare( 'start_date >= %s ', $_REQUEST['events_events_start'] );
                    $argument_counter++;
                }
                if( $_REQUEST['events_events_end'] != '' ) {
                    if($argument_counter > 0) {
                        $sql_query .= "AND ";
                    }
                    $sql_query .= $wpdb->prepare( 'end_date <= %s ', $_REQUEST['events_events_end'] );
                    $argument_counter++;
                }
                if( $_REQUEST['events_events_category'] != '' ) {
                    if($argument_counter > 0) {
                        $sql_query .= "AND ";
                    }
                    $sql_category_id = $wpdb->get_results ( $wpdb->prepare( 'SELECT id FROM ' . EVENTS_CATEGORY_TABLE . ' WHERE category_name = %s LIMIT 1 ', $_REQUEST['events_events_category'] ) );
                    $sql_query .= "FIND_IN_SET(";
                    $sql_query .= $wpdb->prepare( '%s', $sql_category_id[0]->id );
                    $sql_query .= ", category_id) > 0 ";
                    $argument_counter++;
                }
                if( $_REQUEST['events_events_type'] != '' ) {
                    if($argument_counter > 0) {
                        $sql_query .= "AND ";
                    }
                    $sql_query .= $wpdb->prepare( 'event_status = %s ', $_REQUEST['events_events_type'] );
                }
            }
            
            $sql_query .= ") ";
            $sql_query .= "AS first_results LEFT JOIN " . EVENTS_CATEGORY_TABLE . " ON first_results.category_id = " . EVENTS_CATEGORY_TABLE . ".id";
            $sql_query .= ") ";
            $sql_query .= "AS second_results INNER JOIN ". EVENTS_ATTENDEE_TABLE. " ON " . EVENTS_ATTENDEE_TABLE . ".event_id = second_results.id ";
            $sql_query .= "GROUP BY second_results.id) as third_results ";
            $sql_query .= "LEFT JOIN " . $wpdb->prefix . "events_attendee_checkin ON third_results.event_id = " . $wpdb->prefix . "events_attendee_checkin.event_id GROUP BY third_results.event_id ";
            $sql_query .= ") AS fourth_results LEFT JOIN " . EVENTS_ATTENDEE_TABLE . " ON fourth_results.event_id = " . EVENTS_ATTENDEE_TABLE . ".event_id WHERE " . EVENTS_ATTENDEE_TABLE . ".payment_status = 'COMPLETED' GROUP BY fourth_results.event_id";
            $sql_results = $wpdb->get_results( $sql_query, ARRAY_A );
        
            $flag = false;
            foreach($sql_results as $row) {
                if(!$flag) {
                    echo implode("\t", array_keys($row)) . "\r\n";
                    $flag = true;
                }
                echo implode("\t", array_values($row)) . "\r\n";
            }
    
            exit();
        }
        
        // Administrative Details Query and Report
        if( isset($_REQUEST['admin_events_id']) || isset($_REQUEST['admin_events_start']) || isset($_REQUEST['admin_events_end']) || isset($_REQUEST['admin_events_cateogry']) ) {
        
            $filename ="excelreport.xls";
            header('Content-type: application/ms-excel');
            header('Content-Disposition: attachment; filename='.$filename);
            
            $sql_query = "SELECT id, event_name AS 'Event Name', start_date AS 'Start Date', end_date AS 'End Date',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_handouts_upload' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Handout File Id Number',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_signs_upload' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Sign File ID Number',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_handouts_notes' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Files Notes',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_room_setup_chairs' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Number of Chairs',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_room_setup_tables' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Number of Tables',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_room_setup' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Chair Configuration',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_room_setup_notes' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Room Setup Notes',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_computers' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Presenter Computer',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_projector_textbox' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Projectors',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_cables' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Presenter Cables',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_slide_advancer' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Slide Advancer Needed',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_laser_pointer' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Laser Pointer Needed',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_smart_projecter' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Smart Projector Needed',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_usb_stick' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'USB Stick Needed',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_av_technician' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'AV Technician Needed',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_computers_notes' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Presenter Equipment Notes',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_video_capture_checkbox' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Video Capture Needed',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_digitization_notes' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Digitization and Communication Notes',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_misc_computer_notes' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Audience Computer Notes',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_admin_support_notes' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'General Notes',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_marketing_communication' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Marketing and Communication Notes',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_catering_notes' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Catering Notes',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_facilitator_pay' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Facilitator Pay',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_ta_pay' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'TA Pay (Total)',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_ad_cost' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Ad Cost',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_food_cost' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Room Cost',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_other_cost' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Other Cost',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_laptop_textbox' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Audience Laptops Required',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_headset_textbox' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Audience Headsets Required',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_clicker_textbox' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Audience Clickers Required',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_virtual_textbox_website' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Audience Computer Website',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_virtual_textbox_login' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Audience Computer Login Name',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_virtual_textbox_password' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Audience Computer Login Password',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_live_stream_textbox' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Live Streaming URL',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_video_conference_textbox_ip' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Video Conference IP Address',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_video_conference_textbox_number' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Video Conference Contact Number',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_phone_conference_textbox_phone' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Teleconference Phone Number',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_phone_conference_textbox_teleconference' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Teleconference Conference Number',
                MAX(CASE WHEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_key = '_ctlt_espresso_phone_conference_textbox_access_code' THEN " . CTLT_ESPRESSO_EVENTS_META . ".meta_value END) AS 'Teleconference Access Code' ";
            $sql_query .= "FROM (SELECT * FROM " . EVENTS_DETAIL_TABLE .  " ";
        
            if( $_REQUEST['admin_events_id'] != '' || $_REQUEST['admin_events_start'] != '' || $_REQUEST['admin_events_end'] != '' || $_REQUEST['admin_events_category'] != '' ) {
                
                $sql_query .= "WHERE ";
                
                if( $_REQUEST['admin_events_id'] != '' ) {
                    $sql_query .= $wpdb->prepare( 'id = %d ', $_REQUEST['admin_events_id'] );
                    $argument_counter++;
                }
                if( $_REQUEST['admin_events_start'] != '' ) {
                    if($argument_counter > 0) {
                        $sql_query .= "AND ";
                    }
                    $sql_query .= $wpdb->prepare( 'start_date >= %s ', $_REQUEST['admin_events_start'] );
                    $argument_counter++;
                }
                if( $_REQUEST['admin_events_end'] != '' ) {
                    if($argument_counter > 0) {
                        $sql_query .= "AND ";
                    }
                    $sql_query .= $wpdb->prepare( 'end_date <= %s ', $_REQUEST['admin_events_end'] );
                    $argument_counter++;
                }
                if( $_REQUEST['admin_events_category'] != '' ) {
                    if($argument_counter > 0) {
                        $sql_query .= "AND ";
                    }
                    $sql_query .= $wpdb->prepare( 'category_name = %s ', $_REQUEST['admin_events_category'] );
                }
                
            }
            
            $sql_query .= ") ";
            $sql_query .= "AS first_results INNER JOIN " . CTLT_ESPRESSO_EVENTS_META . " ON first_results.id = " . CTLT_ESPRESSO_EVENTS_META . ".event_id GROUP BY first_results.id";

            $sql_results = $wpdb->get_results( $sql_query, ARRAY_A );
            
            $flag = false;
            foreach($sql_results as $row) {
                if(!$flag) {
                    echo implode("\t", array_keys($row)) . "\r\n";
                    $flag = true;
                }
                echo implode("\t", array_values($row)) . "\r\n";
            }
            
            exit();
        }
        
        // Events Attended Query and Report
        if( isset($_REQUEST['person_fname']) || isset($_REQUEST['person_lname']) ) {
        
            $filename ="excelreport.xls";
            header('Content-type: application/ms-excel');
            header('Content-Disposition: attachment; filename='.$filename);
            
            $sql_query = "SELECT fname as 'First Name', lname as 'Last Name', event_name as 'Event Name', start_date as 'Start Date', end_date as 'End Date', payment_status as 'Registration Status', CASE WHEN checked_in = 1 THEN 'yes' END as 'Attended' FROM (SELECT fname, lname, event_name, start_date, end_date, attendee_id, payment_status FROM (SELECT fname, lname, event_id, id as attendee_id, payment_status FROM " . EVENTS_ATTENDEE_TABLE . " ";
            
            if( $_REQUEST['person_fname'] != '' || $_REQUEST['person_lname'] != '' ) {
                $sql_query .= "WHERE ";
                
                if( $_REQUEST['person_fname'] != '' ) {
                    $sql_query .= $wpdb->prepare( 'fname = %s ', $_REQUEST['person_fname'] );
                    $argument_counter++;
                }
                if( $_REQUEST['person_lname'] != '' ) {
                    if($argument_counter > 0) {
                        $sql_query .= "AND ";
                    }
                    $sql_query .= $wpdb->prepare( 'lname = %s ', $_REQUEST['person_lname'] );
                    $argument_counter++;
                }
                
            }
            
            $sql_query .= ") ";
            $sql_query .= "AS first_results INNER JOIN " . EVENTS_DETAIL_TABLE . " ON first_results.event_id = " . EVENTS_DETAIL_TABLE . ".id";
            $sql_query .= ") ";
            $sql_query .= "AS second_results LEFT JOIN " . $wpdb->prefix . "events_attendee_checkin ON second_results.attendee_id = " . $wpdb->prefix . "events_attendee_checkin.attendee_id";

            $sql_results = $wpdb->get_results( $sql_query, ARRAY_A );
            
            $flag = false;
            foreach($sql_results as $row) {
                if(!$flag) {
                    echo implode("\t", array_keys($row)) . "\r\n";
                    $flag = true;
                }
                echo implode("\t", array_values($row)) . "\r\n";
            }
            
            exit();

        }
        
        
    }
    
	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		// TODO: Define activation functionality here
	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Deactivate" action, false if WPMU is disabled or plugin is deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {
		// TODO: Define deactivation functionality here
	}

	/**
	 * init_ctlt_espresso_controls function
	 * This function includes the necessary php files to create the metaboxes and reports page
	 */
	public function init_ctlt_espresso_controls() {
		require_once( 'lib/class.ctlt-espresso-metaboxes.php' );
		/** meta box ordering **/
		// the order of the require_once statements are what the order of the meta boxes as they appear in the events admin
        // lib/class.ctlt-espresso-reports.php creates the report page
        require_once( 'lib/class.ctlt-espresso-room-setup.php' );
		require_once( 'lib/class.ctlt-espresso-handouts.php' );
		require_once( 'lib/class.ctlt-espresso-additional-requirements.php' );
		require_once( 'lib/class.ctlt-espresso-additional-information.php' );
		require_once( 'lib/class.ctlt-espresso-costs.php' );
		require_once( 'lib/class.ctlt-espresso-saving.php' );
		require_once( 'lib/class.ctlt-espresso-reports.php' );
        add_action( 'ctlt_espresso_insert_event', array( 'CTLT_Espresso_Saving', 'insert' ) );
		add_action( 'ctlt_espresso_update_event', array( 'CTLT_Espresso_Saving', 'update' ) );
	}

	/**
	 * admin_stylesheets function
	 * This function enqueues the styles to the events admin page
	 */
	public function admin_stylesheets() {
		$css = CTLT_ESPRESSO_CONTROLS_DEBUG === true ? 'style.css' : 'style.min.css';
		wp_register_style( 'ctlt_espresso_controls_css', CTLT_ESPRESSO_CONTROLS_CSS_URL . $css, false, '1.0.0' );
		wp_enqueue_style( 'ctlt_espresso_controls_css' );
	}
    
    /*
     * admin_scripts function
     * This functions enqueues the scripts to set the
     *
     */
    public function admin_scripts() {
        wp_enqueue_script( 'ctlt-espresso-box-hider-js', CTLT_ESPRESSO_CONTROLS_JS_URL . 'ctlt-espresso-box-hider.js', array( 'jquery' ), '1.0.0', true );
    }
    

	public function espresso_properties() {
		if( !defined( 'EVENT_ESPRESSO_VERSION' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice' ) );
			deactivate_plugins( ESPRESSO_CTLT_CONTROLS_BASENAME );
		}

	}

	public function admin_notice() {
		?>
		<div class="updated">
			<p>Please enable <strong>Event Espresso</strong></p>
		</div>
		<?php
	}

	/**
	 * frontend_get_data function
	 * This function allows the frontend to get the data entered from the admin side of the plugin
	 * using the event id
	 */
	public function frontend_get_data() {
		global $wpdb;
		$event_id = $_GET['ee'];
		

		$sql = "SELECT meta_key, meta_value 
		FROM " . CTLT_ESPRESSO_EVENTS_META . " 
		WHERE event_id=%d;";  

		$results = $wpdb->get_results( $wpdb->prepare( $sql, $event_id ), ARRAY_A );
		return array_column( $results, 'meta_value', 'meta_key' );
	}

}

/**
 * This file is part of the array_column library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) 2013 Ben Ramsey <http://benramsey.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

if (!function_exists('array_column')) {

    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();

        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }

        if (!is_array($params[0])) {
            trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
            return null;
        }

        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }

        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;

        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }

        $resultArray = array();

        foreach ($paramsInput as $row) {

            $key = $value = null;
            $keySet = $valueSet = false;

            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }

            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }

            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }

        }

        return $resultArray;
    }

}