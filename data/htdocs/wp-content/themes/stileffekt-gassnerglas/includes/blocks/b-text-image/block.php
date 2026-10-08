<?php

/**
 * @var array $block
 */

$block    = new Stilpress_Block_Helper( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$button_1 = $block->output( 'button_1', 'button' );
$button_2 = $block->output( 'button_2', 'button' );
$image_1  = $block->output( 'image_1', 'image_responsive', [
	'columns' => [
		'lg'      => 12,
		'sm'      => 20,
		'default' => 24,
	],
] );

include __DIR__ . '/view.php';
