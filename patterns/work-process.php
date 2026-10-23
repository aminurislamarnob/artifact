<?php
/**
 * Title: Work process
 * Slug: artifact/work-process
 * Categories: featured
 *
 * @package Artifact
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"textColor":"text-color","fontSize":"medium-title"} -->
		<p class="has-text-color-color has-text-color has-medium-title-font-size"><?php echo esc_html__( 'Work Process', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"fontSize":"heading-03"} -->
		<h2 class="wp-block-heading has-heading-03-font-size"><?php echo esc_html__( 'How we work', 'artifact' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide" style="margin-top:var(--wp--preset--spacing--50)">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"textColor":"primary","fontSize":"medium-title"} -->
			<p class="has-primary-color has-text-color has-medium-title-font-size">1</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"fontSize":"medium-title"} -->
			<h3 class="wp-block-heading has-medium-title-font-size"><?php echo esc_html__( 'Submit a proposal for your awesome project.', 'artifact' ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"text-color","fontSize":"small-paragraph"} -->
			<p class="has-text-color-color has-text-color has-small-paragraph-font-size"><?php echo esc_html__( 'Get your thoughts to paper faster with our step-by-step process.', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p><a href="#"><?php echo esc_html__( 'Get Started', 'artifact' ); ?></a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"textColor":"primary","fontSize":"medium-title"} -->
			<p class="has-primary-color has-text-color has-medium-title-font-size">2</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"fontSize":"medium-title"} -->
			<h3 class="wp-block-heading has-medium-title-font-size"><?php echo esc_html__( 'Our expert developer team is ready to do all.', 'artifact' ); ?></h3>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph {"textColor":"primary","fontSize":"medium-title"} -->
			<p class="has-primary-color has-text-color has-medium-title-font-size">3</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"fontSize":"medium-title"} -->
			<h3 class="wp-block-heading has-medium-title-font-size"><?php echo esc_html__( 'Get full support from us through the project.', 'artifact' ); ?></h3>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","className":"is-style-rounded"} -->
		<div class="wp-block-button is-style-rounded"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background wp-element-button" href="#"><?php echo esc_html__( 'Start A Project', 'artifact' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
