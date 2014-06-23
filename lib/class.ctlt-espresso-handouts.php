<?php

class CTLT_Espresso_Handouts extends CTLT_Espresso_Metaboxes {

    // arrays to hold handout and sign information
	static $handout_file = null;
    static $handout_policy = null;
    static $sign_file = null;

	public function __construct() {
		$this->init_handout_properties();
		add_action( $this->add_hook, array( $this, 'handouts' ) );
		add_action( $this->edit_hook, array( $this, 'handouts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'uploader_js' ) );
		add_action( 'ctlt_espresso_form', array( $this, 'update_edit_form') );
	}

	/**
	 * init_handout_properties function
	 * This function sets the form fields and their ids
	 * Provides an easy place to change any option ids
	 */
	public function init_handout_properties() {
		self::$handout_file = array(
			'name' => 'Handout File',
			'id' => self::$prefix . 'handouts_upload',
			'type' => 'file',
            'notes' => self::$prefix . 'handouts_notes'
			);
        self::$sign_file = array(
			'name' => 'Sign File',
			'id' => self::$prefix . 'signs_upload',
			'type' => 'file'
			);
        self::$handout_policy = array(
			'name' => 'Materials Distribution Policy',
			'id' => self::$prefix . 'do_not_handout',
			'type' => 'checkbox',
            'checkbox_label' => 'Do not publicly display link to event materials',
		);
            
	}

	/**
	 * handouts function
	 * This function creates the wrapper for the handout form fields
	 */
	public function handouts() {
		?>
		<div id="event-handouts" class="postbox">
			<div class="handlediv" title="Click to toggle"><br>
			</div>
			<h3 class="hndle"> <span>
				Handouts
				</span> </h3>
			<div class="inside">
				<?php echo $this->nonce_input( 'handouts_noncename' ); ?>
				<?php $this->the_file_upload(); ?>
			</div>
		</div>
		<?php
	}
    
	/**
	 * the_file_upload function
	 * This function renders the upload file box
	 */
	public function the_file_upload() {
        $text = isset( self::$data[self::$handout_file['notes']] ) ? self::$data[self::$handout_file['notes']] : '';
		?>
            
			<div class="uploader handout-file">
				<p><label><?php echo self::$handout_file['name']; ?>:</label></p>
				<?php $attachment_id = isset( self::$data[self::$handout_file['id']] ) ? self::$data[self::$handout_file['id']] : null;?>
				<?php $attachment_url = wp_get_attachment_url( $attachment_id ); ?>
				<input class="ctlt-espresso-upload-button button" type="button" name="<?php echo self::$handout_file['id'] . '_button'; ?>" id="<?php echo self::$handout_file['id'] . '_button'; ?>" value="Upload" />
					<input class="ctlt-espresso-upload" type="text" value="<?php echo $attachment_url !== false ? $attachment_url : null; ?>" />
					<input class="ctlt-espresso-target-attachment-id" type="hidden" name="<?php echo self::$handout_file['id']; ?>" id="<?php echo self::$handout_file['id']; ?>" value="<?php echo $attachment_id; ?>"/>
			</div>

            <div class="uploader display-public">
	            <p>
	                <?php $checked = isset( self::$handout_policy['id'] ) ? self::$data[self::$handout_policy['id']] : ''; ?>
	                <label for="<?php echo self::$handout_policy['id']; ?>"><?php echo self::$handout_policy['checkbox_label']; ?></label><br />
	                <input type="<?php echo self::$handout_policy['type']; ?>" name="<?php echo self::$handout_policy['id']; ?>" id="<?php echo self::$handout_policy['id']; ?>" <?php checked( $checked, 'yes' ); ?>>
	            </p>
            </div>
            
			<div class="uploader sign-file">
				<p><label><?php echo self::$sign_file['name']; ?>:</label></p>
				<?php $attachment_id = isset( self::$data[self::$sign_file['id']] ) ? self::$data[self::$sign_file['id']] : null;?>
				<?php $attachment_url = wp_get_attachment_url( $attachment_id ); ?>
				<input class="ctlt-espresso-upload-button button" type="button" name="<?php echo self::$sign_file['id'] . '_button'; ?>" id="<?php echo self::$sign_file['id'] . '_button'; ?>" value="Upload" />
					<input class="ctlt-espresso-upload" type="text" value="<?php echo $attachment_url !== false ? $attachment_url : null; ?>" />
					<input class="ctlt-espresso-target-attachment-id" type="hidden" name="<?php echo self::$sign_file['id']; ?>" id="<?php echo self::$sign_file['id']; ?>" value="<?php echo $attachment_id; ?>"/>
			</div>

            
            <div class="uploader handout-notes ctlt-espresso-controls-textarea">
                <p><label>Handouts and Signs Notes:</label></p>
                <textarea class="ctlt-full-width" rows="2" name="<?php echo self::$handout_file['notes'] ?>" id="<?php echo self::$handout_file['notes'] ?>"><?php echo $text; ?></textarea>
            </div>
		<?php
	}

	/**
	 * update_edit_form function
	 * This function allows uploaded files to be uploaded
	 */
	public function update_edit_form() {
		echo ' enctype="multipart/form-data"';	
	}

	/**
	 * add_download_link function
	 * This function adds a download link to the uploaded file if it exists
	 */
	public function add_download_link() {
		$attachment = self::$data[self::$handout_file['id']];
		print_r( $attachment );
		if( !empty( $attachment['url'] ) ) { ?>
		<a class="ctlt-colspan-12 ctlt-events-col" href="<?php echo $attachment['url']; ?>" download="handout.pdf">
			Download the attachment here
		</a>
		<?php }
	}
	
	/**
	 * uploader_js function
	 * This function enqueues the javascript for the uploader
	 */
	public function uploader_js() {
		wp_enqueue_media();
		wp_enqueue_script( 'media-upload' );
		wp_enqueue_script( 'ctlt-espresso-uploader-js', CTLT_ESPRESSO_CONTROLS_JS_URL . 'ctlt-espresso-uploader.js', array( 'jquery' ), '1.0.0', true );
	}
}

new CTLT_Espresso_Handouts();
