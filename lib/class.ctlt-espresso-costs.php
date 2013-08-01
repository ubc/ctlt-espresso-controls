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
		<div class="ctlt-espresso-row">
			<div class=""
		</div>
		<?php
	}
}

new CTLT_Espresso_Costs();