<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_products' ) ) {
	class b_products extends Stilpress_Block_Helper {
		protected function output_products( $data ): array {

			$args = [
				'post_type'      => 'product',
				'orderby'        => 'date',
				'order'          => 'ASC',
				'posts_per_page' => - 1,
			];

			if ( ! empty( $data['value'] ) ) {
				$args['tax_query'] = [
					[
						'taxonomy' => 'product-category',
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

					$post_data = get_field( 'ptype_product', get_the_ID() );

					$image = ! empty( $post_data['image'] ) ? $this->output_image( [
						'value' => $post_data['image'],
					] ) : '';

					$prices = ! empty( $post_data['prices'] ) ? $this->output_image( [
						'value' => $post_data['prices'],
					] ) : '';

					$title = ! empty( $post_data['title'] ) ? $this->output_headline( [
						'value'     => $post_data['title'],
						'arguments' => [
							'type'  => 'h2',
							'style' => 'h2',
						],
					] ) : '';

					$description = ! empty( $post_data['description'] ) ? $this->output_text( [
						'value' => $post_data['description'],
					] ) : '';

					$button_1 = $this->output_button( [
						'value' => $post_data['button_1'],
					] );

					$data[] = [
						'slug'        => get_post_field( 'post_name', get_the_ID() ),
						'image'       => $image,
						'prices'      => $prices,
						'title'       => $title,
						'description' => $description,
						'button_1'    => $button_1,
					];
				}
			}

			return $data;
		}
	}
}

$block    = new b_products( $block );
$products = $block->output( 'items_taxonomy', 'products' );

include __DIR__ . '/view.php';