<?php
/**
 * @var object $block
 * @var string $headline
 * @var array  $items
 */
?>

<div id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?>">
    <div class="widget__inner">
        <?php if ( ! empty( $headline ) ): ?>
            <?= $headline ?>
        <?php endif; ?>

        <?php if ( ! empty( $items ) ): ?>
            <ul>
                <?php foreach ( $items as $item ): ?>
                    <li>
                        <?php if ( ! empty( $item['icon'] ) ): ?>
                            <?= $item['icon'] ?>
                        <?php endif; ?>
                        <?php if ( ! empty( $item['content'] ) ): ?>
                            <?= $item['content'] ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
