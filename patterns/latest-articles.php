<?php
/**
 * Title: Latest articles
 * Slug: artifact/latest-articles
 * Categories: featured, posts
 *
 * @package Artifact
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"textColor":"text-color","fontSize":"medium-title"} -->
			<p class="has-text-color-color has-text-color has-medium-title-font-size"><?php echo esc_html__( 'Blog', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"fontSize":"heading-03"} -->
			<h2 class="wp-block-heading has-heading-03-font-size"><?php echo wp_kses_post( __( 'Our latest<br>articles', 'artifact' ) ); ?></h2>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:group -->

		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","className":"is-style-rounded"} -->
			<div class="wp-block-button is-style-rounded"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background wp-element-button" href="#"><?php echo esc_html__( 'View All', 'artifact' ); ?></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

	<!-- wp:query {"queryId":4,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"align":"wide"} -->
	<div class="wp-block-query alignwide">
		<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
			<!-- wp:post-featured-image {"isLink":true} /-->
			<!-- wp:post-terms {"term":"category"} /-->
			<!-- wp:post-date /-->
			<!-- wp:post-title {"isLink":true,"fontSize":"large-title"} /-->
			<!-- wp:read-more {"content":"<?php echo esc_html__( 'Read more', 'artifact' ); ?>"} /-->
		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
