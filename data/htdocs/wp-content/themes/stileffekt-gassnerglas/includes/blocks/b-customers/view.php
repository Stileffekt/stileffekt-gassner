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

                <div class="b__customers">

                    <div class="c-customers">

                        <?php foreach ( $items as $item ): ?>

                            <div class="c-customer l-grid">

                                <div class="c-customer__media">
                                    <?php if ( ! empty( $item['logo'] ) ): ?>
                                        <?= $item['logo']; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="c-customer__content">
                                    <?php if ( ! empty( $item['name'] ) ): ?>
                                        <div class="c-customer__name h2">
                                            <?= $item['name']; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $item['solution'] ) || ! empty( $item['system_environment'] ) ): ?>
                                        <div class="c-customer__text">

                                            <?php if ( ! empty( $item['solution'] ) ): ?>
                                                <div class="c-customer__solution">
                                                    <strong><?= __( 'Solution:', 'stilpress' ); ?></strong>
                                                    <?= $item['solution']; ?>
                                                </div>
                                            <?php endif; ?>

                                            <?php if ( ! empty( $item['systems_environment'] ) ): ?>
                                                <div class="c-customer__system_environment">
                                                    <strong><?= __( 'Systems & Environment:', 'stilpress' ); ?></strong>
                                                    <?= $item['systems_environment']; ?>
                                                </div>
                                            <?php endif; ?>

                                        </div>
                                    <?php endif; ?>

                                    <div class="c-links">
                                        <a class="c-link"
                                           href="<?= $item['link'] ?>" target="_blank">
                                            <div class="c-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="7.805" height="7.805"
                                                     viewBox="0 0 7.805 7.805">
                                                    <path d="M0,0V1.765H4.793L0,6.558,1.248,7.806,6.041,3.013V7.806H7.805V0Z"
                                                          transform="translate(0 -0.001)"></path>
                                                </svg>
                                            </div>
                                            <span>Website besuchen</span></a></div>
                                    <?php if ( ! empty( $item['link'] ) ): ?>

                                    <?php endif; ?>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>
