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

		<?php if ( ! empty( $text ) ): ?>
			<?= $text ?>
		<?php endif; ?>

    </div>

</div>