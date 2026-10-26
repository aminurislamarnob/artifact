<?php
/**
 * Artifact functions and definitions.
 *
 * @package Artifact
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/tgmpa.php';

/**
 * Load the theme text domain.
 */
function artifact_setup() {
	load_theme_textdomain( 'artifact', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'artifact_setup' );

/**
 * WooCommerce inserts a cart and an account icon after header navigation.
 * This theme is not a shop, so those hooks stay off the header.
 *
 * @param string[] $hooked_blocks Hooked block names.
 * @param string   $position      Insertion position.
 * @param string   $anchor_block  Anchor block name.
 * @param mixed    $context       Template, pattern, or post being rendered.
 * @return string[]
 */
function artifact_unhook_shop_blocks( $hooked_blocks, $position, $anchor_block, $context ) {
	if ( 'after' !== $position || 'core/navigation' !== $anchor_block ) {
		return $hooked_blocks;
	}

	$slug = '';
	if ( is_array( $context ) ) {
		$slug = isset( $context['name'] ) ? $context['name'] : '';
		$slug = isset( $context['slug'] ) && '' === $slug ? $context['slug'] : $slug;
	} elseif ( $context instanceof WP_Block_Template ) {
		$slug = $context->slug;
	}

	if ( 'header' !== $slug && 'artifact/header' !== $slug ) {
		return $hooked_blocks;
	}

	return array_values(
		array_diff(
			$hooked_blocks,
			array( 'woocommerce/customer-account', 'woocommerce/mini-cart' )
		)
	);
}
add_filter( 'hooked_block_types', 'artifact_unhook_shop_blocks', 20, 4 );
