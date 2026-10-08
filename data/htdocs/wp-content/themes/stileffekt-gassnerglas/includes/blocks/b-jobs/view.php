<?php
/**
 * @var object $block
 * @var string $overline
 * @var string $headline
 * @var string $text
 * @var array $items
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

            <div class="b__jobs">

                <div class="c-jobs">

                    <?php foreach ( $items as $item ): ?>

                        <?php if ( ! empty( $item['permalink'] ) ): ?>


                            <a class="c-jobs__item" href="<?= $item['permalink'] ?>">

                                <div class="c-jobs__type">
                                    <?= $item['type']; ?>
                                </div>

                                <div class="c-jobs__title">
                                    <?= $item['title']; ?>
                                </div>

                                <button class="c-jobs__icon"
                                        aria-label="<?= __( 'Open job', 'stilpress' ) ?> <?= $item['title'] ?>">
                                    <?= stilpress__return_icon( 'Arrow-Right-1-Streamline-Ultimate' ); ?>
                                </button>

                            </a>


                        <?php endif; ?>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>

    </div>

</section>
