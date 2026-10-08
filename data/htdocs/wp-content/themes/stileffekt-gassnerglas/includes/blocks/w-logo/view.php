<?php
/**
 * @var object $block
 * @var string $logo
 */
?>

<div id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?>">

    <div class="widget__inner">

        <?php if ( ! empty( $logo ) ): ?>
            <?= $logo ?>
        <?php endif; ?>

    </div>

</div>