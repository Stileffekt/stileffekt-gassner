<?php
/**
 * @var object $block
 * @var string $headline
 * @var string $text
 * @var string $link_1
 * @var string $link_2
 * @var string $icon
 */
?>

<div id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?> l-padding b-quotes--single">

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

			<?php if ( ! empty( $quotes ) ): ?>
                <div class="b__quotes">

					<?php foreach ( $quotes as $quote ): ?>

                        <div class="c-quote c-quote--single">

                            <div class="c-quote__text">
								<?php if ( ! empty( $quote['text'] ) ): ?>
									<?php echo $quote['text']; ?>
								<?php endif; ?>
                            </div>

                            <div class="c-quote__meta">

								<?php if ( ! empty( $quote['image'] ) ): ?>
                                    <div class="c-quote__media">
										<?= $quote['image']; ?>
                                    </div>
								<?php endif; ?>

                                <div class="c-quote__info">

									<?php if ( ! empty( $quote['name'] ) ): ?>
                                        <div class="c-quote__name">
											<?= $quote['name']; ?><?= ! empty( $quote['position'] ) ? ',' : ''; ?>
                                        </div>
									<?php endif; ?>

									<?php if ( ! empty( $quote['position'] ) ): ?>
                                        <div class="c-quote__position">
											<?= $quote['position']; ?>
                                        </div>
									<?php endif; ?>

									<?php if ( ! empty( $quote['company'] ) ): ?>
                                        <div class="c-quote__company">
											<?= $quote['company']; ?>
                                        </div>
									<?php endif; ?>
                                </div>

                            </div>

                        </div>

					<?php endforeach; ?>

                </div>
			<?php endif; ?>

        </div>

    </div>
</div>
