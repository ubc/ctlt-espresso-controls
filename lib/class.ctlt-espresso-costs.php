<?php

class CTLT_Espresso_Costs extends CTLT_Espresso_Metaboxes {
	
	static $costs_arr = null;

	public function __construct() {
		$this->init_default_assets();
		add_action( 'add_meta_boxes_' . $this->espresso_slug, array( $this, 'costs_metabox' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	public function init_default_assets() {
		self::$costs_arr = array(
			'name' => 'Costs',
			'id' => $this->prefix . 'costs',
			'type' => 'text',
			'options' => array(
				array( 'name' => 'Facilitator Pay (Total)', 'id' => $this->prefix . 'facilitator-pay' ),
				array( 'name' => 'TA Pay (Total)', 'id' => $this->prefix . 'ta-pay' ),
				array( 'name' => 'Room Cost', 'id' => $this->prefix . 'room-cost' ),
				array( 'name' => 'Ad Cost', 'id' => $this->prefix . 'ad-cost' ),
				array( 'name' => 'Food Cost', 'id' => $this->prefix . 'food-cost' ),
				array( 'name' => 'Other Cost', 'id' => $this->prefix . 'other-cost' )
			)
		);
	}

	public function costs_metabox() {
		add_meta_box(
			'ctlt_espresso_costs',
			'Costs',
			array( $this, 'render_costs' ),
			$this->espresso_slug,
			'normal',
			'high'
		);
	}

	public function render_costs() {
		global $post;
		echo '<input type="hidden" name="' . $this->prefix . 'costs_noncename" value="' . wp_create_nonce( CTLT_ESPRESSO_CONTROLS_BASENAME ) . '" />';
		$meta = get_post_custom( $post->ID );
		//var_dump( $meta );
		$this->costs( $meta );
	}

	public function costs( $meta ) {
		//$count = count( self::$costs_arr['options'] ) * 2;
		foreach( self::$costs_arr['options'] as $option ) { 
			$value = isset( $meta[$option['id']] ) ? esc_attr( $meta[$option['id']][0] ) : '';
			//echo $count % 4 === 0 ? '<div class="ctlt-events-row">' : ''; ?>
			<div class="ctlt-events-row">
				<div class="ctlt-colspan-3 ctlt-events-col">
					<label for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></label>
				</div>
				<div class="ctlt-colspan-3 ctlt-events-col currency-prepend">
					<!--<span class="currency">$</span>-->
					<input name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" type="text" value="<?php echo $value; ?>">
				</div>
			</div>
			<?php //echo $count % 4 === 1 ? '</div>' : '';
			$count -= 1;
		}
	}

	public function save( $post_id ) {
		
		// verify the nonce
		if( !wp_verify_nonce($_POST[$this->prefix .'costs_noncename'], CTLT_ESPRESSO_CONTROLS_BASENAME) ) {
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
		foreach( self::$costs_arr['options'] as $option ) {
			if( isset( $_POST[$option['id']] ) ) {
				$this->create_post_meta_fields( $option['id'], strip_tags( $_POST[$option['id']] ) );
				update_post_meta( $post_id, $option['id'], strip_tags( $_POST[$option['id']] ) );
			}
		}
		
	}

}

new CTLT_Espresso_Costs();