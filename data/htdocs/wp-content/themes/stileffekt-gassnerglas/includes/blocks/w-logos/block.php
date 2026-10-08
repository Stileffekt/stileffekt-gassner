<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'w_logos' ) ) {
	class w_logos extends Stilpress_Block_Helper {
		protected function output_logos( $data ): array {
			if ( empty( $data ) ) {
				return [];
			}

			$output = [];


			foreach ( $data['value'] as $item ) {

				$image = $this->output_image( [
					'value'     => $item['image_1'] ?? [],
					'arguments' => [
						'behaviour' => ! empty( $item['image_1_behaviour'] ) ? $item['image_1_behaviour'] : 'contain',
					],
				] );

				$output[] = [
					'image' => $image,
				];
			}

			return $output;
		}
	}
}

$block    = new w_logos( $block );
$headline = $block->output( 'headline', 'headline' );
$items    = $block->output( 'items', 'logos' );

include __DIR__ . '/view.php';
