<?php
/**
 * Title: Services
 * Slug: artifact/services
 * Categories: featured
 *
 * @package Artifact
 */

$artifact_services = array(
	__( 'Theme Development & Customization', 'artifact' ),
	__( 'Plugin Development & Customization', 'artifact' ),
	__( 'E-commerce Development', 'artifact' ),
	__( 'Custom WordPress Development', 'artifact' ),
	__( 'Custom APIs & Integration', 'artifact' ),
	__( 'Security & Performance', 'artifact' ),
);
$artifact_service_copy = __( 'Creates tailored websites to reflect your brand and engage your audience effectively.', 'artifact' );
$artifact_learn_more   = __( 'Learn More', 'artifact' );
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"textColor":"text-color","fontSize":"medium-title"} -->
		<p class="has-text-color-color has-text-color has-medium-title-font-size"><?php echo esc_html__( 'Services', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"fontSize":"heading-03"} -->
		<h2 class="wp-block-heading has-heading-03-font-size"><?php echo esc_html__( 'Top notch digital services', 'artifact' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30","top":"var:preset|spacing|30"},"margin":{"top":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide" style="margin-top:var(--wp--preset--spacing--50)">
		<?php foreach ( array_slice( $artifact_services, 0, 3 ) as $artifact_title ) : ?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"backgroundColor":"light-bg","layout":{"type":"constrained"}} -->
			<div class="wp-block-group has-light-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)">
				<!-- wp:heading {"level":3,"fontSize":"large-title"} -->
				<h3 class="wp-block-heading has-large-title-font-size"><?php echo esc_html( $artifact_title ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textColor":"text-color","fontSize":"small-paragraph"} -->
				<p class="has-text-color-color has-text-color has-small-paragraph-font-size"><?php echo esc_html( $artifact_service_copy ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph -->
				<p><a href="#"><?php echo esc_html( $artifact_learn_more ); ?></a></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30","top":"var:preset|spacing|30"},"margin":{"top":"var:preset|spacing|30"}}}} -->
	<div class="wp-block-columns alignwide" style="margin-top:var(--wp--preset--spacing--30)">
		<?php foreach ( array_slice( $artifact_services, 3, 3 ) as $artifact_title ) : ?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30","left":"var:preset|spacing|30","right":"var:preset|spacing|30"}}},"backgroundColor":"light-bg","layout":{"type":"constrained"}} -->
			<div class="wp-block-group has-light-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)">
				<!-- wp:heading {"level":3,"fontSize":"large-title"} -->
				<h3 class="wp-block-heading has-large-title-font-size"><?php echo esc_html( $artifact_title ); ?></h3>
				<!-- /wp:heading -->
				<!-- wp:paragraph {"textColor":"text-color","fontSize":"small-paragraph"} -->
				<p class="has-text-color-color has-text-color has-small-paragraph-font-size"><?php echo esc_html( $artifact_service_copy ); ?></p>
				<!-- /wp:paragraph -->
				<!-- wp:paragraph -->
				<p><a href="#"><?php echo esc_html( $artifact_learn_more ); ?></a></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","className":"is-style-rounded"} -->
		<div class="wp-block-button is-style-rounded"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background wp-element-button" href="#"><?php echo esc_html__( 'View All', 'artifact' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
