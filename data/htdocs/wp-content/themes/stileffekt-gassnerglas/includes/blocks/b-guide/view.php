<?php
/**
 * @var object $block
 * @var string $overline
 * @var string $headline
 * @var string $text
 * @var array $guide
 */
?>

<section id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?> l-padding">

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
            </div>

            <?php if ( ! empty( $guide ) ): ?>
                <div class="b__guide">
                    <div class="c-guide">
                        <?php foreach ( $guide as $item ): ?>
                            <div class="c-guide__item">

                                <div class="c-guide__content">

                                    <?php if ( ! empty( $item['image_1'] ) ): ?>
                                        <div class="c-guide__image">
                                            <?= $item['image_1'] ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $item['title'] ) || ! empty( $item['text'] ) ): ?>

                                        <div class="c-guide__text">
                                            <?php if ( ! empty( $item['title'] ) ): ?>

                                                <div class="c-guide__title h3">
                                                    <?= $item['title'] ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ( ! empty( $item['text'] ) ): ?>
                                                <div>
                                                    <?= $item['text'] ?>
                                                </div>
                                            <?php endif; ?>

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
