<?php
/**
 * Test_Banner_Image
 *
 * @package BannerImage
 */

namespace BannerImage;

/**
 * Class Test_Banner_Image
 *
 * @package BannerImage
 */
class Test_Banner_Image extends \WP_UnitTestCase {

	/**
	 * Test _banner_image_php_version_error().
	 *
	 * @see _banner_image_php_version_error()
	 */
	public function test_banner_image_php_version_error() {
		ob_start();
		_banner_image_php_version_error();
		$buffer = ob_get_clean();
		$this->assertContains( '<div class="error">', $buffer );
	}

	/**
	 * Test _banner_image_php_version_text().
	 *
	 * @see _banner_image_php_version_text()
	 */
	public function test_banner_image_php_version_text() {
		$this->assertContains( 'Banner Image plugin error:', _banner_image_php_version_text() );
	}
}
