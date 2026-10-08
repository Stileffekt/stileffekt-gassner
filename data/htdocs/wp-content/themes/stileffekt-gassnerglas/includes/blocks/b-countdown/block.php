<?php

/**
 * @var array $block
 */

$block       = new Stilpress_Block_Helper( $block );
$overline    = $block->output( 'overline', 'overline' );
$headline    = $block->output( 'headline', 'headline' );
$text        = $block->output( 'text', 'text' );
$button_1    = $block->output( 'button_1', 'button', [
	'icon' => 'Arrow-Right-Streamline-Ultimate',
] );
$button_2    = $block->output( 'button_2', 'button', [
	'icon' => 'Arrow-Right-Streamline-Ultimate',
] );
$go_live_raw = $block->output_raw( 'date_end' );
$go_live     = '';

if ( ! empty( $go_live_raw ) ) {
	$go_live_date = DateTimeImmutable::createFromFormat( 'Y-m-d H:i:s', $go_live_raw, wp_timezone() );

	if ( $go_live_date instanceof DateTimeImmutable ) {
		$go_live = $go_live_date->format( DATE_ATOM );
	}
}

include __DIR__ . '/view.php';
