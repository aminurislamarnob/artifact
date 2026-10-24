<?php
/**
 * Title: Team
 * Slug: artifact/team
 * Categories: featured
 *
 * @package Artifact
 */

$artifact_arrow = esc_url( get_parent_theme_file_uri( 'assets/images/icon-arrow-outward.svg' ) );
$artifact_icon_alt = esc_attr__( 'Arrow', 'artifact' );
$artifact_names = array(
	__( 'Jacob McDany', 'artifact' ),
	__( 'Aliah Lane', 'artifact' ),
	__( 'Loki Bright', 'artifact' ),
	__( 'Rosalee Melvin', 'artifact' ),
);
$artifact_role = __( 'CEO of Rackspace', 'artifact' );
$artifact_team = array();
foreach ( array( 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h' ) as $artifact_index => $artifact_letter ) {
	$artifact_team[] = array(
		'file' => 'team-' . $artifact_letter . '.png',
		'name' => $artifact_names[ $artifact_index % 4 ],
		'role' => $artifact_role,
		'alt'  => $artifact_names[ $artifact_index % 4 ],
	);
}
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"var:preset|spacing|50"}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
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
			<!-- wp:button {"backgroundColor":"primary","textColor":"text-white","className":"artifact-button-icon"} -->
			<div class="wp-block-button artifact-button-icon"><a class="wp-block-button__link has-text-white-color has-primary-background-color has-text-color has-background wp-element-button" href="#"><?php echo esc_html__( 'View All', 'artifact' ); ?> <img src="<?php echo $artifact_arrow; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="24" height="24"/></a></div>
			<!-- /wp:button -->
		</div>
		<!-- /wp:buttons -->
	</div>
	<!-- /wp:group -->

	<?php foreach ( array_chunk( $artifact_team, 4 ) as $artifact_row ) : ?>
	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"30px","top":"30px"}}}} -->
	<div class="wp-block-columns alignwide">
		<?php foreach ( $artifact_row as $artifact_member ) : ?>
			<?php $artifact_photo = esc_url( get_parent_theme_file_uri( 'assets/images/' . $artifact_member['file'] ) ); ?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"artifact-team-card","style":{"border":{"radius":"24px"}}} -->
			<figure class="wp-block-image size-full artifact-team-card" style="border-radius:24px"><img src="<?php echo $artifact_photo; ?>" alt="<?php echo esc_attr( $artifact_member['alt'] ); ?>" style="border-radius:24px;width:100%;height:auto"/></figure>
			<!-- /wp:image -->

			<!-- wp:group {"style":{"spacing":{"blockGap":"12px","margin":{"top":"16px"}}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
			<div class="wp-block-group" style="margin-top:16px">
				<!-- wp:image {"width":"20px","height":"20px","sizeSlug":"full","linkDestination":"none"} -->
				<figure class="wp-block-image size-full is-resized" style="margin-top:4px"><img src="<?php echo $artifact_arrow; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="20" height="20"/></figure>
				<!-- /wp:image -->

				<!-- wp:group {"style":{"spacing":{"blockGap":"4px"}},"layout":{"type":"constrained","justifyContent":"left"}} -->
				<div class="wp-block-group">
					<!-- wp:heading {"level":3,"style":{"typography":{"lineHeight":"26px"}},"fontSize":"medium-title"} -->
					<h3 class="wp-block-heading has-medium-title-font-size" style="line-height:26px"><?php echo esc_html( $artifact_member['name'] ); ?></h3>
					<!-- /wp:heading -->
					<!-- wp:paragraph {"style":{"typography":{"lineHeight":"22px"}},"textColor":"text-color","fontSize":"small-paragraph"} -->
					<p class="has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:22px"><?php echo esc_html( $artifact_member['role'] ); ?></p>
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
	<?php endforeach; ?>
</div>
<!-- /wp:group -->
