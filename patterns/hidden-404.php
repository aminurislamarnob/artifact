<?php
/**
 * Title: 404
 * Slug: artifact/hidden-404
 * Inserter: no
 *
 * @package Artifact
 */
?>
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading"><?php echo esc_html__( 'Page not found', 'artifact' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html__( 'The page you are looking for does not exist, or it has been moved. Try a search.', 'artifact' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:search {"label":"<?php echo esc_attr__( 'Search', 'artifact' ); ?>","showLabel":false,"placeholder":"<?php echo esc_attr__( 'Search…', 'artifact' ); ?>","buttonText":"<?php echo esc_attr__( 'Search', 'artifact' ); ?>"} /-->
