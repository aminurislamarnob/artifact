<?php
/**
 * Title: Project call to action
 * Slug: artifact/project-cta
 * Categories: featured, call-to-action
 *
 * @package Artifact
 */

$artifact_bg = esc_url( get_parent_theme_file_uri( 'assets/images/cta-bg.png' ) );
$artifact_arrow = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-outward.svg' ) );
$artifact_icon_alt = esc_attr__( 'Arrow', 'artifact' );
$artifact_subtitle = esc_html__( 'Let’s Collaborate', 'artifact' );
$artifact_title = esc_html__( 'Got A Project? Lets Talk.', 'artifact' );
$artifact_button = esc_html__( 'Start A Project', 'artifact' );
?>
<!-- wp:group {"align":"full","className":"artifact-cta","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull artifact-cta has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","className":"artifact-cta-box","style":{"spacing":{"padding":{"top":"80px","bottom":"80px","left":"32px","right":"32px"},"blockGap":"24px"}},"backgroundColor":"primary","layout":{"type":"flex","orientation":"vertical","justifyContent":"center","verticalAlignment":"center"}} -->
	<div class="wp-block-group alignwide artifact-cta-box has-primary-background-color has-background" style="background-image:url('<?php echo $artifact_bg; ?>');background-size:cover;background-position:center;border-radius:24px;padding-top:80px;padding-right:32px;padding-bottom:80px;padding-left:32px">
		<!-- wp:paragraph {"align":"center","textColor":"text-white","fontSize":"medium-title","style":{"typography":{"lineHeight":"26px"}}} -->
		<p class="has-text-align-center has-text-white-color has-text-color has-medium-title-font-size" style="line-height:26px"><?php echo $artifact_subtitle; ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"textAlign":"center","level":2,"className":"artifact-cta-title","style":{"typography":{"lineHeight":"1.15","letterSpacing":"-0.03em"}},"textColor":"text-white","fontSize":"heading-02"} -->
		<h2 class="wp-block-heading has-text-align-center artifact-cta-title has-text-white-color has-text-color has-heading-02-font-size" style="letter-spacing:-0.03em;line-height:1.15"><?php echo $artifact_title; ?></h2>
		<!-- /wp:heading -->

		<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
		<div class="wp-block-buttons">
			<!-- wp:button {"backgroundColor":"main-bg","textColor":"text-white","className":"artifact-button-icon"} -->
			<div class="wp-block-button artifact-button-icon"><a class="wp-block-button__link has-text-white-color has-main-bg-background-color has-text-color has-background wp-element-button" href="#"><?php echo $artifact_button; ?> <img src="<?php echo $artifact_arrow; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="24" height="24"/></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
