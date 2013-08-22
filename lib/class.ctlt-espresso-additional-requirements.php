<?php

class CTLT_Espresso_Additional_Requirements extends CTLT_Espresso_Metaboxes {

	static $equipment = null;
	static $computers = null;
	static $cables = null;
	static $misc_computer_stuff = null;

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
				array( 'name' => 'Slide Advancer', 'id' => self::$prefix . 'slide_advancer' ),
				array( 'name' => 'Laser Pointer', 'id' => self::$prefix . 'laser_pointer' ),
				array( 'name' => 'Smart Projector', 'id' => self::$prefix . 'smart_projecter' ),
				array( 'name' => 'USB Stick', 'id' => self::$prefix . 'usb_stick' ),
				array( 'name' => 'AV Technician', 'id' => self::$prefix . 'av_technician' )
			)
		);

		self::$computers = array(
			'name' => 'Computers',
			'id' => self::$prefix . 'computers', 
			'type' => 'radio',
			'options' => array(
				array( 'name' => 'Room Computer' ),
				array( 'name' => 'Own Computer' )
			) 
		);

		self::$cables = array(
			'name' => 'Cables',
			'id' => self::$prefix . 'cables',
			'type' => 'radio',
			'options' => array(
				array( 'name' => 'VGA' ),
				array( 'name' => 'DVI' ),
				array( 'name' => 'Display Port' ),
				array( 'name' => 'HDMI' )
			)
		);

		self::$misc_computer_stuff = array(
			'name' => 'Computer Requirements',
			'options' => array(
				array( 
					'name' => 'Laptops',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'laptop_checkbox' ), 
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'laptop_textbox' ), 'label' => array( 'Quantity' ), 'description' => 'Max number of laptops are 20' )
				),
				array(
					'name' => 'Headsets',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'headset_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'headset_textbox' ), 'label' => array( 'Quantity' ), 'description' => 'Max number of headsets are 20' )
				),
				array(
					'name' => 'Clickers',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'clicker_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'clicker_textbox' ), 'label' => array( 'Quantity' ), 'description' => 'Max number of clickers are 25' )
				),
				array(
					'name' => 'Virtual Participation',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'virtual_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'virtual_textbox_website', self::$prefix . 'virtual_textbox_login' ), 'label' => array( 'Website', 'Login' ), 'description' => 'The website and login details for virtual participation' )
				),
				array(
					'name' => 'URL\'s on Computers',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'url_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'url_textbox' ), 'label' => array( 'URL' ), 'description' => 'The website each computer will be at initially' )
				),
				array(
					'name' => 'Folder with Files',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'folder_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'folder_textbox' ), 'label' => array( null ), 'description' => 'Please send or give a USB containing your files to the admin team' )
				),
				array(
					'name' => 'Additional Software',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'software_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'software_textbox' ), 'label' => array( 'Software Name' ) , 'description' => 'Additional software you would like to be installed in all the computers' )
				),
				array(
					'name' => 'Login Information',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'login_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'login_textbox_name', self::$prefix . 'login_textbox_password' ), 'label' => array( 'Username', 'Password' ), 'description' => 'Specific accounts users need to login to' )
				),
				array(
					'name' => 'Audio Recording',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'audio_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'audio_textbox' ), 'label' => array( 'Quantity' ), 'description' => 'How many people in the room?' )
				),
				array(
					'name' => 'Projectors',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'projector_checkbox' ),
					'textbox' => array( 'type' => 'textbox', 'id' => array( self::$prefix . 'projector_textbox' ), 'label' => array( 'Quantity' ), 'description' => 'Max number of projectors are 2 and only in room 2.22' )
				),
				array(
					'name' => 'Speakers',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'speakers_checkbox' ),
					'textbox' => array( null )
				)
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
				<?php $this->nonce_input( 'additional_requirements_noncename' ); ?>
				<?php $this->the_computers(); ?>
				<?php //print_r( self::$data ); ?>
			</div>
		</div>
		<?php
	}

	public function the_computers() {
		?>
		
		<?php
	}
}

new CTLT_Espresso_Additional_Requirements();
