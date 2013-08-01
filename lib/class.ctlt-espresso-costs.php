<?php

class CTLT_Espresso_Costs extends CTLT_Espresso_Metaboxes {
	

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'costs_metabox' ) );
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
		<div class="row-fluid">
			<div class="span3">
				<label>Facilitator Pay (Total)</label>
			</div>
			<div class="span3">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="span5" id="facilitator-cost" type="text">
				</div>
			</div>
			<div class="span3">
				<label>TA Pay (Total)</label>
			</div>
			<div class="span3">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="span5" id="ta-cost" type="text">
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span3">
				<label>Room Cost</label>
			</div>
			<div class="span3">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="span5" id="room-cost" type="text">
				</div>
			</div>
			<div class="span3">
				<label>Ad Cost</label>
			</div>
			<div class="span3">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="span5" id="ad-cost" type="text">
				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span3">
				<label>Food Cost</label>
			</div>
			<div class="span3">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="span5" id="food-cost" type="text">
				</div>
			</div>
			<div class="span3">
				<label>Other Cost</label>
			</div>
			<div class="span3">
				<div class="input-prepend">
					<span class="add-on">$</span>
					<input class="span5" id="other-cost" type="text">
				</div>
			</div>
		</div>
		<?php
	}
}

new CTLT_Espresso_Costs();