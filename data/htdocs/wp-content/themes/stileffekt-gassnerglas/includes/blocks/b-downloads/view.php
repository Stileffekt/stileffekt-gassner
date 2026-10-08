<?php
/**i
 * @var object $block
 * @var string $overline
 * @var string $headline
 * @var string $text
 * @var array $documents
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

            <?php if ( ! empty( $downloads ) ): ?>

                <div class="b__documents">

                    <div class="c-documents">

                        <?php foreach ( $downloads as $item ): ?>
                            <?php if ( ! empty( $item['file']['url'] ) ): ?>
                                <div class="c-downloads__item">

                                    <a class="c-button" href="<?= $item['file']['url'] ?>" target="_blank">
                                        <span><?= __( 'Download', 'stilpress' ); ?></span>
                                        <?= stilpress__return_icon( 'Keyboard-Arrow-Down--Streamline-Ultimate' ); ?>
                                    </a>

                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </div>

                </div>
            <?php endif; ?>

        </div>

    </div>

</section>
