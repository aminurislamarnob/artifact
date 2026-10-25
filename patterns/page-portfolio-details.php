<?php
/**
 * Title: Portfolio details page
 * Slug: artifact/page-portfolio-details
 * Categories: portfolio, featured
 * Keywords: starter, portfolio, project, case study
 * Block Types: core/post-content
 * Post Types: page
 * Viewport width: 1400
 * Description: Body of a single project page: the page title with an introduction and project facts, photos, the brief, challenges and solutions, process and results. Use it with the Portfolio Details template.
 *
 * @package Artifact
 */

$artifact_photo_wide  = esc_url( get_parent_theme_file_uri( 'assets/images/portfolio-team-desk.jpg' ) );
$artifact_photo_left  = esc_url( get_parent_theme_file_uri( 'assets/images/portfolio-monitors.jpg' ) );
$artifact_photo_right = esc_url( get_parent_theme_file_uri( 'assets/images/portfolio-code-screen.jpg' ) );
$artifact_facts       = array(
	array(
		'label' => __( 'Category', 'artifact' ),
		'value' => __( 'Theme Development', 'artifact' ),
	),
	array(
		'label' => __( 'Client', 'artifact' ),
		'value' => __( 'BuildX', 'artifact' ),
	),
	array(
		'label' => __( 'Date', 'artifact' ),
		'value' => __( 'August 27, 2024', 'artifact' ),
	),
	array(
		'label' => __( 'Location', 'artifact' ),
		'value' => __( 'New York, USA', 'artifact' ),
	),
);
$artifact_columns     = array(
	array(
		'title' => __( 'Challenges', 'artifact' ),
		'items' => array(
			__( 'Hundreds of listings were updated by hand in an old theme that only one developer could change.', 'artifact' ),
			__( 'Listing pages took more than six seconds to load on a phone, and visitors left before the photos appeared.', 'artifact' ),
			__( 'Agents had no simple way to feature new homes or collect viewing requests from the site.', 'artifact' ),
		),
	),
	array(
		'title' => __( 'Solutions', 'artifact' ),
		'items' => array(
			__( 'A block theme with listing, neighbourhood and agent patterns that the office team edits in the Site Editor.', 'artifact' ),
			__( 'Responsive images, lazy loading and a lean stylesheet that bring listing pages under two seconds.', 'artifact' ),
			__( 'Featured home sections and a viewing request form on every listing, sent straight to the right agent.', 'artifact' ),
		),
	),
);
$artifact_sections    = array(
	array(
		'title' => __( 'Our process', 'artifact' ),
		'items' => array(
			__( 'Two workshops with the BuildX sales and marketing teams to map how buyers search, compare and get in touch, and which pages matter most to them.', 'artifact' ),
			__( 'A design system in theme.json built from the BuildX brand, followed by templates and patterns tested with real listings on a private staging site.', 'artifact' ),
			__( 'Training for the office team, a content migration of every listing, and a launch with our developers on hand for the first busy week.', 'artifact' ),
		),
	),
	array(
		'title' => __( 'Result driven', 'artifact' ),
		'items' => array(
			__( 'Listing pages load in under two seconds on a phone, and visitors now view twice as many homes per visit.', 'artifact' ),
			__( 'Viewing requests through the website grew by 40 percent in the first three months after launch.', 'artifact' ),
			__( 'The office team publishes new listings in minutes, without waiting for a developer.', 'artifact' ),
		),
	),
);
?>
<!-- wp:group {"align":"wide","className":"artifact-portfolio-details","style":{"spacing":{"padding":{"top":"80px","bottom":"80px"},"blockGap":"40px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide artifact-portfolio-details" style="padding-top:80px;padding-bottom:80px">
	<!-- wp:columns {"verticalAlignment":"center","className":"artifact-project-hero","style":{"spacing":{"padding":{"bottom":"40px"},"blockGap":{"top":"40px","left":"130px"}}}} -->
	<div class="wp-block-columns are-vertically-aligned-center artifact-project-hero" style="padding-bottom:40px">
		<!-- wp:column {"verticalAlignment":"center","width":"570px","style":{"spacing":{"blockGap":"24px"}}} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:570px">
			<!-- wp:post-title {"level":1,"style":{"typography":{"lineHeight":"64px"}},"fontSize":"heading-03"} /-->

			<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-color","fontSize":"medium-paragraph"} -->
			<p class="has-text-color-color has-text-color has-medium-paragraph-font-size" style="line-height:28px"><?php echo esc_html__( 'A fast, easy-to-edit block theme that helps BuildX show every home at its best and turn visitors into viewing requests.', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"443px"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:443px">
			<!-- wp:group {"className":"artifact-project-facts","style":{"spacing":{"blockGap":"54px"}},"layout":{"type":"grid","columnCount":2}} -->
			<div class="wp-block-group artifact-project-facts">
				<?php foreach ( $artifact_facts as $artifact_fact ) : ?>
				<!-- wp:group {"style":{"spacing":{"blockGap":"4px"}},"layout":{"type":"flex","orientation":"vertical"}} -->
				<div class="wp-block-group">
					<!-- wp:paragraph {"style":{"typography":{"lineHeight":"22px"}},"textColor":"text-color","fontSize":"small-paragraph"} -->
					<p class="has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:22px"><?php echo esc_html( $artifact_fact['label'] ); ?></p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"style":{"typography":{"lineHeight":"20px","fontWeight":"600"}},"textColor":"text-white","fontSize":"medium-paragraph"} -->
					<p class="has-text-white-color has-text-color has-medium-paragraph-font-size" style="font-weight:600;line-height:20px"><?php echo esc_html( $artifact_fact['value'] ); ?></p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
				<?php endforeach; ?>
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:image {"width":"100%","aspectRatio":"1170/447","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"20px"}}} -->
	<figure class="wp-block-image size-full is-resized has-custom-border"><img src="<?php echo $artifact_photo_wide; ?>" alt="<?php echo esc_attr__( 'Team working on laptops around a shared table', 'artifact' ); ?>" style="border-radius:20px;aspect-ratio:1170/447;object-fit:cover;width:100%"/></figure>
	<!-- /wp:image -->

	<!-- wp:group {"style":{"spacing":{"blockGap":"24px"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"style":{"typography":{"lineHeight":"42px"}},"fontSize":"heading-06"} -->
		<h2 class="wp-block-heading has-heading-06-font-size" style="line-height:42px"><?php echo esc_html__( 'About project', 'artifact' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-color","fontSize":"small-paragraph"} -->
		<p class="has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:28px"><?php echo esc_html__( 'BuildX is a New York real estate agency with more than three hundred homes for sale and rent at any time. Their old website was slow, hard to update and gave buyers no easy way to book a viewing. They asked us for a new site that shows every listing at its best, loads quickly on a phone and lets their office team add homes, neighbourhood guides and news without calling a developer. We designed and built a custom block theme, moved every listing across, and trained the team to run the site on their own.', 'artifact' ); ?></p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"40px","left":"var:preset|spacing|30"}}}} -->
	<div class="wp-block-columns">
		<?php foreach ( $artifact_columns as $artifact_column ) : ?>
		<!-- wp:column {"style":{"spacing":{"blockGap":"24px"}}} -->
		<div class="wp-block-column">
			<!-- wp:heading {"style":{"typography":{"lineHeight":"42px"}},"fontSize":"heading-06"} -->
			<h2 class="wp-block-heading has-heading-06-font-size" style="line-height:42px"><?php echo esc_html( $artifact_column['title'] ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:list {"className":"artifact-service-list","style":{"typography":{"lineHeight":"28px"}},"textColor":"text-color","fontSize":"small-paragraph"} -->
			<ul class="wp-block-list artifact-service-list has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:28px">
				<?php foreach ( $artifact_column['items'] as $artifact_item ) : ?>
				<!-- wp:list-item -->
				<li><?php echo esc_html( $artifact_item ); ?></li>
				<!-- /wp:list-item -->
				<?php endforeach; ?>
			</ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->

	<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|30"}}}} -->
	<div class="wp-block-columns">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:image {"width":"100%","aspectRatio":"5/3","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"20px"}}} -->
			<figure class="wp-block-image size-full is-resized has-custom-border"><img src="<?php echo $artifact_photo_left; ?>" alt="<?php echo esc_attr__( 'Developer at a desk with several monitors', 'artifact' ); ?>" style="border-radius:20px;aspect-ratio:5/3;object-fit:cover;width:100%"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:image {"width":"100%","aspectRatio":"5/3","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"20px"}}} -->
			<figure class="wp-block-image size-full is-resized has-custom-border"><img src="<?php echo $artifact_photo_right; ?>" alt="<?php echo esc_attr__( 'Laptop screen showing lines of code in the dark', 'artifact' ); ?>" style="border-radius:20px;aspect-ratio:5/3;object-fit:cover;width:100%"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<?php foreach ( $artifact_sections as $artifact_section ) : ?>
	<!-- wp:group {"style":{"spacing":{"blockGap":"24px"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"style":{"typography":{"lineHeight":"42px"}},"fontSize":"heading-06"} -->
		<h2 class="wp-block-heading has-heading-06-font-size" style="line-height:42px"><?php echo esc_html( $artifact_section['title'] ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:list {"className":"artifact-service-list","style":{"typography":{"lineHeight":"28px"}},"textColor":"text-color","fontSize":"small-paragraph"} -->
		<ul class="wp-block-list artifact-service-list has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:28px">
			<?php foreach ( $artifact_section['items'] as $artifact_item ) : ?>
			<!-- wp:list-item -->
			<li><?php echo esc_html( $artifact_item ); ?></li>
			<!-- /wp:list-item -->
			<?php endforeach; ?>
		</ul>
		<!-- /wp:list -->
	</div>
	<!-- /wp:group -->
	<?php endforeach; ?>
</div>
<!-- /wp:group -->
