<?php
/**
 * Title: Archive heading
 * Slug: artifact/hidden-archive-heading
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
		<p class="has-text-color-color has-text-color has-medium-title-font-size" style="line-height:26px"><?php echo esc_html__( 'Archive', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:query-title {"type":"archive","level":1,"fontSize":"heading-03","style":{"typography":{"lineHeight":"64px"}}} /-->
	</div>
	<!-- /wp:column -->
	<!-- wp:column {"verticalAlignment":"center","width":"42%"} -->
	<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%">
		<!-- wp:term-description {"textColor":"text-color","fontSize":"medium-paragraph","style":{"typography":{"lineHeight":"28px"}}} /-->
	</div>
	<!-- /wp:column -->
</div>
<!-- /wp:columns -->
