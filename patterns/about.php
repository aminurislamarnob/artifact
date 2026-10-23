<?php
/**
 * Title: About
 * Slug: artifact/about
 * Categories: featured
 *
 * @package Artifact
 */

$artifact_about = esc_url( get_parent_theme_file_uri( 'assets/images/about-portrait.jpg' ) );
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column {"width":"50%"} -->
		<div class="wp-block-column" style="flex-basis:50%">
			<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $artifact_about; ?>" alt="<?php echo esc_attr__( 'Team member at work', 'artifact' ); ?>"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"50%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
		<div class="wp-block-column" style="flex-basis:50%">
			<!-- wp:paragraph {"textColor":"text-color","fontSize":"medium-title"} -->
			<p class="has-text-color-color has-text-color has-medium-title-font-size"><?php echo esc_html__( 'About Us', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:heading {"fontSize":"heading-03"} -->
			<h2 class="wp-block-heading has-heading-03-font-size"><?php echo esc_html__( 'We help to accelerate your business growth', 'artifact' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"style":{"typography":{"lineHeight":"1.4"}},"fontSize":"heading-06"} -->
			<p class="has-heading-06-font-size" style="line-height:1.4"><?php echo esc_html__( 'We develop disruptive solutions for organisations. We’ve built a reputation for excellent client satisfaction as evidenced by our service.', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"textColor":"text-color"} -->
			<p class="has-text-color-color has-text-color"><?php echo esc_html__( 'Seamlessly formulate exceptional “outside the box” thinking business e-commerce. Phosfluorescently engage end-to-end platforms before integrated functionalities.', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph -->
			<p><a href="#"><?php echo esc_html__( 'More about us', 'artifact' ); ?></a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
