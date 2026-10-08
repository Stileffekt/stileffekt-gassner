<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_history' ) ) {
	class b_history extends Stilpress_Block_Helper {
		protected function output_history( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $item ) {

				$title = ! empty( $item['title'] ) ? $item['title'] : '';
				$text  = ! empty( $item['text'] ) ? $item['text'] : '';
				$image = ! empty( $item['image_1'] ) ? $this->output_image( [
					'value'     => $item['image_1'],
					'arguments' => [
						'image_position' => 'center-center',
						'behaviour'      => ! empty( $item['image_1_behaviour'] ) ? $item['image_1_behaviour'] : 'natural',
					]
				] ) : '';

				$output[] = [
					'title' => $title,
					'text'  => $text,
					'image' => $image,
				];
			}

			return $output;
		}
	}
}

$block    = new b_history( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$history  = $block->output( 'items', 'history' );

include __DIR__ . '/view.php';
