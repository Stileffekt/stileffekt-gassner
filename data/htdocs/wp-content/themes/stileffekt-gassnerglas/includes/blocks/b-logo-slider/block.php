<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_logo_slider' ) ) {
	class b_logo_slider extends Stilpress_Block_Helper {
		protected function output_logos( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $item ) {

				$image = $this->output_image( [
					'value'     => $item['image_1'] ?? [],
					'arguments' => [
						'behaviour' => ! empty( $item['image_1_behaviour'] ) ? $item['image_1_behaviour'] : 'contain',
					]
				] );

				$link = '';
				if ( ! empty( $item['link_1'] ) ) {
					$link = $item['link_1'];
				}

				$output[] = [
					'image' => $image,
					'link'  => $link,
				];

			}

			return $output;
		}
	}
}

$block    = new b_logo_slider( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$images   = $block->output( 'items', 'logos' );

include __DIR__ . '/view.php';
