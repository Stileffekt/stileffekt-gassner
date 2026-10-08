<?php
/**
 * @var object $block
 * @var string $structure_visible
 * @var string $overline
 * @var string $headline
 * @var string $text
 * @var array $items
 */
?>

<section id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?> l-padding">

    <?php if ( ! empty( $structure_visible ) && $structure_visible === '1' ): ?>
        <div class="b__background b__background--structure">
            <img src="<?= get_theme_file_uri( '/assets/images/wood-structure.png' ) ?>" alt="" aria-hidden="true">
        </div>
    <?php endif; ?>

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

            <?php if ( ! empty( $items ) ): ?>
                <div class="b__items">

                    <div class="c-price c-price--count-<?= min( count( $items ), 4 ) ?>">

                        <?php foreach ( $items as $item ): ?>

                            <div class="c-price__item">

                                <?php if ( ! empty( $item['title'] ) || ! empty( $item['description'] ) ): ?>

                                    <div class="c-price__header">
                                        <?php if ( ! empty( $item['title'] ) ): ?>
                                            <div class="c-price__title">
                                                <?= $item['title'] ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ( ! empty( $item['description'] ) ): ?>
                                            <div class="c-price__description">
                                                <?= $item['description'] ?>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                <?php endif; ?>

                                <div class="c-price__price">
                                    <?php if ( $item['price_free'] ): ?>
                                        <span class="c-price__free">Kostenlos</span>
                                    <?php else: ?>
                                        <?php if ( ! empty( $item['price_prefix'] ) ): ?>
                                            <span class="c-price__prefix"><?= $item['price_prefix'] ?></span>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $item['price_from'] ) ): ?>
                                            <span class="c-price__from"><?= $item['price_from'] ?></span>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $item['price_to'] ) ): ?>
                                            <span class="c-price__separator">–</span>
                                            <span class="c-price__to"><?= $item['price_to'] ?></span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <?php if ( ! empty( $item['text'] ) ): ?>
                                    <div class="c-price__text"><?= $item['text'] ?></div>
                                <?php endif; ?>

                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>
            <?php endif; ?>

        </div>

    </div>

</section>
