<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_icon_list' ) ) {
	class b_icon_list extends Stilpress_Block_Helper {
		public function output_list( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $item ) {

				$icon  = ! empty( $item['icon'] ) ? stilpress__return_icon( $item['icon'] ) : '';
				$title = ! empty( $item['title'] ) ? $item['title'] : '';
				$text  = $this->output_text( [
					'value' => $item['text']
				] );
				$link  = $this->output_link( [
					'value'     => $item['link_1'],
					'arguments' => [
						'icon'          => 'hex',
						'icon_position' => 'left',
					]
				] );

				$output[] = [
					'icon'  => $icon,
					'title' => $title,
					'text'  => $text,
					'link'  => $link,
				];

			}

			return $output;
		}

	}
}

$block    = new b_icon_list( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$items    = $block->output( 'items', 'list' );

include __DIR__ . '/view.php';
