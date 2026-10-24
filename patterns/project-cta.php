<?php
/**
 * Title: Project call to action
 * Slug: artifact/project-cta
 * Categories: featured, call-to-action
 *
 * @package Artifact
 */

$artifact_banner = esc_url( get_parent_theme_file_uri( 'assets/images/cta-banner.png' ) );
$artifact_email_label = esc_attr__( 'Enter your email', 'artifact' );
?>
<!-- wp:group {"align":"full","className":"artifact-cta","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull artifact-cta has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:html -->
	<figure class="wp-block-image alignwide size-full artifact-cta__media">
		<img src="<?php echo $artifact_banner; ?>" alt="<?php echo esc_attr__( 'Got A Project? Let’s Talk. Hi,', 'artifact' ); ?>" />
		<form action="#" method="post">
			<label class="screen-reader-text" for="artifact-cta-email"><?php echo $artifact_email_label; ?></label>
			<input id="artifact-cta-email" type="email" name="email" autocomplete="email" placeholder="<?php echo $artifact_email_label; ?>" />
			<button type="submit" aria-label="<?php echo esc_attr__( 'Send', 'artifact' ); ?>"></button>
		</form>
	</figure>
	<!-- /wp:html -->
</div>
<!-- /wp:group -->
