<?php

class CTLT_Espresso_Additional_Information extends CTLT_Espresso_Metaboxes {

	static $add_info = null;
	static $checks = null;
	
	public function __construct() {
		$this->init_default_assets();
		add_action( $this->hook_name, array( $this, 'additional_information' ) );
	}

	/**
	 * init_default_assets function
	 * This function sets the form fields and their ids
	 * Provides an easy place to change any option ids
	 */
	public function init_default_assets() {
		self::$add_info = array(
			'name' => 'Additional Information',
			'id' => $this->prefix . 'additional-information',
			'options' => array(
				array( 'name' => 'Room Setup Notes', 'id' => $this->prefix . 'room-setup-notes' ),
				array( 'name' => 'A/V and Computer Requirements', 'id' => $this->prefix . 'av-computer-requirements' ),
				array( 'name' => 'Admin Support Notes', 'id' => $this->prefix . 'admin-support-notes' ),
				array( 'name' => 'Marketing and Communication Support Notes', 'id' => $this->prefix . 'marketing-communication' ),
				array( 'name' => 'Catering Notes', 'id' => $this->prefix . 'catering-notes' )
			)
		);
		self::$checks = array(
			'name' => 'Event Misc',
			'id' => $this->prefix . 'event-misc',
			'type' => 'checkbox',
			'options' => array(
				array( 'name' => 'Room Setup Assistance', 'id' => $this->prefix . 'room-setup-assistance', 'checked' => 'off' ),
				array( 'name' => 'Signs for Event', 'id' => $this->prefix . 'signs-for-event', 'checked' => 'off' )
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
				<?php $this->the_textboxes(); ?>
				<?php $this->the_checkboxes(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * the_textboxes function
	 * This function renders the text areas for the form
	 */
	public function the_textboxes() {
		foreach( self::$add_info['options'] as $option ) {
			//$text = isset( $meta[$option['id']] ) ? $meta[$option['id']][0] : '';
			?>
			<div class="ctlt-events-row">
				<label class="ctlt-colspan-12 ctlt-events-col"for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?>:</label>
				<textarea class="ctlt-colspan-12 ctlt-events-col ctlt-espresso-controls-textarea" name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" cols="40" rows="8"><?php // echo $text; ?></textarea>
			</div>
			<?php 
		}
	}

	/**
	 * the_checkboxes function
	 * This function renders the checkboxes for the form
	 */
	public function the_checkboxes() {
		echo '<div class="ctlt-events-row">';
		foreach( self::$checks['options'] as $option ) {
			//$checked = isset( $meta[$option['id']] ) ? esc_attr( $meta[$option['id']][0] ) : '';
			?>
			<div class="ctlt-colspan-6 ctlt-events-col">
				<label class="label-pad-right" for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?>:</label>
				<input type="<?php echo self::$checks['type']; ?>" name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" <?php //checked( $checked, 'on' ); ?>>
			</div>
			<?php
		}
		echo '</div>';
	}
}

new CTLT_Espresso_Additional_Information();