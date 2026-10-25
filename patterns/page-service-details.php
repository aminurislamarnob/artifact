<?php
/**
 * Title: Service details page
 * Slug: artifact/page-service-details
 * Categories: services, featured
 * Keywords: starter, service, details
 * Block Types: core/post-content
 * Post Types: page
 * Viewport width: 1400
 * Description: Body of a single service page: introduction, photos, approach, features, problems solved, deliverables and next steps. Use it with the Service Details template, which adds the page title.
 *
 * @package Artifact
 */

$artifact_photo_code    = esc_url( get_parent_theme_file_uri( 'assets/images/service-laptop-code.jpg' ) );
$artifact_photo_desk    = esc_url( get_parent_theme_file_uri( 'assets/images/service-laptop-desk.jpg' ) );
$artifact_photo_monitor = esc_url( get_parent_theme_file_uri( 'assets/images/service-monitor-desk.jpg' ) );
$artifact_features      = array(
	__( 'Custom block themes built from your design, with full Site Editor support.', 'artifact' ),
	__( 'Reusable patterns for the sections your team builds most often.', 'artifact' ),
	__( 'Global styles for colours, fonts and spacing that anyone can edit without code.', 'artifact' ),
	__( 'Accessible, responsive templates tested on real devices.', 'artifact' ),
);
$artifact_problems      = array(
	__( 'A theme that only a developer can change.', 'artifact' ),
	__( 'Pages that look different every time someone edits them.', 'artifact' ),
	__( 'Slow, heavy themes that hurt search rankings and sales.', 'artifact' ),
	__( 'Outdated code that breaks with each WordPress update.', 'artifact' ),
);
$artifact_deliverables  = array(
	__( 'A production-ready block theme with every template, template part and pattern your site needs, built to WordPress.org coding standards, tested on current browsers and devices, and ready to install on your live site.', 'artifact' ),
	__( 'A design system in theme.json that turns your brand guidelines into colours, fonts, spacing and block styles, so every new page your team builds looks consistent without anyone touching code.', 'artifact' ),
	__( 'Clear documentation and a recorded training session that show the people who edit your site how to create pages, reuse patterns and change global styles with confidence from day one.', 'artifact' ),
	__( 'Thirty days of fixes and adjustments after launch, so anything that comes up once real visitors and real content arrive is handled quickly and at no extra cost to you.', 'artifact' ),
);
$artifact_steps         = array(
	__( 'Tell us about your site, your audience and what is holding it back today, whether that is slow pages, a theme that is hard to edit or a design that no longer fits your brand.', 'artifact' ),
	__( 'Within a week you get a scoped plan with clear milestones, a realistic timeline and a fixed quote, so you know exactly what you are paying for before any work begins.', 'artifact' ),
	__( 'Follow progress on a private staging site while we build, share feedback at each milestone, and see your real content in the new theme long before launch day.', 'artifact' ),
	__( 'Launch with our team on hand, then keep improving the site with one of our support plans for updates, new patterns, performance checks and help whenever you need it.', 'artifact' ),
);
$artifact_sections      = array(
	array(
		'title' => __( 'What we deliver', 'artifact' ),
		'items' => $artifact_deliverables,
	),
	array(
		'title' => __( 'How you can start', 'artifact' ),
		'items' => $artifact_steps,
	),
);
$artifact_columns       = array(
	array(
		'title' => __( 'Service features', 'artifact' ),
		'items' => $artifact_features,
	),
	array(
		'title' => __( 'Problems we solve', 'artifact' ),
		'items' => $artifact_problems,
	),
);
?>
<!-- wp:group {"align":"wide","className":"artifact-service-details","style":{"spacing":{"padding":{"bottom":"80px"},"blockGap":"40px"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignwide artifact-service-details" style="padding-bottom:80px">
	<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-color","fontSize":"small-paragraph"} -->
	<p class="has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:28px"><?php echo esc_html__( 'We design and build WordPress block themes that look like your brand, load fast and stay easy for your team to edit. Whether you need a theme from scratch or changes to the one you already have, we plan the work with you, build it to WordPress.org standards and hand over a site you can grow on your own. Every theme ships with patterns, style settings and documentation, so a new page takes minutes instead of a developer’s afternoon.', 'artifact' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:image {"width":"100%","aspectRatio":"1170/447","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"20px"}}} -->
	<figure class="wp-block-image size-full is-resized has-custom-border"><img src="<?php echo $artifact_photo_code; ?>" alt="<?php echo esc_attr__( 'Laptop showing code on a dark desk', 'artifact' ); ?>" style="border-radius:20px;aspect-ratio:1170/447;object-fit:cover;width:100%"/></figure>
	<!-- /wp:image -->

	<!-- wp:group {"style":{"spacing":{"blockGap":"24px"}},"layout":{"type":"default"}} -->
	<div class="wp-block-group">
		<!-- wp:heading {"style":{"typography":{"lineHeight":"42px"}},"fontSize":"heading-06"} -->
		<h2 class="wp-block-heading has-heading-06-font-size" style="line-height:42px"><?php echo esc_html__( 'How we approach it', 'artifact' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-color","fontSize":"small-paragraph"} -->
		<p class="has-text-color-color has-text-color has-small-paragraph-font-size" style="line-height:28px"><?php echo esc_html__( 'We start with your goals, your content and the people who will edit the site every day. From there we turn your design into theme.json settings, templates and block patterns, so colours, type and spacing stay consistent on every page. We build in small steps, share a staging site early, and test each template with real content, keyboard navigation and screen readers before anything goes live.', 'artifact' ); ?></p>
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
			<figure class="wp-block-image size-full is-resized has-custom-border"><img src="<?php echo $artifact_photo_desk; ?>" alt="<?php echo esc_attr__( 'Laptop on a white desk beside a plant', 'artifact' ); ?>" style="border-radius:20px;aspect-ratio:5/3;object-fit:cover;width:100%"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:image {"width":"100%","aspectRatio":"5/3","scale":"cover","sizeSlug":"full","linkDestination":"none","style":{"border":{"radius":"20px"}}} -->
			<figure class="wp-block-image size-full is-resized has-custom-border"><img src="<?php echo $artifact_photo_monitor; ?>" alt="<?php echo esc_attr__( 'Developer typing at a desk with a monitor full of code', 'artifact' ); ?>" style="border-radius:20px;aspect-ratio:5/3;object-fit:cover;width:100%"/></figure>
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
