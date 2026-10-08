<?php
/**
 * @var object $block
 * @var string $overline
 * @var string $headline
 * @var string $text
 * @var string $button_1
 * @var string $button_2
 * @var string $go_live
 */
?>

<section id="<?= esc_attr( $block->return_id() ); ?>" class="<?= esc_attr( $block->return_classes() ); ?> l-padding">

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

                <?php if ( ! empty( $go_live ) ): ?>
                    <div class="b__countdown" data-countdown data-go-live="<?= esc_attr( $go_live ); ?>">
                        <div class="b__countdown-item">
                            <span class="b__countdown-value" data-countdown-value="days">00</span>
                            <span class="b__countdown-label">Tage</span>
                        </div>
                        <div class="b__countdown-item">
                            <span class="b__countdown-value" data-countdown-value="hours">00</span>
                            <span class="b__countdown-label">Stunden</span>
                        </div>
                        <div class="b__countdown-item">
                            <span class="b__countdown-value" data-countdown-value="minutes">00</span>
                            <span class="b__countdown-label">Minuten</span>
                        </div>
                        <div class="b__countdown-item">
                            <span class="b__countdown-value" data-countdown-value="seconds">00</span>
                            <span class="b__countdown-label">Sekunden</span>
                        </div>
                    </div>
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

        </div>

    </div>

</section>
