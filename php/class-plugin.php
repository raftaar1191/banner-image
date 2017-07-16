<?php
/**
 * Bootstraps the Banner Image plugin.
 *
 * @package BannerImage
 */

namespace BannerImage;

/**
 * Main plugin bootstrap file.
 */
class Plugin extends Plugin_Base {

	/**
	 * Initiate the plugin resources.
	 *
	 * Priority is 9 because WP_Customize_Widgets::register_settings() happens at
	 * after_setup_theme priority 10. This is especially important for plugins
	 * that extend the Customizer to ensure resources are available in time.
	 *
	 * @action after_setup_theme, 9
	 */
	public function init() {
		$this->config = apply_filters( 'banner_image_plugin_config', $this->config, $this );

		$this->add_action( 'wp_default_scripts', array( $this, 'register_scripts' ), 11 );
		$this->add_action( 'wp_default_styles', array( $this, 'register_styles' ), 11 );

		include_once( $this->dir_path . '/php/functions.php' );

		new admin_setting();
		new frountend();
	}

	public function get_banner_imges_setting() {
		return get_option( $this->config[ 'option_name' ], false );
	}

	/**
	 * Register scripts.
	 *
	 * @action wp_default_scripts, 11
	 *
	 * @param \WP_Scripts $wp_scripts Instance of \WP_Scripts.
	 */
	public function register_scripts( \WP_Scripts $wp_scripts ) {
		$script_name = "frountend.min.js";
		if ( defined( WP_DEBUG ) && WP_DEBUG ) {
			$script_name = "frountend.js";
		}
		$wp_scripts->add( $this->config['js_handle_frountend'], $this->dir_url . 'plugins/' . $this->slug . "/js/" . $script_name, array( 'jquery' ), $this->config['version'] );
		$wp_scripts->add_data( $this->config['js_handle_frountend'] , 'group', 1 );
	}

	/**
	 * Register styles.
	 *
	 * @action wp_default_styles, 11
	 *
	 * @param \WP_Styles $wp_styles Instance of \WP_Styles.
	 */
	public function register_styles( \WP_Styles $wp_styles ) {
		$style_name = "frountend.min.css";
		if ( defined( WP_DEBUG ) && WP_DEBUG ) {
			$style_name = "frountend.css";
		}
		$wp_styles->add( $this->config['css_handle_frountend'], $this->dir_url . 'plugins/' . $this->slug . "/css/" . $style_name, array(), $this->config['version'] );
	}
}
