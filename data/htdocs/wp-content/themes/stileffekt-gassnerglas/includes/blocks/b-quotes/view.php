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

            <?php if ( ! empty( $quotes ) ): ?>
            <div class="b__quotes">


                <div class="splide">
                    <div class="splide__track">
                        <div class="splide__list c-quotes">

                            <?php foreach ( $quotes as $quote ): ?>

                                <div class="c-quote splide__slide">

                                    <div class="c-quote__text">
                                        <?php if ( ! empty( $quote['text'] ) ): ?>
                                            <?php echo $quote['text']; ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="c-quote__meta">

                                        <div class="c-quote__media">
                                            <?php if ( ! empty( $quote['image'] ) ): ?>
                                                <?= $quote['image']; ?>
                                            <?php endif; ?>
                                        </div>

                                        <div class="c-quote__info">
                                            <div class="c-quote__name">
                                                <?= $quote['name']; ?><?= ! empty( $quote['position'] ) ? ',' : ''; ?>
                                            </div>
                                            <div class="c-quote__position">
                                                <?= $quote['position']; ?>
                                            </div>
                                            <div class="c-quote__company">
                                                <?php if ( ! empty( $quote['company'] ) ): ?>
                                                    <?= $quote['company']; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="splide__controls">

                        <?php $pagination_icon = stilpress__return_icon( 'Arrow-Thick-Right-1-Streamline-Ultimate' ); ?>
                        <div class="splide__arrows">
                            <button class="splide__arrow splide__arrow--prev"><?= $pagination_icon ?></button>
                            <button class="splide__arrow splide__arrow--next"><?= $pagination_icon ?></button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <?php endif; ?>

    </div>

</section>