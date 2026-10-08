<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<a href="#main" class="skip-link"><?= __( 'Skip to main content', 'stileffekt' ); ?></a>

<div class="l-wrapper">

    <header id="header" class="header l-padding" role="banner">

        <div class="l-width">

            <div class="header__row">

                <div class="header__logo">
                    <?php echo stilpress__return_logo( 'header' ) ?>
                </div>

                <div class="header__languages">
                    <?php stilpress__language_switcher_wpml(); ?>
                </div>

                <?php if ( has_nav_menu( 'main' ) ): ?>

                    <button class="header__toggle toggle toggle--navigation"
                            aria-label="<?php esc_attr_e( 'Open Navigation', 'stilpress' ) ?>"
                            aria-expanded="false"
                            aria-controls="header-navigation"
                            data-label-open="<?php esc_attr_e( 'Open Navigation', 'stilpress' ) ?>"
                            data-label-close="<?php esc_attr_e( 'Close Navigation', 'stilpress' ) ?>">
                        <span class="toggle__indicator"
                              aria-hidden="true"><span></span><span></span><span></span></span>
                    </button>

                    <?php wp_nav_menu( [
                            'theme_location'       => 'main',
                            'container'            => 'nav',
                            'container_class'      => 'header__navigation c-navigation c-navigation--main',
                            'container_id'         => 'header-navigation',
                            'container_aria_label' => esc_attr__( 'Main Navigation', 'stilpress' ),
                            'menu_class'           => 'c-navigation__list',
                            'depth'                => 3,
                            'fallback_cb'          => false,
                            'walker'               => new Stilpress_Walker_Main(),
                    ] ); ?>
                <?php endif; ?>

            </div>

            <div class="header__cta">
                <?= stilpress__header_cta(); ?>
            </div>

            <div class="header__search toggle toggle--search" aria-label="<?php _e( 'Toggle Search', 'stilpress' ); ?>">
                <?= stilpress__return_icon( 'Search-Circle-Streamline_Ultimate' ); ?>
            </div>

        </div>

    </header>
