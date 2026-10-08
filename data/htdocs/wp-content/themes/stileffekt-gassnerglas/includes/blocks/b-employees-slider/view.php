<?php
/**
 * @var object $block
 * @var string $headline
 * @var string $text
 * @var string $link_1
 * @var string $link_2
 * @var string $icon
 * @var array $images
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

            <?php if ( ! empty( $employees ) ): ?>
            <div class="b__employees">

                <div class="splide">

                    <div class="splide__track">

                        <div class="splide__list c-employee">

                            <?php foreach ( $employees as $item ): ?>

                                <div class="c-employee splide__slide">

                                    <div class="c-employee__media">

                                        <?php if ( ! empty( $item['image'] ) ): ?>
                                            <?= $item['image'] ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="c-employee__content">

                                        <div class="c-employee__name">
                                            <?php if ( ! empty( $item['name'] ) ): ?>
                                                <?= $item['name'] ?>
                                            <?php endif; ?>
                                        </div>

                                        <div class="c-employee__description">
                                            <?php if ( ! empty( $item['description'] ) ): ?>
                                                <?= $item['description'] ?>
                                            <?php endif; ?>
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
                        <div class="splide__pagination"></div>
                    </div>

                </div>
            </div>

        </div>
        <?php endif; ?>

    </div>

</section>