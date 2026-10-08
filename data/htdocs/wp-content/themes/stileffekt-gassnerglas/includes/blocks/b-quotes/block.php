<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_quotes' ) ) {
	class b_quotes extends Stilpress_Block_Helper {
		protected function output_quotes( array $data = [] ): array {

			$count = - 1;
			$items_count = $this->return_raw_data_value( 'items_count' );
			if ( ! empty( $items_count ) ) {
				$count = $items_count;
			}

			$items_by = 'taxonomy';
			$items_by_field = $this->return_raw_data_value( 'items_by' );
			if ( ! empty( $items_by_field ) ) {
				$items_by = $items_by_field;
			}

			$args = [
				'posts_per_page' => $count,
				'post_type'      => 'quote',
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
			];

			if ( ! empty( $data['value'] ) ) {
				if ( $items_by == 'taxonomy' ) {
					$args['tax_query'] = [
						[
							'taxonomy' => 'quote-category',
							'field'    => 'term_id',
							'terms'    => $data['value'],
						]
					];
				} elseif ( $items_by == 'selection' ) {
					$args['post__in'] = [ $data['value'] ];
				}
			}

			$query = new WP_Query( $args );

			$output = [];
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {

					$query->the_post();

					$data = get_field( 'ptype_quote', get_the_ID() );

					$text     = ! empty( $data['text'] ) ? $data['text'] : '';
					$name     = get_the_title();
					$position = ! empty( $data['position'] ) ? $data['position'] : '';
					$company  = ! empty( $data['company'] ) ? $data['company'] : '';

					$image = $this->output_image( [
						'value'     => $data['image'],
						'arguments' => [
							'behaviour' => 'cover',
						]
					] );

					$output[] = [
						'text'     => $text,
						'name'     => $name,
						'position' => $position,
						'company'  => $company,
						'image'    => $image,
					];
				}
			}

			return $output;
		}
	}
}

$block    = new b_quotes( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );

$items_by = $block->output( 'items_by', 'select' );
if ( $items_by == 'selection' ) {
	$quotes = $block->output( 'items_selection', 'quotes' );
}
if ( $items_by == 'taxonomy' ) {
	$quotes = $block->output( 'items_taxonomy', 'quotes' );
}


if ( $items_by == 'taxonomy' ) {
	include __DIR__ . '/view.php';
}
if ( $items_by == 'selection' ) {
	include __DIR__ . '/view-single.php';
}
