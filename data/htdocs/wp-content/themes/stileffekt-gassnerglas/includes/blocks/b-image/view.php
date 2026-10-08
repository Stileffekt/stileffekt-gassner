<?php
/**
 * @var object $block
 * @var string $headline
 * @var string $text
 * @var string $link_1
 * @var string $link_2
 */
?>

<section id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?> l-padding">

    <div class="l-width">

        <div class="l-grid">

            <div class="b__image">

                <?php if ( ! empty( $image_1 ) ): ?>
                    <?= $image_1 ?>
                <?php endif; ?>

            </div>

        </div>

    </div>

</section>
