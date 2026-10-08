<?php
/**
 * @var object $block
 * @var string $overline
 * @var string $headline
 * @var string $text
 */
?>

<section id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?> l-padding">

    <div class="l-width">

        <div class="l-grid">

            <?php if ( ! empty( $overline ) || ! empty( $headlinne ) || ! empty( $text ) ): ?>
                <div class="b__content">
                    <?php if ( ! empty( $overline ) ): ?>
                        <?= $overline; ?>
                    <?php endif; ?>

                    <?php if ( ! empty( $headline ) ): ?>
                        <?= $headline; ?>
                    <?php endif; ?>

                    <?php if ( ! empty( $text ) ): ?>
                        <?= $text; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $form ) ): ?>
                <div class="b__form">
                    <?= $form; ?>
                </div>
            <?php endif; ?>

        </div>

    </div>

</section>
