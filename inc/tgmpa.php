<?php
/**
 * Plugin recommendations, through TGM Plugin Activation.
 *
 * The Contact page is designed for Contact Form 7, so admins are told about
 * it once, in a notice they can dismiss. Nothing is required, and nothing is
 * installed or activated without the admin choosing to.
 *
 * @package Artifact
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

/**
 * Recommend Contact Form 7.
 */
function artifact_register_recommended_plugins() {
	$plugins = array(
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => false,
		),
	);

	$config = array(
		'id'           => 'artifact',
		'menu'         => 'artifact-install-plugins',
		'parent_slug'  => 'themes.php',
		'capability'   => 'install_plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'is_automatic' => false,
		'message'      => '<p>' . esc_html__( 'This theme recommends Contact Form 7 for the contact page form.', 'artifact' ) . '</p>',
		'strings'      => array(
			/* translators: 1: plugin name(s). */
			'notice_can_install_recommended' => _n_noop(
				'This theme recommends %1$s for the contact page form.',
				'This theme recommends these plugins: %1$s.',
				'artifact'
			),
		),
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'artifact_register_recommended_plugins' );
