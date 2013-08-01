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
		<div class="row-fluid">
			<div class="span4 room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'hollow-sqaure.png';?>" class="img-polaroid image-clip" alt="Hollow Square" />
				<label class="radio inline">
					<input type="radio" name="room-setup-radios" id="room-setup-radios-1" value="Hollow Sqaure"> Hollow Sqaure
				</label>
			</div>
			<div class="span4 room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'classroom-style.png';?>" class="img-polaroid image-clip" alt="Classroom Style" />
				<label class="radio inline">
					<input type="radio" name="room-setup-radios" id="room-setup-radios-2" value="Classroom Style"> Classroom Style
				</label>
			</div>
			<div class="span4 room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'conference-style.png';?>" class="img-polaroid image-clip" alt="Conference Style" />
				<label class="radio inline">
					<input type="radio" name="room-setup-radios" id="room-setup-radios-3" value="Conference Style"> Conference Style
				</label>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span4 room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'circle-of-chairs.png';?>" class="img-polaroid image-clip" alt="Circle of Chairs" />
				<label class="radio inline">
					<input type="radio" name="room-setup-radios" id="room-setup-radios-4" value="Circle of Chairs"> Circle of Chairs
				</label>
			</div>
			<div class="span4 room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'theater-style.png';?>" class="img-polaroid image-clip" alt="Theater Style" />
				<label class="radio inline">
					<input type="radio" name="room-setup-radios" id="room-setup-radios-5" value="Theater Style"> Theater Style
				</label>
			</div>
			<div class="span4 room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'u-shaped-style.png';?>" class="img-polaroid image-clip" alt="U-Shaped Style" />
				<label class="radio inline">
					<input type="radio" name="room-setup-radios" id="room-setup-radios-6" value="U-Shaped Style"> U-Shaped Style
				</label>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span4 room-setup">
				<img src="<?php echo CTLT_ESPRESSO_CONTROLS_ASSETS_URL . 'seminar-style.png';?>" class="img-polaroid image-clip" alt="Seminar Style" />
				<label class="radio inline">
					<input type="radio" name="room-setup-radios" id="room-setup-radios-7" value="Seminar Style"> Seminar Style
				</label>
			</div>
			<div class="span4 room-setup">
				<img src="" class="img-polaroid image-clip" alt="Open Space" />
				<label class="radio inline">
					<input type="radio" name="room-setup-radios" id="room-setup-radios-8" value="Open Space"> Open Space
				</label>
			</div>
			<div class="span4 room-setup">
				<img src="" class="img-polaroid image-clip" alt="Custom Arrangement" />
				<label class="radio inline">
					<input type="radio" name="room-setup-radios" id="room-setup-radios-9" value="Custom Arrangement"> Custom Arrangement
				</label>
			</div>
		</div>
		<?php
	}

}

new CTLT_Espresso_Room_Setup();