<?php

class CTLT_Espresso_Room_Setup extends CTLT_Espresso_Metaboxes {
	
    // array to hold room setup information
	static $rooms = null;

	public function __construct() {
		$this->init_assets();
		add_action( $this->add_hook, array( $this, 'room_setup' ) );
		add_action( $this->edit_hook, array( $this, 'room_setup' ) );
	}

	/**
	 * init_assets function
	 * This function sets the form fields and their ids
	 * Provides an easy place to change any option ids
	 */
	public function init_assets() {
		self::$rooms = array(
			'name' => 'Room Setup Style:',
			'id' => self::$prefix . 'room_setup',
			'type' => 'radio',
			'options' => array(
                array( 'name' => 'As Is (No Changes)', 'value' => 'As Is', 'image' => null, 'alt' => 'As Is (No Changes)' ),
				array( 'name' => 'Hollow Square', 'value' => 'Hollow Square', 'image' => 'hollow-square.png', 'alt' => 'Hollow Square' ),
				array( 'name' => 'Classroom Style', 'value' => 'Classroom Style', 'image' => 'classroom-style.png', 'alt' => 'Classroom Style' ),
				array( 'name' => 'Conference Style', 'value' => 'Conference Style', 'image' => 'conference-style.png', 'alt' => 'Conference Style' ),
				array( 'name' => 'Circle of Chairs', 'value' => 'Circle of Chairs', 'image' => 'circle-of-chairs.png', 'alt' => 'Circle of Chairs' ),
				array( 'name' => 'Theater Style', 'value' => 'Theater Style', 'image' => 'theater-style.png', 'alt' => 'Theater Style' ),
				array( 'name' => 'U-Shaped Style', 'value' => 'U-Shaped Style', 'image' => 'u-shaped-style.png', 'alt' => 'U-Shaped Style' ),
				array( 'name' => 'Seminar Style', 'value' => 'Seminar Style', 'image' => 'seminar-style.png', 'alt' => 'Seminar Style' ),
				array( 'name' => 'Alternate Open Space (no tables and chairs)', 'value' => 'Alternate Open Space', 'image' => null, 'alt' => 'Alternate Open Space' ),
				array( 'name' => 'Open Space (tables and chairs stacked to the side)', 'value' => 'Open Space', 'image' => null, 'alt' => 'Open Space' )
			),
            'notes' => self::$prefix . 'room_setup_notes',
            'chairs' => self::$prefix . 'room_setup_chairs',
            'tables' => self::$prefix . 'room_setup_tables'
		);
	}

	/**
	 * room_setup function
	 * This function creates the wrapper for the room setup styles
	 */
	public function room_setup() {
		?>
		<div id="event-room-setup" class="postbox">
			<div class="handlediv" title="Click to toggle"><br>
			</div>
			<h3 class="hndle"> <span>
				Room Setup
				</span> </h3>
			<div class="inside">
				<?php echo $this->nonce_input( 'room_setup_noncename' ); ?>
				<?php $this->the_room_styles(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * the_room_styles function
	 * This function creates each of the individual room styles
	 */
	public function the_room_styles() { ?>
		        <div class="ctlt-left">
        <p>
            <?php $value = isset( self::$data[self::$rooms['chairs']] ) ? esc_attr( self::$data[self::$rooms['chairs']] ) : '0'; ?>
            <label for="<?php echo self::$rooms['chairs']; ?>">Number of chairs:</label><br />
            <input type="number" id="<?php echo self::$rooms['chairs']; ?>" name="<?php echo self::$rooms['chairs']; ?>" style="width:50px" value="<?php echo $value; ?>">
        </p>
        </div>
        <div class="ctlt-left">
        <p>
            <?php $value = isset( self::$data[self::$rooms['tables']] ) ? esc_attr( self::$data[self::$rooms['tables']] ) : '0'; ?>
            <label for="<?php echo self::$rooms['tables']; ?>">Number of tables:</label><br />
            <input type="number" id="<?php echo self::$rooms['tables']; ?>" name="<?php echo self::$rooms['tables']; ?>" style="width:50px" value="<?php echo $value; ?>">
        </p>
        </div>
        <div class="ctlt-inline">
        <label>Arrangement:</label><br />
		<?php foreach( self::$rooms['options'] as $option ) { ?>

            <?php $img_src = !empty( $option['image'] ) ? CTLT_ESPRESSO_CONTROLS_ASSETS_URL . $option['image'] : '';?>
            <?php $checked = isset( self::$data[self::$rooms['id']] ) && self::$data[self::$rooms['id']] == $option['value'] ? 'yes' : empty( self::$data[self::$rooms['id']] ) && strtolower( $option['value'] ) === 'as is' ? 'yes' : 'no'; ?>
            <?php $img_tag = '<img src="' . $img_src . '" class="image-clip" alt="' . $option['alt'] . '" /><br />'; ?>

            <label for="<?php echo $option['value']; ?>">
            <div class="ctlt-option-box ctlt-room-setup-option-box">
            <?php echo !empty( $img_src ) ? $img_tag : '' ?>
                <?php echo $option['name']; ?>
            <br /><input type="<?php echo self::$rooms['type']; ?>" name="<?php echo self::$rooms['id']?>" value="<?php echo $option['value']; ?>" <?php echo checked( $checked, 'yes' );?> id="<?php echo $option['value']; ?>"/>
            </div>
            </label>
		<?php } ?>
        </div>
        <?php $text = isset( self::$data[self::$rooms['notes']] ) ? self::$data[self::$rooms['notes']] : ''; ?>
        <div class="ctlt-espresso-controls-textarea">
        <label>Additional Room Setup Notes:</label><br />
        <textarea class="ctlt-full-width" rows="2" name="<?php echo self::$rooms['notes'] ?>" id="<?php echo self::$rooms['notes'] ?>"><?php echo $text; ?></textarea>
        </div>
	<?php }
    
}

new CTLT_Espresso_Room_Setup();