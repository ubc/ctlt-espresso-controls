<?php

class CTLT_Espresso_Costs extends CTLT_Espresso_Metaboxes {
	
	static $costs_arr = null;

	public function __construct() {
		$this->init_default_assets();
		add_action( $this->hook_name, array( $this, 'costs' ) );
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

	public function costs() {
		?>
		<div id="event-costs" class="postbox">
			<div class="handlediv" title="Click to toggle"><br />
			</div>
			<h3 class="hndle"> <span>
				Costs
			</span> </h3>
			<div class="inside">
				<?php $this->the_number_boxes(); ?>
			</div>
		</div>
		<?php
	}

	public function the_number_boxes() {
		foreach( self::$costs_arr['options'] as $option ) { 
			//$value = isset( $meta[$option['id']] ) ? esc_attr( $meta[$option['id']][0] ) : '';
			//echo $count % 4 === 0 ? '<div class="ctlt-events-row">' : ''; ?>
			<div class="ctlt-events-row">
				<div class="ctlt-colspan-3 ctlt-events-col">
					<label for="<?php echo $option['id']; ?>"><?php echo $option['name']; ?></label>
				</div>
				<div class="ctlt-colspan-3 ctlt-events-col ctlt-espresso-controls-currency-prepend">
					<span class="currency">$</span>
					<input name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" type="<?php echo self::$costs_arr['type']; ?>" value="<?php //echo $value; ?>">
				</div>
			</div>
			<?php //echo $count % 4 === 1 ? '</div>' : '';
			$count -= 1;
		}		
	}

}

new CTLT_Espresso_Costs();