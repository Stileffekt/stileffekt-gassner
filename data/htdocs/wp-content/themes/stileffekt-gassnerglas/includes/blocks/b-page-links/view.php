<?php
/**
 * @var object $block
 * @var string $overline
 * @var string $headline
 * @var string $text
 * @var array $links
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

            <?php if ( ! empty( $links ) ): ?>

                <div class="b__pagelinks">

                    <div class="c-page-links">

                        <?php foreach ( $links as $item ): ?>

                            <?php if ( ! empty( $item['url'] ) ): ?>
                                <a class="c-page-links__item"<?= $item['url'] ?><?= $item['target'] ?>>

                                    <div class="c-page-links__title">
                                        <?= $item['title'] ?>
                                    </div>

                                    <div class="c-page-links__icon">
                                        <?= stilpress__return_icon( 'Keyboard-Arrow-Right--Streamline-Ultimate' ) ?>
                                    </div>

                                </a>
                            <?php endif; ?>

                        <?php endforeach; ?>

                    </div>

                </div>
            <?php endif; ?>

        </div>

    </div>

</section>
