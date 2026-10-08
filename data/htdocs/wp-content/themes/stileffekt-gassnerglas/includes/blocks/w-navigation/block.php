<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'w_navigation' ) ) {
	class w_navigation extends Stilpress_Block_Helper {

	}
}

$block      = new w_navigation( $block );
$headline   = $block->output( 'headline', 'headline' );
$navigation = $block->output( 'navigation', 'navigation' );

include __DIR__ . '/view.php';