<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_jobs' ) ) {
	class b_jobs extends Stilpress_Block_Helper {

		protected function output_jobs( array $data ): array {

			if ( empty( $data ) ) {
				return [];
			}

			$args = [
				'post_type'      => 'job',
				'posts_per_page' => - 1,
				'orderby'        => 'date',
				'order'          => 'ASC',
			];

			if ( ! empty( $data['value'] ) ) {
				$args['tax_query'] = [
					[
						'taxonomy' => 'job-category',
						'field'    => 'term_id',
						'terms'    => $data['value'],
					],
				];
			}

			$query = new WP_Query( $args );

			$data = [];

			if ( $query->have_posts() ) {

				while ( $query->have_posts() ) {

					$query->the_post();

					$post_data = get_field( 'ptype_job', get_the_ID() );

					$id        = get_the_ID();
					$permalink = get_the_permalink();
					$title     = get_the_title();

					$type = ! empty( $post_data['type'] ) ? $post_data['type'] : '';

					$data[] = [
						'id'        => $id,
						'type'      => $type,
						'title'     => $title,
						'permalink' => $permalink,
					];
				}
			}

			return $data;

		}
	}
}

$block    = new b_jobs( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$items    = $block->output( 'job_taxonomy', 'jobs' );

include __DIR__ . '/view.php';
