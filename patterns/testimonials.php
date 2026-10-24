<?php
/**
 * Title: Testimonials
 * Slug: artifact/testimonials
 * Categories: featured
 *
 * @package Artifact
 */

$artifact_stars = esc_url( get_parent_theme_file_uri( 'assets/images/stars-rating.svg' ) );
$artifact_icon_alt = esc_attr__( '5 stars', 'artifact' );
$artifact_name = esc_html__( 'Wade Warren', 'artifact' );
$artifact_role = esc_html__( 'CEO, ABC Corporation', 'artifact' );
$artifact_stories = array(
	array(
		'photo' => 'story-wade-a.png',
		'quote' => __( '“I just wanted to share a quick note and let you know that you guys do a really good job. I’m glad I decided to work with you. It’s really great how easy your websites are to update and manage.”', 'artifact' ),
		'alt'   => __( 'Portrait of Wade Warren', 'artifact' ),
	),
	array(
		'photo' => 'story-wade-b.png',
		'quote' => __( '“It’s all good. It was worth a fortune to my company. It is the most valuable business resource we have.”', 'artifact' ),
		'alt'   => __( 'Portrait of Wade Warren', 'artifact' ),
	),
	array(
		'photo' => 'story-wade-c.png',
		'quote' => __( '“I just wanted to share a quick note and let you know that you guys do a really good job. I’m glad I decided to work with you. It’s really great how easy your websites are to update and manage.”', 'artifact' ),
		'alt'   => __( 'Portrait of Wade Warren', 'artifact' ),
	),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"},"blockGap":"48px"}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"24px"}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"align":"center","textColor":"text-color","fontSize":"medium-title"} -->
		<p class="has-text-align-center has-text-color-color has-text-color has-medium-title-font-size"><?php echo esc_html__( 'Testimonial', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"textAlign":"center","style":{"typography":{"lineHeight":"64px"}},"fontSize":"heading-03"} -->
		<h2 class="wp-block-heading has-text-align-center has-heading-03-font-size" style="line-height:64px"><?php echo esc_html__( 'Our client stories', 'artifact' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"30px","top":"30px"}}}} -->
	<div class="wp-block-columns alignwide">
		<?php foreach ( $artifact_stories as $artifact_story ) : ?>
			<?php $artifact_photo = esc_url( get_parent_theme_file_uri( 'assets/images/' . $artifact_story['photo'] ) ); ?>
		<!-- wp:column {"style":{"spacing":{"blockGap":"32px"}}} -->
		<div class="wp-block-column">
			<!-- wp:image {"width":"164px","height":"32px","sizeSlug":"full","linkDestination":"none"} -->
			<figure class="wp-block-image size-full is-resized"><img src="<?php echo $artifact_stars; ?>" alt="<?php echo $artifact_icon_alt; ?>" style="width:164px;height:32px"/></figure>
			<!-- /wp:image -->

			<!-- wp:paragraph {"style":{"typography":{"lineHeight":"26px"}},"textColor":"text-white","fontSize":"medium-title"} -->
			<p class="has-text-white-color has-text-color has-medium-title-font-size" style="line-height:26px"><?php echo esc_html( $artifact_story['quote'] ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:group {"style":{"spacing":{"blockGap":"16px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
			<div class="wp-block-group">
				<!-- wp:image {"width":"60px","height":"60px","sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"100%"}}} -->
				<figure class="wp-block-image size-full is-resized has-custom-border"><img src="<?php echo $artifact_photo; ?>" alt="<?php echo esc_attr( $artifact_story['alt'] ); ?>" style="border-radius:100%;width:60px;height:60px"/></figure>
				<!-- /wp:image -->
				<!-- wp:group {"style":{"spacing":{"blockGap":"4px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
				<div class="wp-block-group">
					<!-- wp:heading {"level":3,"style":{"typography":{"lineHeight":"26px"}},"textColor":"text-white","fontSize":"medium-title"} -->
					<h3 class="wp-block-heading has-text-white-color has-text-color has-medium-title-font-size" style="line-height:26px"><?php echo $artifact_name; ?></h3>
					<!-- /wp:heading -->
					<!-- wp:paragraph {"textColor":"text-color","fontSize":"medium-paragraph"} -->
					<p class="has-text-color-color has-text-color has-medium-paragraph-font-size"><?php echo $artifact_role; ?></p>
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

	<!-- wp:group {"align":"wide","className":"artifact-pagination-dots","layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-group alignwide artifact-pagination-dots">
		<!-- wp:html -->
		<span class="artifact-dot is-active" aria-hidden="true"></span>
		<span class="artifact-dot" aria-hidden="true"></span>
		<span class="artifact-dot" aria-hidden="true"></span>
		<!-- /wp:html -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
