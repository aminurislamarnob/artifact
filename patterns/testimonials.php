<?php
/**
 * Title: Testimonials
 * Slug: artifact/testimonials
 * Categories: featured
 *
 * @package Artifact
 */

$artifact_star = esc_url( get_parent_theme_file_uri( 'assets/images/icon-star.svg' ) );
$artifact_icon_alt = esc_attr__( 'Star', 'artifact' );
$artifact_name = esc_html__( 'Wade Warren', 'artifact' );
$artifact_role = esc_html__( 'CEO, ABC Corporation', 'artifact' );
$artifact_stories = array(
	array(
		'photo' => 'story-wade-a.png',
		'quote' => __( 'I just wanted to share a quick note and let you know that you guys do a really good job. I’m glad I decided to work with you. It’s really great how easy your websites are to update and manage.', 'artifact' ),
		'alt'   => __( 'Portrait of Wade Warren', 'artifact' ),
	),
	array(
		'photo' => 'story-wade-b.png',
		'quote' => __( 'It’s all good. It was worth a fortune to my company. It is the most valuable business resource we have.', 'artifact' ),
		'alt'   => __( 'Portrait of Wade Warren', 'artifact' ),
	),
	array(
		'photo' => 'story-wade-a.png',
		'quote' => __( 'I just wanted to share a quick note and let you know that you guys do a really good job. I’m glad I decided to work with you. It’s really great how easy your websites are to update and manage.', 'artifact' ),
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

	<!-- wp:columns {"align":"wide"} -->
	<div class="wp-block-columns alignwide">
		<?php foreach ( $artifact_stories as $artifact_story ) : ?>
			<?php $artifact_photo = esc_url( get_parent_theme_file_uri( 'assets/images/' . $artifact_story['photo'] ) ); ?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph -->
			<p><img src="<?php echo $artifact_star; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="20" height="20"/><img src="<?php echo $artifact_star; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="20" height="20"/><img src="<?php echo $artifact_star; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="20" height="20"/><img src="<?php echo $artifact_star; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="20" height="20"/><img src="<?php echo $artifact_star; ?>" alt="<?php echo $artifact_icon_alt; ?>" width="20" height="20"/></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"textColor":"text-white","fontSize":"medium-title"} -->
			<p class="has-text-white-color has-text-color has-medium-title-font-size"><?php echo esc_html( $artifact_story['quote'] ); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:group {"style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
			<div class="wp-block-group">
				<!-- wp:image {"width":"56px","height":"56px","sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"100%"}}} -->
				<figure class="wp-block-image size-full is-resized" style="border-radius:100%"><img src="<?php echo $artifact_photo; ?>" alt="<?php echo esc_attr( $artifact_story['alt'] ); ?>" style="border-radius:100%;width:56px;height:56px;object-fit:cover"/></figure>
				<!-- /wp:image -->
				<!-- wp:group {"style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","orientation":"vertical"}} -->
				<div class="wp-block-group">
					<!-- wp:paragraph {"textColor":"text-white","fontSize":"medium-paragraph"} -->
					<p class="has-text-white-color has-text-color has-medium-paragraph-font-size"><?php echo $artifact_name; ?></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"textColor":"text-color","fontSize":"small-paragraph"} -->
					<p class="has-text-color-color has-text-color has-small-paragraph-font-size"><?php echo $artifact_role; ?></p>
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
</div>
<!-- /wp:group -->
