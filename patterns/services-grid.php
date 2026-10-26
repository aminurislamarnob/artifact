<?php
/**
 * Title: Services grid
 * Slug: artifact/services-grid
 * Categories: services
 * Description: Nine service cards with an icon, a title, a short description and a link.
 *
 * @package Artifact
 */

$artifact_arrow = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-right.svg' ) );
$artifact_learn = __( 'Learn More', 'artifact' );
/* translators: %s: service name. */
$artifact_about = __( 'about %s', 'artifact' );
$artifact_services = array(
	array(
		'icon'  => 'icon-service-single-store.svg',
		'alt'   => __( 'Storefront', 'artifact' ),
		'title' => __( 'Single-Store E-Commerce', 'artifact' ),
		'copy'  => __( 'Launches a fast, secure online store that turns visitors into loyal, returning customers.', 'artifact' ),
	),
	array(
		'icon'  => 'icon-service-multi-vendor.svg',
		'alt'   => __( 'Marketplace', 'artifact' ),
		'title' => __( 'Multi-Vendor E-Commerce', 'artifact' ),
		'copy'  => __( 'Builds marketplaces where many sellers list, sell and get paid from one shared platform.', 'artifact' ),
	),
	array(
		'icon'  => 'icon-service-api.svg',
		'alt'   => __( 'API', 'artifact' ),
		'title' => __( 'Headless E-Commerce', 'artifact' ),
		'copy'  => __( 'Pairs a flexible commerce back end with a fast, custom front end on any channel you need.', 'artifact' ),
	),
	array(
		'icon'  => 'icon-service-speed.svg',
		'alt'   => __( 'Speed', 'artifact' ),
		'title' => __( 'Page Speed Optimization', 'artifact' ),
		'copy'  => __( 'Trims load times and improves Core Web Vitals so pages feel instant on every device.', 'artifact' ),
	),
	array(
		'icon'  => 'icon-service-plugin.svg',
		'alt'   => __( 'Plugin', 'artifact' ),
		'title' => __( 'WordPress Plugin Development', 'artifact' ),
		'copy'  => __( 'Writes custom plugins that add exactly the features your site needs, built to last.', 'artifact' ),
	),
	array(
		'icon'  => 'icon-service-theme.svg',
		'alt'   => __( 'Theme', 'artifact' ),
		'title' => __( 'WordPress Theme Development', 'artifact' ),
		'copy'  => __( 'Designs and builds block themes that match your brand and are easy for your team to edit.', 'artifact' ),
	),
	array(
		'icon'  => 'icon-service-mobile-app.svg',
		'alt'   => __( 'Mobile app', 'artifact' ),
		'title' => __( 'E-Commerce Mobile App', 'artifact' ),
		'copy'  => __( 'Brings your store to iOS and Android with apps that stay in sync with your catalogue.', 'artifact' ),
	),
	array(
		'icon'  => 'icon-service-automation.svg',
		'alt'   => __( 'Automation', 'artifact' ),
		'title' => __( 'Business Process Automation', 'artifact' ),
		'copy'  => __( 'Connects your tools and automates repeat tasks so your team can focus on real work.', 'artifact' ),
	),
	array(
		'icon'  => 'icon-service-support.svg',
		'alt'   => __( 'Support', 'artifact' ),
		'title' => __( 'Support & Maintenance', 'artifact' ),
		'copy'  => __( 'Keeps your site updated, backed up, monitored and secure, with help when you need it.', 'artifact' ),
	),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:0;padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","className":"artifact-services-grid","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":3,"minimumColumnWidth":"280px"}} -->
	<div class="wp-block-group alignwide artifact-services-grid">
		<?php foreach ( $artifact_services as $artifact_service ) : ?>
			<?php $artifact_icon = esc_url( get_parent_theme_file_uri( 'assets/images/' . $artifact_service['icon'] ) ); ?>
		<!-- wp:group {"className":"artifact-service-card","style":{"border":{"radius":"20px","width":"1px","color":"var:preset|color|border"},"spacing":{"padding":{"top":"24px","bottom":"24px","left":"24px","right":"24px"},"blockGap":"48px"}},"backgroundColor":"light-bg","layout":{"type":"flex","orientation":"vertical"}} -->
		<div class="wp-block-group artifact-service-card has-border-color has-light-bg-background-color has-background" style="border-color:var(--wp--preset--color--border);border-width:1px;border-radius:20px;padding-top:24px;padding-right:24px;padding-bottom:24px;padding-left:24px">
			<!-- wp:group {"style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="wp-block-group">
				<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"artifact-service-icon"} -->
				<figure class="wp-block-image size-full artifact-service-icon"><img src="<?php echo $artifact_icon; ?>" alt="<?php echo esc_attr( $artifact_service['alt'] ); ?>"/></figure>
				<!-- /wp:image -->

				<!-- wp:heading {"level":3,"style":{"typography":{"lineHeight":"30px"}},"fontSize":"large-title"} -->
				<h3 class="wp-block-heading has-large-title-font-size" style="line-height:30px"><?php echo esc_html( $artifact_service['title'] ); ?></h3>
				<!-- /wp:heading -->
			</div>
			<!-- /wp:group -->

			<!-- wp:group {"style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="wp-block-group">
				<!-- wp:paragraph {"style":{"typography":{"lineHeight":"22px"}},"textColor":"text-color","fontSize":"small-paragraph"} -->
				<p class="has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:22px"><?php echo esc_html( $artifact_service['copy'] ); ?></p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-white","fontSize":"medium-paragraph"} -->
				<p class="has-text-white-color has-text-color has-medium-paragraph-font-size" style="line-height:28px"><a class="artifact-service-link" href="#"><?php echo esc_html( $artifact_learn ); ?><span class="screen-reader-text"> <?php echo esc_html( sprintf( $artifact_about, $artifact_service['title'] ) ); ?></span> <img src="<?php echo $artifact_arrow; ?>" alt="" width="24" height="24"/></a></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
