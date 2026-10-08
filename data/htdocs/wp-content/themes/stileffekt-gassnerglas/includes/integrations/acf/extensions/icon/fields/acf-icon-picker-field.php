<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'stilpress__acf_icon_picker_field' ) ) :

    class stilpress__acf_icon_picker_field extends acf_field {

        public $name;
        public $label;
        public $category;
        public $defaults;
        public $l10n;
        public $url;
        public $path;
        public $path_suffix;
        public $svgs;
        public $settings;

        function __construct( $settings ) {


            if ( ! is_admin() ) {
                return;
            }

            $this->name = 'icon-picker';

            $this->label = __( 'Icon Picker', 'stilpress' );

            $this->category = 'advanced';

            $this->defaults = array(
                    'initial_value' => '',
            );

            $this->l10n = array(
                    'error' => __( 'Error!', 'stilpress' ),
            );

            $this->settings = $settings;

            $this->path_suffix = apply_filters( 'acf_icon_path_suffix', '/' );

            $this->path = apply_filters( 'acf_icon_path', $this->settings['path'] ) . $this->path_suffix;

            $this->url = apply_filters( 'acf_icon_url', $this->settings['url'] ) . $this->path_suffix;


            $upload_dir = wp_upload_dir();


            $priority_dir_lookup = $upload_dir['path'] . $this->path_suffix;

            if ( file_exists( $priority_dir_lookup ) ) {
                $this->path = $priority_dir_lookup;
                $this->url  = $upload_dir['url'] . $this->path_suffix;
            }

            $icons = get_field( 'icons', 'option' );

            $this->svgs = array();

            if ( ! empty( $icons ) ) {

                foreach ( $icons as $icon ) {

                    $icon = wp_prepare_attachment_for_js( $icon );

                    if ( empty( $icon['filename'] ) ) {
                        continue;
                    }

                    if ( pathinfo( $icon['filename'], PATHINFO_EXTENSION ) == 'svg' ) {

                        $icon_push = array(
                                'name' => str_replace( '.svg', '', $icon['filename'] ),
                                'icon' => $icon['url']
                        );

                        array_push( $this->svgs, $icon_push );
                    }
                }
            }

            parent::__construct();
        }

        function render_field( $field ) {
            $input_icon = $field['value'] != "" ? $field['value'] : $field['initial_value'];
            $svg        = $this->path . $input_icon . '.svg';
            ?>
            <div class="acf-icon-picker">
                <div class="acf-icon-picker__img">
                    <?php
                    if ( file_exists( $svg ) ) {
                        $svg = $this->url . $input_icon . '.svg';
                        echo '<div class="acf-icon-picker__svg">';
                        echo '<img src="' . $svg . '" alt=""/>';
                        echo '</div>';
                    } else {
                        echo '<div class="acf-icon-picker__svg">';
                        echo '<span class="acf-icon-picker__svg--span">&plus;</span>';
                        echo '</div>';
                    }
                    ?>
                    <input type="hidden" readonly name="<?php echo esc_attr( $field['name'] ) ?>"
                           value="<?php echo esc_attr( $input_icon ) ?>"/>
                </div>
                <?php if ( $field['required'] == false ) { ?>
                    <span class="acf-icon-picker__remove">
						<?php _e( 'Remove', 'stilpress' ); ?>
					</span>
                <?php } ?>
            </div>
            <?php
        }

        function input_admin_enqueue_scripts() {

            $url     = $this->settings['url'];
            $version = $this->settings['version'];

            wp_register_script( 'acf-input-icon-picker', "{$url}/includes/integrations/acf/extensions/icon/assets/js/input.js", array( 'acf-input' ), $version );
            wp_enqueue_script( 'acf-input-icon-picker' );

            wp_localize_script( 'acf-input-icon-picker', 'iv', array(
                    'path'         => $this->url,
                    'svgs'         => $this->svgs,
                    'no_icons_msg' => sprintf( esc_html__( 'There are no icons uploaded in Theme Settings.', 'stilpress' ), $this->path_suffix )
            ) );

            wp_register_style( 'acf-input-icon-picker', "{$url}/includes/integrations/acf/extensions/icon/assets/css/input.css", array( 'acf-input' ), $version );
            wp_enqueue_style( 'acf-input-icon-picker' );
        }
    }

    new stilpress__acf_icon_picker_field( $this->settings );

endif;

?>
