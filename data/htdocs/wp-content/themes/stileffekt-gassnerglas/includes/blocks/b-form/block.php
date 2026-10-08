<?php

/**
 * @var array $block
 */

$block    = new Stilpress_Block_Helper( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$form     = $block->output( 'form', 'cf7form' );

include __DIR__ . '/view.php';
