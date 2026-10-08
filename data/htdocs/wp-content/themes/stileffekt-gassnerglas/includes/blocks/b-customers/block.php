<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_customers' ) ) {
	class b_customers extends Stilpress_Block_Helper {
		protected function output_customers_taxonomy( array $data ): array {

			$args = [
				'post_type'      => 'customer',
				'posts_per_page' => - 1,
			];

			if ( ! empty( $data['value'] ) ) {
				$args['tax_query'] = [
					[
						'taxonomy' => 'customer-category',
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

					$query_data          = get_field( 'ptype_customer', get_the_ID() );
					$name                = ! empty( get_the_title() ) ? '<span>' . get_the_title() . '</span>' : '';
					$solution            = ! empty( $query_data['solution'] ) ? '<span>' . $query_data['solution'] . '</span>' : '';
					$systems_environment = ! empty( $query_data['systems_environment'] ) ? '<span>' . $query_data['systems_environment'] . '</span>' : '';
					$link                = ! empty( $query_data['link'] ) ? $query_data['link'] : '';

					$logo = '';
					if ( ! empty( $query_data['logo'] ) ) {
						$logo = $this->output_image( [
							'value'     => $query_data['logo'],
							'arguments' => [
								'image_behaviour' => 'contain'
							]
						] );
					}

					$output[] = [
						'name'                => $name,
						'solution'            => $solution,
						'systems_environment' => $systems_environment,
						'logo'                => $logo,
						'link'                => $link,
					];
				}
			}

			return $output;
		}
	}
}

$block    = new b_customers( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$items    = $block->output( 'items_taxonomy', 'customers_taxonomy' );

include __DIR__ . '/view.php';