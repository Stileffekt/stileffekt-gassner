<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_references' ) ) {
	class b_references extends Stilpress_Block_Helper {

		private function return_meta( string $name ): array {
			return [];
		}

		public function output_references(): array {

			$args = [
				'post_type'      => 'reference',
				'posts_per_page' => - 1,
			];

			$query = new WP_Query( $args );

			$output = [];

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$query_data = '';
					$query_data = get_field( 'ptype_reference', get_the_ID() );

					$text = $name = $position = $company = $image = '';

					$title      = ! empty( get_the_title() ) ? get_the_title() : '';
					$permalink  = get_the_permalink();
					$quote_data = '';

					$logo = '';

					if ( ! empty( $query_data['logo'] ) ) {
						$logo = $this->output_image( [
							'value'     => $query_data['logo'],
							'arguments' => [
								'image_position'  => 'center-center',
								'image_behaviour' => 'contain',
							],
						] );
					}

					if ( ! empty( $query_data['quote'] ) ) {

						$quote_data = get_field( 'ptype_quote', $query_data['quote'] );
						$name       = ! empty( get_the_title() ) ? get_the_title( $query_data['quote'] ) : '';
						$text       = ! empty( $quote_data['text'] ) ? '„' . strip_tags( $quote_data['text'] ) . '“' : '';
						$position   = ! empty( $quote_data['position'] ) ? $quote_data['position'] : '';
						$company    = ! empty( $quote_data['company'] ) ? $quote_data['company'] : '';

						if ( ! empty( $quote_data['image'] ) ) {
							$image = $this->output_image( [
								'value'     => $quote_data['image'],
								'arguments' => [
									'image_position'  => 'center-center',
									'image_behaviour' => 'contain',
								],
							] );
						}
					}

					// Die Taxonomie-IDs abfragen
					$industries_terms = wp_get_post_terms( get_the_ID(), 'reference-industry', [ 'fields' => 'ids' ] );
					$industries_ids   = is_array( $industries_terms ) ? implode( ',', $industries_terms ) : '';

					$areas_terms = wp_get_post_terms( get_the_ID(), 'reference-area', [ 'fields' => 'ids' ] );
					$areas_ids   = is_array( $areas_terms ) ? implode( ',', $areas_terms ) : '';

					$interfaces_terms = wp_get_post_terms( get_the_ID(), 'reference-interface', [ 'fields' => 'ids' ] );
					$interfaces_ids   = is_array( $interfaces_terms ) ? implode( ',', $interfaces_terms ) : '';

					$output[] = [
						'title'      => $title,
						'name'       => $name,
						'text'       => $text,
						'position'   => $position,
						'company'    => $company,
						'permalink'  => $permalink,
						'logo'       => $logo,
						'industries' => $industries_ids,
						'areas'      => $areas_ids,
						'interfaces' => $interfaces_ids,
					];
				}
			}

			return $output;
		}
	}
}

$industries = get_terms( [
	'taxonomy'   => 'reference-industry',
	'hide_empty' => true
] );
$interfaces = get_terms( [
	'taxonomy'   => 'reference-interface',
	'hide_empty' => true
] );
$areas      = get_terms( [
	'taxonomy'   => 'reference-area',
	'hide_empty' => true
] );


$block    = new b_references( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$items    = $block->output_references();

include __DIR__ . '/view.php';
