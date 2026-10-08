<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_anchor_navigation' ) ) {
	class b_anchor_navigation extends Stilpress_Block_Helper {
		public function output_anchor_navigation( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $item ) {

				$title = ! empty( $item['link']['title'] ) ? $item['link']['title'] : '';
				$url   = ! empty( $item['link']['url'] ) ? $item['link']['url'] : '';

				$output[] = [
					'title' => $title,
					'$url'  => $url,
				];

			}

			return $output;
		}

	}
}

$block    = new b_anchor_navigation( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$items    = $block->output( 'items', 'anchor_navigation' );

include __DIR__ . '/view.php';
