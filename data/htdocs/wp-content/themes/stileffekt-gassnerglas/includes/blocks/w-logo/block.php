<?php

/**
 * @var array $block
 */

$block = new Stilpress_Block_Helper( $block );
$logo  = $block->output( 'image_1', 'image_responsive' );

include __DIR__ . '/view.php';
