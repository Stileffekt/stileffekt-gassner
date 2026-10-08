<?php

/**
 * @var array $block
 */

$block    = new Stilpress_Block_Helper( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$button_1 = $block->output( 'button_1', 'button', [
	'icon'           => 'Arrow-Right-Streamline-Ultimate',
	'inline_toolbar' => true,
] );
$button_2 = $block->output( 'button_2', 'button', [
	'icon'           => 'Arrow-Right-Streamline-Ultimate',
	'inline_toolbar' => true,
] );

include __DIR__ . '/view.php';
