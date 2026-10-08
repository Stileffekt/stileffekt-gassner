<?php

$items = get_field( 'sticky_icons', 'option' );

if ( empty( $items ) ) {
    return '';
}

?>

<div class="c-sticky-icons">

    <div class="c-sticky-icons__items">

        <?php foreach ( $items as $item ): ?>

            <div class="c-sticky-icons__item">

                <?php if ( $item['type'] === 'link' ): ?>
                <a href="<?php echo esc_url( $item['link']['url'] ); ?>"
                   target="<?php echo esc_attr( ! empty( $item['link']['target'] ) ? $item['link']['target'] : '_self' ); ?>"
                   rel="noopener">
                    <?php else: ?>
                    <button type="button">
                        <?php endif; ?>

                        <div class="c-sticky-icons__content">
                            <?php if ( $item['type'] === 'link' ): ?>
                                <?php echo esc_html( $item['link']['title'] ); ?>
                            <?php else: ?>
                                <?php echo wp_kses_post( $item['text'] ); ?>
                            <?php endif; ?>
                        </div>

                        <div class="c-sticky-icons__icon">
                            <?php echo stilpress__return_icon( $item['icon'] ); ?>
                        </div>

                        <?php if ( $item['type'] === 'link' ): ?>
                </a>
            <?php else: ?>
                </button>
            <?php endif; ?>

            </div>

        <?php endforeach; ?>

    </div>

</div>
