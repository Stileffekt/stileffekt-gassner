<?php
/**
 * @var object $block
 * @var string $headline
 * @var string $text
 * @var string $list
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
                <div class="b__list">

                    <div class="c-list">

                        <?php foreach ( $items as $item ): ?>

                            <?php
                            $item_id = 'content-' . $block->return_id() . '-' . $loop->index;
                            ?>
                            <div class="c-list__item l-grid" data-expandable>

                                <div class="c-list__icon">
                                    <?= $item['icon'] ?>
                                </div>

                                <div class="c-list__title">
                                    <?= $item['title'] ?>
                                </div>

                                <div class="c-list__content">
                                    <div class="c-list__content-inner" data-expandable-content id="<?= $item_id ?>">
                                        <?= $item['text'] ?>
                                    </div>
                                    <button
                                            type="button"
                                            class="c-button c-list__expand-btn"
                                            data-expand-toggle
                                            aria-expanded="false"
                                            aria-controls="<?= $item_id ?>"
                                            hidden
                                    >
                                        <span data-text="more">Mehr anzeigen</span>
                                        <span data-text="less" hidden>Weniger anzeigen</span>
                                        <svg class="c-list__expand-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                                            <line class="c-list__expand-icon-horizontal" x1="8" y1="2" x2="8" y2="14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <line class="c-list__expand-icon-vertical" x1="2" y1="8" x2="14" y2="8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>

</section>
