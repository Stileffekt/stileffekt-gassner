<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_image_boxes' ) ) {
	class b_image_boxes extends Stilpress_Block_Helper {
		public function output_boxes( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $item ) {

				$image = $this->output_image( [
					'value'     => $item['image_1'] ?? [],
					'arguments' => [
						'behaviour' => ! empty( $item['image_1_behaviour'] ) ? $item['image_1_behaviour'] : 'natural',
					],
				] );

				$title = $this->output_headline( [
					'value'     => $item['title'],
					'arguments' => [
						'type'  => 'h3',
						'style' => 'h3',
					]
				] );

				$text = $this->output_text( [
					'value' => $item['text']
				] );

				$link_1 = $this->output_link( [
					'value'     => $item['link_1'],
					'arguments' => [
						'icon'          => 'Keyboard-Arrow-Right--Streamline-Ultimate',
						'icon_position' => 'right',
					]
				] );

				$output[] = [
					'image'  => $image,
					'title'  => $title,
					'text'   => $text,
					'link_1' => $link_1,
				];
			}

			return $output;
		}

	}
}

$block    = new b_image_boxes( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$boxes    = $block->output( 'items', 'boxes' );

include __DIR__ . '/view.php';
