<?php
/**
 * Title: About page
 * Slug: artifact/page-about
 * Categories: about, featured
 * Keywords: starter, about, company, team
 * Block Types: core/post-content
 * Post Types: page, wp_template
 * Viewport width: 1400
 * Description: An about page: page hero, team photo, client names, values, company figures, team and a call to action. Use it with the Page No Title template.
 *
 * @package Artifact
 */

$artifact_photo = esc_url( get_parent_theme_file_uri( 'assets/images/company-meeting.jpg' ) );
?>
<!-- wp:pattern {"slug":"artifact/page-hero"} /-->
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-main-bg-background-color has-background" style="padding-top:0;padding-right:var(--wp--preset--spacing--20);padding-bottom:0;padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:image {"align":"wide","aspectRatio":"1170/520","scale":"cover","sizeSlug":"full","linkDestination":"none","className":"artifact-about-photo","style":{"border":{"radius":"20px"}}} -->
	<figure class="wp-block-image alignwide size-full has-custom-border artifact-about-photo"><img src="<?php echo $artifact_photo; ?>" alt="<?php echo esc_attr__( 'Three colleagues smiling around a meeting table with a laptop and a tablet', 'artifact' ); ?>" style="border-radius:20px;aspect-ratio:1170/520;object-fit:cover"/></figure>
	<!-- /wp:image -->
</div>
<!-- /wp:group -->
<!-- wp:pattern {"slug":"artifact/brands"} /-->
<!-- wp:pattern {"slug":"artifact/values"} /-->
<!-- wp:pattern {"slug":"artifact/fun-facts-grid"} /-->
<!-- wp:separator {"align":"wide","className":"is-style-wide"} -->
<hr class="wp-block-separator alignwide has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->
<!-- wp:pattern {"slug":"artifact/team"} /-->
<!-- wp:separator {"align":"wide","className":"is-style-wide"} -->
<hr class="wp-block-separator alignwide has-alpha-channel-opacity is-style-wide"/>
<!-- /wp:separator -->
<!-- wp:pattern {"slug":"artifact/project-cta"} /-->
