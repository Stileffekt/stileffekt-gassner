<?php

/**
 * @var object $block
 * @var string $overline
 * @var string $headline
 * @var string $image_1
 * @var string $video_1
 * @var string $icon
 */
?>

<section id="<?= $block->return_id(); ?>"
         class="<?= $block->return_classes(); ?> l-padding l-padding-top">

    <div class="l-width">

        <div class="l-grid">

            <div class="b__content">

                <?php if ( ! empty( $overline ) ): ?>
                    <?= $overline ?>
                <?php endif; ?>

                <?php if ( ! empty( $headline ) ): ?>
                    <?= $headline ?>
                <?php endif; ?>

                <?php if ( ! empty( $text ) ): ?>
                    <?= $text ?>
                <?php endif; ?>

                <?php if ( ! empty( $button_1 ) || ! empty( $button_2 ) ) : ?>
                    <div class="c-buttons">
                        <?php if ( ! empty( $button_1 ) ): ?>
                            <?= $button_1 ?>
                        <?php endif; ?>
                        <?php if ( ! empty( $button_2 ) ): ?>
                            <?= $button_2 ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>

            <?php if ( ! empty( $image_1 ) || ! empty( $video_1 ) ): ?>
                <div class="b__media">
                    <?= $image_1 ?>
                    <?= $video_1 ?>
                </div>
            <?php endif; ?>

        </div>

    </div>

    <div class="b__background"></div>

    <button class="b__arrow" type="button" aria-label="<?= esc_attr__( 'Scroll down', 'stilpress' ); ?>">
        <?= stilpress__return_icon( 'Arrow-Down-1-Streamline-Ultimate' ) ?>
    </button>

</section>
