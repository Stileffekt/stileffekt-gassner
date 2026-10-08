<?php
/**
 * @var object $block
 * @var string $overline
 * @var string $headline
 * @var string $text
 * @var array $items
 */
?>

<section id="<?= $block->return_id(); ?>" class="<?= $block->return_classes(); ?> l-padding">

    <div class="l-width">

        <div class="l-grid">

            <?php if ( ! empty( $items ) ): ?>
                <div class="b__anchor-navigation">

                    <div class="c-anchor-navigation">

                        <h2 class="c-anchor-navigation__title"><?= __( 'Inhaltsverzeichnis', 'stilpress' ); ?></h2>
                        <nav class="c-anchor-navigation__list">
                            <ol>
                                <?php foreach ( $items as $item ): ?>
                                    <li class="c-anchor-navigation__item">
                                        <a href="<?= $item['url'] ?>">
                                            <span><?= $item['title'] ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ol>

                        </nav>

                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>

</section>
