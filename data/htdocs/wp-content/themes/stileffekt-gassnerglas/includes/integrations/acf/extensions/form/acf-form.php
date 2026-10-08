<?php

if ( ! defined( 'ABSPATH' ) || ! defined( 'WPCF7_VERSION' ) || ! class_exists( 'ACF' ) ) {
    return false;
}

class stilpress__acf_extend_field_contactform7 extends acf_field {

    function __construct() {

        $this->name     = 'contactform7';
        $this->label    = __( 'Contact Form', 'stilpress' );
        $this->category = 'choice';
        $this->defaults = array(
                'default_form' => 1,
        );
        $this->l10n     = array(
                'error' => __( 'Error', 'stilpress' ),
        );

        parent::__construct();
    }

    function get_forms() {

        $arr = [];

        foreach ( WPCF7_ContactForm::find() as $_ => $obj ) {
            $arr[ $obj->id() ] = $obj->title();
        }

        return $arr;
    }

    function render_field_settings( $field ) {

    }

    function format_value( $value, $post_id, $field ) {
        $return_value = ( empty( $value ) ) ? $field['default_form'] : $value;

        return $return_value;
    }


    function render_field( $field ) {

        $value = empty( $field['value'] ) ? $this->default_sentinel : $field['value'];

        ?>

        <select name="<?= esc_attr( $field['name'] ) ?>" value="<?= esc_attr( $value ) ?>">
            <?php

            if ( ! empty( WPCF7_ContactForm::find() ) ) {

                foreach ( WPCF7_ContactForm::find() as $_ => $obj ) {

                    if ( $value == $obj->id() ) {
                        echo '<option selected value="' . esc_attr( $obj->id() ) . '">' . esc_html( $obj->title() ) . '</option>';
                    } else {
                        echo '<option value="' . esc_attr( $obj->id() ) . '">' . esc_html( $obj->title() ) . '</option>';
                    }
                }

            } else {
                echo '<option disabled selected value>' . __( 'No form available', 'stilpress' ) . '</option>';
            }
            ?>

        </select>

        <?php
    }
}


add_action( 'acf/init', function () {
    new stilpress__acf_extend_field_contactform7();
} );

