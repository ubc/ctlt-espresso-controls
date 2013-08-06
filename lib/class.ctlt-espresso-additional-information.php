<?php

class CTLT_Espresso_Additional_Information extends CTLT_Espresso_Metaboxes{
	
	static $add_info = null;
	static $checks = null;

	public function __construct() {
		$this->init_default_assets();
		add_action( 'add_meta_boxes_' . $this->espresso_slug, array( $this, 'additional_information_metabox' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}


	public function init_default_assets() {
		self::$add_info = array(
			'name' => 'Additional Information',
			'id' => $this->prefix . 'additional-information',
			'options' => array(
				array( 'name' => 'Room Setup Notes', 'id' => $this->prefix . 'room-setup-notes' ),
				array( 'name' => 'A/V and Computer Requirements', 'id' => $this->prefix . 'av-computer-requirements' ),
				array( 'name' => 'Admin Support Notes', 'id' => $this->prefix . 'admin-support-notes' ),
				array( 'name' => 'Marketing and Communication Support Notes', 'id' => $this->prefix . 'marketing-communication' ),
				array( 'name' => 'Catering Notes', 'id' => $this->prefix . 'catering-notes' )
			)
		);
		self::$checks = array(
			'name' => 'Event Misc',
			'id' => $this->prefix . 'event-misc',
			'type' => 'checkbox',
			'options' => array(
				array( 'name' => 'Room Setup Assistance', 'id' => $this->prefix . 'room-setup-assistance', 'checked' => 'off' ),
				array( 'name' => 'Signs for Event', 'id' => $this->prefix . 'signs-for-event', 'checked' => 'off' )
			)
		);
	}

	public function additional_information_metabox() {
		add_meta_box(
			'ctlt_espresso_additional_information',
			'Additional Information',
			array( $this, 'render_additional_information' ),
			$this->espresso_slug,
			'normal',
			'high'
		);
	}

	public function render_additional_information() {
		global $post;
		echo '<input type="hidden" name="' . $this->prefix . 'additional_information_noncename" value="' . wp_create_nonce( CTLT_ESPRESSO_CONTROLS_BASENAME ) . '" />';
		$meta = get_post_custom( $post->ID );
		$this->additional_information( $meta );
		$this->checkboxes( $meta );
	}

	public function additional_information( $meta ) {
		foreach( self::$add_info['options'] as $option ) {
			$text = isset( $meta[$option['id']] ) ? $meta[$option['id']][0] : '';
			?>
			<div class="ctlt-events-row additional-information-no-padding">
				<label class="ctlt-colspan-12 ctlt-events-col"for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?>:</label>
			<!--</div>
			<div class="ctlt-events-row">-->
				<textarea class="ctlt-colspan-12 ctlt-events-col ctlt-espresso-controls-textarea" name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" cols="40" rows="8"><?php echo $text; ?></textarea>
			</div>
			<?php
		}
	}

	public function checkboxes( $meta ) {
		echo '<div class="ctlt-events-row">';
		foreach( self::$checks['options'] as $option ) {
			$checked = isset( $meta[$option['id']] ) ? esc_attr( $meta[$option['id']][0] ) : '';
			?>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?>:</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<input type="<?php echo self::$checks['type']; ?>" name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" <?php checked( $checked, 'on' ); ?>>
			</div>
			<?php
		}
		echo '</div>';
	}

	public function save( $post_id ) {
		
		// verify the nonce
		if( !wp_verify_nonce($_POST[$this->prefix .'additional_information_noncename'], CTLT_ESPRESSO_CONTROLS_BASENAME) ) {
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
		// saving the values of the textareas
		foreach( self::$add_info['options'] as $option ) {
			if( isset( $_POST[$option['id']] ) ) {
				$this->create_post_meta_fields( $option['id'], $_POST[$option['id']] );
				update_post_meta( $post_id, $option['id'], $_POST[$option['id']] );
			}
		}
		// saving for the checkboxes
		foreach( self::$checks['options'] as $option ) {
			$confirm = isset( $_POST[$option['id']] ) && $_POST[$option['id']] ? 'on' : 'off';
			$this->create_post_meta_fields( $option['id'], $confirm );
			update_post_meta( $post_id, $option['id'], $confirm );
		}
		
	}

}

new CTLT_Espresso_Additional_Information();