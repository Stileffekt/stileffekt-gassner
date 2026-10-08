<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_employees' ) ) {
	class b_employees extends Stilpress_Block_Helper {
		protected function output_employees_taxonomy( array $data ): array {

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

			$query = new WP_Query( $args );

			$output = [];

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$query_data = get_field( 'ptype_employee', get_the_ID() );
					$name       = ! empty( get_the_title() ) ? '<span>' . get_the_title() . '</span>' : '';
					$position   = ! empty( $query_data['position'] ) ? '<span>' . $query_data['position'] . '</span>' : '';
					$areas      = ! empty( $query_data['areas'] ) ? '<span>' . $query_data['areas'] . '</span>' : '';

					$image_1 = '';
					if ( ! empty( $query_data['image_1'] ) ) {
						$image_1 = $this->output_image( [
							'value'     => $query_data['image_1'],
							'arguments' => [
								'behaviour' => 'cover',
							],
						] );
					}
					$link_phone = '';
					if ( ! empty( $query_data['link_phone'] ) ) {
						$link_phone = $this->output_link( [
							'value'     => $query_data['link_phone'],
							'arguments' => [
								'icon' => 'Phone--Streamline-Ultimate'
							]
						] );
					}
					$link_mail = '';
					if ( ! empty( $query_data['link_mail'] ) ) {
						$link_mail = $this->output_link( [
							'value'     => $query_data['link_mail'],
							'arguments' => [
								'icon' => 'Send-Email-1--Streamline-Ultimate'
							]
						] );
					}
					$output[] = [
						'name'       => $name,
						'position'   => $position,
						'areas'      => $areas,
						'image_1'    => $image_1,
						'link_phone' => $link_phone,
						'link_mail'  => $link_mail,
					];
				}
			}

			return $output;
		}
	}
}

$block    = new b_employees( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$items    = $block->output( 'items_taxonomy', 'employees_taxonomy' );

include __DIR__ . '/view.php';
