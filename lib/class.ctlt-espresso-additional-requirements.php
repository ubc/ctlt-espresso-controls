<?php

class CTLT_Espresso_Additional_Requirements extends CTLT_Espresso_Metaboxes {

    // arrays to hold equipment/setup information, roughly in the order they appear to the user
	static $equipment = null;
	static $presenter_equipment = null;
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

		self::$presenter_equipment = array(
			'name' => 'Podium/Presenter Computer Requirements',
			'id' => self::$prefix . 'computers', 
			'type' => 'checkbox',
            'checkbox_label' => 'University-Provided Computer:',
            'notes_label' => 'Podium/Presenter Equipment Notes:',
            'notes' => self::$prefix . 'computers_notes',
            'projectors' => array(
                'name' => 'Projectors (not available in every space):',
                'textbox' => array( 'type' => 'text', 'id' => self::$prefix . 'projector_textbox' , 'max' => 2 )
            ),
            'speakers' => array(
                'name' => 'Speakers On (not available in every space):',
                'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'speakers_checkbox' )
            )
		);

		self::$cables = array(
			'name' => 'Cables',
			'id' => self::$prefix . 'cables',
			'type' => 'radio',
			'options' => array(
				array( 'name' => 'None', 'value' => 'None' ),
				array( 'name' => 'VGA', 'value' => 'VGA' ),
				array( 'name' => 'DVI', 'value' => 'DVI' ),
				array( 'name' => 'Display Port', 'value' => 'Display Port' ),
				array( 'name' => 'HDMI', 'value' => 'HDMI' ),
				array( 'name' => 'Other', 'value' => 'Other' )
			)
		);

		self::$misc_computer_stuff = array(
			'name' => 'Audience Computer Requirements',
			'options' => array(
				array( 
					'name' => 'Laptops',
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'laptop_textbox' ), 'label' => array( 'Quantity' ), 'max' => 20 )
				),
				array(
					'name' => 'Headsets',
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'headset_textbox' ), 'label' => array( 'Quantity' ), 'max' => 20 )
				),
				array(
					'name' => 'Clickers',
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'clicker_textbox' ), 'label' => array( 'Quantity' ), 'max' => 25 )
				),
				array(
					'name' => 'Audience Computer Setup',
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'virtual_textbox_website', self::$prefix . 'virtual_textbox_login', self::$prefix . 'virtual_textbox_password'  ), 'label' => array( 'Initial website:', 'Login:', 'Password:' ) )
				)
			),
            'notes' => self::$prefix . 'misc_computer_notes',
            'notes_label' => 'Audience Computer Notes:',
            'notes_warning' => 'Please note any additional setup requirements, including what software must be installed'
		);

		self::$conference_misc = array(
            'name' => 'Digitalization and Communication Requirements',
            'video_capture' => array(
					'name' => 'UBC Video Capture (recording):',
					'description' => 'Conference will be recorded',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'video_capture_checkbox' ),
				),
			'options' => array(
				array(
					'name' => 'Live Streaming:',
					'description' => 'Conference will be streamed to a live audience',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'live_stream_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'live_stream_textbox' ), 'label' => array( 'URL:' ) ) 
				),
				array(
					'name' => 'Video Conference:',
					'description' => 'Will this conference be at least partially a video conference?',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'video_conference_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'video_conference_textbox_ip', self::$prefix . 'video_conference_textbox_number' ), 'label' => array( 'IP Address:', 'Contact Number:' ) )
				),
				array(
					'name' => 'Phone Conference:',
					'description' => 'Will this conference have participants over the phone?',
					'checkbox' => array( 'type' => 'checkbox', 'id' => self::$prefix . 'phone_conference_checkbox' ),
					'textbox' => array( 'type' => 'text', 'id' => array( self::$prefix . 'phone_conference_textbox_phone', self::$prefix . 'phone_conference_textbox_teleconference', self::$prefix . 'phone_conference_textbox_access_code' ), 'label' => array( 'Phone Number:', 'Conference Number:', 'Access Code:' ) )
				)
			),
            'notes' => self::$prefix . 'digitization_notes',
            'notes_label' => 'Digitization and Communication Notes:'
		);
	}

    /*
    * additional_requirements function
    * Builds the A/V and computer requirements meta box
    */
	public function additional_requirements() {
		?>
		<div id="event-additional-requirements" class="postbox">
			<div class="handlediv" title="Click to toggle"><br>
			</div>
			<h3 class="hndle"> <span>
				A/V and Computer Requirements
				</span> </h3>
			<div class="inside">
				<?php echo $this->nonce_input( 'additional_requirements_noncename' ); ?>
                <h4><?php echo self::$presenter_equipment['name']; ?></h4>
				<?php $this->the_computers(); ?>
				<?php $this->the_equipment(); ?>
                <h4><?php echo self::$misc_computer_stuff['name']; ?></h4>
				<?php $this->the_misc_computer_stuff(); ?>
				<h4><?php echo self::$conference_misc['name']; ?></h4>
				<?php $this->the_conference_misc(); ?>
			</div>
		</div>
		<?php
	}
    
    
    /*
    * the_computers function
    * builds the equipment section of the A/V and computer requirements meta box
    */
	public function the_computers() {
		?>
        <div class="ctlt-text-block">
            <div class="ctlt-left">
                <?php $checked = isset( self::$presenter_equipment['id'] ) ? self::$data[self::$presenter_equipment['id']] : ''; ?>
                <label for="<?php echo self::$presenter_equipment['id']; ?>"><?php echo self::$presenter_equipment['checkbox_label']; ?></label><br />
                <input type="<?php echo self::$presenter_equipment['type']; ?>" name="<?php echo self::$presenter_equipment['id']; ?>" id="<?php echo self::$presenter_equipment['id']; ?>" <?php checked( $checked, 'yes' ); ?>>
            </div>
        <div class="ctlt-left">
            <label><?php echo self::$presenter_equipment['projectors']['name']; ?></label><br />
            <?php $select = isset( self::$presenter_equipment['projectors']['textbox']['id'] ) ? self::$data[self::$presenter_equipment['projectors']['textbox']['id']] : 'none'; ?>
                <select name="<?php echo self::$presenter_equipment['projectors']['textbox']['id']; ?>" id="<?php echo self::$presenter_equipment['projectors']['textbox']['id']; ?>">
                    <option <?php selected( $select, 'none' ); ?>>none</option>
                <?php for( $j = 1; $j <= self::$presenter_equipment['projectors']['textbox']['max']; $j++ ) { ?>
                    <option <?php selected( $select, $j ); ?>><?php echo $j; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="ctlt-left">
            <?php $checked = isset( self::$presenter_equipment['speakers']['checkbox']['id'] ) ? self::$data[self::$presenter_equipment['speakers']['checkbox']['id']] : ''; ?>
            <label for="<?php echo self::$presenter_equipment['speakers']['checkbox']['id']; ?>"><?php echo self::$presenter_equipment['speakers']['name']; ?></label><br />
            <input type="<?php echo self::$presenter_equipment['speakers']['checkbox']['type'] ?>" name="<?php echo self::$presenter_equipment['speakers']['checkbox']['id']; ?>" id="<?php echo self::$presenter_equipment['speakers']['checkbox']['id']; ?>" <?php checked( $checked, 'yes' ); ?>>
        </div>
        </div>
        <div class="ctlt-inline">
			<label for="<?php echo self::$cables['id']; ?>"><?php echo self::$cables['name']; ?></label><br />
            <?php foreach( self::$cables['options'] as $option ) { ?>
                <?php $checked = isset( self::$data[self::$cables['id']] ) && self::$data[self::$cables['id']] == $option['value'] ? 'yes' : empty( self::$data[self::$presenter_equipment['id']] ) && strtolower( $option['value'] ) === 'none' ? 'yes' : 'no'; ?>
                <label for="<?php echo $option['value']; ?>">
                <div class="ctlt-option-box ctlt-computer-setup-option-box">
                    <?php echo !empty( $img_src ) ? $img_tag : '' ?>
                        <?php echo $option['name']; ?>
                    <br /><input type="<?php echo self::$cables['type']; ?>" name="<?php echo self::$cables['id']?>" value="<?php echo $option['value']; ?>" <?php echo checked( $checked, 'yes' );?> id="<?php echo $option['value']; ?>"/>
                </div>
                </label>
            <?php } ?>
        </div>
        <?php
	}

    /*
    * the_misc_computer_stuff function
    * builds the computer section of the A/V and computer requirements meta box
    */
	public function the_misc_computer_stuff() {
        ?>
        <div class="ctlt-text-block">
		<?php foreach( self::$misc_computer_stuff['options'] as $option ) { ?>
			<?php $checked = isset( self::$data[$option['textbox']['id']] ) ? esc_attr( self::$data[$option['textbox']['id']] ) : ''; ?>
			<div class="ctlt-left">
				<label><?php echo $option['name']; ?></label><br />
                <?php for( $i = 0; $i < count( $option['textbox']['id'] ); $i++ ) { ?>
                    <?php $value = isset( self::$data[$option['textbox']['id'][$i]] ) ? esc_attr( self::$data[$option['textbox']['id'][$i]] ) : ''; ?>
                        <div class="ctlt-inline">
                            <label><?php echo $option['textbox']['label'][$i]; ?></label>
                            <input type="<?php echo $option['textbox']['type']; ?>" size="8" name="<?php echo $option['textbox']['id'][$i]; ?>" id="<?php echo $option['textbox']['id'][$i]; ?>" value="<?php echo $value; ?>">
                        </div>
                <?php } ?>
			</div>
		<?php } ?>
        </div>
        <div class="ctlt-text-block">
        <?php $text = isset( self::$data[self::$misc_computer_stuff['notes']] ) ? self::$data[self::$misc_computer_stuff['notes']] : ''; ?>
            <label><?php echo self::$misc_computer_stuff['notes_label']; ?></label><br />
            <?php echo self::$misc_computer_stuff['notes_warning']; ?><br />
            <textarea class="ctlt-full-width" rows="2" name="<?php echo self::$misc_computer_stuff['notes'] ?>" id="<?php echo self::$misc_computer_stuff['notes'] ?>"><?php echo $text; ?></textarea>
        </div>
        <hr />
	<?php }

    /*
    * the_equipment function
    * builds the minor equipment checkboxes fields
    */
	public function the_equipment() {
		?>
		<div class="ctlt-inline">
		<?php foreach( self::$equipment['options'] as $option ) { ?>
			<?php $checked = isset( self::$data[$option['id']] ) ? esc_attr( self::$data[$option['id']] ) : '';?>
            <div class="ctlt-left">
            <label for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></label><br />
            <input type="<?php echo self::$equipment['type']; ?>" name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" <?php checked( $checked, 'yes' ); ?>>
            </div>
		<?php } ?>
		</div>
        <div class="ctlt-text-block">
            <?php $text = isset( self::$data[self::$presenter_equipment['notes']] ) ? self::$data[self::$presenter_equipment['notes']] : ''; ?>
            <label><?php echo self::$presenter_equipment['notes_label']; ?></label><br />
            <textarea class="ctlt-full-width" rows="2" name="<?php echo self::$presenter_equipment['notes'] ?>" id="<?php echo self::$presenter_equipment['notes'] ?>"><?php echo $text; ?></textarea>
        </div>
        <hr />
    <?php
    }

    /*
    * the_conference_misc function
    * builds the IT Services/Support section of the A/V and Computer Requirements
    * meta box
    */
	public function the_conference_misc() {
		$checked = isset( self::$data[self::$conference_misc['video_capture']['checkbox']['id']] ) ? self::$data[self::$conference_misc['video_capture']['checkbox']['id']] : ''; ?>
        <label for="<?php echo self::$conference_misc['video_capture']['checkbox']['id']; ?>"><?php echo self::$conference_misc['video_capture']['name']; ?></label><br />
        <input type="checkbox" name="<?php echo self::$conference_misc['video_capture']['checkbox']['id']; ?>" id="<?php echo self::$conference_misc['video']['checkbox']['id']; ?>" <?php checked( $checked, 'yes' ); ?>>
		<?php foreach( self::$conference_misc['options'] as $option ) { ?>
		<div class="ctlt-text-block">
			<label><?php echo $option['name']; ?></label><br />
				<?php for( $i = 0; $i < count( $option['textbox']['id'] ); $i++ ) { ?>
					<?php $value = isset( self::$data[$option['textbox']['id'][$i]] ) ? esc_attr( self::$data[$option['textbox']['id'][$i]] ) : ''; ?>
                    <div class="ctlt-inline">
                        <label for="<?php echo $option['textbox']['id'][$i]; ?>"><?php echo $option['textbox']['label'][$i]; ?></label>
                        <input type="<?php echo $option['textbox']['type']; ?>" name="<?php echo $option['textbox']['id'][$i]; ?>" size="8" id="<?php echo $option['textbox']['id'][$i]; ?>" value="<?php echo $value; ?>">
                    </div>
				<?php } ?>
		</div>
		<?php } ?>
        <div class="ctlt-text-block">
            <?php $text = isset( self::$data[self::$conference_misc['notes']] ) ? self::$data[self::$conference_misc['notes']] : ''; ?>
            <label><?php echo self::$conference_misc['notes_label']; ?></label><br />
            <textarea class="ctlt-full-width" rows="2" name="<?php echo self::$conference_misc['notes'] ?>" id="<?php echo self::$conference_misc['notes'] ?>"><?php echo $text; ?></textarea>
        </div>
        <?php
    }
}

new CTLT_Espresso_Additional_Requirements();
