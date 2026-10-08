<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_prices' ) ) {
	class b_prices extends Stilpress_Block_Helper {
		protected function output_prices( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $item ) {

				$title = ! empty( $item['title'] ) ? $this->output_headline( [
					'value'     => $item['title'],
					'arguments' => [
						'type'  => 'h3',
						'style' => 'h3',
					],
				] ) : '';

				$description  = ! empty( $item['description'] ) ? $item['description'] : '';
				$price_prefix = ! empty( $item['price_prefix'] ) ? trim( $item['price_prefix'] ) : '';
				$price_from   = ! empty( $item['price_from'] ) ? trim( $item['price_from'] ) : '';
				$price_to     = ! empty( $item['price_to'] ) ? trim( $item['price_to'] ) : '';
				$text         = $this->output_text( [ 'value' => $item['text'] ?? '' ] );

				$output[] = [
					'title'        => $title,
					'description'  => $description,
					'price_prefix' => $price_prefix,
					'price_from'   => $price_from,
					'price_to'     => $price_to,
					'price_free'   => empty( $price_from ) && empty( $price_to ),
					'text'         => $text,
				];
			}

			return $output;
		}
	}
}

$block    = new b_prices( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$items    = $block->output( 'items', 'prices' );

$structure_visible = $block->output_raw( 'structure_visible' );

include __DIR__ . '/view.php';
