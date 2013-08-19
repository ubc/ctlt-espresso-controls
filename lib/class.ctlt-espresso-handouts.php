<?php

class CTLT_Espresso_Handouts extends CTLT_Espresso_Metaboxes {

	static $radios_arr = null;
	static $handout_file = null;

	public function __construct() {
		$this->init_handout_properties();
		add_action( $this->hook_name, array( $this, 'handouts' ) );
		add_action( 'post_edit_form_tag', array( $this, 'update_edit_form') );
	}

	public function init_handout_properties() {

		self::$radios_arr = array(
			'name' => 'Handouts:',
			'id' => $this->prefix . 'handouts_radio',
			'type' => 'radio',
			'options' => array(
				array( 'name' => 'N/A', 'value' => 'n/a' ),
				array( 'name' => 'Expected', 'value' => 'expected' ),
				array( 'name' => 'Received', 'value' => 'received' ),
				array( 'name' => 'Copying Complete', 'value' => 'copying-complete' )
				)
			);
		self::$handout_file = array(
			'name' => 'Handout File',
			'id' => $this->prefix . 'handout-upload',
			'type' => 'file'
			);
	}



	public function handouts() {
		?>
		<div  id="event-handouts" class="postbox">
			<div class="handlediv" title="Click to toggle"><br>
			</div>
			<h3 class="hndle"> <span>
				Handouts
				</span> </h3>
			<div class="inside">
				<?php $this->the_radio_buttons(); ?>
				<?php $this->the_file_upload(); ?>
			</div>
		</div>
		<?php
	}

	public function the_radio_buttons() {
		?>
		<div class="ctlt-events-row">
			<div class="ctlt-span-12">
				<label class="ctlt-inline ctlt-span-4 ctlt-events-col" for="<?php echo self::$radios_arr['id']; ?>"><?php echo self::$radios_arr['name']; ?></label>
				<?php foreach( self::$radios_arr['options'] as $option ) { ?>
					<?php //$checked = $meta == $option['value'] ? ' checked="checked"' : ''; ?>
					<label class="ctlt-inline ctlt-span-2 ctlt-events-col">
						<input type="<?php echo self::$radios_arr['type']; ?>" name="<?php echo self::$radios_arr['id']; ?>" value="<?php echo $option['value']; ?>" <?php //echo $checked; ?> /> <?php echo $option['name']; ?>
					</label>
				<?php } ?>
			</div>
		</div>
		<?php
	}

	public function the_file_upload() {
		?>
		<div class="ctlt-events-row">
			<div class="ctlt-span-12">
				<label class="ctlt-span-4 ctlt-events-col" for="<?php echo self::$handout_file['id']; ?>"><?php echo self::$handout_file['name']; ?>:</label>
				<input class="ctlt-span-6 ctlt-events-col" type="<?php echo self::$handout_file['type']; ?>" name="<?php echo self::$handout_file['id']; ?>" id="<?php echo self::$handout_file['id']; ?>" />
				<?php //$this->add_download_link( $post->ID ); ?>
			</div>
		</div>
		<?php
	}

	public function update_edit_form() {
		echo ' enctype="multipart/form-data"';	
	}
	
}

new CTLT_Espresso_Handouts();