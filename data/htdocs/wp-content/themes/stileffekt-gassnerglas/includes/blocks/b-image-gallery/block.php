<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_image_gallery' ) ) {
	class b_image_gallery extends Stilpress_Block_Helper {
		protected function output_images( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $item ) {

				$image = $this->output_image( [
					'value'     => $item['image_1'] ?? [],
					'arguments' => [
						'position'  => ! empty( $item['image_1_position'] ) ? $item['image_1_position'] : 'center-center',
						'behaviour' => ! empty( $item['image_1_behaviour'] ) ? $item['image_1_behaviour'] : 'natural',
					]
				] );

				$output[] = [
					'image' => $image,
				];

			}

			return $output;
		}
	}
}

$block    = new b_image_gallery( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$images   = $block->output( 'items', 'images' );

include __DIR__ . '/view.php';
