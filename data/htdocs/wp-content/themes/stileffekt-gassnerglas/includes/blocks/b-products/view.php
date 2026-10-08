<?php
/**
 * @var array $block
 * @var string $headline
 * @var array $posts
 */
?>

<?php if ( ! empty( $products ) ): ?>
    <div id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?>">

        <div class="l-padding">

            <div class="l-width">

                <div class="l-grid">

                    <div class="b__navigation">

                        <h2>Produktübersicht</h2>

                        <nav aria-label="Produktübersicht">
                            <ol>
                                <?php foreach ( $products as $item ): ?>
                                    <?php if ( ! empty( $item['slug'] ) && ! empty( $item['title'] ) ): ?>
                                        <li>
                                            <a href="#<?= esc_attr( $item['slug'] ) ?>"><?= strip_tags( $item['title'] ) ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>
        </div>

        <div class="b__products">

            <div class="c-products">

                <?php foreach ( $products as $item ): ?>
                    <div id="<?= esc_attr( $item['slug'] ) ?>" class="c-product l-padding">

                        <div class="l-width">
                            <div class="l-grid">

                                <div class="c-product__header">
                                    <?php if ( ! empty( $item['overline'] ) ): ?>
                                        <?= $item['overline'] ?>
                                    <?php endif; ?>
                                    <?php if ( ! empty( $item['title'] ) ): ?>
                                        <?= $item['title'] ?>
                                    <?php endif; ?>
                                </div>

                                <?php if ( ! empty( $item['image'] ) ): ?>
                                    <div class="c-product__image">
                                        <?= $item['image'] ?>
                                    </div>
                                <?php endif; ?>

                                <div class="c-product__content">

                                    <?php $tabs_id = uniqid( 'tabs-' ); ?>

                                    <div class="c-tabs">

                                        <div class="c-tabs__nav" role="tablist">

                                            <button class="c-tabs__button is-active"
                                                    id="<?= $tabs_id ?>-tab-beschreibung"
                                                    role="tab" aria-selected="true"
                                                    aria-controls="<?= $tabs_id ?>-panel-beschreibung" tabindex="0">
                                                Beschreibung
                                            </button>
                                            <button class="c-tabs__button" id="<?= $tabs_id ?>-tab-preise" role="tab"
                                                    aria-selected="false" aria-controls="<?= $tabs_id ?>-panel-preise"
                                                    tabindex="-1">Preise
                                            </button>
                                        </div>

                                        <div class="c-tabs__panels">

                                            <div class="c-tabs__panel is-active" id="<?= $tabs_id ?>-panel-beschreibung"
                                                 role="tabpanel" aria-labelledby="<?= $tabs_id ?>-tab-beschreibung">
                                                <?php if ( ! empty( $item['description'] ) ): ?>
                                                    <?= $item['description'] ?>
                                                <?php endif; ?>
                                                <?php if ( ! empty( $item['button_1'] ) ): ?>
                                                    <div class="c-buttons">
                                                        <?= $item['button_1'] ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="c-tabs__panel" id="<?= $tabs_id ?>-panel-preise" role="tabpanel"
                                                 aria-labelledby="<?= $tabs_id ?>-tab-preise" hidden>

                                                <?php if ( ! empty( $item['prices'] ) ): ?>
                                                    <?= $item['prices'] ?>
                                                <?php else: ?>
                                                    <p>Preise auf Anfage.</p>
                                                <?php endif; ?>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>

            </div>

        </div>

    </div>
<?php endif; ?>

