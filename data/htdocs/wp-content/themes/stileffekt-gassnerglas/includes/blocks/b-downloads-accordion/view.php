<?php
/**
 * @var object $block
 * @var string $overline
 * @var string $headline
 * @var string $text
 * @var array $categories
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

                <div class="b__downloads">

                    <div class="c-downloads-accordion">

                        <?php foreach ( $items as $index => $item ): ?>

                            <?php if ( ! empty( $item['category'] ) && ! empty( $item['downloads'] ) ): ?>

                                <?php
                                $accordion_id = 'downloads-' . $block->return_id() . '-' . $index;
                                $content_id   = $accordion_id . '-content';
                                $is_first     = $index === 0;
                                ?>

                                <div class="c-downloads-accordion__item<?= $is_first ? ' active' : ''; ?>">

                                    <h3 class="c-downloads-accordion__header">
                                        <button
                                                class="c-downloads-accordion__button"
                                                aria-expanded="<?= $is_first ? 'true' : 'false'; ?>"
                                                aria-controls="<?= $content_id; ?>"
                                                id="<?= $accordion_id; ?>"
                                        >
                                            <span class="c-downloads-accordion__title">
                                                <?= esc_html( $item['category'] ); ?>
                                            </span>
                                            <span class="c-downloads-accordion__indicator" aria-hidden="true">
                                                <?= stilpress__return_icon( 'Arrow-Down-1--Streamline-Ultimate' ); ?>
                                            </span>
                                        </button>
                                    </h3>

                                    <div
                                            class="c-downloads-accordion__content"
                                            id="<?= $content_id; ?>"
                                            role="region"
                                            aria-labelledby="<?= $accordion_id; ?>"
                                    >
                                        <div class="c-downloads-accordion__inner">
                                            <div class="c-downloads">

                                                <?php foreach ( $item['downloads'] as $download ): ?>

                                                    <?php if ( ! empty( $download['file']['url'] ) ): ?>

                                                        <div class="c-downloads__item">

                                                            <div class="c-downloads__content">

                                                                <?php if ( ! empty( $download['text'] ) ): ?>
                                                                    <div class="c-downloads__text">
                                                                        <?= wp_kses_post( $download['text'] ); ?>
                                                                    </div>
                                                                <?php endif; ?>

                                                            </div>

                                                            <a class="c-downloads__button c-button"
                                                               href="<?= esc_url( $download['file']['url'] ); ?>"
                                                               target="_blank"
                                                               rel="noreferrer noopener"
                                                               download
                                                               aria-label="<?= __( 'Download the file', 'stilpress' ); ?>">
                                                                <span><?= __( 'Download', 'stilpress' ); ?></span>
                                                            </a>

                                                        </div>

                                                    <?php endif; ?>

                                                <?php endforeach; ?>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>
