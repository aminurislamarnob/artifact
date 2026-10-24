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
$artifact_arrow = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-outward.svg' ) );
$artifact_icon_alt = esc_attr__( 'Arrow', 'artifact' );
$artifact_email = __( 'support@welan.com', 'artifact' );
$artifact_phone = __( '+254 659 546', 'artifact' );
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|50","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"var:preset|spacing|60"}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"bottom":"var:preset|spacing|30"}},"border":{"bottom":{"color":"var:preset|color|border","style":"solid","width":"1px"}}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
	<div class="wp-block-group alignwide" style="border-bottom-color:var(--wp--preset--color--border);border-bottom-style:solid;border-bottom-width:1px;padding-bottom:var(--wp--preset--spacing--30)">
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

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column {"width":"55%","style":{"spacing":{"blockGap":"32px"}}} -->
		<div class="wp-block-column" style="flex-basis:55%">
			<!-- wp:heading {"level":2,"style":{"typography":{"lineHeight":"64px"}},"fontSize":"heading-03"} -->
			<h2 class="wp-block-heading has-heading-03-font-size" style="line-height:64px"><?php echo esc_html__( 'Let’s work together', 'artifact' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:group {"style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
			<div class="wp-block-group">
				<!-- wp:paragraph {"className":"artifact-footer-pill"} -->
				<p class="artifact-footer-pill"><a href="<?php echo esc_url( 'mailto:' . $artifact_email ); ?>"><?php echo esc_html( $artifact_email ); ?> <img src="<?php echo $artifact_arrow; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="20" height="20"/></a></p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"className":"artifact-footer-pill"} -->
				<p class="artifact-footer-pill"><a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $artifact_phone ) ); ?>"><?php echo esc_html( $artifact_phone ); ?> <img src="<?php echo $artifact_arrow; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="20" height="20"/></a></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"22.5%"} -->
		<div class="wp-block-column" style="flex-basis:22.5%">
			<!-- wp:navigation {"ariaLabel":"<?php echo esc_attr__( 'Footer menu', 'artifact' ); ?>","overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"}} -->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( '• About', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( '• Services', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( '• Blog', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( '• Contact', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
			<!-- /wp:navigation -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"22.5%"} -->
		<div class="wp-block-column" style="flex-basis:22.5%">
			<!-- wp:navigation {"ariaLabel":"<?php echo esc_attr__( 'Footer resources menu', 'artifact' ); ?>","overlayMenu":"never","layout":{"type":"flex","orientation":"vertical"}} -->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( '• Portfolios', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( '• Team members', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
				<!-- wp:navigation-link {"label":"<?php echo esc_html__( '• Help', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
			<!-- /wp:navigation -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"textColor":"text-color","fontSize":"medium-paragraph"} -->
		<p class="has-text-color-color has-text-color has-medium-paragraph-font-size"><?php echo esc_html__( 'Powered by WeLabs', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:group {"className":"artifact-footer-newsletter","style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group artifact-footer-newsletter">
			<!-- wp:paragraph {"textColor":"text-white","fontSize":"small-paragraph"} -->
			<p class="has-text-white-color has-text-color has-small-paragraph-font-size"><?php echo esc_html__( 'Subscribe newsletter', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:html -->
			<form class="artifact-newsletter-form" action="#" method="post">
				<label class="screen-reader-text" for="artifact-footer-email"><?php echo esc_attr__( 'Enter email address...', 'artifact' ); ?></label>
				<input id="artifact-footer-email" type="email" name="email" placeholder="<?php echo esc_attr__( 'Enter email address...', 'artifact' ); ?>" required />
				<button type="submit" aria-label="<?php echo esc_attr__( 'Subscribe', 'artifact' ); ?>">
					<img src="<?php echo $artifact_arrow; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="20" height="20"/>
				</button>
			</form>
			<!-- /wp:html -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
