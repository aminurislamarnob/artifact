<?php
/**
 * Title: Hero
 * Slug: artifact/hero
 * Categories: banner, featured
 * Description: Homepage dark hero with headline, supporting copy, and a call to action.
 *
 * @package Artifact
 */

$artifact_portrait = esc_url( get_parent_theme_file_uri( 'assets/images/hero-portrait.jpg' ) );
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column {"width":"50%","style":{"spacing":{"blockGap":"var:preset|spacing|50"}}} -->
		<div class="wp-block-column" style="flex-basis:50%">
			<!-- wp:heading {"level":1,"fontSize":"heading-01"} -->
			<h1 class="wp-block-heading has-heading-01-font-size"><?php echo wp_kses_post( __( 'Creating<br>Software &amp; Digital Excellence', 'artifact' ) ); ?></h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"textColor":"text-color","fontSize":"large-paragraph"} -->
			<p class="has-text-color-color has-text-color has-large-paragraph-font-size"><?php echo esc_html__( 'We transform businesses of most major sectors with powerful and adaptable digital solutions.', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","className":"is-style-rounded","fontSize":"button-large"} -->
				<div class="wp-block-button is-style-rounded"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background has-button-large-font-size has-custom-font-size wp-element-button" href="#"><?php echo esc_html__( 'Lets Talk With US', 'artifact' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"50%","verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:image {"sizeSlug":"large","linkDestination":"none"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo $artifact_portrait; ?>" alt="<?php echo esc_attr__( 'Portrait of a professional', 'artifact' ); ?>"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
