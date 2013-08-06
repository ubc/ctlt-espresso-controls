<?php

// TODO: add an upload field for custom arrangement

class CTLT_Espresso_Room_Setup extends CTLT_Espresso_Metaboxes {

	static $rooms = null;
	
	public function __construct() {
		$this->init_assets();
		add_action( 'add_meta_boxes_' . $this->espresso_slug, array( $this, 'room_setup_metabox' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function init_assets() {
		self::$rooms = array(
			'name' => 'Room Setup Style:',
			'id' => $this->prefix . 'room_setup',
			'type' => 'radio',
			'options' => array(
				array( 'name' => 'Hollow Square', 'value' => 'hollow-square', 'image' => 'hollow-square.png' ),
				array( 'name' => 'Classroom Style', 'value' => 'classroom-style', 'image' => 'classroom-style.png' ),
				array( 'name' => 'Conference Style', 'value' => 'conference-style', 'image' => 'conference-style.png' ),
				array( 'name' => 'Circle of Chairs', 'value' => 'circle-of-chairs', 'image' => 'circle-of-chairs.png' ),
				array( 'name' => 'Theater Style', 'value' => 'theater-style', 'image' => 'theater-style.png' ),
				array( 'name' => 'U-Shaped Style', 'value' => 'u-shaped-style', 'image' => 'u-shaped-style.png' ),
				array( 'name' => 'Seminar Style', 'value' => 'seminar-style', 'image' => 'seminar-style.png' ),
				array( 'name' => 'Alternate Open Space (no tables and chairs)', 'value' => 'alternate-open-space', 'image' => null ),
				array( 'name' => 'Open Space (tables and chairs stacked to the side)', 'value' => 'open-space', 'image' => null )
			)
		);
	}

	public function room_setup_metabox() {
		add_meta_box(
			'ctlt_espresso_room_setup',
			'Room Setup',
			array( $this, 'render_room_setup' ),
			$this->espresso_slug,
			'normal',
			'high'
		);
	}

	public function render_room_setup() {
		global $post;
		echo '<input type="hidden" name="' . $this->prefix . 'roomsetup_noncename" value="' . wp_create_nonce( CTLT_ESPRESSO_CONTROLS_BASENAME ) . '" />';
		$meta = get_post_meta( $post->ID, self::$rooms['id'], true );
		$this->rooms( $meta );
	}

	public function rooms( $meta ) {
		$count = count( self::$rooms['options'] ); ?>
		<label class="ctlt-colspan-12 ctlt-events-col ctlt-hidden" for="<?php echo self::$rooms['id'] ?>"><?php echo self::$rooms['name']; ?></label>
		<?php foreach( self::$rooms['options'] as $option ) { ?>
			<?php echo $count % 3 === 0 ? '<div class="ctlt-events-row">' : ''; ?>
				<div class="ctlt-colspan-4 ctlt-events-col room-setup">
					<?php $img_src = !empty( $option['image'] ) ? CTLT_ESPRESSO_CONTROLS_ASSETS_URL . $option['image'] : '';?>
					<?php $checked = $meta == $option['value'] ? ' checked="checked"' : ''; ?>
					<img src="<?php echo $img_src; ?>" class="image-clip" alt="<?php echo $option['name']; ?>" />
					<label class="ctlt-align-mid">
						<input type="<?php echo self::$rooms['type']; ?>" name="<?php echo self::$rooms['id']?>" value="<?php echo $option['value']; ?>" <?php echo $checked;?> /> <?php echo $option['name']; ?>
					</label>
				</div>
			<?php echo $count % 3 === 1 ? '</div>' : ''; ?>
			<?php $count -= 1; ?>
		<?php }
	}

	public function save( $post_id ) {
		
		// verify the nonce
		if( !wp_verify_nonce($_POST[$this->prefix .'roomsetup_noncename'], CTLT_ESPRESSO_CONTROLS_BASENAME) ) {
			return $post_id;
		}
		// check autosave
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		// check permissions
		if( 'page' == $_POST['post_type'] ) {
			if( !current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		}
		elseif( !current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		// do the actual saving here
		$old_post_meta = get_post_meta( $post_id, self::$rooms['id'], true );
		$new_post_meta = $_POST[self::$rooms['id']];
		if( $new_post_meta && $new_post_meta != $old_post_meta ) {
			$this->create_post_meta_fields( self::$rooms['id'], $new_post_meta );
			update_post_meta( $post_id, self::$rooms['id'], $new_post_meta );
		}
		elseif( '' == $new_post_meta && $old_post_meta ) {
			delete_post_meta( $post_id, self::$rooms['id'], $old_post_meta );
		}
		
	}

}

new CTLT_Espresso_Room_Setup();