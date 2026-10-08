<?php
/**
 * @var object $block
 * @var string $headline
 * @var string $text
 * @var string $link_1
 * @var string $link_2
 * @var string $icon
 */
?>

<section id="<?= $block->return_id(); ?>"
         class="<?= $block->return_classes(); ?> l-padding<?= ! empty( $box_columns ) ? ' b-columns-' . $box_columns : '' ?>">

    <div class="l-width">

        <div class="l-grid">

            <?php if ( ! empty( $overline ) || ! empty( $headline ) || ! empty( $text ) ): ?>
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

            <?php if ( ! empty( $boxes ) ): ?>

                <div class="b__boxes">

                    <div class="c-boxes">

                        <?php foreach ( $boxes as $box ): ?>

                            <div class="c-box">

                                <?php if ( ! empty( $box['image'] ) ): ?>
                                    <div class="c-box__header">
                                        <?= $box['image'] ?>
                                    </div>
                                <?php endif; ?>

                                <div class="c-box__body">

                                    <?php if ( ! empty( $box['title'] ) ): ?>
                                        <?= $box['title'] ?>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $box['text'] ) ): ?>
                                        <?= $box['text'] ?>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $box['link_1'] ) ): ?>
                                        <div class="c-links">
                                            <?= $box['link_1'] ?>
                                        </div>
                                    <?php endif; ?>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>
