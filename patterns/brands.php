<?php
/**
 * Title: Brands
 * Slug: artifact/brands
 * Categories: about
 * Description: A "trusted by" label above a row of client names, then a divider. Swap any name for an Image block with your client's logo.
 *
 * @package Artifact
 */

$artifact_brands = array(
	__( 'Orbitly', 'artifact' ),
	__( 'Velora', 'artifact' ),
	__( 'Lumenix', 'artifact' ),
	__( 'Goldmere', 'artifact' ),
	__( 'Zentro', 'artifact' ),
	__( 'Kyanor', 'artifact' ),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"0","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"32px"}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--20);padding-bottom:0;padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"26px","fontWeight":"600","textTransform":"uppercase"}},"textColor":"text-white","fontSize":"medium-paragraph"} -->
	<p class="has-text-align-center has-text-white-color has-text-color has-medium-paragraph-font-size" style="font-weight:600;line-height:26px;text-transform:uppercase"><?php echo esc_html__( '2K brands trust us', 'artifact' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:group {"align":"wide","className":"artifact-brands","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
	<div class="wp-block-group alignwide artifact-brands">
		<?php foreach ( $artifact_brands as $artifact_brand ) : ?>
		<!-- wp:paragraph {"style":{"typography":{"lineHeight":"32px","fontWeight":"700","letterSpacing":"-0.02em"}},"textColor":"text-color","fontSize":"large-title"} -->
		<p class="has-text-color-color has-text-color has-large-title-font-size" style="font-weight:700;letter-spacing:-0.02em;line-height:32px"><?php echo esc_html( $artifact_brand ); ?></p>
		<!-- /wp:paragraph -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->

	<!-- wp:separator {"align":"wide","className":"is-style-wide","style":{"spacing":{"margin":{"top":"64px","bottom":"0"}}}} -->
	<hr class="wp-block-separator alignwide has-alpha-channel-opacity is-style-wide" style="margin-top:64px;margin-bottom:0"/>
	<!-- /wp:separator -->
</div>
<!-- /wp:group -->
