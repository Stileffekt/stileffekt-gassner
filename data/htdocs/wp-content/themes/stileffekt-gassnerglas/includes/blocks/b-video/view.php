<?php
/**
 * @var object $block
 * @var string $overline
 * @var string $headline
 * @var string $text
 * @var string $video_1
 * @var string $video_oembed
 */
?>

<section id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?> l-padding">

    <div class="l-width">

        <div class="l-grid">

            <?php if ( ! empty( $overline ) || ! empty( $headline ) || ! empty( $text ) ): ?>
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
            <?php endif; ?>

            <?php if ( ! empty( $video_1 ) || ! empty( $video_oembed ) ): ?>
                <div class="b__video">
                    <?= $video_1 ?>
                    <?= $video_oembed ?>
                </div>
            <?php endif; ?>

        </div>

    </div>

</section>
