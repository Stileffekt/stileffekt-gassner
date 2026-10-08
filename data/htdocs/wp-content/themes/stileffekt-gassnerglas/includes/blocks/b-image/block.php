<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_image' ) ) {
	class b_image extends Stilpress_Block_Helper {
	}
}

$block   = new b_image( $block );
$image_1 = $block->output( 'image_1', 'image' );

include __DIR__ . '/view.php';
