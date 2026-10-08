<?php
/**
 * @var object $block
 * @var string $headline
 * @var string $text
 * @var string $link_1
 * @var string $link_2
 */
?>

<section id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?> l-padding">

    <div class="l-width">

        <div class="l-grid">

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
            <div class="b__iframe">
                <?php if ( ! empty( $iframe ) ): ?>
                    <?= $iframe; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>

</section>
