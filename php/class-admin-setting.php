<?php
/**
 * Bootstraps the Banner Image plugin.
 *
 * @package BannerImage
 */

namespace BannerImage;

/**
 * Admin setting Class.
 *
 * Handle Banner setting all function.
 */
class admin_setting extends Plugin_Base {

	/**
	 * Initiate the plugin resources.
	 *
	 * Priority is 9 because WP_Customize_Widgets::register_settings() happens at
	 * after_setup_theme priority 10. This is especially important for plugins
	 * that extend the Customizer to ensure resources are available in time.
	 *
	 * @action after_setup_theme, 9
	 */
	public function __construct() {

		$this->config[ 'page_name' ] = 'Banner Image';
		$this->config[ 'page_name_full' ] = 'Banner Image Setting';
		$this->config[ 'page_slug' ] = 'banner-image';
		$this->config[ 'field' ] = 'banner_image_admin_group';
		$this->config[ 'capability'  ] = 'manage_options';
		$this->config = apply_filters( 'banner_image_admin_setting_config', $this->config, $this );


		add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );
		add_action( 'admin_init', array( $this, 'page_init' ), 12 );

	}

	/**
	 * Fire in admin_menu action is called
     *
	 */
	public function admin_menu() {
		/**
		 * Add submenu Page in admin dashhboard under Setting tab.
		 */
		add_submenu_page( 'options-general.php', $this->config['page_name'], $this->config['page_name'], $this->config['capability'], $this->config['page_slug'], array( $this, 'banner_image_main' ) );
	}

	/**
	 * Banner Page under setting tab containt.
	 */
	public function banner_image_main() {
		// Get the value of the banner setting.
		$this->options = get_option( $this->config['option_name'] );
		?>
        <div class="wrap">
            <h1> <?php echo $this->config['page_name']; ?> </h1>
            <form method="post" action="options.php">
				<?php
				// This prints out all hidden setting fields
				settings_fields( $this->config['field'] );

				do_settings_sections( $this->config['page_slug'] );

				submit_button();
				?>
            </form>
        </div>
		<?php
	}

	/**
	 * Register and add settings
	 */
	public function page_init() {

		register_setting( $this->config['field'], $this->config['option_name'], array( $this, 'sanitize' ) );

		add_settings_section( 'banner_image_display_option', $this->config['page_name_full'], array( $this, 'banner_image_display_text' ), $this->config['page_slug'] );
		add_settings_field( 'imw_admin_main', 'Banner Images Display', array( $this, 'display_callback' ), $this->config['page_slug'], 'banner_image_display_option' );
		add_settings_field( 'imw_admin_frountend', 'Banner Images Frountend Button', array( $this, 'display_frountend_callback' ), $this->config['page_slug'], 'banner_image_display_option' );

		add_settings_section( 'banner_image_id_option', $this->config['page_name_full'], array( $this, 'banner_image_id_text' ), $this->config['page_slug'] );
		add_settings_field( 'imw_admin', 'Banner Images ID', array( $this, 'image_id_callback' ), $this->config['page_slug'], 'banner_image_id_option' );

		add_settings_section( 'banner_image_link_option', $this->config['page_name_full'], array( $this, 'banner_image_link_text' ), $this->config['page_slug'] );
		add_settings_field( 'imw_admin', 'Banner Images Link', array( $this, 'image_link_callback' ), $this->config['page_slug'], 'banner_image_link_option' );

	}

	/**
	 * Sanitize each setting field as needed
	 *
	 * @param array $input Contains all settings fields as array keys
	 */
	public function sanitize( $input ) {
		$new_input = array();
		if ( isset( $input['display'] ) ) {
			$new_input['display'] = $input['display'];
		}

		if ( isset( $input['display_frountend'] ) ) {
			$new_input['display_frountend'] = $input['display_frountend'];
		}

		if ( isset( $input['image_id'] ) ) {
			$new_input['image_id'] = $input['image_id'];
		}

		if ( isset( $input['image_link'] ) ) {
			$new_input['image_link'] = $input['image_link'];
		}
		return $new_input;
	}

	/**
	 * Print the Section text
	 */
	public function banner_image_display_text() {
		?>
        <p>
            Set ON button to show Banner Image in Frountend and vice versa.
        </p>
		<?php
	}

	/**
	 * Print the Section text
	 */
	public function banner_image_id_text() {
		?>
        <p>
            Enter the Image ID in the INPUT box.
        </p>
        <p>
            Image Size would be greater then 1920 * 1200 ( WIDHT * HEIGHT )
        </p>
		<?php
	}

	/**
	 * Print the Section text
	 */
	public function banner_image_link_text() {
		?>
        <p>
            Enter the Banner link in the INPUT box.
        </p>
		<?php
	}


	/**
	 * Get the settings option array and print one of its values
	 */
	public function display_callback() {
		$display = isset( $this->options['display'] ) ? esc_attr( $this->options['display'] ) : '1';

		?>
        <input type="radio" name="<?php echo $this->config['option_name'] . '[display]'; ?>" value="1" <?php checked( $display, 1, true ); ?> > Show
        <input type="radio" name="<?php echo $this->config['option_name'] . '[display]'; ?>" value="0" <?php checked( $display, 0, true ); ?> > Hide
        <?php
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function display_frountend_callback() {
		$display = isset( $this->options['display_frountend'] ) ? esc_attr( $this->options['display_frountend'] ) : '1';

		?>
        <input type="radio" name="<?php echo $this->config['option_name'] . '[display_frountend]'; ?>" value="1" <?php checked( $display, 1, true ); ?> > Show
        <input type="radio" name="<?php echo $this->config['option_name'] . '[display_frountend]'; ?>" value="0" <?php checked( $display, 0, true ); ?> > Hide
		<?php
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function image_id_callback() {
		$image_id = isset( $this->options['image_id'] ) ? esc_attr( $this->options['image_id'] ) : '';
		?>
        <input type="number" name="<?php echo $this->config['option_name'] . '[image_id]'; ?>" value="<?php echo $image_id; ?>" >
		<?php
	}

	/**
	 * Get the settings option array and print one of its values
	 */
	public function image_link_callback() {
		$image_link = isset( $this->options['image_link'] ) ? esc_attr( $this->options['image_link'] ) : '';
		?>
        <input type="text" name="<?php echo $this->config['option_name'] . '[image_link]'; ?>" value="<?php echo $image_link; ?>" >
		<?php
	}
}