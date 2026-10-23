<?php
/**
 * Title: Project call to action
 * Slug: artifact/project-cta
 * Categories: featured, call-to-action
 *
 * @package Artifact
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:heading {"textAlign":"center","align":"wide","fontSize":"heading-03"} -->
	<h2 class="wp-block-heading alignwide has-text-align-center has-heading-03-font-size"><?php echo wp_kses_post( __( 'Got A Project?<br>Let’s Talk. Hi,', 'artifact' ) ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","className":"is-style-rounded"} -->
		<div class="wp-block-button is-style-rounded"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background wp-element-button" href="#"><?php echo esc_html__( 'Start A Project', 'artifact' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
