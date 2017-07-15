<?php
/**
 * Instantiates the Banner Image plugin
 *
 * @package BannerImage
 */

namespace BannerImage;

global $banner_image_plugin;

require_once __DIR__ . '/php/class-plugin-base.php';
require_once __DIR__ . '/php/class-plugin.php';

$banner_image_plugin = new Plugin();

/**
 * Banner Image Plugin Instance
 *
 * @return Plugin
 */
function get_plugin_instance() {
	global $banner_image_plugin;
	return $banner_image_plugin;
}
