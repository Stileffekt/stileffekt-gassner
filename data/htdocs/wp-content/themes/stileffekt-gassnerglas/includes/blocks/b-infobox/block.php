<?php

/**
 * @var array $block
 */

$block    = new Stilpress_Block_Helper( $block );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );

include __DIR__ . '/view.php';