<?php

class CTLT_Espresso_Room_Setup extends CTLT_Espresso_Metaboxes {
	
	static $rooms = null;

	public function __construct() {
		$this->init_assets();
		add_action( $this->hook_name, array( $this, 'room_setup' ) );
	}

	/**
	 * init_assets function
	 * This function sets the form fields and their ids
	 * Provides an easy place to change any option ids
	 */
	public function init_assets() {
		self::$rooms = array(
			'name' => 'Room Setup Style:',
			'id' => $this->prefix . 'room_setup',
			'type' => 'radio',
			'options' => array(
				array( 'name' => 'Hollow Square', 'value' => 'hollow-square', 'image' => 'hollow-square.png', 'alt' => 'Hollow Square' ),
				array( 'name' => 'Classroom Style', 'value' => 'classroom-style', 'image' => 'classroom-style.png', 'alt' => 'Classroom Style' ),
				array( 'name' => 'Conference Style', 'value' => 'conference-style', 'image' => 'conference-style.png', 'alt' => 'Conference Style' ),
				array( 'name' => 'Circle of Chairs', 'value' => 'circle-of-chairs', 'image' => 'circle-of-chairs.png', 'alt' => 'Circle of Chairs' ),
				array( 'name' => 'Theater Style', 'value' => 'theater-style', 'image' => 'theater-style.png', 'alt' => 'Theater Style' ),
				array( 'name' => 'U-Shaped Style', 'value' => 'u-shaped-style', 'image' => 'u-shaped-style.png', 'alt' => 'U-Shaped Style' ),
				array( 'name' => 'Seminar Style', 'value' => 'seminar-style', 'image' => 'seminar-style.png', 'alt' => 'Seminar Style' ),
				array( 'name' => 'Alternate Open Space (no tables and chairs)', 'value' => 'alternate-open-space', 'image' => null, 'alt' => 'Alternate Open Space' ),
				array( 'name' => 'Open Space (tables and chairs stacked to the side)', 'value' => 'open-space', 'image' => null, 'alt' => 'Open Space' )
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
					<?php //$checked = $meta == $option['value'] ? ' checked="checked"' : ''; ?>
					<?php $img_tag = '<img src="' . $img_src . '" class="image-clip" alt="' . $option['alt'] . '" />'; ?>
					<?php echo !empty( $img_src ) ? $img_tag : '<div class="image-clip ctlt-inline">' . $option['alt'] . '</div>'; ?>
					<label class="ctlt-align-mid">
						<input type="<?php echo self::$rooms['type']; ?>" name="<?php echo self::$rooms['id']?>" value="<?php echo $option['value']; ?>" <?php //echo $checked;?> /> <?php echo $option['name']; ?>
					</label>
				</div>
			<?php echo $count % 3 === 1 ? '</div>' : ''; ?>
			<?php $count -= 1; ?>
		<?php }
	}

}

new CTLT_Espresso_Room_Setup();