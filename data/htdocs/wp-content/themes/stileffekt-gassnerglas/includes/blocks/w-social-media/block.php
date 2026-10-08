<?php

/**
 * @var array $block
 */

if ( ! class_exists( 'w_social_media' ) ) {
	class w_social_media extends Stilpress_Block_Helper {

		protected function output_socials( array $data ): array {

			if ( empty( $data['value'] ) ) {
				return [];
			}

			$output = [];

			foreach ( $data['value'] as $item ) {

				$icon      = ! empty( $item['icon'] ) ? stilpress__return_icon( $item['icon'] ) : '';
				$link_data = ! empty( $item['link'] ) ? $item['link'] : [];

				if ( empty( $link_data['url'] ) ) {
					continue;
				}

				$url         = esc_url( $link_data['url'] );
				$title       = ! empty( $link_data['title'] ) ? esc_attr( $link_data['title'] ) : '';
				$target      = ! empty( $link_data['target'] ) ? esc_attr( $link_data['target'] ) : '';
				$target_attr = $target ? ' target="' . $target . '" rel="noopener noreferrer"' : '';

				$link = '<a href="' . $url . '" aria-label="' . $title . '"' . $target_attr . '>';
				$link .= $icon;
				$link .= '<span class="screen-reader-text">' . $title . '</span>';
				$link .= '</a>';

				$output[] = [
					'link' => $link,
				];
			}

			return $output;
		}
	}
}

$block    = new w_social_media( $block );
$headline = $block->output( 'headline', 'headline' );
$items    = $block->output( 'items', 'socials' );

include __DIR__ . '/view.php';