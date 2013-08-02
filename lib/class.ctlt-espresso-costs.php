<?php

class CTLT_Espresso_Costs extends CTLT_Espresso_Metaboxes {
	

	public function __construct() {
		add_action( 'add_meta_boxes_' . $this->espresso_slug, array( $this, 'costs_metabox' ) );
	}

	public function init_assets() {

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
		?>
		<div class="ctlt-events-row">
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label>Facilitator Pay (Total)</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="ctlt-colspan-5 ctlt-events-col" id="facilitator-cost" type="text">
				</div>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label>TA Pay (Total)</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="ctlt-colspan-5 ctlt-events-col" id="ta-cost" type="text">
				</div>
			</div>
		</div>
		<div class="ctlt-events-row">
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label>Room Cost</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="ctlt-colspan-5 ctlt-events-col" id="room-cost" type="text">
				</div>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label>Ad Cost</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="ctlt-colspan-5 ctlt-events-col" id="ad-cost" type="text">
				</div>
			</div>
		</div>
		<div class="ctlt-events-row">
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label>Food Cost</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="ctlt-colspan-5 ctlt-events-col" id="food-cost" type="text">
				</div>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label>Other Cost</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="ctlt-colspan-5 ctlt-events-col" id="other-cost" type="text">
				</div>
			</div>
		</div>
		<?php
	}
}

new CTLT_Espresso_Costs();