<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_facts' ) ) {
	class b_facts extends Stilpress_Block_Helper {

		protected function output_counter( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $item ) {

				$icon   = ! empty( $item['icon'] ) ? stilpress__return_icon( $item['icon'] ) : '';
				$value  = ! empty( $item['value'] ) ? $item['value'] : '';
				$prefix = ! empty( $item['prefix'] ) ? $item['prefix'] : '';
				$suffix = ! empty( $item['suffix'] ) ? $item['suffix'] : '';
				$text   = ! empty( $item['text'] ) ? $item['text'] : '';

				$output[] = [
					'icon'   => $icon,
					'value'  => $value,
					'prefix' => $prefix,
					'suffix' => $suffix,
					'text'   => $text
				];

			}

			return $output;
		}
	}
}

$block = new b_facts( $block );
$items = $block->output( 'items', 'counter' );

include __DIR__ . '/view.php';