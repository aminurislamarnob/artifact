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
$artifact_stories = array(
	array(
		'photo' => 'story-wade-a.jpg',
		'name'  => __( 'Wade Warren', 'artifact' ),
		'role'  => __( 'CEO, ABC Corporation', 'artifact' ),
		'quote' => __( '“I just wanted to share a quick note and let you know that you guys do a really good job. I’m glad I decided to work with you. It’s really great how easy your websites are to update and manage.”', 'artifact' ),
		'alt'   => __( 'Portrait of Wade Warren', 'artifact' ),
	),
	array(
		'photo' => 'team-b.jpg',
		'name'  => __( 'Esther Howard', 'artifact' ),
		'role'  => __( 'VP of Marketing, TechFlow', 'artifact' ),
		'quote' => __( '“It’s all good. It was worth a fortune to my company. It is the most valuable business resource we have ever invested in. The turnaround time was incredible.”', 'artifact' ),
		'alt'   => __( 'Portrait of Esther Howard', 'artifact' ),
	),
	array(
		'photo' => 'story-wade-b.jpg',
		'name'  => __( 'Cameron Williamson', 'artifact' ),
		'role'  => __( 'Founder, StudioDesign', 'artifact' ),
		'quote' => __( '“Artifact exceeded our expectations on every single front. Their engineering standard, attention to typography, and performance is world-class. Our core web vitals went from red to straight 100s across mobile and desktop. I cannot recommend them highly enough.”', 'artifact' ),
		'alt'   => __( 'Portrait of Cameron Williamson', 'artifact' ),
	),
	array(
		'photo' => 'team-d.jpg',
		'name'  => __( 'Jenny Wilson', 'artifact' ),
		'role'  => __( 'Head of Product, Apex Global', 'artifact' ),
		'quote' => __( '“The seamless integration and responsive design delivered exactly what we needed to scale our enterprise platform effortlessly.”', 'artifact' ),
		'alt'   => __( 'Portrait of Jenny Wilson', 'artifact' ),
	),
	array(
		'photo' => 'story-wade-c.jpg',
		'name'  => __( 'Robert Fox', 'artifact' ),
		'role'  => __( 'CTO, CloudSphere', 'artifact' ),
		'quote' => __( '“Working with Artifact felt like having an elite engineering team in-house. They understood complex requirements immediately and executed with flawless precision. Truly exceptional work from start to finish.”', 'artifact' ),
		'alt'   => __( 'Portrait of Robert Fox', 'artifact' ),
	),
	array(
		'photo' => 'team-f.jpg',
		'name'  => __( 'Leslie Alexander', 'artifact' ),
		'role'  => __( 'Managing Director, Horizon Media', 'artifact' ),
		'quote' => __( '“Outstanding quality, clear communication, and impeccable design sense. They turned our ambitious vision into reality faster than we thought possible.”', 'artifact' ),
		'alt'   => __( 'Portrait of Leslie Alexander', 'artifact' ),
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

	<!-- wp:group {"align":"wide","className":"artifact-testimonials-masonry","layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide artifact-testimonials-masonry">
		<?php foreach ( $artifact_stories as $artifact_story ) : ?>
			<?php $artifact_photo = esc_url( get_parent_theme_file_uri( 'assets/images/' . $artifact_story['photo'] ) ); ?>
		<!-- wp:group {"className":"artifact-testimonial-card","style":{"border":{"radius":"20px","width":"1px","color":"var:preset|color|border"},"spacing":{"padding":{"top":"32px","bottom":"32px","left":"28px","right":"28px"},"blockGap":"24px"}},"backgroundColor":"light-bg","layout":{"type":"flex","orientation":"vertical"}} -->
		<div class="wp-block-group artifact-testimonial-card has-border-color has-light-bg-background-color has-background" style="border-color:var(--wp--preset--color--border);border-width:1px;border-radius:20px;padding-top:32px;padding-right:28px;padding-bottom:32px;padding-left:28px">
			<!-- wp:image {"width":"164px","height":"32px","sizeSlug":"full","linkDestination":"none"} -->
			<figure class="wp-block-image size-full is-resized"><img src="<?php echo $artifact_stars; ?>" alt="<?php echo $artifact_icon_alt; ?>" style="width:164px;height:32px"/></figure>
			<!-- /wp:image -->

			<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-white","fontSize":"medium-paragraph"} -->
			<p class="has-text-white-color has-text-color has-medium-paragraph-font-size" style="line-height:28px"><?php echo esc_html( $artifact_story['quote'] ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:group {"style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
			<div class="wp-block-group">
				<!-- wp:image {"width":"60px","height":"60px","sizeSlug":"full","linkDestination":"none","className":"artifact-testimonial-avatar"} -->
				<figure class="wp-block-image size-full is-resized artifact-testimonial-avatar"><img src="<?php echo $artifact_photo; ?>" alt="<?php echo esc_attr( $artifact_story['alt'] ); ?>" style="width:60px;height:60px"/></figure>
				<!-- /wp:image -->
				<!-- wp:group {"style":{"spacing":{"blockGap":"4px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
				<div class="wp-block-group">
					<!-- wp:heading {"level":3,"style":{"typography":{"lineHeight":"26px"}},"textColor":"text-white","fontSize":"medium-title"} -->
					<h3 class="wp-block-heading has-text-white-color has-text-color has-medium-title-font-size" style="line-height:26px"><?php echo esc_html( $artifact_story['name'] ); ?></h3>
					<!-- /wp:heading -->
					<!-- wp:paragraph {"className":"artifact-testimonial-role","textColor":"text-color","fontSize":"small-paragraph"} -->
					<p class="artifact-testimonial-role has-text-color-color has-text-color has-small-paragraph-font-size"><?php echo esc_html( $artifact_story['role'] ); ?></p>
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
