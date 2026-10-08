<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_quotes_slider' ) ) {
	class b_quotes_slider extends Stilpress_Block_Helper {
		protected function output_quotes( array $data = [] ): array {

			$items_count = $this->return_raw_data_value( 'items_count' );
			$count       = ! empty( $items_count ) && is_numeric( $items_count ) ? $items_count : - 1;

			$args = [
				'post_type'      => 'quote',
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'posts_per_page' => $count,
			];

			if ( ! empty( $data['value'] ) ) {
				$args['tax_query'] = [
					[
						'taxonomy' => 'quote-category',
						'field'    => 'term_id',
						'terms'    => $data['value'],
					]
				];
			}

			$query = new WP_Query( $args );

			$data = [];

			if ( $query->have_posts() ) {

				while ( $query->have_posts() ) {

					$query->the_post();

					$post_data = get_field( 'ptype_quote', get_the_ID() );

					$text = ! empty( $post_data['text'] ) ? $this->output_text( [
						'value' => $post_data['text'],
					] ) : '';

					$author = ! empty( $post_data['author'] ) ? $this->output_text( [
						'value' => $post_data['author'],
					] ) : '';

					$data[] = [
						'text'   => $text,
						'author' => $author,
					];
				}
			}

			return $data;
		}
	}
}

$block = new b_quotes_slider( $block );

$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$quotes   = $block->output( 'items_taxonomy', 'quotes' );

$structure_visible = $block->output_raw( 'structure_visible' );

include __DIR__ . '/view.php';
