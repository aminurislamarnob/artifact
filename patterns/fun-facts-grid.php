<?php
/**
 * Title: Fun facts grid
 * Slug: artifact/fun-facts-grid
 * Categories: about
 * Description: Five company figures in icon tiles around a team photo.
 *
 * @package Artifact
 */

$artifact_photo = esc_url( get_parent_theme_file_uri( 'assets/images/company-celebration.jpg' ) );
$artifact_facts = array(
	array(
		'icon'   => 'icon-fact-solutions.svg',
		'alt'    => __( 'Light bulb', 'artifact' ),
		'number' => __( '20', 'artifact' ),
		'label'  => __( 'Generic Solutions', 'artifact' ),
		'wide'   => true,
	),
	array(
		'icon'   => 'icon-fact-experience.svg',
		'alt'    => __( 'Calendar', 'artifact' ),
		'number' => __( '12+', 'artifact' ),
		'label'  => __( 'Years of Experience', 'artifact' ),
		'wide'   => false,
	),
	array(
		'icon'   => 'icon-fact-projects.svg',
		'alt'    => __( 'Briefcase', 'artifact' ),
		'number' => __( '1000', 'artifact' ),
		'label'  => __( 'Projects Completed', 'artifact' ),
		'wide'   => false,
	),
	array(
		'icon'   => 'icon-fact-customers.svg',
		'alt'    => __( 'Smiling face', 'artifact' ),
		'number' => __( '1M+', 'artifact' ),
		'label'  => __( 'Happy Customers', 'artifact' ),
		'wide'   => false,
	),
	'photo',
	array(
		'icon'   => 'icon-fact-countries.svg',
		'alt'    => __( 'Globe', 'artifact' ),
		'number' => __( '160+', 'artifact' ),
		'label'  => __( 'Countries', 'artifact' ),
		'wide'   => false,
	),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"80px","bottom":"80px","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:80px;padding-right:var(--wp--preset--spacing--20);padding-bottom:80px;padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","className":"artifact-fun-facts","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"grid","columnCount":4}} -->
	<div class="wp-block-group alignwide artifact-fun-facts">
		<?php foreach ( $artifact_facts as $artifact_fact ) : ?>
			<?php if ( 'photo' === $artifact_fact ) : ?>
		<!-- wp:image {"aspectRatio":"570/268","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"artifact-fact-wide artifact-fact-photo","style":{"border":{"radius":"20px"}}} -->
		<figure class="wp-block-image size-full has-custom-border artifact-fact-wide artifact-fact-photo"><img src="<?php echo $artifact_photo; ?>" alt="<?php echo esc_attr__( 'Colleagues cheering and clapping around a meeting table', 'artifact' ); ?>" style="border-radius:20px;aspect-ratio:570/268;object-fit:cover"/></figure>
		<!-- /wp:image -->
				<?php continue; ?>
			<?php endif; ?>
			<?php
			$artifact_icon  = esc_url( get_parent_theme_file_uri( 'assets/images/' . $artifact_fact['icon'] ) );
			$artifact_class = $artifact_fact['wide'] ? 'artifact-fact artifact-fact-wide' : 'artifact-fact';
			?>
		<!-- wp:group {"className":"<?php echo esc_attr( $artifact_class ); ?>","style":{"border":{"radius":"20px","width":"1px","color":"var:preset|color|border"},"spacing":{"padding":{"top":"0","bottom":"24px","left":"24px","right":"24px"},"blockGap":"0"}},"backgroundColor":"light-bg","layout":{"type":"default"}} -->
		<div class="wp-block-group <?php echo esc_attr( $artifact_class ); ?> has-border-color has-light-bg-background-color has-background" style="border-color:var(--wp--preset--color--border);border-width:1px;border-radius:20px;padding-top:0;padding-right:24px;padding-bottom:24px;padding-left:24px">
			<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"artifact-fact-icon"} -->
			<figure class="wp-block-image size-full artifact-fact-icon"><img src="<?php echo $artifact_icon; ?>" alt="<?php echo esc_attr( $artifact_fact['alt'] ); ?>"/></figure>
			<!-- /wp:image -->

			<!-- wp:paragraph {"style":{"typography":{"lineHeight":"52px","fontWeight":"700"}},"textColor":"heading-color","fontSize":"heading-04"} -->
			<p class="has-heading-color-color has-text-color has-heading-04-font-size" style="font-weight:700;line-height:52px"><?php echo esc_html( $artifact_fact['number'] ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph {"style":{"typography":{"lineHeight":"26px"}},"textColor":"text-color","fontSize":"medium-paragraph"} -->
			<p class="has-text-color-color has-text-color has-medium-paragraph-font-size" style="line-height:26px"><?php echo esc_html( $artifact_fact['label'] ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
