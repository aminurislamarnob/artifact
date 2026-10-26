<?php
/**
 * Title: Blog heading
 * Slug: artifact/hidden-blog-heading
 * Inserter: no
 *
 * @package Artifact
 */
?>
<!-- wp:columns {"align":"wide","verticalAlignment":"center","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50","top":"var:preset|spacing|20"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center">
	<!-- wp:column {"verticalAlignment":"center","width":"58%"} -->
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:58%">
		<!-- wp:paragraph {"textColor":"text-color","fontSize":"medium-title","style":{"typography":{"lineHeight":"26px"}}} -->
		<p class="has-text-color-color has-text-color has-medium-title-font-size" style="line-height:26px"><?php echo esc_html__( 'Blog', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"level":1,"fontSize":"heading-03","style":{"typography":{"lineHeight":"64px"}}} -->
		<h1 class="wp-block-heading has-heading-03-font-size" style="line-height:64px"><?php echo esc_html__( 'Our latest articles that might help you', 'artifact' ); ?></h1>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:column -->
	<!-- wp:column {"verticalAlignment":"center","width":"42%"} -->
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%">
		<!-- wp:paragraph {"textColor":"text-color","fontSize":"medium-paragraph","style":{"typography":{"lineHeight":"28px"}}} -->
		<p class="has-text-color-color has-text-color has-medium-paragraph-font-size" style="line-height:28px"><?php echo esc_html__( 'Guides, ideas and lessons from our team on building websites, software and digital products that grow a business.', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->
