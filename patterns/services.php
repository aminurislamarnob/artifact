<?php
/**
 * Title: Services
 * Slug: artifact/services
 * Categories: services, featured
 *
 * @package Artifact
 */

$artifact_arrow = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-right.svg' ) );
$artifact_arrow_out = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-outward.svg' ) );
$artifact_icon_alt = esc_attr__( 'Arrow', 'artifact' );
$artifact_copy = __( 'Creates tailored websites to reflect your brand and engage your audience effectively.', 'artifact' );
$artifact_learn = __( 'Learn More', 'artifact' );
/* translators: %s: service name. */
$artifact_about = __( 'about %s', 'artifact' );
$artifact_services = array(
	array(
		'icon'  => 'icon-service-theme.svg',
		'title' => __( 'Theme Development & Customization', 'artifact' ),
		'alt'   => __( 'Theme development', 'artifact' ),
	),
	array(
		'icon'  => 'icon-service-plugin.svg',
		'title' => __( 'Plugin Development & Customization', 'artifact' ),
		'alt'   => __( 'Plugin development', 'artifact' ),
	),
	array(
		'icon'  => 'icon-service-commerce.svg',
		'title' => __( 'E-commerce Development', 'artifact' ),
		'alt'   => __( 'E-commerce', 'artifact' ),
	),
	array(
		'icon'  => 'icon-service-wordpress.svg',
		'title' => __( 'Custom WordPress Development', 'artifact' ),
		'alt'   => __( 'WordPress', 'artifact' ),
	),
	array(
		'icon'  => 'icon-service-api.svg',
		'title' => __( 'Custom APIS & Integration', 'artifact' ),
		'alt'   => __( 'APIs', 'artifact' ),
	),
	array(
		'icon'  => 'icon-service-security.svg',
		'title' => __( 'Website Security & Performance', 'artifact' ),
		'alt'   => __( 'Security', 'artifact' ),
	),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"40px"}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"24px"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"align":"center","style":{"typography":{"lineHeight":"26px"}},"textColor":"text-color","fontSize":"medium-title"} -->
		<p class="has-text-align-center has-text-color-color has-text-color has-medium-title-font-size" style="line-height:26px"><?php echo esc_html__( 'Services', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"textAlign":"center","style":{"typography":{"lineHeight":"64px"}},"fontSize":"heading-03"} -->
		<h2 class="wp-block-heading has-text-align-center has-heading-03-font-size" style="line-height:64px"><?php echo esc_html__( 'Top notch digital services', 'artifact' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"30px","top":"30px"}}}} -->
	<div class="wp-block-columns alignwide">
		<?php foreach ( array_slice( $artifact_services, 0, 3 ) as $artifact_service ) : ?>
			<?php $artifact_icon = esc_url( get_parent_theme_file_uri( 'assets/images/' . $artifact_service['icon'] ) ); ?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"style":{"border":{"radius":"20px","width":"1px","color":"var:preset|color|border"},"spacing":{"padding":{"top":"24px","bottom":"24px","left":"24px","right":"24px"},"blockGap":"48px"}},"backgroundColor":"light-bg","layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="wp-block-group has-border-color has-light-bg-background-color has-background" style="border-color:var(--wp--preset--color--border);border-width:1px;border-radius:20px;padding-top:24px;padding-right:24px;padding-bottom:24px;padding-left:24px">
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
					<p class="has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:22px"><?php echo esc_html( $artifact_copy ); ?></p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-white","fontSize":"medium-paragraph"} -->
					<p class="has-text-white-color has-text-color has-medium-paragraph-font-size" style="line-height:28px"><a class="artifact-service-link" href="#"><?php echo esc_html( $artifact_learn ); ?><span class="screen-reader-text"> <?php echo esc_html( sprintf( $artifact_about, $artifact_service['title'] ) ); ?></span> <img src="<?php echo $artifact_arrow; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="24" height="24"/></a></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"30px","top":"30px"}}}} -->
	<div class="wp-block-columns alignwide">
		<?php foreach ( array_slice( $artifact_services, 3 ) as $artifact_service ) : ?>
			<?php $artifact_icon = esc_url( get_parent_theme_file_uri( 'assets/images/' . $artifact_service['icon'] ) ); ?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"style":{"border":{"radius":"20px","width":"1px","color":"var:preset|color|border"},"spacing":{"padding":{"top":"24px","bottom":"24px","left":"24px","right":"24px"},"blockGap":"48px"}},"backgroundColor":"light-bg","layout":{"type":"flex","orientation":"vertical"}} -->
			<div class="wp-block-group has-border-color has-light-bg-background-color has-background" style="border-color:var(--wp--preset--color--border);border-width:1px;border-radius:20px;padding-top:24px;padding-right:24px;padding-bottom:24px;padding-left:24px">
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
					<p class="has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:22px"><?php echo esc_html( $artifact_copy ); ?></p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-white","fontSize":"medium-paragraph"} -->
					<p class="has-text-white-color has-text-color has-medium-paragraph-font-size" style="line-height:28px"><a class="artifact-service-link" href="#"><?php echo esc_html( $artifact_learn ); ?><span class="screen-reader-text"> <?php echo esc_html( sprintf( $artifact_about, $artifact_service['title'] ) ); ?></span> <img src="<?php echo $artifact_arrow; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="24" height="24"/></a></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->

	<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"light-bg","textColor":"text-white","className":"artifact-button-icon","style":{"border":{"width":"1px","color":"var:preset|color|border"}},"fontSize":"button-large"} -->
		<div class="wp-block-button artifact-button-icon"><a class="wp-block-button__link has-text-white-color has-light-bg-background-color has-text-color has-background has-border-color has-button-large-font-size has-custom-font-size wp-element-button" href="#" style="border-color:var(--wp--preset--color--border);border-width:1px"><?php echo esc_html__( 'View All', 'artifact' ); ?> <img src="<?php echo $artifact_arrow_out; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="24" height="24"/></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
