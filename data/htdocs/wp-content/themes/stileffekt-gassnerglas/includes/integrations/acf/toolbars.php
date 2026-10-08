<?php


/**
 * add custom toolbar for wysiwyg acf field
 *
 * @param array $toolbars
 *
 * @return array
 */
function stilpress__add_toolbar( $toolbars ) {

	// debugging
//	echo '<pre>';
//	print_r( $toolbars );
//	echo '</pre>';
//	die;

	// add new toolbar
	$toolbars['stilpress'] = array();

	// set toobar row 1
	$toolbars['stilpress'][1] = array(
		'formatselect',
		'removeformat',
		'bold',
		'italic',
		'underline',
		'strikethrough',
		'bullist',
		'numlist',
		'link',
		'hr',
		'undo',
		'redo',
	);

	return $toolbars;
}

add_filter( 'acf/fields/wysiwyg/toolbars', 'stilpress__add_toolbar' );


/**
 * force load custom toolbar for wysiwyg acf field
 *
 * @param array $field
 *
 * @return array
 */
function stilpress__toolbar_force_load( $field ) {
	

	if ( $field['type'] == 'wysiwyg' ) {
		$field['toolbar']      = 'stilpress';
		$field['media_upload'] = 0;
	}

	return $field;
}

add_filter( 'acf/get_valid_field', 'stilpress__toolbar_force_load' );