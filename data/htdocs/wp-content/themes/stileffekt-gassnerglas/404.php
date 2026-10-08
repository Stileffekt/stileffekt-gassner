<?php get_header(); ?>

    <main id="main" class="l-padding" role="main">

        <div class="error-404 js-animate l-width">

            <div class="c-block__inner">

                <div class="l-grid">

                    <div class="l-grid__item">

                        <div class="c-content">

                            <div class="error-404__headline"><h1>404</h1></div>

                            <div class="error-404__subline">
                                <p><?= __( 'Oops - something went wrong!', 'stilpress' ); ?></p>
                            </div>
                            <div class="error-404__text">
                                <p><?= __( 'It\'s not you, the page just doesn\'t want to be found.', 'stilpress' ); ?></p>
                            </div>

                            <div class="error-404__buttons">
                                <a class="c-button"
                                   href="<?= home_url( $path = '/', $scheme = 'https' ); ?>"><?= __( 'return home', 'stilpress' ); ?></a>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

<?php get_footer(); ?>
