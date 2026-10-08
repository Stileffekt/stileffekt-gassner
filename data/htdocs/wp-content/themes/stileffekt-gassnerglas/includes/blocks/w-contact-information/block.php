<?php
if ( ! class_exists( 'w_contact_information' ) ) {
    class w_contact_information extends Stilpress_Block_Helper {
        protected function output_contact_items( array $data ): array {
            if ( empty( $data['value'] ) ) {
                return [];
            }

            $output = [];

            foreach ( $data['value'] as $item ) {
                $icon = ! empty( $item['icon'] ) ? stilpress__return_icon( $item['icon'] ) : '';
                $type = ! empty( $item['type'] ) ? $item['type'] : 'link';

                $content = '';

                if ( $type === 'link' && ! empty( $item['link'] ) ) {
                    $link_data   = $item['link'];
                    $url         = esc_url( $link_data['url'] );
                    $title       = ! empty( $link_data['title'] ) ? esc_html( $link_data['title'] ) : esc_html( $link_data['url'] );
                    $target      = ! empty( $link_data['target'] ) ? esc_attr( $link_data['target'] ) : '';
                    $target_attr = $target ? ' target="' . $target . '" rel="noopener noreferrer"' : '';
                    $content     = '<a href="' . $url . '"' . $target_attr . '>' . $title . '</a>';
                } elseif ( $type === 'text' && ! empty( $item['text'] ) ) {
                    $content = '<span>' . esc_html( $item['text'] ) . '</span>';
                }

                if ( empty( $icon ) && empty( $content ) ) {
                    continue;
                }

                $output[] = [
                    'icon'    => $icon,
                    'content' => $content,
                ];
            }

            return $output;
        }
    }
}

$block    = new w_contact_information( $block );
$headline = $block->output( 'headline', 'headline' );
$items    = $block->output( 'items', 'contact_items' );

include __DIR__ . '/view.php';
