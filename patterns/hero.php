<?php
/**
 * Title: Hero
 * Slug: artifact/hero
 * Categories: banner, featured
 * Description: Homepage dark hero with headline, supporting copy, and a call to action.
 *
 * @package Artifact
 */

$artifact_scene = esc_url( get_parent_theme_file_uri( 'assets/images/hero-scene.png' ) );
$artifact_arrow = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-outward.svg' ) );
$artifact_icon_alt = esc_attr__( 'Arrow', 'artifact' );
?>
<!-- wp:group {"align":"full","className":"artifact-hero","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull artifact-hero has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"artifact-hero__scene"} -->
	<figure class="wp-block-image size-full artifact-hero__scene"><img src="<?php echo $artifact_scene; ?>" alt="<?php echo esc_attr__( 'Product team at a workstation, with project and satisfaction highlights', 'artifact' ); ?>"/></figure>
	<!-- /wp:image -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide">
		<!-- wp:column {"width":"49%","style":{"spacing":{"blockGap":"48px"}}} -->
		<div class="wp-block-column" style="flex-basis:49%">
			<!-- wp:heading {"level":1,"style":{"typography":{"lineHeight":"100px"}},"fontSize":"heading-01"} -->
			<h1 class="wp-block-heading has-heading-01-font-size" style="line-height:100px"><?php echo wp_kses_post( __( 'Creating<br>Software &amp; Digital Excellence', 'artifact' ) ); ?></h1>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-color","fontSize":"large-paragraph"} -->
			<p class="has-text-color-color has-text-color has-large-paragraph-font-size" style="line-height:28px"><?php echo esc_html__( 'We transform businesses of most major sectors with powerful and adaptable digital solutions.', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","className":"is-style-rounded artifact-button-icon","fontSize":"button-large"} -->
				<div class="wp-block-button is-style-rounded artifact-button-icon"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background has-button-large-font-size has-custom-font-size wp-element-button" href="#"><?php echo esc_html__( 'Lets Talk With US', 'artifact' ); ?> <img src="<?php echo $artifact_arrow; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="24" height="24"/></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"51%"} -->
		<div class="wp-block-column" style="flex-basis:51%"></div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
