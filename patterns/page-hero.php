<?php
/**
 * Title: Page hero
 * Slug: artifact/page-hero
 * Categories: banner
 * Description: Page title as a label, a large heading and a short introduction.
 *
 * @package Artifact
 */

?>
<!-- wp:group {"align":"full","className":"artifact-page-hero","style":{"spacing":{"padding":{"top":"80px","bottom":"var:preset|spacing|60","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull artifact-page-hero has-main-bg-background-color has-background" style="padding-top:80px;padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30","top":"24px"}}}} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center","width":"670px","style":{"spacing":{"blockGap":"24px"}}} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:670px">
			<!-- wp:post-title {"level":0,"style":{"typography":{"lineHeight":"26px","fontWeight":"600"}},"textColor":"text-color","fontSize":"medium-title"} /-->

			<!-- wp:heading {"level":1,"style":{"typography":{"lineHeight":"64px"}},"fontSize":"heading-03"} -->
			<h1 class="wp-block-heading has-heading-03-font-size" style="line-height:64px"><?php echo esc_html__( 'We build bridges between companies and customers', 'artifact' ); ?></h1>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"470px"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:470px">
			<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-color","fontSize":"medium-paragraph"} -->
			<p class="has-text-color-color has-text-color has-medium-paragraph-font-size" style="line-height:28px"><?php echo esc_html__( 'From a single storefront to a full product platform, we plan, design, build and look after the websites and tools that connect your business with the people it serves.', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
