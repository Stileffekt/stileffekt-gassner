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

            <?php if ( ! empty( $images ) ): ?>
            <div class="b__logos">

                <div class="splide">

                    <div class="splide__track">

                        <div class="splide__list c-logos">

                            <?php foreach ( $images as $item ): ?>

                                <?php if ( ! empty( $item['link'] ) ): ?>
                                    <a class="c-logos__item splide__slide"
                                       href="<?= $item['link']['url'] ?>" <?= ( ! empty( $item['link']['target'] ) ) ? 'target="' . $item['link']['target'] . '"' : '' ?><?= ( ! empty( $item['link']['title'] ) ) ? ' aria-label="' . $item['link']['title'] . '"' : '' ?>>
                                        <?= $item['image'] ?>
                                    </a>
                                <?php else: ?>
                                    <div class="c-logos__item splide__slide">
                                        <?= $item['image'] ?>
                                    </div>
                                <?php endif; ?>

                            <?php endforeach; ?>

                        </div>

                    </div>

                </div>

            </div>

        </div>
        <?php endif; ?>

    </div>

</section>