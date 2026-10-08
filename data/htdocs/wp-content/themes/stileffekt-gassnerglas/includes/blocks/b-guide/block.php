<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_guide' ) ) {
	class b_guide extends Stilpress_Block_Helper {
		protected function output_guide( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $item ) {
				$title   = ! empty( $item['title'] ) ? $item['title'] : '';
				$text    = ! empty( $item['text'] ) ? $item['text'] : '';
				$image_1 = ! empty( $item['image_1'] ) ? $this->output_image( [
					'value'     => $item['image_1'],
					'arguments' => [
						'behaviour' => ! empty( $item['image_1_behaviour'] ) ? $item['image_1_behaviour'] : 'cover',
					]
				] ) : '';

				$output[] = [
					'title'   => $title,
					'text'    => $text,
					'image_1' => $image_1,
				];
			}

			return $output;
		}
	}
}

$block    = new b_guide( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$guide    = $block->output( 'items', 'guide' );

include __DIR__ . '/view.php';
