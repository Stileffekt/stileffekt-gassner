<?php

// theme version constant
define( 'STILPRESS_VERSION', '1.1.1' );

// add/remove theme support
function stilpress__theme_support(): void {

    // title support
    add_theme_support( 'title-tag' );

    // add editor styles
    add_theme_support( 'editor-styles' );
    add_editor_style( [
            'assets/styles/styles.css',
            'assets/styles/editor.css',
    ] );

    // html5 support
    add_theme_support( 'html5', array(
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption',
            'style',
            'script'
    ) );

    // remove admin warning
    remove_filter( 'admin_head', 'wp_check_widget_editor_deps' );

    // remove block patterns functionality
    remove_theme_support( 'core-block-patterns' );

    // yoast support
    add_theme_support( 'yoast-seo-breadcrumbs' );

    // translation support
    load_theme_textdomain( 'stilpress', get_theme_file_path() . '/assets/languages' );

    add_image_size( 'page-title', 1400 );
    add_image_size( 'page-links', 800, 800 );
}

add_action( 'after_setup_theme', 'stilpress__theme_support' );


// register navigation menus
function stilpress__register_nav_menus(): void {
    register_nav_menus( array(
            'main'   => esc_html__( 'Main Menu', 'stilpress' ),
            'footer' => esc_html__( 'Footer Navigation', 'stilpress' ),
    ) );
}

add_action( 'after_setup_theme', 'stilpress__register_nav_menus' );


/**
 * Register shared block assets before block metadata is processed.
 */
function stilpress__register_block_assets(): void {
    $version = STILPRESS_VERSION;

    wp_register_style( 'splide', get_theme_file_uri( '/assets/styles/_lib/splide/splide.css' ), [], $version );

    wp_register_script( 'stilpress-blocks', get_theme_file_uri( '/assets/scripts/blocks.js' ), [], $version, false );
    wp_register_script( 'splide', get_theme_file_uri( '/assets/scripts/_lib/splide/splide.min.js' ), [], $version, true );
    wp_register_script( 'splide-autoscroll', get_theme_file_uri( '/assets/scripts/_lib/splide/splide-autoscroll.min.js' ), [ 'splide' ], $version, true );
    wp_register_script( 'gsap', get_theme_file_uri( '/assets/scripts/_lib/gsap/gsap.min.js' ), [], $version, true );
    wp_register_script( 'gsapScrollTrigger', get_theme_file_uri( '/assets/scripts/_lib/gsap/gsapScrollTrigger.min.js' ),
            [ 'gsap' ], $version, true );
    wp_register_script( 'gsapFlip', get_theme_file_uri( '/assets/scripts/_lib/gsap/gsapFlip.min.js' ), [ 'gsap' ],
            $version, true );
    wp_register_script( 'popper', get_theme_file_uri( '/assets/scripts/_lib/popper/popper.min.js' ), [], $version, true );
}

add_action( 'init', 'stilpress__register_block_assets', 5 );


// en/dequeue styles
function stilpress__styles(): void {

    // remove default styles
    wp_dequeue_style( 'global-styles' );
    wp_dequeue_style( 'classic-theme-styles' );
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-blocks-style' );
    remove_action( 'wp_enqueue_scripts', 'wp_enqueue_classic_theme_styles' );
    remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
    remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

    // enqueue styles
    wp_enqueue_style( 'styles', get_theme_file_uri( '/assets/styles/styles.css' ), [], STILPRESS_VERSION );

}

add_action( 'wp_enqueue_scripts', 'stilpress__styles', 100 );

//function stilpress__editor_content_styles(): void {
//    if ( ! is_admin() ) {
//        return;
//    }
//
//    wp_enqueue_style(
//            'stilpress-editor-content',
//            get_theme_file_uri( '/assets/styles/styles.css' ),
//            [],
//            STILPRESS_VERSION
//    );
//}
//
//add_action( 'enqueue_block_assets', 'stilpress__editor_content_styles', 100 );
//


/**
 * en/dequeue scripts
 */
function stilpress__scripts(): void {
    wp_enqueue_script( 'scripts', get_theme_file_uri( '/assets/scripts/scripts.js' ), [], STILPRESS_VERSION, true );
}

add_action( 'wp_enqueue_scripts', 'stilpress__scripts' );


/**
 * initialize widget areas
 */

function stilpress__widgets(): void {
    for ( $i = 1; $i <= 4; $i ++ ) {
        register_sidebar( array(
                'id'            => 'widget-' . $i,
                'class'         => '',
                'name'          => 'Footer ' . $i,
                'description'   => '',
                'before_widget' => '',
                'after_widget'  => '',
                'before_title'  => '',
                'after_title'   => '',
                'show_in_rest'  => true,
        ) );
    }
}

add_action( 'widgets_init', 'stilpress__widgets' );


// dependencies
function stilpress__dependencies_met(): bool {
    return class_exists( 'ACF' ) && function_exists( 'get_field' );
}

if ( stilpress__dependencies_met() ) {
    require_once get_theme_file_path( '/includes/includes.php' );
} else {
    add_action( 'admin_notices', function () {
        echo '<div class="notice notice-error"><p>';
        echo '<strong>Stilpress:</strong> The plugin <em>Advanced Custom Fields (ACF)</em> is required. Please install it.';
        echo '</p></div>';
    } );

    add_action( 'template_redirect', function () {
        wp_die(
                '<h1>Website not available</h1><p>The required plugin <em>Advanced Custom Fields</em> is not active.</p>',
                'Missing Dependencies',
                [ 'response' => 503 ]
        );
    } );
}

function whitelabel__ajax_search() { ?>
    <script type="text/javascript">
        function stilpress__search() {
            const formData = new FormData();
            formData.append('action', 'search_global');
            formData.append('keyword', document.getElementById('keyword').value);

            fetch('<?php echo admin_url( 'admin-ajax.php' ); ?>', {
                method: 'POST',
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('search_result').innerHTML = data;
                });
        }
    </script>
    <?php
}

add_action( 'wp_footer', 'whitelabel__ajax_search' );

function whitelabel__search_global() {

    $args = [
            'posts_per_page' => - 1,
            's'              => esc_attr( $_POST['keyword'] ),
            'post_type'      => array( 'page', 'post', 'project', 'job' ),
            'post_status'    => 'publish',
    ];

    $the_query = new WP_Query( $args );
    if ( strlen( $_POST['keyword'] ) <= 2 ) {
        die;
    }

    $count = '';
    if ( $the_query->have_posts() ) :

        $count = $the_query->found_posts;

        echo '<div class="results__inner">';
        echo '<div class="count"><span>' . __( 'Search results', 'stilpress' ) . '</span> (' . $count . ')</div>';

        echo '<ul>';
        while ( $the_query->have_posts() ): $the_query->the_post();

            $post_type = get_post_type();

            $image = '';
            if ( ! empty( $post_type ) ) {
                switch ( $post_type ) {
                    case 'post':
                        $post_type = __( 'Post', 'stilpress' );
                        $data      = get_field( 'ptype_post', get_the_ID() );
                        break;
                    case 'project':
                        $post_type = __( 'Project', 'stilpress' );
                        $data      = get_field( 'ptype_project', get_the_ID() );
                        break;
                    case 'page':
                        $post_type = __( 'Page', 'stilpress' );
                        $data      = get_field( 'ptype_page', get_the_ID() );

                        $url = strtolower( get_permalink( get_the_ID() ) );
                        if ( strpos( $url, 'product' ) !== false || strpos( $url, 'produkt' ) !== false ) {
                            $post_type = __( 'Product', 'stilpress' );
                        }

                        break;
                    case 'job':
                        $post_type = __( 'Job', 'stilpress' );
                        $data      = get_field( 'ptype_job', get_the_ID() );
                        break;
                    case 'product':
                        $post_type = __( 'Product', 'stilpress' );
                        $data      = get_field( 'ptype_product', get_the_ID() );
                        break;
                }
            }

            if ( ! empty( $data['image']['url'] ) ) {
                $url    = ! empty( $data['image']['url'] ) ? $data['image']['url'] : '';
                $width  = ! empty( $data['image']['width'] ) ? $data['image']['width'] : '';
                $height = ! empty( $data['image']['height'] ) ? $data['image']['height'] : '';
                $alt    = ! empty( $data['image']['alt'] ) ? ' alt="' . $data['image']['alt'] . '"' : ' alt=""';

                $overlay = '<div class="c-media__overlay"></div>';

                $image = '<figure class="c-media"><img class="c-media__image" src="' . $url . '" width="' . $width . '" height="' . $height . '"' . $alt . '>' . $overlay . '</figure>';

            }

            echo '<li>';

            echo '<a href="' . esc_url( get_permalink() ) . '" class="entry">';
            echo '<div class="image">';
            if ( ! empty( $image ) ) {
                echo $image;
            }
            echo '</div>';
            echo '<div class="content">';
            echo '<div class="title">';
            echo get_the_title();
            echo '</div>';
            echo '<div class="meta">';
            if ( ! empty( $post_type ) ) {
                echo $post_type;
            }
            echo '</div>';
            echo '</div>';
            echo '</a>';
            echo '</li>';
        endwhile;
        echo '</ul>';
        echo '</div>';
        wp_reset_postdata();

    else:
        echo '<div class="results__inner">';
        echo '<div class="count"><span>' . __( 'Nothing found :(', 'stilpress' ) . '</span></div>';
        echo '</div>';

    endif;

    die();
}

add_action( 'wp_ajax_search_global', 'whitelabel__search_global' );
add_action( 'wp_ajax_nopriv_search_global', 'whitelabel__search_global' );
