<?php
/**
 * @var object $block
 * @var string $headline
 * @var array $items
 */
?>

<div id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?>">

    <div class="widget__inner">

        <?php if ( ! empty( $headline ) ): ?>
            <?= $headline ?>
        <?php endif; ?>

        <?php if ( ! empty( $items ) ): ?>
            <nav aria-label="Social Media">
                <ul>
                    <?php foreach ( $items as $item ): ?>
                        <?php if ( ! empty( $item['link'] ) ): ?>
                            <li><?= $item['link'] ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </nav>
        <?php endif; ?>

    </div>

</div>