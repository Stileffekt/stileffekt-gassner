<?php

/**
 * @var array $block
 */

$block  = new Stilpress_Block_Helper( $block );
$text   = $block->output( 'text', 'text' );
$author = $block->output( 'author', 'text' );

include __DIR__ . '/view.php';
