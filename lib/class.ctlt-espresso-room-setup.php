<?php

class CTLT_Espresso_Room_Setup extends CTLT_Espresso_Metaboxes {
	
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
				array( 'name' => 'Hollow Square', 'value' => 'Hollow Square', 'image' => 'hollow-square.png', 'alt' => 'Hollow Square' ),
				array( 'name' => 'Classroom Style', 'value' => 'Classroom Style', 'image' => 'classroom-style.png', 'alt' => 'Classroom Style' ),
				array( 'name' => 'Conference Style', 'value' => 'Conference Style', 'image' => 'conference-style.png', 'alt' => 'Conference Style' ),
				array( 'name' => 'Circle of Chairs', 'value' => 'Circle of Chairs', 'image' => 'circle-of-chairs.png', 'alt' => 'Circle of Chairs' ),
				array( 'name' => 'Theater Style', 'value' => 'Theater Style', 'image' => 'theater-style.png', 'alt' => 'Theater Style' ),
				array( 'name' => 'U-Shaped Style', 'value' => 'U-Shaped Style', 'image' => 'u-shaped-style.png', 'alt' => 'U-Shaped Style' ),
				array( 'name' => 'Seminar Style', 'value' => 'Seminar Style', 'image' => 'seminar-style.png', 'alt' => 'Seminar Style' ),
				array( 'name' => 'Alternate Open Space (no tables and chairs)', 'value' => 'Alternate Open Space', 'image' => null, 'alt' => 'Alternate Open Space' ),
				array( 'name' => 'Open Space (tables and chairs stacked to the side)', 'value' => 'Open Space', 'image' => null, 'alt' => 'Open Space' )
			)
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
	public function the_room_styles() {
		$count = count( self::$rooms['options'] ); ?>
		<label class="ctlt-colspan-12 ctlt-events-col ctlt-hidden" for="<?php echo self::$rooms['id'] ?>"><?php echo self::$rooms['name']; ?></label>
		<?php foreach( self::$rooms['options'] as $option ) { ?>
			<?php echo $count % 3 === 0 ? '<div class="ctlt-events-row">' : ''; ?>
				<div class="ctlt-colspan-4 ctlt-events-col room-setup">
					<?php $img_src = !empty( $option['image'] ) ? CTLT_ESPRESSO_CONTROLS_ASSETS_URL . $option['image'] : '';?>
					<?php $checked = isset( self::$data[self::$rooms['id']] ) && self::$data[self::$rooms['id']] == $option['value'] ? 'yes' : empty( self::$data[self::$rooms['id']] ) && strtolower( $option['value'] ) === 'open space' ? 'yes' : 'no'; ?>
					<?php $img_tag = '<img src="' . $img_src . '" class="image-clip" alt="' . $option['alt'] . '" />'; ?>
					<?php echo !empty( $img_src ) ? $img_tag : '<div class="image-clip ctlt-inline">' . $option['alt'] . '</div>'; ?>
					<label class="ctlt-align-mid">
						<input type="<?php echo self::$rooms['type']; ?>" name="<?php echo self::$rooms['id']?>" value="<?php echo $option['value']; ?>" <?php echo checked( $checked, 'yes' );?> /> <?php echo $option['name']; ?>
					</label>
				</div>
			<?php echo $count % 3 === 1 ? '</div>' : ''; ?>
			<?php $count -= 1; ?>
		<?php }
	}

}

new CTLT_Espresso_Room_Setup();