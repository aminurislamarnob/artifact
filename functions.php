<?php
/**
 * Artifact functions and definitions.
 *
 * @package Artifact
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load the theme text domain.
 */
function artifact_setup() {
	load_theme_textdomain( 'artifact', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'artifact_setup' );
