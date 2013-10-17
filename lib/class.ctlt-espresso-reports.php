<?php

class CTLT_Espresso_Reports {
    
	public function reports_menu_page() {
    
        global $wpdb;
        $sql_query = "SELECT category_name FROM " . EVENTS_CATEGORY_TABLE . " ";
        $sql_results = $wpdb->get_results( $sql_query, ARRAY_A );
        
        $categories_options_builder = '<option value="">Any</option>';
        
        foreach($sql_results as $row) {
            $categories_options_builder .= '<option value="' . $row['category_name'] . '">' . $row['category_name'] . '</option>\n';
        }
        
        

    ?>

        <div class="wrap"><div id="icon-tools" class="icon32"></div>
            <h2>Event Reports</h2>
            <p>This page is for generating UBC reports about events and attendees. To create or modify an event, select the Event Espresso button at left. For questions about generating both reports and events, consult the UBC wiki page: http://wiki.ubc.ca.</p>
            <hr />
            <form method="post" action="">
                <h3>Attendees Summary</h3>
                <p>Exports list of unique registrants for selected events. Includes name, email, job title (student, faculty, staff, and other), institution, faculty, and department.</p>
                <table>
                    <tr>
                        <td>Event ID (#):</td>
                        <td><input type="text" size="5" name="attendees_events_id"></td>
                    </tr>
                    <tr>
                        <td>Starting after (yyyy-mm-dd):</td>
                        <td><input type="text" size="5" name="attendees_events_start"></td>
                    </tr>
                    <tr>
                        <td>Ending before (yyyy-mm-dd):</td>
                        <td><input type="text" size="5" name="attendees_events_end"></td>
                    </tr>
                    <tr>
                        <td>Event Category:</td>
                        <td><select name="attendees_events_category"><?php echo $categories_options_builder; ?></select></td>
                    </tr>
                    <tr>
                        <td>Return unique names only:</td>
                        <td><input type="checkbox" name="attendees_events_unique" value="DISTINCT "></td>
                    </tr>
                </table>
                <?php wp_nonce_field('ctlt_espresso_nonce_check','ctlt_espresso_nonce_field'); ?>
                <p> <?php submit_button( 'Export to Excel' ); ?> </p>
            </form>
            <hr />
            <form method="post" action="">
                <h3>Events Summary</h3>
                <p>Exports list of event summaries. Includes name, category, start date and time, end date and time, number of registrants, and names of coordinators.</p>
                <table>
                    <tr>
                        <td>Event ID (#):</td>
                        <td><input type="text" size="5" name="events_events_id"></td>
                    </tr>
                    <tr>
                        <td>Starting after (yyyy-mm-dd):</td>
                        <td><input type="text" size="5" name="events_events_start"></td>
                    </tr>
                    <tr>
                        <td>Ending before (yyyy-mm-dd):</td>
                        <td><input type="text" size="5" name="events_events_end"></td>
                    </tr>
                    <tr>
                        <td>Event Category:</td>
                        <td><select name="events_events_category"><?php echo $categories_options_builder; ?></select></td>
                    </tr>
                </table>
                <?php wp_nonce_field('ctlt_espresso_nonce_check','ctlt_espresso_nonce_field'); ?>
                <p> <?php submit_button( 'Export to Excel' ); ?> </p>
            </form>
            <hr />
            <form method="post" action="">
                <h3>Administrative Details</h3>
                <p>Exports document of administrative details for a selected event.</p>
                <table>
                    <tr>
                        <td>Event ID (#):</td>
                        <td><input type="text" size="5" name="admin_events_id"></td>
                    </tr>
                    <tr>
                        <td>Starting after (yyyy-mm-dd):</td>
                        <td><input type="text" size="5" name="admin_events_start"></td>
                    </tr>
                    <tr>
                        <td>Ending before (yyyy-mm-dd):</td>
                        <td><input type="text" size="5" name="admin_events_end"></td>
                    </tr>
                    <tr>
                        <td>Event Category:</td>
                        <td><select name="admin_events_category"><?php echo $categories_options_builder; ?></select></td>
                    </tr>
                </table>
                <?php wp_nonce_field('ctlt_espresso_nonce_check','ctlt_espresso_nonce_field'); ?>
                <p> <?php submit_button( 'Export to Excel' ); ?> </p>
            </form>
            <hr />
            <form method="post" action="">
                <h3>Events Attended Report</h3>
                <p>Exports a list of all events registered by all people sharing the information entered below.</p>
                <table>
                    <tr>
                        <td>First:</td>
                        <td><input type="text" size="10" name="person_fname"></td>
                    </tr>
                    <tr>
                        <td>Last:</td>
                        <td><input type="text" size="10" name="person_lname"></td>
                    </tr>
                </table>
                <?php wp_nonce_field('ctlt_espresso_nonce_check','ctlt_espresso_nonce_field'); ?>
                <p> <?php submit_button( 'Export to Excel' ); ?> </p>
            </form>
        </div>

	<?php }
}