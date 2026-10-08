<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_number_list_image' ) ) {
	class b_number_list_image extends Stilpress_Block_Helper {
		public function output_items( array $data ): array {
			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];
			foreach ( $data['value'] as $item ) {
				$output[] = [
					'headline'    => ! empty( $item['headline'] ) ? $item['headline'] : '',
					'description' => ! empty( $item['description'] ) ? $item['description'] : '',
				];
			}

			return $output;
		}
	}
}

$block    = new b_number_list_image( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$items    = $block->output( 'items', 'items' );
$button_1 = $block->output( 'button_1', 'button', [
	'icon' => 'Arrow-Right-Streamline-Ultimate',
] );
$button_2 = $block->output( 'button_2', 'button', [
	'icon' => 'Arrow-Right-Streamline-Ultimate',
] );
$image_1  = $block->output( 'image_1', 'image_responsive', [
	'columns' => [
		'lg'      => 12,
		'sm'      => 20,
		'default' => 24,
	],
] );

$structure_visible = $block->output_raw( 'structure_visible' );

include __DIR__ . '/view.php';
