<?php
/**
 * Title: Portfolio grid
 * Slug: artifact/portfolio-grid
 * Categories: portfolio
 * Description: Eight project cards in alternating wide and narrow rows, each with a photo, a linked title and a category.
 *
 * @package Artifact
 */

$artifact_arrow    = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-outward.svg' ) );
$artifact_projects = array(
	array(
		'photo'    => 'portfolio-code-screen.jpg',
		'alt'      => __( 'Laptop screen showing lines of code in the dark', 'artifact' ),
		'title'    => __( 'Real estate website for BuildX', 'artifact' ),
		'category' => __( 'Theme Development', 'artifact' ),
	),
	array(
		'photo'    => 'portfolio-laptop-typing.jpg',
		'alt'      => __( 'Hands typing on a laptop keyboard', 'artifact' ),
		'title'    => __( 'Seller marketplace for Velora', 'artifact' ),
		'category' => __( 'Multi-Vendor E-Commerce', 'artifact' ),
	),
	array(
		'photo'    => 'portfolio-team-desk.jpg',
		'alt'      => __( 'Team working on laptops around a shared table', 'artifact' ),
		'title'    => __( 'Team workspace for Orbitly', 'artifact' ),
		'category' => __( 'Plugin Development', 'artifact' ),
	),
	array(
		'photo'    => 'portfolio-vr-headset.jpg',
		'alt'      => __( 'Person wearing a virtual reality headset', 'artifact' ),
		'title'    => __( 'VR product launch for Lumenix', 'artifact' ),
		'category' => __( 'Headless E-Commerce', 'artifact' ),
	),
	array(
		'photo'    => 'portfolio-laptop-wood.jpg',
		'alt'      => __( 'Hands on a laptop on a wooden desk', 'artifact' ),
		'title'    => __( 'Online store for Goldmere', 'artifact' ),
		'category' => __( 'Single-Store E-Commerce', 'artifact' ),
	),
	array(
		'photo'    => 'portfolio-monitors.jpg',
		'alt'      => __( 'Developer at a desk with several monitors', 'artifact' ),
		'title'    => __( 'Operations dashboard for Zentro', 'artifact' ),
		'category' => __( 'API Integration', 'artifact' ),
	),
	array(
		'photo'    => 'portfolio-home-office.jpg',
		'alt'      => __( 'Laptop and monitor lit by a desk lamp in a home office', 'artifact' ),
		'title'    => __( 'Speed overhaul for Kyanor', 'artifact' ),
		'category' => __( 'Page Speed Optimization', 'artifact' ),
	),
	array(
		'photo'    => 'portfolio-laptop-plant.jpg',
		'alt'      => __( 'Laptop on a desk beside a potted plant', 'artifact' ),
		'title'    => __( 'Mobile shop app for Brightleaf', 'artifact' ),
		'category' => __( 'E-Commerce Mobile App', 'artifact' ),
	),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0","bottom":"80px","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:0;padding-right:var(--wp--preset--spacing--20);padding-bottom:80px;padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","className":"artifact-portfolio-grid","style":{"spacing":{"blockGap":"30px"}},"layout":{"type":"grid","columnCount":2}} -->
	<div class="wp-block-group alignwide artifact-portfolio-grid">
		<?php foreach ( $artifact_projects as $artifact_project ) : ?>
		<!-- wp:group {"className":"artifact-portfolio-card","style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
		<div class="wp-block-group artifact-portfolio-card">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"20px"}}} -->
			<figure class="wp-block-image size-full has-custom-border"><img src="<?php echo esc_url( get_parent_theme_file_uri( 'assets/images/' . $artifact_project['photo'] ) ); ?>" alt="<?php echo esc_attr( $artifact_project['alt'] ); ?>" style="border-radius:20px"/></figure>
			<!-- /wp:image -->

			<!-- wp:group {"style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
			<div class="wp-block-group">
				<!-- wp:image {"width":"32px","height":"32px","sizeSlug":"full","linkDestination":"none","className":"artifact-portfolio-arrow"} -->
				<figure class="wp-block-image size-full is-resized artifact-portfolio-arrow"><img src="<?php echo $artifact_arrow; ?>" alt="" style="width:32px;height:32px"/></figure>
				<!-- /wp:image -->

				<!-- wp:group {"style":{"spacing":{"blockGap":"4px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
				<div class="wp-block-group">
					<!-- wp:heading {"style":{"typography":{"lineHeight":"26px","fontWeight":"700"}},"fontSize":"medium-title"} -->
					<h2 class="wp-block-heading has-medium-title-font-size" style="font-weight:700;line-height:26px"><a href="#"><?php echo esc_html( $artifact_project['title'] ); ?></a></h2>
					<!-- /wp:heading -->

					<!-- wp:paragraph {"style":{"typography":{"lineHeight":"22px"}},"textColor":"text-color","fontSize":"small-paragraph"} -->
					<p class="has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:22px"><?php echo esc_html( $artifact_project['category'] ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
