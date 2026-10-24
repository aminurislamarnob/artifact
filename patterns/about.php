<?php
/**
 * Title: About
 * Slug: artifact/about
 * Categories: featured
 *
 * @package Artifact
 */

$artifact_about = esc_url( get_parent_theme_file_uri( 'assets/images/about-team.png' ) );
$artifact_arrow = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-outward.svg' ) );
$artifact_icon_alt = esc_attr__( 'Arrow', 'artifact' );
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"48px"}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"24px"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"style":{"typography":{"lineHeight":"26px"}},"textColor":"text-color","fontSize":"medium-title"} -->
		<p class="has-text-color-color has-text-color has-medium-title-font-size" style="line-height:26px"><?php echo esc_html__( 'About Us', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"style":{"typography":{"lineHeight":"64px"}},"fontSize":"heading-03"} -->
		<h2 class="wp-block-heading has-heading-03-font-size" style="line-height:64px"><?php echo esc_html__( 'We help to accelerate your business growth', 'artifact' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"left":"80px"}}}} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-center">
		<!-- wp:column {"width":"40%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:40%">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"24px"}},"className":"is-style-rounded"} -->
			<figure class="wp-block-image size-full is-style-rounded" style="border-radius:24px"><img src="<?php echo $artifact_about; ?>" alt="<?php echo esc_attr__( 'Three colleagues reviewing work on a laptop', 'artifact' ); ?>" style="border-radius:24px"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"60%","style":{"spacing":{"blockGap":"48px"}}} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:60%">
			<!-- wp:group {"style":{"spacing":{"blockGap":"20px"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
			<div class="wp-block-group">
				<!-- wp:paragraph {"style":{"typography":{"lineHeight":"36px"}},"textColor":"text-white","fontSize":"heading-06"} -->
				<p class="has-text-white-color has-text-color has-heading-06-font-size" style="line-height:36px"><?php echo esc_html__( 'We develop disruptive solutions for organisations. We’ve built a reputation for excellent clients satisfaction as evidenced by our service.', 'artifact' ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-color","fontSize":"medium-paragraph"} -->
				<p class="has-text-color-color has-text-color has-medium-paragraph-font-size" style="line-height:28px"><?php echo esc_html__( 'Seamlessly formulate exceptional “outside the box” thinking business e-commerce. Phosfluorescently engage end-to-end platforms before integrated functionalities.', 'artifact' ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","className":"is-style-rounded artifact-button-icon","fontSize":"button-large"} -->
				<div class="wp-block-button is-style-rounded artifact-button-icon"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background has-button-large-font-size has-custom-font-size wp-element-button" href="#"><?php echo esc_html__( 'More about us', 'artifact' ); ?> <img src="<?php echo $artifact_arrow; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="24" height="24"/></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
