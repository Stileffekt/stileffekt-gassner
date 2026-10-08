<?php
/**
 * @var array $block
 * @var string $headline
 * @var string $overline
 * @var string $text
 * @var string $icon
 * @var array $items
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

            <?php if ( ! empty( $items ) ): ?>

                <div class="b__employees">

                    <div class="c-employees">

                        <?php foreach ( $items as $item ): ?>

                            <div class="c-employee">

                                <div class="c-employee__media">
                                    <?php if ( ! empty( $item['image_1'] ) ): ?>
                                        <?= $item['image_1']; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="c-employee__content">

                                    <div class="c-employee__hidden">
                                        <?php if ( ! empty( $item['areas'] ) ): ?>
                                            <div class="c-employee__areas">
                                                <?= $item['areas']; ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ( ! empty( $item['link_phone'] ) ): ?>
                                            <div class="c-employee__phone">
                                                <?= $item['link_phone']; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="c-employee__fixed">
                                        <div class="c-employee__position">
                                            <?php if ( ! empty( $item['position'] ) ): ?>
                                                <?= $item['position']; ?>
                                            <?php endif; ?>
                                        </div>

                                        <div class="c-employee__name">
                                            <?php if ( ! empty( $item['name'] ) ): ?>
                                                <?= $item['name']; ?>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>
