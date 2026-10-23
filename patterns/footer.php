<?php
/**
 * Title: Footer
 * Slug: artifact/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Inserter: no
 *
 * @package Artifact
 */

$artifact_logo = esc_url( get_parent_theme_file_uri( 'assets/images/logo.svg' ) );
$artifact_home = esc_url( home_url( '/' ) );
$artifact_email = __( 'support@welan.com', 'artifact' );
$artifact_phone = __( '+254 659 546', 'artifact' );
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|50","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:image {"width":"154px","height":"36px","sizeSlug":"full","linkDestination":"custom"} -->
		<figure class="wp-block-image size-full is-resized"><a href="<?php echo $artifact_home; ?>"><img src="<?php echo $artifact_logo; ?>" alt="<?php echo esc_attr__( 'weLabs', 'artifact' ); ?>" style="width:154px;height:36px"/></a></figure>
		<!-- /wp:image -->

		<!-- wp:social-links {"iconColor":"text-white","size":"has-normal-icon-size","className":"is-style-logos-only","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|20"}}}} -->
		<ul class="wp-block-social-links has-normal-icon-size has-icon-color is-style-logos-only">
			<!-- wp:social-link {"url":"#","service":"facebook","label":"<?php echo esc_attr__( 'Facebook', 'artifact' ); ?>"} /-->
			<!-- wp:social-link {"url":"#","service":"x","label":"<?php echo esc_attr__( 'X', 'artifact' ); ?>"} /-->
			<!-- wp:social-link {"url":"#","service":"linkedin","label":"<?php echo esc_attr__( 'LinkedIn', 'artifact' ); ?>"} /-->
			<!-- wp:social-link {"url":"#","service":"instagram","label":"<?php echo esc_attr__( 'Instagram', 'artifact' ); ?>"} /-->
		</ul>
		<!-- /wp:social-links -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"},"margin":{"top":"var:preset|spacing|70"}}}} -->
	<div class="wp-block-columns alignwide" style="margin-top:var(--wp--preset--spacing--70)">
		<!-- wp:column {"width":"55%"} -->
		<div class="wp-block-column" style="flex-basis:55%">
			<!-- wp:heading {"level":2,"fontSize":"heading-03"} -->
			<h2 class="wp-block-heading has-heading-03-font-size"><?php echo esc_html__( 'Let’s work together', 'artifact' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><a href="<?php echo esc_url( 'mailto:' . $artifact_email ); ?>"><?php echo esc_html( $artifact_email ); ?></a></p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph -->
			<p><a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $artifact_phone ) ); ?>"><?php echo esc_html( $artifact_phone ); ?></a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"22.5%"} -->
		<div class="wp-block-column" style="flex-basis:22.5%">
			<!-- wp:navigation {"overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"}} -->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'About', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Services', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Blog', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Contact', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
			<!-- /wp:navigation -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"22.5%"} -->
		<div class="wp-block-column" style="flex-basis:22.5%">
			<!-- wp:navigation {"overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"}} -->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Portfolios', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Team members', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Help', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
			<!-- /wp:navigation -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:group {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|70"},"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group alignwide" style="margin-top:var(--wp--preset--spacing--70)">
		<!-- wp:paragraph {"textColor":"text-color"} -->
		<p class="has-text-color-color has-text-color"><?php echo esc_html__( 'Powered by WeLabs', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph -->
			<p><?php echo esc_html__( 'Subscribe newsletter', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"textColor":"text-color"} -->
			<p class="has-text-color-color has-text-color"><?php echo esc_html__( 'Enter email address...', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","fontSize":"button-small"} -->
				<div class="wp-block-button"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background has-button-small-font-size has-custom-font-size wp-element-button" href="#"><?php echo esc_html__( 'Subscribe', 'artifact' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
