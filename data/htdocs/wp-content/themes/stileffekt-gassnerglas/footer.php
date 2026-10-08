<footer class="footer">

    <div class="footer__widgets l-padding l-background-2 l-text-inverted">

        <div class="l-width">

            <div class="l-grid">

                <div class="widgets__area">
                    <?php if ( is_active_sidebar( 'widget-1' ) ): ?>
                        <?php dynamic_sidebar( 'widget-1' ) ?>
                    <?php endif; ?>
                </div>

                <div class="widgets__break"></div>

                <div class="widgets__area">
                    <?php if ( is_active_sidebar( 'widget-2' ) ): ?>
                        <?php dynamic_sidebar( 'widget-2' ) ?>
                    <?php endif; ?>
                </div>

                <div class="widgets__area">
                    <?php if ( is_active_sidebar( 'widget-3' ) ): ?>
                        <?php dynamic_sidebar( 'widget-3' ) ?>
                    <?php endif; ?>
                </div>

                <div class="widgets__area">
                    <?php if ( is_active_sidebar( 'widget-4' ) ): ?>
                        <?php dynamic_sidebar( 'widget-4' ) ?>
                    <?php endif; ?>
                </div>

            </div>

        </div>
    </div>

    <div class="footer__bottom l-padding">

        <div class="l-width">
            <div class="l-grid">

                <div class="footer__copyright">
                    <?= stilpress__get_copyright() ?>
                </div>

                <div class="footer__navigation">
                    <?php if ( has_nav_menu( 'footer' ) ) : ?>
                        <?php wp_nav_menu( [
                                'theme_location'       => 'footer',
                                'walker'               => new Stilpress_Walker_Footer(),
                                'container'            => 'nav',
                                'container_class'      => 'c-navigation c-navigation--footer',
                                'container_aria_label' => esc_attr__( 'Footer Navigation', 'stilpress' ),
                                'menu_class'           => 'c-navigation__list',
                                'depth'                => 1,
                                'fallback_cb'          => false,
                        ] ); ?>
                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</footer>

</div>

<?php get_template_part( 'parts/search' ); ?>
<?php get_template_part( 'parts/sticky-icons' ); ?>

<?php wp_footer() ?>

</body>
</html>