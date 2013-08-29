<?php

class CTLT_Espresso_Additional_Requirements extends CTLT_Espresso_Metaboxes {

	static $equipment = null;
	static $computers = null;
	static $cables = null;
	static $misc_computer_stuff = null;
	static $conference_misc = null;

	public function __construct() {
		$this->init_assets();
		add_action( $this->add_hook, array( $this, 'additional_requirements' ) );
		add_action( $this->edit_hook, array( $this, 'additional_requirements' ) );
	}

	/**
	 * init_assets function
	 * This function initializes the data needed to generate the form fields
	 */
	public function init_assets() {
		self::$equipment = array(
			'name' => 'Equipment',
			'type' => 'checkbox',
			'options' => array(
				array( 'name' => 'Slide Advancer', 'id' => self::$prefix . 'slide_advancer', 'checked' => 'no' ),
				array( 'name' => 'Laser Pointer', 'id' => self::$prefix . 'laser_pointer', 'checked' => 'no' ),
				array( 'name' => 'Smart Projector', 'id' => self::$prefix . 'smart_projecter', 'checked' => 'no' ),
				array( 'name' => 'USB Stick', 'id' => self::$prefix . 'usb_stick', 'checked' => 'no' ),
				array( 'name' => 'A/V Technician', 'id' => self::$prefix . 'av_technician', 'checked' => 'no' )
			)
		);

		self::$computers = array(
			'name' => 'Computers',
			'id' => self::$prefix . 'computers', 
			'type' => 'radio',
			'options' => array(
				array( 'name' => 'Room Computer', 'value' => 'Room Computer' ),
				array( 'name' => 'Own Computer', 'value' => 'Own Computer' ),
				array( 'name' => 'None', 'value' => 'None' )
			) 
		);

		self::$cables = array(
			'name' => 'Cables',
			'id' => self::$prefix . 'cables',
			'type' => 'radio',
			'options' => array(
				array( 'name' => 'VGA', 'value' => 'VGA' ),
				array( 'name' => 'DVI', 'value' => 'DVI' ),
				array( 'name' => 'Display Port', 'value' => 'Display Port' ),
				array( 'name' => 'HDMI', 'value' => 'HDMI' ),
				array( 'name' => 'None', 'value' => 'None' )
			)
		);

		self::$misc_computer_stuff = array(
			'name' => 'Computer Requirements',
			'options' => array(
				array( 
					'name' => 'Laptops',
					'description' => 'Max number of laptops are 20',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'laptop_checkbox' ), 
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'laptop_textbox' ), 'label' => array( 'Quantity' ), 'max' => 20 )
				),
				array(
					'name' => 'Headsets',
					'description' => 'Max number of headsets are 20',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'headset_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'headset_textbox' ), 'label' => array( 'Quantity' ), 'max' => 20 )
				),
				array(
					'name' => 'Clickers',
					'description' => 'Max number of clickers are 25',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'clicker_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'clicker_textbox' ), 'label' => array( 'Quantity' ), 'max' => 25 )
				),
				array(
					'name' => 'Virtual Participation',
					'description' => 'The website and login details for virtual participation',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'virtual_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'virtual_textbox_website', self::$prefix . 'virtual_textbox_login' ), 'label' => array( 'URL', 'Login' ) )
				),
				array(
					'name' => 'URL\'s on Computers',
					'description' => 'The website each computer will be at initially',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'url_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'url_textbox' ), 'label' => array( 'URL' ) )
				),
				array(
					'name' => 'Folder with Files',
					'description' => 'Please send or give a USB containing your files to the admin team',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'folder_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => null, 'label' => null )
				),
				array(
					'name' => 'Additional Software',
					'description' => 'Additional software you would like to be installed in all the computers',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'software_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'software_textbox' ), 'label' => array( 'Software Name' ) )
				),
				array(
					'name' => 'Login Information',
					'description' => 'Specific accounts users need to login to',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'login_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'login_textbox_name', self::$prefix . 'login_textbox_password' ), 'label' => array( 'Username', 'Password' ) )
				),
				array(
					'name' => 'Audio Recording',
					'description' => 'How many people in the room?',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'audio_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'audio_textbox' ), 'label' => array( 'Headcount' ) )
				),
				array(
					'name' => 'Projectors',
					'description' => 'Max number of projectors are 2 and only in room 2.22',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'projector_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'projector_textbox' ), 'label' => array( 'Quantity' ), 'max' => 2 )
				),
				array(
					'name' => 'Speakers',
					'description' => 'Turn on room speakers?',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'speakers_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => null, 'label' => null )
				)
			)
		);

		self::$conference_misc = array(
			'name' => 'Conference Miscellaneous Information',
			'options' => array(
				array(
					'name' => 'Video Capture',
					'description' => 'Conference will be recorded',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'video_capture_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => null, 'label' => null )
				),
				array(
					'name' => 'Live Streaming',
					'description' => 'Conference will be streamed to a live audience',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'live_stream_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'live_stream_textbox' ), 'label' => array( 'URL' ) ) 
				),
				array(
					'name' => 'Video Conference',
					'description' => 'Will this conference be at least partially a video conference?',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'video_conference_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'video_conference_textbox_ip', self::$prefix . 'video_conference_textbox_number' ), 'label' => array( 'IP Address', 'Contact Number' ) )
				),
				array(
					'name' => 'Phone Conference',
					'description' => 'Will this conference have participants over the phone?',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'phone_conference_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'phone_conference_textbox_phone', self::$prefix . 'phone_conference_textbox_teleconference', self::$prefix . 'phone_conference_textbox_access_code' ), 'label' => array( 'Phone Number', 'Conference Number', 'Access Code' ) )
				),
			)
		);
	}

	public function additional_requirements() {
		?>
		<div id="event-additional-requirements" class="postbox">
			<div class="handlediv" title="Click to toggle"><br>
			</div>
			<h3 class="hndle"> <span>
				Additional Requirements
				</span> </h3>
			<div class="inside">
				<?php echo $this->nonce_input( 'additional_requirements_noncename' ); ?>
				<h4><?php echo self::$computers['name']; ?></h4>
				<?php $this->the_computers(); ?>
				<?php $this->the_cables(); ?>
				<?php $this->the_misc_computer_stuff(); ?>
				<h4><?php echo self::$equipment['name']; ?></h4>
				<?php $this->the_equipment(); ?>
				<h4><?php echo self::$conference_misc['name']; ?></h4>
				<?php $this->the_conference_misc(); ?>
			</div>
		</div>
		<?php
	}

	public function the_computers() {
		?>
		<div class="ctlt-events-row">
			<label class="ctlt-inline ctlt-colspan-2 ctlt-events-col" for="<?php echo self::$computers['id']; ?>"><?php echo self::$computers['name']; ?></label>
			<?php foreach( self::$computers['options'] as $option ) { ?>
				<?php $checked = isset( self::$data[self::$computers['id']] ) && self::$data[self::$computers['id']] == $option['name'] ? 'yes' : empty( self::$data[self::$computers['id']] ) && strtolower( $option['value'] ) === 'none' ? 'yes' : 'no'; ?>
				<label class="ctlt-inline ctlt-colspan-2 ctlt-events-col">
					<input type="<?php echo self::$computers['type']; ?>" id="" name="<?php echo self::$computers['id']; ?>" value="<?php echo $option['value']; ?>" <?php checked( $checked, 'yes' ); ?>/> <?php echo $option['name']; ?>
				</label>
			<?php } ?>
		</div>
		<?php
	}

	public function the_cables() {
		?>
		<div class="ctlt-events-row">
			<label class="ctlt-inline ctlt-colspan-1 ctlt-events-col" for="<?php echo self::$cables['id']; ?>"><?php echo self::$cables['name']; ?></label>
			<?php foreach( self::$cables['options'] as $option ) { ?>
				<?php $checked = isset( self::$data[self::$cables['id']] ) && self::$data[self::$cables['id']] == $option['name'] ? 'yes' : empty( self::$data[self::$cables['id']] ) && strtolower( $option['value'] ) === 'none' ? 'yes' : 'no'; ?>
				<label class="ctlt-inline ctlt-colspan-2 ctlt-events-col">
					<input type="<?php echo self::$cables['type']; ?>" name="<?php echo self::$cables['id']; ?>" value="<?php echo $option['value']; ?>" <?php checked( $checked, 'yes' ); ?>/> <?php echo $option['name']; ?>
				</label>
			<?php } ?>
		</div>
		<?php
	}

	public function the_misc_computer_stuff() {
		foreach( self::$misc_computer_stuff['options'] as $option ) { ?>
			<?php $checked = isset( self::$data[$option['checkbox']['id']] ) ? esc_attr( self::$data[$option['checkbox']['id']] ) : ''; ?>
			<div class="ctlt-events-row">
				<div class="ctlt-inline ctlt-colspan-2 ctlt-events-col" for="<?php echo $option['checkbox']['id']; ?>"><label><?php echo $option['name']; ?></label><?php echo isset( $option['textbox']['id'] ) ? '<br/>' . $option['description'] : ''; ?></div>
				<input class="ctlt-inline ctlt-colspan-1 ctlt-events-col" type="<?php echo $option['checkbox']['type']; ?>" name="<?php echo $option['checkbox']['id']; ?>" id="<?php echo $option['checkbox']['id']; ?>" <?php checked( $checked, 'yes' ); ?>>
				<?php if( isset( $option['textbox']['id'] ) ) { ?>
					<?php for( $i = 0; $i < count( $option['textbox']['id'] ); $i++ ) { ?>
						<?php $value = isset( self::$data[$option['textbox']['id'][$i]] ) ? esc_attr( self::$data[$option['textbox']['id'][$i]] ) : ''; ?>
						<label class="ctlt-inline ctlt-colspan-1 ctlt-events-col" for="<?php echo $option['textbox']['id'][$i]; ?>"><?php echo $option['textbox']['label'][$i]; ?></label>
						<?php if( strtolower( $option['textbox']['label'][$i] ) !== "quantity" ) { ?>
							<input class="ctlt-inline ctlt-colspan-2 ctlt-events-col" type="<?php echo $option['textbox']['type']; ?>" name="<?php echo $option['textbox']['id'][$i]; ?>" id="<?php echo $option['textbox']['id'][$i]; ?>" value="<?php echo $value; ?>">
						<?php } 
						else { ?>
							<?php $select = isset( self::$data[$option['textbox']['id'][$i]] ) ? self::$data[$option['textbox']['id'][$i]] : 'none'; ?>
							<select name="<?php echo $option['textbox']['id'][$i]; ?>" id="<?php echo $option['textbox']['id'][$i] ?>">
								<option <?php selected( $select, 'none' ); ?>>none</option>
							<?php for( $j = 1; $j <= $option['textbox']['max']; $j++ ) { ?>
								<option <?php selected( $select, $j ); ?>><?php echo $j; ?></option>
							<?php } ?>
							</select>
						<?php } ?>
					<?php } ?>
				<?php } 
				else { ?>
				<div class="ctlt-inline ctlt-colspan-7 ctlt-events-col"><?php echo $option['description']; ?></div>
			<?php } ?>
			</div>
		<?php }
	}

	public function the_equipment() {
		?>
		<div class="ctlt-events-row">
		<?php foreach( self::$equipment['options'] as $option ) { ?>
			<?php $checked = isset( self::$data[$option['id']] ) ? esc_attr( self::$data[$option['id']] ) : '';?>
				<label class="ctlt-inline ctlt-colspan-1 ctlt-events-col" for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></label>
				<input class="ctlt-inline ctlt-colspan-1 ctlt-events-col" type="<?php echo self::$equipment['type']; ?>" name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" <?php checked( $checked, 'yes' ); ?>>
		<?php } ?>
		</div>
		<?php
	}

	public function the_conference_misc() {
		foreach( self::$conference_misc['options'] as $option ) { ?>
		<?php $checked = isset( self::$data[$option['checkbox']['id']] ) ? esc_attr( self::$data[$option['checkbox']['id']] ) : ''; ?>
		<div class="ctlt-events-row">
			<div class="ctlt-inline ctlt-colspan-2 ctlt-events-col" for="<?php echo $option['checkbox']['id']; ?>"><label><?php echo $option['name']; ?></label><?php echo isset( $option['textbox']['id'] ) ? '<br/>' . $option['description'] : ''; ?></div>
			<input class="ctlt-inline ctlt-colspan-1 ctlt-events-col" type="<?php echo $option['checkbox']['type']; ?>" name="<?php echo $option['checkbox']['id']; ?>" id="<?php echo $option['checkbox']['id']; ?>" <?php checked( $checked, 'yes' ); ?>>
			<?php if( isset( $option['textbox']['id'] ) ) { ?>
				<?php for( $i = 0; $i < count( $option['textbox']['id'] ); $i++ ) { ?>
					<?php $value = isset( self::$data[$option['textbox']['id'][$i]] ) ? esc_attr( self::$data[$option['textbox']['id'][$i]] ) : ''; ?>
					<label class="ctlt-inline ctlt-colspan-1 ctlt-events-col" for="<?php echo $option['textbox']['id'][$i]; ?>"><?php echo $option['textbox']['label'][$i]; ?></label>
					<input class="ctlt-inline ctlt-colspan-<?php echo ( strtolower( $option['textbox']['label'][$i] ) === 'url' ) || ( strpos( strtolower( $option['textbox']['label'][$i] ), 'number' ) !== false ) ? '2' : '1'; ?> ctlt-events-col" type="<?php echo $option['textbox']['type']; ?>" name="<?php echo $option['textbox']['id'][$i]; ?>" id="<?php echo $option['textbox']['id'][$i]; ?>" value="<?php echo $value; ?>">
				<?php } ?>
			<?php }
			else { ?>
			<div class="ctlt-inline ctlt-colspan-7 ctlt-events-col"><?php echo $option['description']; ?></div>
			<?php } ?>
		</div>
		<?php }
	}
}

new CTLT_Espresso_Additional_Requirements();
