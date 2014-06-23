<?php

class CTLT_Espresso_Additional_Information extends CTLT_Espresso_Metaboxes {

    // array to hold additional information fields
	static $add_info = null;
    static $event_waitlisting = null;
    static $event_contiguous = null;
	
	public function __construct() {
		$this->init_default_assets();
		add_action( $this->add_hook, array( $this, 'additional_information' ) );
		add_action( $this->edit_hook, array( $this, 'additional_information' ) );
	}

	/**
	 * init_default_assets function
	 * This function sets the form fields and their ids
	 * Provides an easy place to change any option ids
	 */
	public function init_default_assets() {
		self::$add_info = array(
			'name' => 'Additional Information',
			'id' => self::$prefix . 'additional_information',
			'options' => array(
				array( 'name' => 'General Notes', 'id' => self::$prefix . 'admin_support_notes' ),
				array( 'name' => 'Marketing and Communication Support Notes', 'id' => self::$prefix . 'marketing_communication' ),
				array( 'name' => 'Catering Notes', 'id' => self::$prefix . 'catering_notes' )
			)
		);
        self::$event_contiguous = array(
			'name' => 'Event Consecutive Policy',
			'id' => self::$prefix . 'event_contiguous',
			'type' => 'checkbox',
            'checkbox_label' => 'This event occurs on non-consecutive days and/or non-consecutive locations. (Set initial date or range of dates and location in the "Event Start Date" fields and note all other dates and locations in the event description, preferably before the "more" tag.)'
		);
        self::$event_waitlisting = array(
			'name' => 'Event Waitlisting Policy',
			'id' => self::$prefix . 'event_waitlisting',
			'type' => 'radio',
			'options' => array(
                array( 'name' => 'Automatic Waitlisting (allows both automatic and manual transfers from event waitlist to main event)', 'value' => 'Automatic Waitlist' ),
				array( 'name' => 'No Waitlisting', 'value' => 'No Waitlist' ),
				array( 'name' => 'Facilitator-approved Registration (allows facilitator to determine applicant success', 'value' => 'Manual Waitlist' )
			)
		);
	}

	/**
	 * additional_information function
	 * This function creates the wrapper for the handout form fields
	 */
	public function additional_information() {
		?>
		<div id="event-additional-information" class="postbox">
			<div class="handlediv" title="Click to toggle"><br />
			</div>
			<h3 class="hndle"> <span>
				Additional Information	
			</span> </h3>
			<div class="inside">
				<?php echo $this->nonce_input( 'additional_information_noncename' ); ?>
				<?php $this->the_textboxes(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * the_textboxes function
	 * This function renders the text areas for the form
	 */
	public function the_textboxes() {
        ?>
            <p>
            <label>Waitlisting/Registration Policy (NOTE: CHANGING THIS OPTION AFTER EVENT CREATION WILL NOT CHANGE REGISTRATION POLICY):</label>
            <?php foreach( self::$event_waitlisting['options'] as $option ) { ?>
                <?php $checked = isset( self::$data[self::$event_waitlisting['id']] ) && self::$data[self::$event_waitlisting['id']] == $option['value'] ? 'yes' : empty( self::$data[self::$event_waitlisting['id']] ) && strtolower( $option['value'] ) === 'automatic waitlist' ? 'yes' : 'no'; ?>
                <br /><input type="<?php echo self::$event_waitlisting['type']; ?>" name="<?php echo self::$event_waitlisting['id']?>" value="<?php echo $option['value']; ?>" <?php echo checked( $checked, 'yes' );?> id="<?php echo $option['value']; ?>"/>
                <label for="<?php echo $option['value']; ?>">
                <?php echo $option['name']; ?>
                </label>
            <?php } ?>
            </p>
            <p>
            <label>Consecutive Days/Locations:</label><br />
                <?php $checked = isset( self::$event_contiguous['id'] ) ? self::$data[self::$event_contiguous['id']] : ''; ?>
                <input type="<?php echo self::$event_contiguous['type']; ?>" name="<?php echo self::$event_contiguous['id']; ?>" id="<?php echo self::$event_contiguous['id']; ?>" <?php checked( $checked, 'yes' ); ?>>
                <label for="<?php echo self::$event_contiguous['id']; ?>"><?php echo self::$event_contiguous['checkbox_label']; ?></label>
            </p>
        <?php
		foreach( self::$add_info['options'] as $option ) {
			$text = isset( self::$data[$option['id']] ) ? self::$data[$option['id']] : '';
			?>
			<div class="ctlt-espresso-controls-textarea">
				<label for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?>:</label>
				<textarea class="ctlt-full-width" name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" cols="40" rows="4"><?php echo $text; ?></textarea>
			</div>
			<?php 
		}
	}
}

new CTLT_Espresso_Additional_Information();