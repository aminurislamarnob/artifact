<?php
/**
 * Title: Work process
 * Slug: artifact/work-process
 * Categories: featured
 *
 * @package Artifact
 */

$artifact_desk        = esc_url( get_parent_theme_file_uri( 'assets/images/work-desk.jpg' ) );
$artifact_arrow       = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-outward.svg' ) );
$artifact_arrow_right = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-right.svg' ) );
$artifact_icon_alt    = esc_attr__( 'Arrow', 'artifact' );
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"48px"}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"24px"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"align":"center","textColor":"text-color","fontSize":"medium-title"} -->
		<p class="has-text-align-center has-text-color-color has-text-color has-medium-title-font-size"><?php echo esc_html__( 'Work Process', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"textAlign":"center","style":{"typography":{"lineHeight":"64px"}},"fontSize":"heading-03"} -->
		<h2 class="wp-block-heading has-text-align-center has-heading-03-font-size" style="line-height:64px"><?php echo esc_html__( 'How we work', 'artifact' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-center">
		<!-- wp:column {"width":"42%","style":{"spacing":{"blockGap":"32px"}}} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%">
			<!-- wp:accordion {"showIcon":false,"autoclose":true,"className":"artifact-work-process-accordion"} -->
			<div role="group" class="wp-block-accordion artifact-work-process-accordion">
				<!-- wp:accordion-item {"openByDefault":true} -->
				<div class="wp-block-accordion-item is-open">
					<!-- wp:accordion-heading {"showIcon":false} -->
					<h3 class="wp-block-accordion-heading"><button class="wp-block-accordion-heading__toggle" type="button"><span class="wp-block-accordion-heading__toggle-title"><?php echo esc_html__( 'Submit a proposal for your awesome project.', 'artifact' ); ?></span></button></h3>
					<!-- /wp:accordion-heading -->

					<!-- wp:accordion-panel -->
					<div class="wp-block-accordion-panel" role="region">
						<!-- wp:paragraph {"style":{"typography":{"lineHeight":"22px"}},"textColor":"text-color","fontSize":"small-paragraph"} -->
						<p class="has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:22px"><?php echo esc_html__( 'Get your thoughts to paper faster with our step-by-step AI copywriter. Get your thoughts to paper faster with our step-by-step AI copywriter.', 'artifact' ); ?></p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph {"textColor":"text-white"} -->
						<p class="has-text-white-color has-text-color"><a href="#"><?php echo esc_html__( 'Get Started', 'artifact' ); ?> <img src="<?php echo $artifact_arrow_right; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="16" height="16"/></a></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:accordion-panel -->
				</div>
				<!-- /wp:accordion-item -->

				<!-- wp:accordion-item -->
				<div class="wp-block-accordion-item">
					<!-- wp:accordion-heading {"showIcon":false} -->
					<h3 class="wp-block-accordion-heading"><button class="wp-block-accordion-heading__toggle" type="button"><span class="wp-block-accordion-heading__toggle-title"><?php echo esc_html__( 'Our expert developer team is ready to do all.', 'artifact' ); ?></span></button></h3>
					<!-- /wp:accordion-heading -->

					<!-- wp:accordion-panel -->
					<div class="wp-block-accordion-panel" role="region">
						<!-- wp:paragraph {"style":{"typography":{"lineHeight":"22px"}},"textColor":"text-color","fontSize":"small-paragraph"} -->
						<p class="has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:22px"><?php echo esc_html__( 'Get your thoughts to paper faster with our step-by-step AI copywriter. Get your thoughts to paper faster with our step-by-step AI copywriter.', 'artifact' ); ?></p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph {"textColor":"text-white"} -->
						<p class="has-text-white-color has-text-color"><a href="#"><?php echo esc_html__( 'Get Started', 'artifact' ); ?> <img src="<?php echo $artifact_arrow_right; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="16" height="16"/></a></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:accordion-panel -->
				</div>
				<!-- /wp:accordion-item -->

				<!-- wp:accordion-item -->
				<div class="wp-block-accordion-item">
					<!-- wp:accordion-heading {"showIcon":false} -->
					<h3 class="wp-block-accordion-heading"><button class="wp-block-accordion-heading__toggle" type="button"><span class="wp-block-accordion-heading__toggle-title"><?php echo esc_html__( 'Get full support from us through the project.', 'artifact' ); ?></span></button></h3>
					<!-- /wp:accordion-heading -->

					<!-- wp:accordion-panel -->
					<div class="wp-block-accordion-panel" role="region">
						<!-- wp:paragraph {"style":{"typography":{"lineHeight":"22px"}},"textColor":"text-color","fontSize":"small-paragraph"} -->
						<p class="has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:22px"><?php echo esc_html__( 'Get your thoughts to paper faster with our step-by-step AI copywriter. Get your thoughts to paper faster with our step-by-step AI copywriter.', 'artifact' ); ?></p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph {"textColor":"text-white"} -->
						<p class="has-text-white-color has-text-color"><a href="#"><?php echo esc_html__( 'Get Started', 'artifact' ); ?> <img src="<?php echo $artifact_arrow_right; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="16" height="16"/></a></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:accordion-panel -->
				</div>
				<!-- /wp:accordion-item -->
			</div>
			<!-- /wp:accordion -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","className":"artifact-button-icon","fontSize":"button-large"} -->
				<div class="wp-block-button artifact-button-icon"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background has-button-large-font-size has-custom-font-size wp-element-button" href="#"><?php echo esc_html__( 'Start A Project', 'artifact' ); ?> <img src="<?php echo $artifact_arrow; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="24" height="24"/></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"58%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:58%">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"24px"}}} -->
			<figure class="wp-block-image size-full has-custom-border"><img src="<?php echo $artifact_desk; ?>" alt="<?php echo esc_attr__( 'Laptop, notebook, and coffee on a desk', 'artifact' ); ?>" style="border-radius:24px"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
