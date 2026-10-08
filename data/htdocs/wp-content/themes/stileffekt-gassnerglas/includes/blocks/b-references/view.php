<?php
/**
 * @var array $block
 * @var string $headline
 * @var string $overline
 * @var string $text
 * @var string $icon
 * @var array $items
 */
$filter_id_prefix = $block->return_id() . '-filter';
?>

<div id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?> l-padding">

    <div class="l-width">

        <div class="l-grid">

            <?php if ( ! empty( $overlinel ) || ! empty( $headline ) || ! empty( $text ) ): ?>
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
            <?php if ( ! empty( $items ) ): ?>

                <div class="b__references">

                    <div class="c-filters">

                        <div class="c-filter">
                            <label class="c-filter__title" for="<?= esc_attr( $filter_id_prefix . '-industries' ); ?>"><?= __( 'Industries', 'stilpress' ); ?></label>
                            <select id="<?= esc_attr( $filter_id_prefix . '-industries' ); ?>" name="industries[]" data-reference-filter="industries" multiple>
                                <?php if ( ! empty( $industries ) && ! is_wp_error( $industries ) ): ?>
                                    <option value="" disabled hidden>Bitte auswählen…</option>
                                    <?php foreach ( $industries as $term ): ?>
                                        <option value="<?= esc_attr( $term->term_id ); ?>">
                                            <?= esc_html( $term->name ); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="c-filter">
                            <label class="c-filter__title" for="<?= esc_attr( $filter_id_prefix . '-areas' ); ?>"><?= __( 'Areas', 'stilpress' ); ?></label>
                            <select id="<?= esc_attr( $filter_id_prefix . '-areas' ); ?>" name="areas[]" data-reference-filter="areas" multiple>
                                <?php if ( ! empty( $areas ) && ! is_wp_error( $areas ) ): ?>
                                    <option value="" disabled hidden>Bitte auswählen…</option>
                                    <?php foreach ( $areas as $term ): ?>
                                        <option value="<?= esc_attr( $term->term_id ); ?>">
                                            <?= esc_html( $term->name ); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="c-filter">
                            <label class="c-filter__title" for="<?= esc_attr( $filter_id_prefix . '-interfaces' ); ?>"><?= __( 'Interfaces', 'stilpress' ); ?></label>
                            <select id="<?= esc_attr( $filter_id_prefix . '-interfaces' ); ?>" name="interfaces[]" data-reference-filter="interfaces" multiple>
                                <?php if ( ! empty( $interfaces ) && ! is_wp_error( $interfaces ) ): ?>
                                    <option value="" disabled hidden>Bitte auswählen…</option>
                                    <?php foreach ( $interfaces as $term ): ?>
                                        <option value="<?= esc_attr( $term->term_id ); ?>">
                                            <?= esc_html( $term->name ); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                    </div>

                    <div class="c-references">

                        <?php foreach ( $items as $item ): ?>

                            <div class="c-reference l-grid"
                                 data-industries="<?php echo esc_attr( $item['industries'] ); ?>"
                                 data-areas="<?php echo esc_attr( $item['areas'] ); ?>"
                                 data-interfaces="<?php echo esc_attr( $item['interfaces'] ); ?>">

                                <div class="c-reference__media">
                                    <?php if ( ! empty( $item['logo'] ) ): ?>
                                        <?= $item['logo']; ?>
                                    <?php endif; ?>
                                </div>

                                <div class="c-reference__content">
                                    <?php if ( ! empty( $item['title'] ) ): ?>
                                        <div class="c-reference__name h2">
                                            <?= $item['title']; ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="c-reference__quote">

                                        <div class="c-quote__text">
                                            <?php if ( ! empty( $item['text'] ) ): ?>
                                                <?php echo $item['text']; ?>
                                            <?php endif; ?>
                                        </div>

                                        <div class="c-quote__meta">

                                            <div class="c-quote__info">
                                                <div class="c-quote__name">
                                                    <?= $item['name']; ?><?= ! empty( $item['position'] ) ? ', ' . $item['position'] : ''; ?>
                                                </div>
                                                <div class="c-quote__company">
                                                    <?php if ( ! empty( $item['company'] ) ): ?>
                                                        <?= $item['company']; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <?php if ( ! empty( $item['permalink'] ) ): ?>
                                    <div class="c-links">
                                        <a class="c-link"
                                           href="<?= $item['permalink'] ?>">
                                            <div class="c-icon">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="7.805" height="7.805"
                                                     viewBox="0 0 7.805 7.805">
                                                    <path d="M0,0V1.765H4.793L0,6.558,1.248,7.806,6.041,3.013V7.806H7.805V0Z"
                                                          transform="translate(0 -0.001)"></path>
                                                </svg>
                                            </div>
                                            <span>Lesen Sie mehr</span></a></div>
                                </div>

                                <?php endif; ?>
                            </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>
