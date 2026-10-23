<?php
/**
 * Base class for the integration tests.
 *
 * @package Artifact
 */

/**
 * Helpers to render the theme the way WordPress does for a front-end request.
 */
abstract class Artifact_Test_Case extends WP_UnitTestCase {

	/**
	 * Navigate to a URL and work out which block template WordPress picks.
	 *
	 * Mirrors the conditional chain in wp-includes/template-loader.php. Block
	 * themes resolve through the `{$type}_template` filters, which set
	 * `$_wp_current_template_id` as a side effect.
	 *
	 * @param string $url Absolute or relative URL.
	 * @return string Template id such as `artifact//single`.
	 */
	protected function resolve_template_id( $url ) {
		global $_wp_current_template_id, $_wp_current_template_content;

		$_wp_current_template_id      = null;
		$_wp_current_template_content = null;

		$this->go_to( $url );

		/*
		 * Same order as the loader. A specific getter that finds nothing falls
		 * through to the next condition (a category with no category template
		 * ends up in archive).
		 */
		$loader = array(
			array( 'is_404', 'get_404_template' ),
			array( 'is_search', 'get_search_template' ),
			array( 'is_front_page', 'get_front_page_template' ),
			array( 'is_home', 'get_home_template' ),
			array( 'is_privacy_policy', 'get_privacy_policy_template' ),
			array( 'is_post_type_archive', 'get_post_type_archive_template' ),
			array( 'is_tax', 'get_taxonomy_template' ),
			array( 'is_attachment', 'get_attachment_template' ),
			array( 'is_single', 'get_single_template' ),
			array( 'is_page', 'get_page_template' ),
			array( 'is_singular', 'get_singular_template' ),
			array( 'is_category', 'get_category_template' ),
			array( 'is_tag', 'get_tag_template' ),
			array( 'is_author', 'get_author_template' ),
			array( 'is_date', 'get_date_template' ),
			array( 'is_archive', 'get_archive_template' ),
		);
		$found  = '';
		foreach ( $loader as $step ) {
			if ( call_user_func( $step[0] ) ) {
				$found = call_user_func( $step[1] );
				if ( $found ) {
					break;
				}
			}
		}
		if ( ! $found ) {
			get_index_template();
		}

		return (string) $_wp_current_template_id;
	}

	/**
	 * Render the full HTML document for a URL through the template canvas.
	 *
	 * @param string $url Absolute or relative URL.
	 * @return string HTML document.
	 */
	protected function render_page( $url ) {
		$this->resolve_template_id( $url );

		ob_start();
		require ABSPATH . WPINC . '/template-canvas.php';
		return (string) ob_get_clean();
	}

	/**
	 * Parse HTML into an XPath query object.
	 *
	 * @param string $html HTML document or fragment.
	 * @return DOMXPath
	 */
	protected function xpath( $html ) {
		$previous = libxml_use_internal_errors( true );
		$document = new DOMDocument();
		$document->loadHTML( '<?xml encoding="utf-8"?>' . $html );
		libxml_clear_errors();
		libxml_use_internal_errors( $previous );

		return new DOMXPath( $document );
	}

	/**
	 * Render a pattern file by including it, bypassing the pattern registry.
	 *
	 * @param string $slug Pattern slug such as artifact/hero.
	 * @return string Block markup.
	 */
	protected function pattern_markup( $slug ) {
		$file = get_theme_file_path( 'patterns/' . substr( $slug, strlen( 'artifact/' ) ) . '.php' );

		ob_start();
		include $file;
		return (string) ob_get_clean();
	}

	/**
	 * Flatten parsed blocks, including inner blocks.
	 *
	 * @param array $blocks Output of parse_blocks().
	 * @return array[] Every block, depth first.
	 */
	protected function flatten_blocks( array $blocks ) {
		$flat = array();
		foreach ( $blocks as $block ) {
			$flat[] = $block;
			if ( ! empty( $block['innerBlocks'] ) ) {
				$flat = array_merge( $flat, $this->flatten_blocks( $block['innerBlocks'] ) );
			}
		}
		return $flat;
	}
}
