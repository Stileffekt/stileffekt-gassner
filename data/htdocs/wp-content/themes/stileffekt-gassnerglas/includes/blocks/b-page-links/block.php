<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_page_links' ) ) {
	class b_page_links extends Stilpress_Block_Helper {

		public function output_links( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $link ) {

				$url    = ! empty( $link['link']['url'] ) ? ' href="' . $link['link']['url'] . '"' : '';
				$target = ! empty( $link['link']['target'] ) ? ' target="' . $link['link']['target'] . '"' : '';
				$title  = ! empty( $link['link']['title'] ) ? '<span>' . $link['link']['title'] . '</span>' : '';

//				$image = ! empty( $link['image_1'] ) ? $this->output_image( [
//					'value'     => $link['image_1'],
//					'arguments' => [
//						'image_position' => $link['image_1_position'] ?? 'center-center',
//						'overlay'        => true,
//						'overlay_icon'   => 'hex-plus'
//					]
//				] ) : '';

				$output[] = [
					'url'    => $url,
					'target' => $target,
					'title'  => $title,
//					'image'  => $image,
				];

			}

			return $output;
		}

	}
}

$block    = new b_page_links( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$links    = $block->output( 'links', 'links' );

include __DIR__ . '/view.php';
