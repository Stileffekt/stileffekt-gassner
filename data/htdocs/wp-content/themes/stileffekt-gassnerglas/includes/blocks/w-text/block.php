<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'w_text' ) ) {
	class w_text extends Stilpress_Block_Helper {
	}
}

$block    = new w_text( $block );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );

include __DIR__ . '/view.php';