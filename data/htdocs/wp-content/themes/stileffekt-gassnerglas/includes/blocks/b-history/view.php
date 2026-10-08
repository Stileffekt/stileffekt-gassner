<?php
/**
 * @var object $block
 * @var string $overline
 * @var string $headline
 * @var string $text
 * @var array $history
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


            <?php if ( ! empty( $history ) ): ?>
                <div class="b__history">
                    <div class="c-history">
                        <?php foreach ( $history as $item ): ?>
                            <div class="c-history__item">

                                <div class="c-history__content">

                                    <?php if ( ! empty( $item['title'] ) ): ?>
                                        <div class="c-history__title h2">
                                            <span><?= $item['title'] ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $item['text'] ) ): ?>
                                        <div class="c-history__text">
                                            <span><?= $item['text'] ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $item['image'] ) ): ?>
                                        <div class="c-history__image">
                                            <?= $item['image'] ?>
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
