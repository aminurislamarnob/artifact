<?php
/**
 * Tests for the structure of templates and template parts.
 *
 * @package Artifact
 */

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * Templates are thin: header, one main landmark, footer. The homepage is a
 * list of pattern references.
 */
class TemplateSourceTest extends TestCase {

	public function test_front_page_composes_the_homepage_sections_in_order() {
		$this->assertSame(
			Artifact_Theme_Files::HOMEPAGE_PATTERNS,
			Artifact_Theme_Files::referenced_patterns( 'templates/front-page.html' )
		);
	}

	/**
	 * @dataProvider all_templates
	 *
	 * @param string $file Template path.
	 */
	public function test_templates_wrap_content_in_header_main_and_footer( $file ) {
		$source = Artifact_Theme_Files::read( $file );

		$this->assertStringContainsString( '<!-- wp:template-part {"slug":"header","tagName":"header"} /-->', $source );
		$this->assertStringContainsString( '<!-- wp:template-part {"slug":"footer","tagName":"footer"} /-->', $source );
		$this->assertSame( 1, substr_count( $source, '"tagName":"main"' ), "{$file} needs exactly one main landmark" );
		$this->assertLessThan( strpos( $source, '"tagName":"main"' ), strpos( $source, '"slug":"header"' ) );
		$this->assertGreaterThan( strpos( $source, '"tagName":"main"' ), strpos( $source, '"slug":"footer"' ) );
	}

	/**
	 * @dataProvider all_templates
	 *
	 * @param string $file Template path.
	 */
	public function test_templates_have_no_remote_or_php_content( $file ) {
		$source = Artifact_Theme_Files::read( $file );

		$this->assertStringNotContainsString( '<?php', $source, 'Templates are static HTML; put PHP in a pattern' );
	}

	/**
	 * @dataProvider all_templates_and_parts
	 *
	 * @param string $file Template or part path.
	 */
	public function test_every_pattern_a_template_references_exists( $file ) {
		$known = Artifact_Theme_Files::pattern_slugs();
		$this->addToAssertionCount( 1 ); // Files without pattern references are fine.

		foreach ( Artifact_Theme_Files::referenced_patterns( $file ) as $slug ) {
			$this->assertContains( $slug, $known, "{$file} references missing pattern {$slug}" );
		}
	}

	public function test_header_and_footer_parts_delegate_to_their_patterns() {
		$this->assertSame( array( 'artifact/header' ), Artifact_Theme_Files::referenced_patterns( 'parts/header.html' ) );
		$this->assertSame( array( 'artifact/footer' ), Artifact_Theme_Files::referenced_patterns( 'parts/footer.html' ) );
	}

	public function test_listing_templates_use_the_main_query_and_show_a_no_results_pattern() {
		foreach ( array( 'index', 'archive', 'search' ) as $name ) {
			$source = Artifact_Theme_Files::read( "templates/{$name}.html" );

			$this->assertStringContainsString( '"inherit":true', $source, "{$name} must use the main query" );
			$this->assertStringContainsString( 'wp:query-no-results', $source );
			$this->assertStringContainsString( 'wp:query-pagination', $source );
			$this->assertStringContainsString( 'wp:post-template', $source );
		}
	}

	public function test_the_404_template_offers_a_search() {
		$this->assertStringContainsString( 'artifact/hidden-404', Artifact_Theme_Files::read( 'templates/404.html' ) );
		$this->assertStringContainsString( 'wp:search', Artifact_Theme_Files::read( 'patterns/hidden-404.php' ) );
	}

	public function test_single_template_includes_title_content_and_comments() {
		$source = Artifact_Theme_Files::read( 'templates/single.html' );

		foreach ( array( 'wp:post-title', 'wp:post-content', 'wp:post-date', 'wp:comments', 'wp:post-comments-form' ) as $block ) {
			$this->assertStringContainsString( $block, $source );
		}
	}

	public function test_page_template_has_a_single_h1_from_the_post_title() {
		$this->assertStringContainsString( '<!-- wp:post-title {"level":1} /-->', Artifact_Theme_Files::read( 'templates/page.html' ) );
	}

	public function test_the_page_no_title_template_leaves_the_h1_to_the_content() {
		$source = Artifact_Theme_Files::read( 'templates/page-no-title.html' );

		$this->assertStringContainsString( 'wp:post-content', $source );
		$this->assertStringNotContainsString( 'wp:post-title', $source );
	}

	public function test_the_service_details_template_frames_the_page_content() {
		$source = Artifact_Theme_Files::read( 'templates/page-service-details.html' );

		$this->assertSame( array( 'artifact/hidden-service-hero', 'artifact/project-cta' ), Artifact_Theme_Files::referenced_patterns( 'templates/page-service-details.html' ) );
		$this->assertLessThan( strpos( $source, 'wp:post-content' ), strpos( $source, 'artifact/hidden-service-hero' ) );
		$this->assertGreaterThan( strpos( $source, 'wp:post-content' ), strpos( $source, 'artifact/project-cta' ) );
		$this->assertStringNotContainsString( 'wp:post-title', $source, 'The hero pattern renders the title' );
	}

	/**
	 * The project hero is part of the page body, so the template only frames
	 * it with the call to action.
	 */
	public function test_the_portfolio_details_template_frames_the_page_content() {
		$source = Artifact_Theme_Files::read( 'templates/page-portfolio-details.html' );

		$this->assertSame( array( 'artifact/project-cta' ), Artifact_Theme_Files::referenced_patterns( 'templates/page-portfolio-details.html' ) );
		$this->assertGreaterThan( strpos( $source, 'wp:post-content' ), strpos( $source, 'artifact/project-cta' ) );
		$this->assertStringNotContainsString( 'wp:post-title', $source, 'The page body renders the title' );
	}

	public function test_homepage_has_exactly_one_h1() {
		$count = 0;
		foreach ( Artifact_Theme_Files::HOMEPAGE_PATTERNS as $slug ) {
			$count += substr_count( Artifact_Theme_Files::read( 'patterns/' . substr( $slug, strlen( 'artifact/' ) ) . '.php' ), '<h1' );
		}

		$this->assertSame( 1, $count );
	}

	public function test_template_blocks_are_balanced_and_use_single_line_comment_delimiters() {
		foreach ( array_merge( Artifact_Theme_Files::files_in( 'templates', 'html' ), Artifact_Theme_Files::files_in( 'parts', 'html' ), Artifact_Theme_Files::files_in( 'patterns', 'php' ) ) as $file ) {
			$source = Artifact_Theme_Files::read( $file );

			$opens  = preg_match_all( '/<!-- wp:[a-z0-9\/-]+(?: \{.*?\})? -->/', $source );
			$closes = preg_match_all( '/<!-- \/wp:[a-z0-9\/-]+ -->/', $source );
			$self   = preg_match_all( '/<!-- wp:[a-z0-9\/-]+(?: \{.*?\})? \/-->/', $source );

			$this->assertSame( $opens, $closes, "{$file} has unbalanced block comments" );
			$this->assertGreaterThan( 0, $opens + $self, "{$file} contains no blocks" );
		}
	}

	public static function all_templates() {
		$cases = array();
		foreach ( Artifact_Theme_Files::files_in( 'templates', 'html' ) as $file ) {
			$cases[ $file ] = array( $file );
		}
		return $cases;
	}

	public static function all_templates_and_parts() {
		$cases = self::all_templates();
		foreach ( Artifact_Theme_Files::files_in( 'parts', 'html' ) as $file ) {
			$cases[ $file ] = array( $file );
		}
		return $cases;
	}
}
