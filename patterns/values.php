<?php
/**
 * Title: Values
 * Slug: artifact/values
 * Categories: about
 * Description: A heading and introduction beside four values, each with an icon, a title and a short description.
 *
 * @package Artifact
 */

$artifact_values = array(
	array(
		'icon'  => 'icon-value-expertise.svg',
		'alt'   => __( 'Route', 'artifact' ),
		'title' => __( 'Expertise', 'artifact' ),
		'copy'  => __( 'Years of building WordPress and commerce sites, so we know what works before we write any code.', 'artifact' ),
	),
	array(
		'icon'  => 'icon-value-communication.svg',
		'alt'   => __( 'Chat', 'artifact' ),
		'title' => __( 'Communication', 'artifact' ),
		'copy'  => __( 'Clear updates at every milestone and a real person to talk to whenever a question comes up.', 'artifact' ),
	),
	array(
		'icon'  => 'icon-value-reliability.svg',
		'alt'   => __( 'Thumbs up', 'artifact' ),
		'title' => __( 'Reliability', 'artifact' ),
		'copy'  => __( 'Tested, documented work delivered on the date we promised, and supported long after launch.', 'artifact' ),
	),
	array(
		'icon'  => 'icon-value-growth.svg',
		'alt'   => __( 'Rocket', 'artifact' ),
		'title' => __( 'Growth driven', 'artifact' ),
		'copy'  => __( 'Every decision is measured against one goal: more visitors, more leads and more sales for you.', 'artifact' ),
	),
);
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"0","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--20);padding-bottom:0;padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:columns {"align":"wide","className":"artifact-values","style":{"spacing":{"blockGap":{"top":"48px","left":"var:preset|spacing|100"}}}} -->
	<div class="wp-block-columns alignwide artifact-values">
		<!-- wp:column {"width":"470px","style":{"spacing":{"blockGap":"24px"}}} -->
		<div class="wp-block-column" style="flex-basis:470px">
			<!-- wp:heading {"style":{"typography":{"lineHeight":"64px"}},"fontSize":"heading-03"} -->
			<h2 class="wp-block-heading has-heading-03-font-size" style="line-height:64px"><?php echo esc_html__( 'Our values', 'artifact' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-color","fontSize":"medium-paragraph"} -->
			<p class="has-text-color-color has-text-color has-medium-paragraph-font-size" style="line-height:28px"><?php echo esc_html__( 'We are a small team of designers and developers who treat every project as a long partnership. We listen first, explain our choices in plain language and build sites your team can run on its own. Honest timelines, careful work and steady support are how we earn the trust of the businesses we work with.', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:group {"className":"artifact-values-grid","style":{"spacing":{"blockGap":"30px"}},"layout":{"type":"grid","columnCount":2,"minimumColumnWidth":"220px"}} -->
			<div class="wp-block-group artifact-values-grid">
				<?php foreach ( $artifact_values as $artifact_value ) : ?>
					<?php $artifact_icon = esc_url( get_parent_theme_file_uri( 'assets/images/' . $artifact_value['icon'] ) ); ?>
				<!-- wp:group {"style":{"spacing":{"blockGap":"22px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
				<div class="wp-block-group">
					<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"artifact-value-icon"} -->
					<figure class="wp-block-image size-full artifact-value-icon"><img src="<?php echo $artifact_icon; ?>" alt="<?php echo esc_attr( $artifact_value['alt'] ); ?>"/></figure>
					<!-- /wp:image -->

					<!-- wp:group {"style":{"spacing":{"blockGap":"12px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
					<div class="wp-block-group">
						<!-- wp:heading {"level":3,"style":{"typography":{"lineHeight":"30px"}},"fontSize":"large-title"} -->
						<h3 class="wp-block-heading has-large-title-font-size" style="line-height:30px"><?php echo esc_html( $artifact_value['title'] ); ?></h3>
						<!-- /wp:heading -->

						<!-- wp:paragraph {"style":{"typography":{"lineHeight":"22px"}},"textColor":"text-color","fontSize":"small-paragraph"} -->
						<p class="has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:22px"><?php echo esc_html( $artifact_value['copy'] ); ?></p>
						<!-- /wp:paragraph -->
					</div>
					<!-- /wp:group -->
				</div>
				<!-- /wp:group -->
				<?php endforeach; ?>
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
