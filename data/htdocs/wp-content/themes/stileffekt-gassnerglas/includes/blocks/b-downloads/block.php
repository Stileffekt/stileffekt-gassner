<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_downloads' ) ) {
	class b_downloads extends Stilpress_Block_Helper {

		public function output_downloads( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $item ) {

				$title = ! empty( $item['titel'] ) ? $item['title'] : '';
				$file  = ! empty( $item['file'] ) ? $item['file'] : '';

				$output[] = [
					'title' => $title,
					'file'  => $file,
				];
			}

			return $output;
		}
	}
}

$block     = new b_downloads( $block );
$overline  = $block->output( 'overline', 'overline' );
$headline  = $block->output( 'headline', 'headline' );
$text      = $block->output( 'text', 'text' );
$downloads = $block->output( 'items', 'downloads' );

include __DIR__ . '/view.php';
