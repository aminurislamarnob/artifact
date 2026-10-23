<?php
/**
 * Title: Testimonials
 * Slug: artifact/testimonials
 * Categories: featured
 *
 * @package Artifact
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:paragraph {"textColor":"text-color","fontSize":"medium-title"} -->
		<p class="has-text-color-color has-text-color has-medium-title-font-size"><?php echo esc_html__( 'Testimonial', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:heading {"fontSize":"heading-03"} -->
		<h2 class="wp-block-heading has-heading-03-font-size"><?php echo esc_html__( 'Our client stories', 'artifact' ); ?></h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"margin":{"top":"var:preset|spacing|50"}}}} -->
	<div class="wp-block-columns alignwide" style="margin-top:var(--wp--preset--spacing--50)">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:quote -->
			<blockquote class="wp-block-quote">
				<!-- wp:paragraph -->
				<p><?php echo esc_html__( 'I just wanted to share a quick note and let you know that you guys do a really good job. I’m glad I decided to work with you. It’s really great how easy your websites are to update and manage.', 'artifact' ); ?></p>
				<!-- /wp:paragraph -->
				<cite><?php echo esc_html__( 'Wade Warren, CEO, ABC Corporation', 'artifact' ); ?></cite>
			</blockquote>
			<!-- /wp:quote -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:quote -->
			<blockquote class="wp-block-quote">
				<!-- wp:paragraph -->
				<p><?php echo esc_html__( 'It’s all good. It was worth a fortune to my company. It is the most valuable business resource we have.', 'artifact' ); ?></p>
				<!-- /wp:paragraph -->
				<cite><?php echo esc_html__( 'Wade Warren, CEO, ABC Corporation', 'artifact' ); ?></cite>
			</blockquote>
			<!-- /wp:quote -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
