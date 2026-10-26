<?php
/**
 * Title: Contact page
 * Slug: artifact/page-contact
 * Categories: contact, featured
 * Keywords: starter, contact, form, email
 * Block Types: core/post-content
 * Post Types: page, wp_template
 * Viewport width: 1400
 * Description: A contact page: page hero, contact details with a message panel, and a call to action. Use it with the Page No Title template.
 *
 * @package Artifact
 */

?>
<!-- wp:group {"align":"full","className":"artifact-page-hero","style":{"spacing":{"padding":{"top":"80px","bottom":"var:preset|spacing|60","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull artifact-page-hero has-main-bg-background-color has-background" style="padding-top:80px;padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|30","top":"24px"}}}} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-center">
		<!-- wp:column {"verticalAlignment":"center","width":"670px","style":{"spacing":{"blockGap":"24px"}}} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:670px">
			<!-- wp:post-title {"level":0,"style":{"typography":{"lineHeight":"26px","fontWeight":"600"}},"textColor":"text-color","fontSize":"medium-title"} /-->

			<!-- wp:heading {"level":1,"style":{"typography":{"lineHeight":"64px"}},"fontSize":"heading-03"} -->
			<h1 class="wp-block-heading has-heading-03-font-size" style="line-height:64px"><?php echo esc_html__( 'Let’s collab. We’d love to hear from you', 'artifact' ); ?></h1>
			<!-- /wp:heading -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"470px"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:470px">
			<!-- wp:paragraph {"style":{"typography":{"lineHeight":"28px"}},"textColor":"text-color","fontSize":"medium-paragraph"} -->
			<p class="has-text-color-color has-text-color has-medium-paragraph-font-size" style="line-height:28px"><?php echo esc_html__( 'Tell us about your project, your timeline or the problem you’re stuck on. We reply to every message within one business day.', 'artifact' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
<!-- wp:pattern {"slug":"artifact/contact-info"} /-->
<!-- wp:separator {"align":"wide","className":"is-style-wide"} -->
<hr class="wp-block-separator alignwide has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->
<!-- wp:pattern {"slug":"artifact/project-cta"} /-->
