<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_downloads_categories' ) ) {
	class b_downloads_categories extends Stilpress_Block_Helper {
		protected function output_downloads_categories( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $category_id ) {

				$category = get_term( $category_id, 'download-category' );

				if ( ! $category || is_wp_error( $category ) ) {
					continue;
				}

				$args = [
					'post_type'      => 'download',
					'posts_per_page' => - 1,
					'orderby'        => 'title',
					'order'          => 'ASC',
					'tax_query'      => [
						[
							'taxonomy' => 'download-category',
							'field'    => 'term_id',
							'terms'    => $category_id,
						],
					],
				];

				$query = new WP_Query( $args );

				$downloads = [];

				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();

						$data = get_field( 'ptype_download', get_the_ID() );

						if ( empty( $data ) ) {
							continue;
						}

						$downloads[] = [
							'file' => ! empty( $data['file'] ) ? $data['file'] : '',
							'text' => ! empty( $data['text'] ) ? $data['text'] : '',
						];
					}
					wp_reset_postdata();
				}

				if ( ! empty( $downloads ) ) {
					$output[] = [
						'category'  => $category->name,
						'downloads' => $downloads,
					];
				}
			}

			return $output;
		}
	}
}

$block    = new b_downloads_categories( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$items    = $block->output( 'taxonomies', 'downloads_categories' );

include __DIR__ . '/view.php';
