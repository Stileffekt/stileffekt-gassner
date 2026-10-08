<?php
/**
 * @var object $block
 * @var string $structure_visible
 * @var string $headline
 * @var string $text
 * @var array $quotes
 */
?>

<section id="<?= $block->return_id(); ?>"
         class="<?= $block->return_classes(); ?> l-padding l-background-2 l-padding-top l-padding-bottom">

    <?php if ( ! empty( $structure_visible ) && $structure_visible === '1' ): ?>
        <div class="b__background b__background--structure">
            <img src="<?= get_theme_file_uri( '/assets/images/wood-structure.png' ) ?>" alt="" aria-hidden="true">
        </div>
    <?php endif; ?>

    <div class="l-width">

        <div class="l-grid">

            <div class="b__content">

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

                                        <div class="c-quote__inner">
                                            <div class="c-quote__text">
                                                <?php if ( ! empty( $quote['text'] ) ): ?>
                                                    <?php echo $quote['text']; ?>
                                                <?php endif; ?>
                                            </div>

                                            <div class="c-quote__website">
                                                <?php if ( ! empty( $quote['website'] ) ): ?>
                                                    <?= $quote['website']; ?>
                                                <?php endif; ?>
                                            </div>

                                            <div class="c-quote__author">
                                                <?= $quote['author']; ?>
                                            </div>

                                        </div>

                                    </div>

                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="splide__controls">

                            <?php $pagination_icon = stilpress__return_icon( 'Arrow-Right-1-Streamline-Ultimate' ); ?>
                            <div class="splide__arrows">
                                <button class="splide__arrow splide__arrow--prev"><?= $pagination_icon ?></button>
                                <button class="splide__arrow splide__arrow--next"><?= $pagination_icon ?></button>
                            </div>
                        </div>

                    </div>
                </div>

            <?php endif; ?>

        </div>

    </div>

</section>