<?php

class CTLT_Espresso_Handouts extends CTLT_Espresso_Metaboxes {
	
	static $radios_arr = null;

	public function __construct() {
		//add_action( 'plugins_loaded', array( $this, 'init_handouts_properties') );

		$this->init_handouts_properties();
		add_action( 'add_meta_boxes_' . $this->espresso_slug, array( $this, 'handouts_metabox' ) );
		//add_action( 'add_meta_boxes', array( $this, 'handouts_metabox' ) );
		add_action( 'save_post', array( $this, 'save' ) );
		//var_dump( self::$radios_arr );
	}

	public function init_handouts_properties() {

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
	}

	public function handouts_metabox() {
		add_meta_box(
			'ctlt_espresso_handouts',
			'Handouts',
			array( $this, 'render_handouts' ),
			$this->espresso_slug,
			'normal',
			'high'
		);
	}

	public function render_handouts() {
		global $post;
		echo '<input type="hidden" name="' . $this->prefix . 'handouts_noncename" value="' . wp_create_nonce( CTLT_ESPRESSO_CONTROLS_BASENAME ) . '" />';
		$meta = get_post_meta( $post->ID, self::$radios_arr['id'], true );
		$this->handouts_radio( $meta );
		$this->handout_upload( $meta );
	}

	public function handouts_radio( $meta ) {
		//global $post;
		?>
		<div class="ctlt-events-row">
			<div class="ctlt-span-12">
				<label class="ctlt-inline ctlt-span-4 ctlt-events-col" for="<?php echo self::$radios_arr['id']; ?>"><?php echo self::$radios_arr['name']; ?></label>
				<?php foreach( self::$radios_arr['options'] as $option ) { ?>
				<?php $checked = $meta == $option['value'] ? ' checked="checked"' : ''; ?>
				<label class="ctlt-inline ctlt-span-2 ctlt-events-col">
					<input type="<?php echo self::$radios_arr['type']; ?>" name="<?php echo self::$radios_arr['id']; ?>" value="<?php echo $option['value']; ?>" <?php echo $checked; ?> /> <?php echo $option['name']; ?>
				</label>
				<?php } ?>
			</div>
		</div>
		<?php
	}

	public function handout_upload( $meta ) {
		global $post;
		?>
		<div class="ctlt-events-row">
			<div class="ctlt-span-12">
				<label class="ctlt-span-4 ctlt-events-col" for="handout-upload">Handout File:</label>
				<input class="ctlt-span-6 ctlt-events-col" type="file" name="handout-upload" id="handout-upload" />
			</div>
		</div>
		<?php
	}

	public function save( $post_id ) {
		
		// verify the nonce
		if( !wp_verify_nonce($_POST[$this->prefix .'handouts_noncename'], CTLT_ESPRESSO_CONTROLS_BASENAME) ) {
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
		$old_post_meta = get_post_meta( $post_id, self::$radios_arr['id'], true );
		$new_post_meta = $_POST[self::$radios_arr['id']];
		if( $new_post_meta && $new_post_meta != $old_post_meta ) {
			update_post_meta( $post_id, self::$radios_arr['id'], $new_post_meta );
		}
		elseif( '' == $new_post_meta && $old_post_meta ) {
			delete_post_meta( $post_id, self::$radios_arr['id'], $old_post_meta );
		}
		
	}

}

new CTLT_Espresso_Handouts();