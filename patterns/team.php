<?php
/**
 * Title: Team
 * Slug: artifact/team
 * Categories: featured
 *
 * @package Artifact
 */

$artifact_team = array(
	array(
		'file'  => 'team-1.jpg',
		'name'  => __( 'Jacob McDany', 'artifact' ),
		'role'  => __( 'CEO of Rackspace', 'artifact' ),
		'alt'   => __( 'Portrait of Jacob McDany', 'artifact' ),
	),
	array(
		'file'  => 'team-2.jpg',
		'name'  => __( 'Aliah Lane', 'artifact' ),
		'role'  => __( 'CEO of Rackspace', 'artifact' ),
		'alt'   => __( 'Portrait of Aliah Lane', 'artifact' ),
	),
	array(
		'file'  => 'team-3.jpg',
		'name'  => __( 'Loki Bright', 'artifact' ),
		'role'  => __( 'CEO of Rackspace', 'artifact' ),
		'alt'   => __( 'Portrait of Loki Bright', 'artifact' ),
	),
	array(
		'file'  => 'team-4.jpg',
		'name'  => __( 'Rosalee Melvin', 'artifact' ),
		'role'  => __( 'CEO of Rackspace', 'artifact' ),
		'alt'   => __( 'Portrait of Rosalee Melvin', 'artifact' ),
	),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
		<div class="wp-block-group">
			<!-- wp:paragraph {"textColor":"text-color","fontSize":"medium-title"} -->
			<p class="has-text-color-color has-text-color has-medium-title-font-size"><?php echo esc_html__( 'Team Member', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"fontSize":"heading-03"} -->
			<h2 class="wp-block-heading has-heading-03-font-size"><?php echo wp_kses_post( __( 'Meet our<br>expert team', 'artifact' ) ); ?></h2>
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

	<!-- wp:columns {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide" style="margin-top:var(--wp--preset--spacing--50)">
		<?php foreach ( $artifact_team as $artifact_member ) : ?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:image {"aspectRatio":"2/3","scale":"cover","sizeSlug":"large","linkDestination":"none"} -->
			<figure class="wp-block-image size-large"><img src="<?php echo esc_url( get_parent_theme_file_uri( 'assets/images/' . $artifact_member['file'] ) ); ?>" alt="<?php echo esc_attr( $artifact_member['alt'] ); ?>" style="aspect-ratio:2/3;object-fit:cover"/></figure>
			<!-- /wp:image -->
			<!-- wp:heading {"level":3,"fontSize":"medium-title"} -->
			<h3 class="wp-block-heading has-medium-title-font-size"><?php echo esc_html( $artifact_member['name'] ); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"text-color","fontSize":"small-paragraph"} -->
			<p class="has-text-color-color has-text-color has-small-paragraph-font-size"><?php echo esc_html( $artifact_member['role'] ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
