<?php

/**
 * @var array $block
 */

$block               = new Stilpress_Block_Helper( $block );
$type                = $block->output_raw( 'type' );
$overline            = $block->output( 'overline', 'overline', [
	'classes' => 'c-overline--transparent'
] );
$headline            = $block->output( 'headline', 'headline' );
$text                = $block->output( 'text', 'text' );
$image_1_data        = $block->output_raw( 'image_1' );
$video_1             = $block->output( 'video_1', 'video_selfhosted', [
	'overlay' => true,
	'poster'  => $image_1_data['url'] ?? '',
] );
$image_1             = empty( $video_1 ) ? $block->output( 'image_1', 'image_responsive', [
	'overlay' => true,
	'is_lcp'  => true,
] ) : '';
$resolve_button_args = function ( string $field_name ) use ( $block ): array {
	$raw = $block->output_raw( $field_name );
	$url = $raw['url'] ?? '';
	if ( str_starts_with( $url, 'tel:' ) ) {
		return [ 'icon' => 'Phone--Streamline-Ultimate', 'position' => true ];
	}
	if ( str_starts_with( $url, 'mailto:' ) ) {
		return [ 'icon' => 'Send-Email-1--Streamline-Ultimate', 'position' => true ];
	}

	return [ 'icon' => 'Arrow-Right-Streamline-Ultimate', 'position' => false ];
};

$button_1 = $block->output( 'button_1', 'button', array_merge( $resolve_button_args( 'button_1' ), [
	'classes' => $type === 'hero' or $type === 'image' ? 'c-button--ghost' : '',
] ) );
$button_2 = $block->output( 'button_2', 'button', array_merge( $resolve_button_args( 'button_2' ), [
	'classes' => 'c-button--ghost',
] ) );


include __DIR__ . '/view.php';
