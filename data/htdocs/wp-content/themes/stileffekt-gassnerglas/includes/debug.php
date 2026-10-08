<?php

// only run on development environments
$host = $_SERVER['HTTP_HOST'] ?? '';
if ( ! str_starts_with( $host, 'localhost' ) && ! str_ends_with( $host, '.geht-mit-stil.online' ) ) {
    return;
}

function debug( $data ): void {
    echo '<pre class="debug">';
    print_r( $data );
    echo '</pre>';
}

function stilpress__debug_grid() {

    $users = array(
            'sebastian@stileffekt.de',
            'christoph@stileffekt.de',
            'it@stileffekt.de',
    );

    $current_user = wp_get_current_user();

    if ( ! in_array( $current_user->user_email, $users ) ) {
        return false;
    }

    ?>

    <div class="stilpress-debug__toggle"></div>

    <script>
        const root = document.querySelector('html');

        const helperGridToggle = document.querySelector('.stilpress-debug__toggle');
        helperGridToggle.addEventListener('click', () => {
            if (root.classList.contains('stilpress-debug__grid')) {
                root.classList.remove('stilpress-debug__grid')
            } else {
                root.classList.add('stilpress-debug__grid')
            }
        })

        document.addEventListener("DOMContentLoaded", () => {
            const root = document.documentElement;

            function updateMediaQuery() {
                const width = window.innerWidth;

                const style = getComputedStyle(root);
                const query = style.getPropertyValue('--g-query');

                root.style.setProperty("--g-width", `${query}" ${width} px"`);
            }

            updateMediaQuery();

            window.addEventListener("resize", updateMediaQuery);
        });

    </script>

    <?php

    return '';
}

add_action( 'wp_footer', 'stilpress__debug_grid' );
