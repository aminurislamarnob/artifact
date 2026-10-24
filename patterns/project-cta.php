<?php
/**
 * Title: Project call to action
 * Slug: artifact/project-cta
 * Categories: featured, call-to-action
 *
 * @package Artifact
 */

$artifact_bg = esc_url( get_parent_theme_file_uri( 'assets/images/cta-bg.png' ) );
$artifact_arrow = esc_url( get_parent_theme_file_uri( 'assets/images/cta-arrow.svg' ) );
$artifact_arrow_alt = esc_attr__( 'Submit', 'artifact' );
$artifact_email_placeholder = esc_attr__( 'Enter your email', 'artifact' );
?>
<!-- wp:group {"align":"full","className":"artifact-cta","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"main-bg","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull artifact-cta has-main-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--20)">
	<!-- wp:group {"align":"wide","className":"artifact-cta-box","style":{"spacing":{"padding":{"top":"80px","bottom":"80px","left":"100px","right":"100px"}}},"backgroundColor":"primary","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"bottom"}} -->
	<div class="wp-block-group alignwide artifact-cta-box has-primary-background-color has-background" style="background-image:url('<?php echo $artifact_bg; ?>');background-size:cover;background-position:center;border-radius:24px;padding-top:80px;padding-right:100px;padding-bottom:80px;padding-left:100px">
		<!-- wp:heading {"level":2,"className":"artifact-cta-title","style":{"typography":{"lineHeight":"64px","letterSpacing":"-0.03em"}},"textColor":"text-white"} -->
		<h2 class="wp-block-heading artifact-cta-title has-text-white-color has-text-color" style="letter-spacing:-0.03em;line-height:64px"><?php echo esc_html__( 'Got A Project?', 'artifact' ); ?><br /><?php echo esc_html__( 'Let’s Talk. Hi,', 'artifact' ); ?></h2>
		<!-- /wp:heading -->

		<!-- wp:html -->
		<form class="artifact-cta-form" action="#" method="post">
			<label class="screen-reader-text" for="artifact-cta-email"><?php echo $artifact_email_placeholder; ?></label>
			<input id="artifact-cta-email" type="email" name="email" autocomplete="email" placeholder="<?php echo $artifact_email_placeholder; ?>" required />
			<button type="submit" aria-label="<?php echo $artifact_arrow_alt; ?>">
				<img src="<?php echo $artifact_arrow; ?>" alt="<?php echo $artifact_arrow_alt; ?>" width="40" height="40" />
			</button>
		</form>
		<!-- /wp:html -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
