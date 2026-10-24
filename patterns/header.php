<?php
/**
 * Title: Header
 * Slug: artifact/header
 * Categories: header
 * Block Types: core/template-part/header
 * Inserter: no
 *
 * @package Artifact
 */

$artifact_logo = esc_url( get_parent_theme_file_uri( 'assets/images/artifact-logo.svg' ) );
$artifact_home = esc_url( home_url( '/' ) );
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:image {"width":"148px","height":"36px","sizeSlug":"full","linkDestination":"custom"} -->
		<figure class="wp-block-image size-full is-resized"><a href="<?php echo $artifact_home; ?>"><img src="<?php echo $artifact_logo; ?>" alt="<?php echo esc_attr__( 'Artifact', 'artifact' ); ?>" style="width:148px;height:36px"/></a></figure>
		<!-- /wp:image -->

		<!-- wp:navigation {"ariaLabel":"<?php echo esc_attr__( 'Primary menu', 'artifact' ); ?>","overlayMenu":"mobile","overlayBackgroundColor":"main-bg","overlayTextColor":"text-white","layout":{"type":"flex","setCascadingProperties":true,"justifyContent":"center","flexWrap":"wrap"}} -->
			<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Home', 'artifact' ); ?>","url":"<?php echo $artifact_home; ?>","kind":"custom"} /-->
			<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'About', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
			<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Services', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
			<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Portfolio', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
			<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Blog', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
			<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Contacts', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
		<!-- /wp:navigation -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","style":{"border":{"radius":"24px"},"spacing":{"padding":{"top":"12px","bottom":"12px","left":"32px","right":"32px"}},"typography":{"fontWeight":"700","lineHeight":"1.25"}},"fontSize":"button-small"} -->
			<div class="wp-block-button"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background has-button-small-font-size has-custom-font-size wp-element-button" href="#" style="border-radius:24px;padding-top:12px;padding-right:32px;padding-bottom:12px;padding-left:32px;font-weight:700;line-height:1.25"><?php echo esc_html__( 'Start A Project', 'artifact' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
