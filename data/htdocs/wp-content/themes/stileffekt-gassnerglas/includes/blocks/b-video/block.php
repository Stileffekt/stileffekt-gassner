<?php

/**
 * @var array $block
 */

$block        = new Stilpress_Block_Helper( $block );
$overline     = $block->output( 'overline', 'overline' );
$headline     = $block->output( 'headline', 'headline' );
$text         = $block->output( 'text', 'text' );
$video_1      = $block->output( 'video_1', 'video_selfhosted' );
$video_oembed = $block->output( 'video_oembed', 'video_oembed' );

include __DIR__ . '/view.php';
