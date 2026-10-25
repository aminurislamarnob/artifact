<?php
/**
 * Title: Service details hero
 * Slug: artifact/hidden-service-hero
 * Inserter: no
 * Description: Label and page title for the Service Details template.
 *
 * @package Artifact
 */

?>
<!-- wp:group {"align":"full","className":"artifact-page-hero","style":{"spacing":{"padding":{"top":"80px","bottom":"30px","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull artifact-page-hero has-main-bg-background-color has-background" style="padding-top:80px;padding-right:var(--wp--preset--spacing--20);padding-bottom:30px;padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"24px"}},"layout":{"type":"constrained","contentSize":"670px","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"style":{"typography":{"lineHeight":"26px","fontWeight":"600"}},"textColor":"text-color","fontSize":"medium-title"} -->
		<p class="has-text-color-color has-text-color has-medium-title-font-size" style="font-weight:600;line-height:26px"><?php echo esc_html__( 'Service Details', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:post-title {"level":1,"style":{"typography":{"lineHeight":"64px"}},"fontSize":"heading-03"} /-->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
