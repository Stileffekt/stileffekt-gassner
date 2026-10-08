<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'stilpress__acf_extension_icon_picker' ) ) :

	class stilpress__acf_extension_icon_picker {

		public array $settings;

		function __construct() {

			$this->settings = [
				'version' => '1',
				'url'     => get_theme_file_uri(),
				'path'    => get_theme_file_uri()
			];

			add_action( 'acf/include_field_types', array( $this, 'include_field_types' ) );
		}

		function include_field_types( $version = false ) {
			include_once __DIR__ . '/fields/acf-icon-picker-field.php';
		}

	}

endif;

new stilpress__acf_extension_icon_picker();
