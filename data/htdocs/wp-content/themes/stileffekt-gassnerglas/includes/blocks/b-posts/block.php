<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_posts' ) ) {
	class b_posts extends Stilpress_Block_Helper {
		protected function output_posts( $data ): array {

			$items_count = $this->return_raw_data_value( 'items_count' );
			$count       = ! empty( $items_count ) && is_numeric( $items_count ) ? $items_count : - 1;

			$args = [
				'post_type'      => 'post',
				'orderby'        => 'date',
				'order'          => 'ASC',
				'posts_per_page' => $count,
			];

			if ( ! empty( $data['value'] ) ) {
				$args['tax_query'] = [
					[
						'taxonomy' => 'category',
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

					$post_data = get_field( 'ptype_post_data', get_the_ID() );

					$image = ! empty( $post_data['image'] ) ? $this->output_image( [
						'value'     => $post_data['image'],
						'arguments' => [
							'behaviour' => 'cover',
						],
					] ) : '';

					$permalink = get_the_permalink();

					$date = get_the_date();

					$title = $this->output_headline( [
						'value'     => get_the_title(),
						'arguments' => [
							'type'  => 'h3',
							'style' => 'h3',
						],
					] );

					$text = ! empty( $post_data['text'] ) ? $this->output_text( [
						'value' => $post_data['text'],
					] ) : '';

					$link_1 = $this->output_link( [
						'value'     => [
							'url'   => get_the_permalink(),
							'title' => __( 'Read More', 'stilpress' ),
						],
						'arguments' => [
							'icon'          => 'Arrow-Right--Streamline-Ultimate',
							'icon_position' => 'right',
						]
					] );

					$data[] = [
						'image'     => $image,
						'permalink' => $permalink,
						'title'     => $title,
						'date'      => $date,
						'text'      => $text,
						'link_1'    => $link_1,
					];
				}
			}

			return $data;
		}
	}
}

$block    = new b_posts( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$posts    = $block->output( 'items_taxonomy', 'posts' );
$button_1 = $block->output( 'button_1', 'button' );

include __DIR__ . '/view.php';
