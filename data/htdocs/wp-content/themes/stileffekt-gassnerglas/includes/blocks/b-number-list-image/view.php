<?php
/**
 * @var object $block
 * @var string $structure_visible
 * @var string $overline
 * @var string $headline
 * @var string $text
 * @var array $items
 * @var string $button_1
 * @var string $button_2
 * @var string $image_1
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

                <?php if ( ! empty( $items ) ): ?>
                    <ol class="c-number-list">
                        <?php foreach ( $items as $index => $item ): ?>
                            <li class="c-number-list__item">
                                <div class="c-number-list__number"><?= str_pad( $index + 1, 2, '0', STR_PAD_LEFT ) ?></div>
                                <div class="c-number-list__body">
                                    <?php if ( ! empty( $item['headline'] ) ): ?>
                                        <div class="c-number-list__headline"><?= $item['headline'] ?></div>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $item['description'] ) ): ?>
                                        <div class="c-number-list__description"><?= $item['description'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                <?php endif; ?>

                <?php if ( ! empty( $button_1 ) || ! empty( $button_2 ) ) : ?>
                    <div class="c-buttons">
                        <?php if ( ! empty( $button_1 ) ): ?>
                            <?= $button_1 ?>
                        <?php endif; ?>
                        <?php if ( ! empty( $button_2 ) ): ?>
                            <?= $button_2 ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="b__image">
                <?php if ( ! empty( $image_1 ) ): ?>
                    <?= $image_1 ?>
                <?php endif; ?>
            </div>

        </div>

    </div>

</section>
