<?php
/**
 * @var array $block
 */
?>

<?php if ( ! empty( $items ) ): ?>

    <section id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?> l-padding">

        <div class="l-width">

            <div class="l-grid">

                <div class="b__counter">

                    <div class="c-counter">

                        <?php foreach ( $items as $item ): ?>
                            <div class="c-counter__item">

                                <?php if ( ! empty( $item['icon'] ) ): ?>
                                    <div class="c-counter__icon">
                                        <?= $item['icon'] ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $item['value'] ) ): ?>
                                    <div class="c-counter__value"
                                         data-value="<?= $item['value'] ?>"
                                         data-duration="5"
                                         data-suffix="<?= $item['suffix'] ?>">
                                        1
                                    </div>
                                <?php endif; ?>

                                <?php if ( ! empty( $item['text'] ) ): ?>
                                    <div class=" c-counter__text">
                                        <?= $item['text'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

        </div>

    </section>

<?php endif; ?>
