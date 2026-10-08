<?php
/**
 * @var array $block
 * @var string $headline
 * @var array $posts
 */
?>

<div id="<?= $block->return_id(); ?>"
     class="<?= $block->return_classes(); ?> l-padding l-background-3 l-padding-top l-padding-bottom">

    <div class="l-width">

        <div class="l-grid">

            <?php if ( ! empty( $overline ) || ! empty( $headline ) || ! empty( $text ) ): ?>
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

            <?php if ( ! empty( $posts ) ): ?>
                <div class="b__posts">

                    <div class="c-posts">

                        <?php foreach ( $posts as $item ): ?>
                            <a class="c-post" href="<?= $item['permalink'] ?>">

                                <?php if ( ! empty( $item['image'] ) ): ?>
                                    <div class="c-post__header">
                                        <?= $item['image'] ?>
                                    </div>
                                <?php endif; ?>

                                <div class="c-post__body">

                                    <div class="c-post__date">
                                        <?= stilpress__return_icon( 'Calendar--Streamline-Ultimate' ) ?>
                                        <span><?= $item['date'] ?></span>
                                    </div>

                                    <?php if ( ! empty( $item['title'] ) ): ?>
                                        <?= $item['title'] ?>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $item['text'] ) ): ?>
                                        <?= $item['text'] ?>
                                    <?php endif; ?>
                                </div>

                            </a>
                        <?php endforeach; ?>

                    </div>

                </div>
            <?php endif; ?>

            <?php if ( ! empty( $button_1 ) ): ?>
                <div class="b__links">
                    <div class="c-buttons">
                        <?= $button_1 ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>

</div>

