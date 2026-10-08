<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_employees_slider' ) ) {
	class b_employees_slider extends Stilpress_Block_Helper {
		protected function output_employees( array $data ): array {

			$args = [
				'post_type'      => 'employee',
				'posts_per_page' => - 1,
			];

			if ( ! empty( $data['value'] ) ) {
				$args['tax_query'] = [
					[
						'taxonomy' => 'employee-category',
						'field'    => 'term_id',
						'terms'    => $data['value'],
					],
				];
			}

			$query  = new WP_Query( $args );
			$output = [];

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$query_data = get_field( 'ptype_employee', get_the_ID() );

					$image = '';
					if ( ! empty( $query_data['image_1'] ) ) {
						$image = $this->output_image( [
							'value'     => $query_data['image_1'],
							'arguments' => [
								'behaviour' => 'cover',
							],
						] );
					}

					$output[] = [
						'image'       => $image,
						'name'        => ! empty( $query_data['name'] ) ? $query_data['name'] : '',
						'description' => ! empty( $query_data['description'] ) ? $query_data['description'] : '',
					];
				}
				wp_reset_postdata();
			}

			return $output;
		}
	}
}

$block     = new b_employees_slider( $block );
$overline  = $block->output( 'overline', 'overline' );
$headline  = $block->output( 'headline', 'headline' );
$text      = $block->output( 'text', 'text' );
$employees = $block->output( 'items_taxonomy', 'employees' );

include __DIR__ . '/view.php';
