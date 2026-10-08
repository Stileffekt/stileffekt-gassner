<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'b_faqs' ) ) {
	class b_faqs extends Stilpress_Block_Helper {

		protected function output_faqs( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$term_ids   = (array) $data['value'];
			$categories = [];

			foreach ( $term_ids as $term_id ) {

				$term = get_term( (int) $term_id, 'faq-category' );

				if ( is_wp_error( $term ) || empty( $term ) ) {
					continue;
				}

				$query = new WP_Query( [
					'post_type'      => 'faq',
					'posts_per_page' => - 1,
					'orderby'        => 'date',
					'order'          => 'ASC',
					'tax_query'      => [ [
						'taxonomy' => 'faq-category',
						'field'    => 'term_id',
						'terms'    => (int) $term_id,
					] ],
				] );

				$faqs = [];

				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();
						$faq_data = get_field( 'ptype_faq', get_the_ID() );
						if ( empty( $faq_data['question'] ) || empty( $faq_data['answer'] ) ) {
							continue;
						}
						$faqs[] = [
							'question' => $faq_data['question'],
							'answer'   => $faq_data['answer'],
						];
					}
					wp_reset_postdata();
				}

				if ( ! empty( $faqs ) ) {
					$categories[] = [
						'term_id' => (int) $term_id,
						'name'    => $term->name,
						'faqs'    => $faqs,
					];
				}
			}

			return $categories;
		}
	}
}

$block    = new b_faqs( $block );
$overline = $block->output( 'overline', 'overline' );
$headline = $block->output( 'headline', 'headline' );
$text     = $block->output( 'text', 'text' );
$items    = $block->output( 'items_taxonomy', 'faqs' );

$headline_type          = get_field( 'headline_type' ) ?: 'h2';
$headline_base          = min( (int) substr( $headline_type, 1 ), 6 );
$category_headline_type = 'h' . min( $headline_base + 1, 6 );
$item_headline_type     = 'h' . min( $headline_base + 2, 6 );

include __DIR__ . '/view.php';