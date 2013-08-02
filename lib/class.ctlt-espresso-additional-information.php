<?php

class CTLT_Espresso_Additional_Information extends CTLT_Espresso_Metaboxes{
	
	public function __construct() {
		add_action( 'add_meta_boxes_' . $this->espresso_slug, array( $this, 'additional_information_metabox' ) );
	}


	public function init_assets() {

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
		?>
		<div class="ctlt-events-row">
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label>Room Setup Notes:</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<textarea class="ctlt-colspan-12"></textarea>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label>Admin Support Notes</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<textarea class="ctlt-colspan-12"></textarea>
			</div>
		</div>
		<div class="ctlt-events-row">
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label>A/V and Computer Requirements:</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<textarea class="ctlt-colspan-12"></textarea>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label>Marketing & Communication Support Notes:</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<textarea class="ctlt-colspan-12"></textarea>
			</div>
		</div>
		<div class="ctlt-events-row">
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label>Catering Notes:</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<textarea class="ctlt-colspan-12"></textarea>
			</div>
		</div>
		<div class="ctlt-events-row">
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label>Need Help Setting Up the Room?</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label class="checkbox ctlt-inline">
					<input type="checkbox" id="help-setup-room" />
				</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label>I Would Like Signs Posted for My Event:</label>
			</div>
			<div class="ctlt-colspan-3 ctlt-events-col">
				<label class="checkbox ctlt-inline">
					<input type="checkbox" id="post-signs" />
				</label>
			</div>
		</div>
		<?php
	}


}

new CTLT_Espresso_Additional_Information();