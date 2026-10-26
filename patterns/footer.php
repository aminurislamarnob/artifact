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

$artifact_home = esc_url( home_url( '/' ) );
$artifact_arrow = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-outward.svg' ) );
$artifact_icon_mail = esc_url( get_parent_theme_file_uri( 'assets/images/icon-mail.svg' ) );
$artifact_icon_mail_alt = esc_attr__( 'Email', 'artifact' );
$artifact_icon_phone = esc_url( get_parent_theme_file_uri( 'assets/images/icon-phone.svg' ) );
$artifact_icon_phone_alt = esc_attr__( 'Phone', 'artifact' );
$artifact_icon_location = esc_url( get_parent_theme_file_uri( 'assets/images/icon-location.svg' ) );
$artifact_icon_location_alt = esc_attr__( 'Location', 'artifact' );
$artifact_email = __( 'contact@example.com', 'artifact' );
$artifact_phone = __( '+254 659 546', 'artifact' );
$artifact_privacy = esc_url( get_privacy_policy_url() );
$artifact_privacy_label = esc_html__( 'Privacy Policy', 'artifact' );
?>
<!-- wp:group {"align":"full","backgroundColor":"light-bg","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull has-light-bg-background-color has-background">
	<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|60","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--20)">
		<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30"}}}} -->
		<div class="wp-block-columns alignwide">
			<!-- wp:column {"width":"34%","style":{"spacing":{"blockGap":"24px"}}} -->
			<div class="wp-block-column" style="flex-basis:34%">
				<!-- wp:group {"className":"artifact-site-brand","style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
				<div class="wp-block-group artifact-site-brand">
					<!-- wp:site-logo {"width":148,"shouldSyncIcon":false} /-->

					<!-- wp:site-title {"level":0,"style":{"typography":{"fontWeight":"600","lineHeight":"36px"}},"fontSize":"heading-06"} /-->
				</div>
				<!-- /wp:group -->

				<!-- wp:paragraph {"textColor":"text-color","fontSize":"medium-paragraph"} -->
				<p class="has-text-color-color has-text-color has-medium-paragraph-font-size" style="line-height:24px;max-width:320px"><?php echo esc_html__( 'Delivering modern software and custom development services worldwide.', 'artifact' ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:group {"className":"artifact-footer-contact","style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
				<div class="wp-block-group artifact-footer-contact">
					<!-- wp:paragraph {"className":"artifact-footer-contact-item"} -->
					<p class="artifact-footer-contact-item"><a href="<?php echo esc_url( 'mailto:' . $artifact_email ); ?>"><img src="<?php echo $artifact_icon_mail; ?>" alt="<?php echo $artifact_icon_mail_alt; ?>" width="18" height="18"/> <span><?php echo esc_html( $artifact_email ); ?></span></a></p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"artifact-footer-contact-item"} -->
					<p class="artifact-footer-contact-item"><a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $artifact_phone ) ); ?>"><img src="<?php echo $artifact_icon_phone; ?>" alt="<?php echo $artifact_icon_phone_alt; ?>" width="18" height="18"/> <span><?php echo esc_html( $artifact_phone ); ?></span></a></p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"artifact-footer-contact-item"} -->
					<p class="artifact-footer-contact-item"><span><img src="<?php echo $artifact_icon_location; ?>" alt="<?php echo $artifact_icon_location_alt; ?>" width="18" height="18"/> <span><?php echo esc_html__( 'Dhaka, Bangladesh', 'artifact' ); ?></span></span></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"width":"20%","style":{"spacing":{"blockGap":"24px"}}} -->
			<div class="wp-block-column" style="flex-basis:20%">
				<!-- wp:paragraph {"className":"artifact-footer-title","fontSize":"button-large"} -->
				<p class="artifact-footer-title has-button-large-font-size"><?php echo esc_html__( 'Site Links', 'artifact' ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:navigation {"ariaLabel":"<?php echo esc_attr__( 'Site links left', 'artifact' ); ?>","overlayMenu":"never","className":"artifact-footer-nav","layout":{"type":"flex","orientation":"vertical"}} -->
					<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Home', 'artifact' ); ?>","url":"<?php echo $artifact_home; ?>","kind":"custom"} /-->
					<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'About Us', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
					<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Our Services', 'artifact' ); ?>","url":"#","kind":"custom"} /-->
				<!-- /wp:navigation -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"width":"20%","style":{"spacing":{"blockGap":"24px"}}} -->
			<div class="wp-block-column" style="flex-basis:20%">
				<!-- wp:paragraph {"className":"artifact-footer-title","fontSize":"button-large"} -->
				<p class="artifact-footer-title has-button-large-font-size"><?php echo esc_html__( 'Explore', 'artifact' ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:navigation {"ariaLabel":"<?php echo esc_attr__( 'Site links right', 'artifact' ); ?>","overlayMenu":"never","className":"artifact-footer-nav","layout":{"type":"flex","orientation":"vertical"}} -->
					<!-- wp:navigation-link {"label":"<?php echo esc_html__( 'Start a Project', 'artifact' ); ?>","url":"<?php echo esc_url( 'mailto:' . $artifact_email ); ?>","kind":"custom"} /-->
					<?php if ( $artifact_privacy ) : ?>
					<!-- wp:navigation-link {"label":"<?php echo $artifact_privacy_label; ?>","url":"<?php echo $artifact_privacy; ?>","kind":"custom"} /-->
					<?php endif; ?>
				<!-- /wp:navigation -->
			</div>
			<!-- /wp:column -->

			<!-- wp:column {"width":"26%","style":{"spacing":{"blockGap":"24px"}}} -->
			<div class="wp-block-column" style="flex-basis:26%">
				<!-- wp:paragraph {"className":"artifact-footer-title","fontSize":"button-large"} -->
				<p class="artifact-footer-title has-button-large-font-size"><?php echo esc_html__( 'Subscribe Us', 'artifact' ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:group {"className":"artifact-footer-newsletter","style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"constrained"}} -->
				<div class="wp-block-group artifact-footer-newsletter">
					<!-- wp:paragraph {"textColor":"text-color","fontSize":"medium-paragraph"} -->
					<p class="has-text-color-color has-text-color has-medium-paragraph-font-size"><?php echo esc_html__( 'Follow our latest articles in your feed reader.', 'artifact' ); ?></p>
					<!-- /wp:paragraph -->

					<!-- wp:buttons -->
					<div class="wp-block-buttons">
						<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","className":"artifact-button-icon"} -->
						<div class="wp-block-button artifact-button-icon"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( get_feed_link() ); ?>"><?php echo esc_html__( 'Subscribe via RSS', 'artifact' ); ?> <img src="<?php echo $artifact_arrow; ?>" alt="" width="24" height="24"/></a></div>
						<!-- /wp:button -->
					</div>
					<!-- /wp:buttons -->
				</div>
				<!-- /wp:group -->

				<!-- wp:social-links {"iconColor":"text-white","size":"has-normal-icon-size","className":"is-style-logos-only","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|20"}}}} -->
				<ul class="wp-block-social-links has-normal-icon-size has-icon-color is-style-logos-only">
					<!-- wp:social-link {"url":"https://x.com/","service":"x","label":"<?php echo esc_attr__( 'X', 'artifact' ); ?>"} /-->
					<!-- wp:social-link {"url":"https://www.linkedin.com/","service":"linkedin","label":"<?php echo esc_attr__( 'LinkedIn', 'artifact' ); ?>"} /-->
					<!-- wp:social-link {"url":"https://www.instagram.com/","service":"instagram","label":"<?php echo esc_attr__( 'Instagram', 'artifact' ); ?>"} /-->
					<!-- wp:social-link {"url":"https://www.facebook.com/","service":"facebook","label":"<?php echo esc_attr__( 'Facebook', 'artifact' ); ?>"} /-->
				</ul>
				<!-- /wp:social-links -->
			</div>
			<!-- /wp:column -->
		</div>
		<!-- /wp:columns -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}},"border":{"top":{"color":"var:preset|color|border","style":"solid","width":"1px"}}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignfull" style="border-top-color:var(--wp--preset--color--border);border-top-style:solid;border-top-width:1px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)">
		<!-- wp:paragraph {"align":"center","textColor":"text-color","fontSize":"small-paragraph"} -->
		<p class="has-text-align-center has-text-color-color has-text-color has-small-paragraph-font-size"><?php echo esc_html__( '© 2026 Artifact, All Rights Reserved.', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
