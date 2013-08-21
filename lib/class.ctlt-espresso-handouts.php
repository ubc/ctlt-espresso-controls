<?php

class CTLT_Espresso_Handouts extends CTLT_Espresso_Metaboxes {

	static $radios_arr = null;
	static $handout_file = null;

	public function __construct() {
		$this->init_handout_properties();
		add_action( $this->add_hook, array( $this, 'handouts' ) );
		add_action( $this->edit_hook, array( $this, 'handouts' ) );
		add_action( 'ctlt_espresso_form', array( $this, 'update_edit_form') );
	}

	/**
	 * init_handout_properties function
	 * This function sets the form fields and their ids
	 * Provides an easy place to change any option ids
	 */
	public function init_handout_properties() {

		self::$radios_arr = array(
			'name' => 'Handouts:',
			'id' => self::$prefix . 'handouts_radio',
			'type' => 'radio',
			'options' => array(
				array( 'name' => 'N/A', 'value' => 'N/A' ),
				array( 'name' => 'Expected', 'value' => 'Expected' ),
				array( 'name' => 'Received', 'value' => 'Received' ),
				array( 'name' => 'Copying Complete', 'value' => 'Copying Complete' )
				)
			);
		self::$handout_file = array(
			'name' => 'Handout File',
			'id' => self::$prefix . 'handouts_upload',
			'type' => 'file'
			);
	}

	/**
	 * handouts function
	 * This function creates the wrapper for the handout form fields
	 */
	public function handouts() {
		global $org_options;
		?>
		<div id="event-handouts" class="postbox">
			<div class="handlediv" title="Click to toggle"><br>
			</div>
			<h3 class="hndle"> <span>
				Handouts
				</span> </h3>
			<div class="inside">
				<?php $this->nonce_input( 'handouts_noncename' ); ?>
				<?php $this->the_radio_buttons(); ?>
				<?php $this->the_file_upload(); ?>
				<?php //print_r( self::$data ); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * the_radio_buttons function
	 * This function renders the radio buttons for the form
	 */
	public function the_radio_buttons() {
		?>
		<div class="ctlt-events-row">
			<div class="ctlt-span-12">
				<label class="ctlt-inline ctlt-span-4 ctlt-events-col" for="<?php echo self::$radios_arr['id']; ?>"><?php echo self::$radios_arr['name']; ?></label>
				<?php foreach( self::$radios_arr['options'] as $option ) { ?>
					<?php $checked = self::$data[self::$radios_arr['id']] == $option['value'] ? ' checked="checked"' : ''; ?>
					<label class="ctlt-inline ctlt-span-2 ctlt-events-col">
						<input type="<?php echo self::$radios_arr['type']; ?>" name="<?php echo self::$radios_arr['id']; ?>" value="<?php echo $option['value']; ?>" <?php echo $checked; ?> /> <?php echo $option['name']; ?>
					</label>
				<?php } ?>
			</div>
		</div>
		<?php
	}

	/**
	 * the_file_upload function
	 * This function renders the upload file box
	 */
	public function the_file_upload() {
		?>
		<div class="ctlt-events-row">
			<div class="ctlt-span-12">
				<label class="ctlt-span-4 ctlt-events-col" for="<?php echo self::$handout_file['id']; ?>"><?php echo self::$handout_file['name']; ?>:</label>
				<input class="ctlt-span-6 ctlt-events-col" type="<?php echo self::$handout_file['type']; ?>" name="<?php echo self::$handout_file['id']; ?>" id="<?php echo self::$handout_file['id']; ?>" />
				<?php //$this->add_download_link(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * update_edit_form function
	 * This function allows uploaded files to be uploaded
	 */
	public function update_edit_form() {
		echo ' enctype="multipart/form-data"';	
	}

	/**
	 * add_download_link function
	 * This function adds a download link to the uploaded file if it exists
	 */
	public function add_download_link() {
		$attachment = self::$data[self::$handout_file['id']];
		print_r( $attachment );
		if( !empty( $attachment['url'] ) ) { ?>
		<a class="ctlt-span-12 ctlt-events-col" href="<?php echo $attachment['url']; ?>" download="handout.pdf">
			Download the attachment here
		</a>
		<?php }
	}
	
}

new CTLT_Espresso_Handouts();
