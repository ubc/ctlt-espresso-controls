<?php

class CTLT_Espresso_Costs extends CTLT_Espresso_Metaboxes {
	
    // array to hold cost information
	static $costs_arr = null;

	public function __construct() {
		$this->init_default_assets();
		add_action( $this->add_hook, array( $this, 'costs' ) );
		add_action( $this->edit_hook, array( $this, 'costs' ) );
	}

	/**
	 * init_default_assets function
	 * This function sets the form fields and their ids
	 * Provides an easy place to change any option ids
	 */
	public function init_default_assets() {
		self::$costs_arr = array(
			'name' => 'Costs',
			'id' => self::$prefix . 'costs',
			'type' => 'text',
			'options' => array(
				array( 'name' => 'Facilitator Pay (Total)', 'id' => self::$prefix . 'facilitator_pay' ),
				array( 'name' => 'TA Pay (Total)', 'id' => self::$prefix . 'ta_pay' ),
				array( 'name' => 'Room Cost', 'id' => self::$prefix . 'room_cost' ),
				array( 'name' => 'Ad Cost', 'id' => self::$prefix . 'ad_cost' ),
				array( 'name' => 'Food Cost', 'id' => self::$prefix . 'food_cost' ),
				array( 'name' => 'Other Cost', 'id' => self::$prefix . 'other_cost' )
			)
		);
	}

	/**
	 * costs function
	 * This function creates the wrapper for the handout form fields
	 */
	public function costs() {
		?>
		<div id="event-costs" class="postbox">
			<div class="handlediv" title="Click to toggle"><br />
			</div>
			<h3 class="hndle"> <span>
				Estimated Costs
			</span> </h3>
			<div class="inside">
				<?php echo $this->nonce_input( 'costs_noncename' ); ?>
				<?php $this->the_number_boxes(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * the_number_boxes function
	 * This function renders the text boxes for the form
	 */
	public function the_number_boxes() {
		foreach( self::$costs_arr['options'] as $option ) { 
			$value = isset( self::$data[$option['id']] ) ? esc_attr( self::$data[$option['id']] ) : '';
			//echo $count % 4 === 0 ? '<div class="ctlt-events-row">' : ''; ?>
			<div class="ctlt-text-block">
                <label for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></label><br />
					$<input name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" type="<?php echo self::$costs_arr['type']; ?>" value="<?php echo $value; ?>">
			</div>
			<?php //echo $count % 4 === 1 ? '</div>' : '';
			//$count -= 1;
		}
	}

}

new CTLT_Espresso_Costs();