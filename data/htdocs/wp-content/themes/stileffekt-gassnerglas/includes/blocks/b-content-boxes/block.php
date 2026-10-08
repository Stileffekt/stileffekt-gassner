<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_content_boxes' ) ) {
	class b_content_boxes extends Stilpress_Block_Helper {
		public function output_boxes( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $item ) {

				$icon = ! empty( $item['icon'] ) ? stilpress__return_icon( $item['icon'] ) : '';

				$headline = $this->output_headline( [
					'value'     => $item['headline'],
					'arguments' => [
						'type'  => 'h3',
						'style' => 'h3',
					]
				] );

				$text = $this->output_text( [
					'value' => $item['text']
				] );

				$output[] = [
					'icon'     => $icon,
					'headline' => $headline,
					'text'     => $text,
				];
			}

			return $output;
		}

	}
}

$block    = new b_content_boxes( $block );
$overline = $block->output( 'overline', 'overline', [
	'classes' => 'c-overline--transparent'
] );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$items    = $block->output( 'items', 'boxes' );
$image_1  = $block->output( 'image_1', 'image' );

include __DIR__ . '/view.php';
