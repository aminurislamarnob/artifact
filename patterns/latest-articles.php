<?php
/**
 * Title: Latest articles
 * Slug: artifact/latest-articles
 * Categories: featured, posts
 *
 * @package Artifact
 */

$artifact_arrow = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-outward.svg' ) );
// Link the blog only when the site has a posts page; otherwise the archive link is the home page.
$artifact_posts_page = 'page' === get_option( 'show_on_front' ) ? (int) get_option( 'page_for_posts' ) : 0;
$artifact_view_all   = esc_html__( 'View All', 'artifact' );
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"var:preset|spacing|50"}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:separator {"align":"wide","className":"is-style-wide"} -->
	<hr class="wp-block-separator alignwide has-alpha-channel-opacity is-style-wide"/>
	<!-- /wp:separator -->

	<!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
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

		<?php if ( $artifact_posts_page ) : ?>
		<!-- wp:buttons -->
		<div class="wp-block-buttons">
			<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","className":"artifact-button-icon"} -->
			<div class="wp-block-button artifact-button-icon"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background wp-element-button" href="<?php echo esc_url( get_permalink( $artifact_posts_page ) ); ?>"><?php echo $artifact_view_all; ?> <img src="<?php echo $artifact_arrow; ?>" alt="" width="24" height="24"/></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
		<?php endif; ?>
	</div>
	<!-- /wp:group -->

	<!-- wp:query {"queryId":4,"query":{"perPage":2,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"exclude","inherit":false},"align":"wide","className":"artifact-latest-articles"} -->
	<div class="wp-block-query alignwide artifact-latest-articles">
		<!-- wp:post-template {"layout":{"type":"grid","columnCount":2},"style":{"spacing":{"blockGap":{"left":"30px","top":"40px"}}}} -->
			<!-- wp:group {"className":"artifact-blog-card","style":{"border":{"radius":"24px","width":"1px","color":"var:preset|color|border"}},"layout":{"type":"default"}} -->
			<div class="wp-block-group artifact-blog-card has-border-color" style="border-color:var(--wp--preset--color--border);border-width:1px;border-radius:24px">
				<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9"} /-->

				<!-- wp:group {"style":{"spacing":{"padding":{"top":"24px","bottom":"24px","left":"24px","right":"24px"},"blockGap":"20px"}},"backgroundColor":"light-bg","layout":{"type":"constrained"}} -->
				<div class="wp-block-group has-light-bg-background-color has-background" style="padding-top:24px;padding-right:24px;padding-bottom:24px;padding-left:24px">
					<!-- wp:group {"style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"constrained"}} -->
					<div class="wp-block-group">
						<!-- wp:post-title {"isLink":true,"style":{"typography":{"lineHeight":"32px"}},"fontSize":"large-title"} /-->
						<!-- wp:post-excerpt {"moreText":"","excerptLength":25,"style":{"typography":{"lineHeight":"24px"}},"textColor":"text-color","fontSize":"small-paragraph"} /-->
					</div>
					<!-- /wp:group -->

					<!-- wp:group {"className":"artifact-blog-meta","style":{"spacing":{"blockGap":"8px","margin":{"top":"16px"}}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
					<div class="wp-block-group artifact-blog-meta" style="margin-top:16px">
						<!-- wp:avatar {"size":32,"style":{"border":{"radius":"999px"}}} /-->
						<!-- wp:post-author-name {"isLink":false,"textColor":"text-color","fontSize":"small-paragraph"} /-->
						<!-- wp:post-date {"format":"M j, Y","textColor":"text-color","fontSize":"small-paragraph"} /-->
						<!-- wp:post-time-to-read {"displayAsRange":false,"textColor":"text-color","fontSize":"small-paragraph"} /-->
					</div>
					<!-- /wp:group -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		<!-- /wp:post-template -->
	</div>
	<!-- /wp:query -->
</div>
<!-- /wp:group -->
