<?php
/**
 * Bootstraps the Banner Image plugin.
 *
 * @package BannerImage
 */

namespace BannerImage;

class frountend extends Plugin_Base {
	/**
	 * Initiate the plugin resources.
	 *
	 * Priority is 9 because WP_Customize_Widgets::register_settings() happens at
	 * after_setup_theme priority 10. This is especially important for plugins
	 * that extend the Customizer to ensure resources are available in time.
	 *
	 * @action after_setup_theme, 9
	 */

	var $setting;

	public function __construct() {

		$instance = get_plugin_instance();
		$this->setting = $instance->get_banner_imges_setting();

		if ( ! empty( $this->setting['display'] ) ) {
			if ( ! empty( $this->setting['image_id'] ) && ! empty( $this->setting['image_link'] ) )
			add_action( 'wp_head', array( $this, 'wp_head' ), 1 );
		}
	}

	/**
	 * Add html in wp head section.
	 */
	function wp_head() {
		$image_src = wp_get_attachment_image_src( $this->setting['image_id'], 'full' );
		if ( $image_src ) {
			?>
            <div class="banner-image banner-image-wp-head">
                <a class="banner-image" href=" <?php echo $this->setting['image_link']; ?> " >
                    <img src="<?php echo $image_src[0]; ?>">
                </a>
				<?php
				if ( ! empty( $this->setting['display_frountend'] ) ) {
                    ?>
                    <a href="#" class="banner-close">x</a>
                    <?php
				}
                ?>
            </div>
			<?php

			wp_enqueue_script( $this->config['js_handle_frountend'] );
			wp_enqueue_style( $this->config['css_handle_frountend'] );
		}
	}
}