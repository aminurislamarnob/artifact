<?php
/**
 * Title: Features
 * Slug: artifact/features
 * Categories: featured
 *
 * @package Artifact
 */

$artifact_features = array(
	array(
		'icon'  => 'icon-feature-care.svg',
		'label' => __( 'Developed With Highest Care. Always updated.', 'artifact' ),
		'alt'   => __( 'Paper plane', 'artifact' ),
	),
	array(
		'icon'  => 'icon-feature-team.svg',
		'label' => __( 'Our Expert & Dedicated Team Members.', 'artifact' ),
		'alt'   => __( 'Team', 'artifact' ),
	),
	array(
		'icon'  => 'icon-feature-support.svg',
		'label' => __( '24/7 Customer Support for Client Satisfaction.', 'artifact' ),
		'alt'   => __( 'Support', 'artifact' ),
	),
);
?>
<!-- wp:group {"align":"full","style":{"border":{"top":{"color":"var:preset|color|border","style":"solid","width":"1px"},"bottom":{"color":"var:preset|color|border","style":"solid","width":"1px"}},"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"light-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-light-bg-background-color has-background" style="border-top-color:var(--wp--preset--color--border);border-top-style:solid;border-top-width:1px;border-bottom-color:var(--wp--preset--color--border);border-bottom-style:solid;border-bottom-width:1px;padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:columns {"verticalAlignment":"center","align":"wide"} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-center">
		<?php foreach ( $artifact_features as $artifact_feature ) : ?>
			<?php $artifact_icon = esc_url( get_parent_theme_file_uri( 'assets/images/' . $artifact_feature['icon'] ) ); ?>
		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:group {"style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
			<div class="wp-block-group">
				<!-- wp:image {"width":"60px","height":"60px","sizeSlug":"full","linkDestination":"none"} -->
				<figure class="wp-block-image size-full is-resized"><img src="<?php echo $artifact_icon; ?>" alt="<?php echo esc_attr( $artifact_feature['alt'] ); ?>" style="width:60px;height:60px"/></figure>
				<!-- /wp:image -->

				<!-- wp:paragraph {"style":{"typography":{"lineHeight":"26px","fontWeight":"500"}},"textColor":"text-white","fontSize":"small-title"} -->
				<p class="has-text-white-color has-text-color has-small-title-font-size" style="font-weight:500;line-height:26px"><?php echo esc_html( $artifact_feature['label'] ); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
