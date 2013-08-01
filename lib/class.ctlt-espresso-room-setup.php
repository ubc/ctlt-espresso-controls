<?php

// TODO: style the metabox content

class CTLT_Espresso_Room_Setup extends CTLT_Espresso_Metaboxes {
	
	public function __construct() {
		add_action( 'admin_init', array( $this, 'init_assets' ) );
		add_action( 'add_meta_boxes', array( $this, 'room_setup_metabox' ) );
	}

	public function init_assets() {

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
		$this->rooms();
	}

	public function rooms() {
		?>
		<div class="ctlt-espresso-row">
			<div class="room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'hollow-sqaure.png';?>" alt="Hollow Square" />
				<input type="radio" name="room-setup-radios" id="room-setup-radios-1" value="Hollow Sqaure"> Hollow Sqaure
			</div>
			<div class="room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'classroom-style.png';?>" alt="Classroom Style" />
				<input type="radio" name="room-setup-radios" id="room-setup-radios-2" value="Classroom Style"> Classroom Style
			</div>
			<div class="room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'conference-style.png';?>" alt="Conference Style" />
				<input type="radio" name="room-setup-radios" id="room-setup-radios-3" value="Conference Style"> Conference Style
			</div>
		</div>
		<div class="ctlt-espresso-row">
			<div class="room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'circle-of-chairs.png';?>" alt="Circle of Chairs" />
				<input type="radio" name="room-setup-radios" id="room-setup-radios-4" value="Circle of Chairs"> Circle of Chairs
			</div>
			<div class="room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'theater-style.png';?>" alt="Theater Style" />
				<input type="radio" name="room-setup-radios" id="room-setup-radios-5" value="Theater Style"> Theater Style
			</div>
			<div class="room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'u-shaped-style.png';?>" alt="U-Shaped Style" />
				<input type="radio" name="room-setup-radios" id="room-setup-radios-6" value="U-Shaped Style"> U-Shaped Style
			</div>
		</div>
		<div class="ctlt-espresso-row">
			<div class="room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'seminar-style.png';?>" alt="Seminar Style" />
				<input type="radio" name="room-setup-radios" id="room-setup-radios-7" value="Seminar Style"> Seminar Style
			</div>
			<div class="room-setup">
				<img src="" alt="Open Space" />
				<input type="radio" name="room-setup-radios" id="room-setup-radios-8" value="Open Space"> Open Space
			</div>
			<div class="room-setup">
				<img src="" alt="Custom Arrangement" />
				<input type="radio" name="room-setup-radios" id="room-setup-radios-9" value="Custom Arrangement"> Custom Arrangement
			</div>
		</div>
		<?php
	}

}

new CTLT_Espresso_Room_Setup();