<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_iframe' ) ) {
	class b_iframe extends Stilpress_Block_Helper {

		protected function output_iframe( array $data ): string {

			if ( empty( $data['value'] ) ) {
				return '';
			}

			return '<iframe src="' . $data['value'] . '" sandbox="allow-same-origin allow-scripts allow-popups allow-forms"></iframe>';
		}
	}
}

$block    = new b_iframe( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$iframe   = $block->output( 'url', 'iframe' );

include __DIR__ . '/view.php';
