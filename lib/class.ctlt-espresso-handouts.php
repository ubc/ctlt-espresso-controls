<?php

class CTLT_Espresso_Handouts extends CTLT_Espresso_Metaboxes {
	
	static $radios_arr = null;
	static $handout_file = null;

	public function __construct() {
		//add_action( 'plugins_loaded', array( $this, 'init_handouts_properties') );

		$this->init_handouts_properties();
		add_action( 'add_meta_boxes_' . $this->espresso_slug, array( $this, 'handouts_metabox' ) );
		add_action( 'save_post', array( $this, 'save' ) );
		add_action( 'post_edit_form_tag', array( $this, 'update_edit_form' ) );
	}

	public function init_handouts_properties() {

		self::$radios_arr = array(
			'name' => 'Handouts:',
			'id' => $this->prefix . 'handouts_radio',
			'type' => 'radio',
			'options' => array(
				array( 'name' => 'N/A', 'value' => 'n/a' ),
				array( 'name' => 'Expected', 'value' => 'expected' ),
				array( 'name' => 'Received', 'value' => 'received' ),
				array( 'name' => 'Copying Complete', 'value' => 'copying-complete' )
			)
		);
		self::$handout_file = array(
			'name' => 'Handout File',
			'id' => $this->prefix . 'handout-upload',
			'type' => 'file'
		);
	}

	public function handouts_metabox() {
		add_meta_box(
			'ctlt_espresso_handouts',
			'Handouts',
			array( $this, 'render_handouts' ),
			$this->espresso_slug,
			'normal',
			'high'
		);
	}

	public function render_handouts() {
		global $post;
		echo '<input type="hidden" name="' . $this->prefix . 'handouts_noncename" value="' . wp_create_nonce( CTLT_ESPRESSO_CONTROLS_BASENAME ) . '" />';
		$meta = get_post_meta( $post->ID, self::$radios_arr['id'], true );
		$this->handouts_radio( $meta );
		$this->handout_upload( $meta );
	}

	public function handouts_radio( $meta ) {
		//global $post;
		?>
		<div class="ctlt-events-row">
			<div class="ctlt-span-12">
				<label class="ctlt-inline ctlt-span-4 ctlt-events-col" for="<?php echo self::$radios_arr['id']; ?>"><?php echo self::$radios_arr['name']; ?></label>
				<?php foreach( self::$radios_arr['options'] as $option ) { ?>
				<?php $checked = $meta == $option['value'] ? ' checked="checked"' : ''; ?>
				<label class="ctlt-inline ctlt-span-2 ctlt-events-col">
					<input type="<?php echo self::$radios_arr['type']; ?>" name="<?php echo self::$radios_arr['id']; ?>" value="<?php echo $option['value']; ?>" <?php echo $checked; ?> /> <?php echo $option['name']; ?>
				</label>
				<?php } ?>
			</div>
		</div>
		<?php
	}

	public function handout_upload( $meta ) {
		global $post;
		?>
		<div class="ctlt-events-row">
			<div class="ctlt-span-12">
				<label class="ctlt-span-4 ctlt-events-col" for="<?php echo self::$handout_file['id']; ?>"><?php echo self::$handout_file['name']; ?>:</label>
				<input class="ctlt-span-6 ctlt-events-col" type="<?php echo self::$handout_file['type']; ?>" name="<?php echo self::$handout_file['id']; ?>" id="<?php echo self::$handout_file['id']; ?>" />
				<?php $this->add_download_link( $post->ID ); ?>
			</div>
		</div>
		<?php
	}

	public function save( $post_id ) {
		
		// verify the nonce
		if( !wp_verify_nonce($_POST[$this->prefix .'handouts_noncename'], CTLT_ESPRESSO_CONTROLS_BASENAME) ) {
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

		// saving the radios
		$old_post_meta = get_post_meta( $post_id, self::$radios_arr['id'], true );
		$new_post_meta = $_POST[self::$radios_arr['id']];
		if( $new_post_meta && $new_post_meta != $old_post_meta ) {
			$this->create_post_meta_fields( self::$radios_arr['id'], $new_post_meta );
			update_post_meta( $post_id, self::$radios_arr['id'], $new_post_meta );
		}
		elseif( '' == $new_post_meta && $old_post_meta ) {
			delete_post_meta( $post_id, self::$radios_arr['id'], $old_post_meta );
		}
		
		// saving the file upload
		// http://wp.tutsplus.com/tutorials/attaching-files-to-your-posts-using-wordpress-custom-meta-boxes-part-1/
		// make sure the file array isn't empty
		if( !empty( $_FILES[self::$handout_file['id']]['name'] ) ) {
			// setup the array of supported file types.
			$supported_types = array( 'application/pdf' );

			// get the file type of the upload
			$arr_file_type = wp_check_filetype( basename( $_FILES[self::$handout_file['id']]['name'] ) );
			$uploaded_type = $arr_file_type['type'];

			// check if the type is supported. if not, throw an error
			if( in_array( $uploaded_type, $supported_types ) ) {

				// use the wordpress API to upload the file
				$upload = wp_upload_bits( $_FILES[self::$handout_file['id']]['name'], null, file_get_contents( $_FILES[self::$handout_file['id']]['tmp_name'] ) );

				if( isset( $upload['error'] ) && $upload['error'] != 0 ) {
					wp_die( 'There was an error uploading your file. The error is: ' . $upload['error'] );
				}
				else {
					$this->create_post_meta_fields( self::$handout_file['id'], $upload );
					update_post_meta( $post_id, self::$handout_file['id'], $upload );
				}

			}
			else {
				wp_die( "The file type that you've uploaded is not a PDF." );
			}
		}

	}

	public function update_edit_form() {
		echo ' enctype="multipart/form-data"';
	}

	public function add_download_link( $post_id ) {
		$attachment = get_post_meta( $post_id, self::$handout_file['id'], 'true' );
		?>
		<a class="ctlt-span-12 ctlt-events-col" href="<?php echo $attachment['url']; ?>" download="handout.pdf">
			Download the attachment here
		</a>
		<?php
	}

}

new CTLT_Espresso_Handouts();