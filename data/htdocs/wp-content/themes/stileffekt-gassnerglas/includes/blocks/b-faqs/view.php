<?php
/**
 * @var array $block
 * @var array $items
 * @var string $category_headline_type
 * @var string $item_headline_type
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

                <?php if ( ! empty( $button_1 ) || ! empty( $button_2 ) ): ?>
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

            <?php if ( ! empty( $items ) ): ?>

            <div class="b__faqs">

                <div class="c-faq__list">

                    <?php foreach ( $items

                    as $category ): ?>

                    <div class="c-faq__group">

                        <<?= $category_headline_type; ?> class="c-faq__category">
                        <?= esc_html( $category['name'] ); ?>
                    </<?= $category_headline_type; ?>>

                    <?php foreach ( $category['faqs'] as $index => $faq ):
                    $faq_id     = 'faq-' . $block->return_id() . '-' . $category['term_id'] . '-' . $index;
                    $content_id = $faq_id . '-content';
                    ?>

                    <div class="c-faq">

                        <<?= $item_headline_type; ?> class="c-faq__header">
                        <button
                                class="c-faq__button"
                                aria-expanded="false"
                                aria-controls="<?= $content_id; ?>"
                                id="<?= $faq_id; ?>"
                        >
                            <span class="c-faq__question"><?= $faq['question']; ?></span>
                            <span class="c-faq__indicator"
                                  aria-hidden="true"><?= stilpress__return_icon( 'Arrow-Down-1-Streamline-Ultimate' ); ?></span>
                        </button>
                    </<?= $item_headline_type; ?>>

                    <div
                            class="c-faq__content"
                            id="<?= $content_id; ?>"
                            role="region"
                            aria-labelledby="<?= $faq_id; ?>"
                    >
                        <div class="c-faq__inner">
                            <div class="c-faq__answer">
                                <?= $faq['answer']; ?>
                            </div>
                        </div>
                    </div>

                </div>

                <?php endforeach; ?>

            </div>

        <?php endforeach; ?>

        </div>

    </div>

    <?php endif; ?>

    </div>

    </div>

    <?php

    $rich_faqs = [];
    foreach ( $items as $category ) {
        foreach ( $category['faqs'] as $faq ) {
            $rich_faqs[] = $faq;
        }
    }

    $rich_data = [
            "@context"   => "https://schema.org",
            "@type"      => "FAQPage",
            "mainEntity" => array_map( function ( $faq ) {
                return [
                        "@type"          => "Question",
                        "name"           => $faq['question'],
                        "acceptedAnswer" => [
                                "@type" => "Answer",
                                "text"  => $faq['answer'],
                        ],
                ];
            }, $rich_faqs )
    ];
    ?>

    <script type="application/ld+json"><?= json_encode( $rich_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ); ?></script>

</section>
