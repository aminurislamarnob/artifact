<?php
/**
 * Title: Contact information and message
 * Slug: artifact/contact-info
 * Categories: contact
 * Keywords: contact, form, email, phone, address
 * Viewport width: 1400
 * Description: Contact details, social links and a message panel. Replace the panel's text and button with a form block, such as Contact Form 7, to take messages on the page.
 *
 * @package Artifact
 */

$artifact_email          = __( 'contact@example.com', 'artifact' );
$artifact_phone          = __( '+254 659 546', 'artifact' );
$artifact_icon_phone     = esc_url( get_parent_theme_file_uri( 'assets/images/icon-phone.svg' ) );
$artifact_icon_mail      = esc_url( get_parent_theme_file_uri( 'assets/images/icon-mail.svg' ) );
$artifact_icon_schedule  = esc_url( get_parent_theme_file_uri( 'assets/images/icon-schedule.svg' ) );
$artifact_icon_location  = esc_url( get_parent_theme_file_uri( 'assets/images/icon-location.svg' ) );
$artifact_arrow          = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-outward.svg' ) );
?>
<!-- wp:group {"align":"full","className":"artifact-contact","style":{"spacing":{"padding":{"top":"0","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull artifact-contact has-main-bg-background-color has-background" style="padding-top:0;padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:columns {"align":"wide","className":"artifact-contact-box","style":{"spacing":{"padding":{"top":"48px","bottom":"48px","left":"48px","right":"48px"},"blockGap":{"left":"130px","top":"48px"}},"border":{"radius":"24px"}},"backgroundColor":"light-bg"} -->
	<div class="wp-block-columns alignwide artifact-contact-box has-light-bg-background-color has-background" style="border-radius:24px;padding-top:48px;padding-right:48px;padding-bottom:48px;padding-left:48px">
		<!-- wp:column {"width":"322px","style":{"spacing":{"blockGap":"53px"}}} -->
		<div class="wp-block-column" style="flex-basis:322px">
			<!-- wp:group {"style":{"spacing":{"blockGap":"31px"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
			<div class="wp-block-group">
				<!-- wp:heading {"style":{"typography":{"lineHeight":"42px"}},"fontSize":"heading-05"} -->
				<h2 class="wp-block-heading has-heading-05-font-size" style="line-height:42px"><?php echo esc_html__( 'Contact information', 'artifact' ); ?></h2>
				<!-- /wp:heading -->

				<!-- wp:group {"className":"artifact-contact-list","style":{"spacing":{"blockGap":"20px"}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap"}} -->
				<div class="wp-block-group artifact-contact-list">
					<!-- wp:paragraph {"className":"artifact-contact-item"} -->
					<p class="artifact-contact-item"><a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $artifact_phone ) ); ?>"><img src="<?php echo $artifact_icon_phone; ?>" alt="" width="24" height="24"/> <span><?php echo esc_html( $artifact_phone ); ?></span></a></p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"artifact-contact-item"} -->
					<p class="artifact-contact-item"><a href="<?php echo esc_url( 'mailto:' . $artifact_email ); ?>"><img src="<?php echo $artifact_icon_mail; ?>" alt="" width="24" height="24"/> <span><?php echo esc_html( $artifact_email ); ?></span></a></p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"artifact-contact-item"} -->
					<p class="artifact-contact-item"><span><img src="<?php echo $artifact_icon_schedule; ?>" alt="" width="24" height="24"/> <span><?php echo esc_html__( 'Mon – Sat: 9am – 6pm', 'artifact' ); ?><br><?php echo esc_html__( 'Sunday (Closed)', 'artifact' ); ?></span></span></p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"artifact-contact-item"} -->
					<p class="artifact-contact-item"><span><img src="<?php echo $artifact_icon_location; ?>" alt="" width="24" height="24"/> <span><?php echo esc_html__( 'Dhaka, Bangladesh', 'artifact' ); ?></span></span></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->

			<!-- wp:group {"className":"artifact-contact-social","style":{"spacing":{"padding":{"top":"24px","bottom":"24px","left":"24px","right":"24px"},"blockGap":"16px"},"border":{"radius":"12px","width":"1px"}},"backgroundColor":"main-bg","borderColor":"border","layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="wp-block-group artifact-contact-social has-border-color has-border-border-color has-main-bg-background-color has-background" style="border-width:1px;border-radius:12px;padding-top:24px;padding-right:24px;padding-bottom:24px;padding-left:24px">
				<!-- wp:paragraph {"style":{"typography":{"lineHeight":"26px","fontWeight":"500"}},"textColor":"text-white","fontSize":"small-title"} -->
				<p class="has-text-white-color has-text-color has-small-title-font-size" style="font-weight:500;line-height:26px"><?php echo esc_html__( 'Follow Us', 'artifact' ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:social-links {"iconColor":"text-color","size":"has-normal-icon-size","className":"is-style-logos-only","style":{"spacing":{"blockGap":{"left":"16px"}}}} -->
				<ul class="wp-block-social-links has-normal-icon-size has-icon-color is-style-logos-only">
					<!-- wp:social-link {"url":"#","service":"facebook","label":"<?php echo esc_attr__( 'Facebook', 'artifact' ); ?>"} /-->
					<!-- wp:social-link {"url":"#","service":"x","label":"<?php echo esc_attr__( 'X', 'artifact' ); ?>"} /-->
					<!-- wp:social-link {"url":"#","service":"linkedin","label":"<?php echo esc_attr__( 'LinkedIn', 'artifact' ); ?>"} /-->
					<!-- wp:social-link {"url":"#","service":"instagram","label":"<?php echo esc_attr__( 'Instagram', 'artifact' ); ?>"} /-->
				</ul>
				<!-- /wp:social-links -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"622px","className":"artifact-contact-form","style":{"spacing":{"padding":{"top":"48px","bottom":"48px","left":"48px","right":"48px"},"blockGap":"24px"},"border":{"radius":"20px","width":"1px"}},"backgroundColor":"main-bg","borderColor":"border"} -->
		<div class="wp-block-column artifact-contact-form has-border-color has-border-border-color has-main-bg-background-color has-background" style="border-width:1px;border-radius:20px;padding-top:48px;padding-right:48px;padding-bottom:48px;padding-left:48px;flex-basis:622px">
			<!-- wp:heading {"style":{"typography":{"lineHeight":"32px"}},"fontSize":"large-title"} -->
			<h2 class="wp-block-heading has-large-title-font-size" style="line-height:32px"><?php echo esc_html__( 'Send us a message', 'artifact' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-color","fontSize":"medium-paragraph"} -->
			<p class="has-text-color-color has-text-color has-medium-paragraph-font-size" style="line-height:28px"><?php echo esc_html__( 'Tell us about your project and we’ll get back to you within one business day.', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"40px"}}}} -->
			<div class="wp-block-buttons" style="margin-top:40px">
				<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","className":"artifact-button-icon"} -->
				<div class="wp-block-button artifact-button-icon"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( 'mailto:' . $artifact_email ); ?>"><?php echo esc_html__( 'Send Inquiry', 'artifact' ); ?> <img src="<?php echo $artifact_arrow; ?>" alt="" width="24" height="24"/></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
