<?php
/**
 * @var object $block
 * @var string $headline
 * @var string $text
 * @var string $link_1
 * @var string $link_2
 * @var string $items
 */
?>

<div id="<?= $block->return_id(); ?>"
     class="<?= $block->return_classes(); ?> l-padding l-background-1 l-text-inverted l-padding-top l-padding-bottom">

    <?php if ( ! empty( $image_1 ) ): ?>
        <div class="b__background">
            <?= $image_1; ?>
        </div>
    <?php endif; ?>

    <div class="l-width">

        <div class="l-grid">

            <?php if ( ! empty( $overline ) || ! empty( $headline ) || ! empty( $texct ) ): ?>
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

                </div>
            <?php endif; ?>

            <?php if ( ! empty( $items ) ): ?>

                <div class="b__boxes">

                    <div class="c-boxes">

                        <?php foreach ( $items as $item ): ?>

                            <div class="c-box">

                                <?php if ( ! empty( $item['icon'] ) ): ?>
                                    <?= $item['icon'] ?>
                                <?php endif; ?>

                                <?php if ( ! empty( $item['headline'] ) ): ?>
                                    <?= $item['headline'] ?>
                                <?php endif; ?>

                                <?php if ( ! empty( $item['text'] ) ): ?>
                                    <?= $item['text'] ?>
                                <?php endif; ?>

                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>

            <?php endif; ?>

        </div>

    </div>

</div>