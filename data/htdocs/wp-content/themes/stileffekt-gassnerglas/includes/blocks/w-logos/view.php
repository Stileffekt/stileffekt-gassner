<?php
/**
 * @var object $block
 * @var string $headline
 * @var string $text
 */
?>

<div id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?>">

    <div class="widget__inner">

        <?php if ( ! empty( $headline ) ): ?>
            <?= $headline ?>
        <?php endif; ?>

        <?php if ( ! empty( $items ) ): ?>
            <div class="c-logos">
                <?php foreach ( $items as $item ): ?>
                    <div class="c-logos__item">
                        <?= $item['image']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

</div>