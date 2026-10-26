<?php
/**
 * Tests for the source of the PHP block patterns.
 *
 * @package Artifact
 */

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * Pattern headers, escaping and translation hygiene, checked from the files.
 * Rendering behaviour is covered by the integration suite.
 */
class PatternSourceTest extends TestCase {

	public function test_the_expected_set_of_patterns_exists() {
		$this->assertEqualsCanonicalizing(
			array_unique(
				array_merge(
					Artifact_Theme_Files::HOMEPAGE_PATTERNS,
					Artifact_Theme_Files::SERVICES_PAGE_PATTERNS,
					Artifact_Theme_Files::ABOUT_PAGE_PATTERNS,
					Artifact_Theme_Files::PORTFOLIO_PAGE_PATTERNS,
					Artifact_Theme_Files::CONTACT_PAGE_PATTERNS,
					Artifact_Theme_Files::PAGE_PATTERNS,
					Artifact_Theme_Files::HIDDEN_PATTERNS
				)
			),
			Artifact_Theme_Files::pattern_slugs()
		);
	}

	/**
	 * An empty navigation block lets core use the site's own menu, or a list
	 * of its pages, so links are real and the current page is marked.
	 */
	public function test_the_header_menu_is_the_sites_own_not_hard_coded_links() {
		$source = Artifact_Theme_Files::read( 'patterns/header.php' );

		$this->assertMatchesRegularExpression( '/<!-- wp:navigation \{.*?\} \/-->/', $source );
		$this->assertStringNotContainsString( 'wp:navigation-link', $source );
	}

	public function test_the_services_page_is_offered_as_a_starter_for_new_pages() {
		$headers = Artifact_Theme_Files::pattern_headers( 'patterns/page-services.php' );

		$this->assertSame( 'core/post-content', $headers['block types'] );
		$this->assertContains( 'page', array_map( 'trim', explode( ',', $headers['post types'] ) ) );
	}

	public function test_the_service_details_body_is_offered_as_a_starter_for_new_pages() {
		$headers = Artifact_Theme_Files::pattern_headers( 'patterns/page-service-details.php' );

		$this->assertSame( 'core/post-content', $headers['block types'] );
		$this->assertContains( 'page', array_map( 'trim', explode( ',', $headers['post types'] ) ) );
	}

	/**
	 * The template supplies the H1 from the page title, so the starter body
	 * must not add another.
	 */
	public function test_the_service_details_h1_is_the_page_title() {
		$this->assertStringContainsString( '<!-- wp:post-title {"level":1', Artifact_Theme_Files::read( 'patterns/hidden-service-hero.php' ) );
		$this->assertStringNotContainsString( '<h1', Artifact_Theme_Files::read( 'patterns/page-service-details.php' ) );
	}

	public function test_the_services_page_composes_its_sections_in_order() {
		$this->assertSame(
			Artifact_Theme_Files::SERVICES_PAGE_PATTERNS,
			Artifact_Theme_Files::referenced_patterns( 'patterns/page-services.php' )
		);
	}

	public function test_the_services_page_has_exactly_one_h1() {
		$count = 0;
		foreach ( Artifact_Theme_Files::SERVICES_PAGE_PATTERNS as $slug ) {
			$count += substr_count( Artifact_Theme_Files::read( 'patterns/' . substr( $slug, strlen( 'artifact/' ) ) . '.php' ), '<h1' );
		}

		$this->assertSame( 1, $count );
	}

	public function test_the_about_page_is_offered_as_a_starter_for_new_pages() {
		$headers = Artifact_Theme_Files::pattern_headers( 'patterns/page-about.php' );

		$this->assertSame( 'core/post-content', $headers['block types'] );
		$this->assertContains( 'page', array_map( 'trim', explode( ',', $headers['post types'] ) ) );
		$this->assertContains( 'about', array_map( 'trim', explode( ',', $headers['categories'] ) ) );
	}

	public function test_the_about_page_composes_its_sections_in_order() {
		$this->assertSame(
			Artifact_Theme_Files::ABOUT_PAGE_PATTERNS,
			Artifact_Theme_Files::referenced_patterns( 'patterns/page-about.php' )
		);
	}

	public function test_the_about_page_has_exactly_one_h1() {
		$count = substr_count( Artifact_Theme_Files::read( 'patterns/page-about.php' ), '<h1' );
		foreach ( Artifact_Theme_Files::ABOUT_PAGE_PATTERNS as $slug ) {
			$count += substr_count( Artifact_Theme_Files::read( 'patterns/' . substr( $slug, strlen( 'artifact/' ) ) . '.php' ), '<h1' );
		}

		$this->assertSame( 1, $count );
	}

	public function test_the_portfolio_page_is_offered_as_a_starter_for_new_pages() {
		$headers = Artifact_Theme_Files::pattern_headers( 'patterns/page-portfolio.php' );

		$this->assertSame( 'core/post-content', $headers['block types'] );
		$this->assertContains( 'page', array_map( 'trim', explode( ',', $headers['post types'] ) ) );
	}

	public function test_the_portfolio_page_composes_its_sections_in_order() {
		$this->assertSame(
			Artifact_Theme_Files::PORTFOLIO_PAGE_PATTERNS,
			Artifact_Theme_Files::referenced_patterns( 'patterns/page-portfolio.php' )
		);
	}

	public function test_the_portfolio_page_has_exactly_one_h1() {
		$count = substr_count( Artifact_Theme_Files::read( 'patterns/page-portfolio.php' ), '<h1' );
		foreach ( Artifact_Theme_Files::PORTFOLIO_PAGE_PATTERNS as $slug ) {
			$count += substr_count( Artifact_Theme_Files::read( 'patterns/' . substr( $slug, strlen( 'artifact/' ) ) . '.php' ), '<h1' );
		}

		$this->assertSame( 1, $count );
	}

	public function test_the_portfolio_details_body_is_offered_as_a_starter_for_new_pages() {
		$headers = Artifact_Theme_Files::pattern_headers( 'patterns/page-portfolio-details.php' );

		$this->assertSame( 'core/post-content', $headers['block types'] );
		$this->assertContains( 'page', array_map( 'trim', explode( ',', $headers['post types'] ) ) );
	}

	/**
	 * Each project's facts differ, so its hero lives in the body, and the
	 * H1 is the page title so the two never drift apart.
	 */
	public function test_the_portfolio_details_h1_is_the_page_title() {
		$source = Artifact_Theme_Files::read( 'patterns/page-portfolio-details.php' );

		$this->assertSame( 1, substr_count( $source, '<!-- wp:post-title {"level":1' ) );
		$this->assertStringNotContainsString( '<h1', $source );
	}

	public function test_the_contact_page_is_offered_as_a_starter_for_new_pages() {
		$headers = Artifact_Theme_Files::pattern_headers( 'patterns/page-contact.php' );

		$this->assertSame( 'core/post-content', $headers['block types'] );
		$this->assertContains( 'page', array_map( 'trim', explode( ',', $headers['post types'] ) ) );
		$this->assertContains( 'contact', array_map( 'trim', explode( ',', $headers['categories'] ) ) );
	}

	public function test_the_contact_page_composes_its_sections_in_order() {
		$this->assertSame(
			Artifact_Theme_Files::CONTACT_PAGE_PATTERNS,
			Artifact_Theme_Files::referenced_patterns( 'patterns/page-contact.php' )
		);
	}

	/**
	 * The Contact hero labels the page with its title and carries the only H1.
	 */
	public function test_the_contact_page_has_exactly_one_h1_after_the_page_title_label() {
		$source = Artifact_Theme_Files::read( 'patterns/page-contact.php' );
		$count  = substr_count( $source, '<h1' );
		foreach ( Artifact_Theme_Files::CONTACT_PAGE_PATTERNS as $slug ) {
			$count += substr_count( Artifact_Theme_Files::read( 'patterns/' . substr( $slug, strlen( 'artifact/' ) ) . '.php' ), '<h1' );
		}

		$this->assertSame( 1, $count );
		$this->assertStringContainsString( '<!-- wp:post-title {"level":0', $source );
	}

	/**
	 * Contact forms are plugin territory, and a form plugin's block or
	 * shortcode only works on the site that made the form. The message panel
	 * ships a mailto button that works without any plugin.
	 */
	public function test_the_contact_message_panel_works_without_a_form_plugin() {
		$source = Artifact_Theme_Files::read( 'patterns/contact-info.php' );

		$this->assertStringNotContainsString( '<form', $source );
		$this->assertMatchesRegularExpression( '/<a class="wp-block-button__link[^"]*" href="<\?php echo esc_url\( \'mailto:/', $source );
	}

	public function test_the_page_hero_label_is_the_page_title_rendered_as_a_paragraph() {
		$this->assertStringContainsString( '<!-- wp:post-title {"level":0', Artifact_Theme_Files::read( 'patterns/page-hero.php' ) );
	}

	/**
	 * Services patterns sit in core's own categories, so functions.php does
	 * not have to register one.
	 *
	 * @dataProvider services_category_patterns
	 *
	 * @param string $file Pattern path.
	 */
	public function test_services_patterns_use_the_core_services_category( $file ) {
		$categories = array_map( 'trim', explode( ',', Artifact_Theme_Files::pattern_headers( $file )['categories'] ) );

		$this->assertContains( 'services', $categories );
	}

	/**
	 * @dataProvider portfolio_category_patterns
	 *
	 * @param string $file Pattern path.
	 */
	public function test_portfolio_patterns_use_the_core_portfolio_category( $file ) {
		$categories = array_map( 'trim', explode( ',', Artifact_Theme_Files::pattern_headers( $file )['categories'] ) );

		$this->assertContains( 'portfolio', $categories );
	}

	public static function portfolio_category_patterns() {
		return array(
			'page-portfolio'         => array( 'patterns/page-portfolio.php' ),
			'portfolio-grid'         => array( 'patterns/portfolio-grid.php' ),
			'page-portfolio-details' => array( 'patterns/page-portfolio-details.php' ),
		);
	}

	public static function services_category_patterns() {
		return array(
			'page-services' => array( 'patterns/page-services.php' ),
			'services-grid' => array( 'patterns/services-grid.php' ),
			'services'      => array( 'patterns/services.php' ),
			'page-service-details' => array( 'patterns/page-service-details.php' ),
		);
	}

	/**
	 * Patterns must work on any site, so they use core blocks only: no
	 * plugin blocks and no shortcodes, which print as raw text when the
	 * plugin is missing.
	 *
	 * @dataProvider pattern_files
	 *
	 * @param string $file Pattern path.
	 */
	public function test_patterns_use_only_core_blocks_and_no_shortcodes( $file ) {
		$source = Artifact_Theme_Files::read( $file );

		preg_match_all( '/<!-- \/?wp:([a-z0-9-]+)\//', $source, $namespaced );
		$this->assertSame( array(), array_diff( array_unique( $namespaced[1] ), array( 'core' ) ), "{$file} uses a plugin block" );
		$this->assertDoesNotMatchRegularExpression( '/\[[a-z][a-z0-9_-]*(\s[^\]]*)?\]/', preg_replace( '/<\?php.*?\?>/s', '', $source ), "{$file} uses a shortcode" );
	}

	/**
	 * @dataProvider pattern_files
	 *
	 * @param string $file Pattern path.
	 */
	public function test_header_has_title_slug_and_package( $file ) {
		$headers = Artifact_Theme_Files::pattern_headers( $file );

		$this->assertNotEmpty( $headers['title'], "{$file} needs a Title" );
		$this->assertNotEmpty( $headers['slug'], "{$file} needs a Slug" );
		$this->assertSame( 'Artifact', $headers['package'], "{$file} needs @package Artifact" );
	}

	/**
	 * @dataProvider pattern_files
	 *
	 * @param string $file Pattern path.
	 */
	public function test_slug_is_namespaced_and_matches_the_file_name( $file ) {
		$headers = Artifact_Theme_Files::pattern_headers( $file );

		$this->assertSame( 'artifact/' . basename( $file, '.php' ), $headers['slug'] );
	}

	/**
	 * @dataProvider pattern_files
	 *
	 * @param string $file Pattern path.
	 */
	public function test_hidden_patterns_are_kept_out_of_the_inserter_and_the_rest_are_categorised( $file ) {
		$headers = Artifact_Theme_Files::pattern_headers( $file );

		if ( in_array( $headers['slug'], Artifact_Theme_Files::HIDDEN_PATTERNS, true ) ) {
			$this->assertSame( 'no', $headers['inserter'], "{$headers['slug']} is a template-only pattern" );
			return;
		}

		$this->assertArrayNotHasKey( 'inserter', $headers, "{$headers['slug']} should show in the inserter" );
		$this->assertNotEmpty( $headers['categories'], "{$headers['slug']} needs a category to be findable" );
	}

	public function test_slugs_are_unique() {
		$slugs = Artifact_Theme_Files::pattern_slugs();

		$this->assertSame( $slugs, array_values( array_unique( $slugs ) ) );
	}

	public function test_header_and_footer_patterns_are_bound_to_their_template_part_areas() {
		$this->assertSame( 'core/template-part/header', Artifact_Theme_Files::pattern_headers( 'patterns/header.php' )['block types'] );
		$this->assertSame( 'core/template-part/footer', Artifact_Theme_Files::pattern_headers( 'patterns/footer.php' )['block types'] );
	}

	/**
	 * @dataProvider pattern_files
	 *
	 * @param string $file Pattern path.
	 */
	public function test_pattern_output_is_escaped( $file ) {
		$source = Artifact_Theme_Files::read( $file );

		// Variables are fine to echo only if they were escaped on assignment.
		preg_match_all( '/\$([a-z_]+)\s*=\s*([a-z_]+)\(/', $source, $assignments, PREG_SET_ORDER );
		$escaped_variables = array();
		foreach ( $assignments as $assignment ) {
			if ( preg_match( '/^(esc_|wp_kses)/', $assignment[2] ) ) {
				$escaped_variables[] = $assignment[1];
			}
		}

		preg_match_all( '/<\?php\s+echo\s+(.+?);\s*\?>/s', $source, $echoes );
		foreach ( $echoes[1] as $expression ) {
			$expression = trim( $expression );
			if ( preg_match( '/^(esc_html|esc_attr|esc_url|wp_kses_post|wp_kses)\w*\(/', $expression ) ) {
				continue;
			}
			if ( preg_match( '/^\$([a-z_]+)$/', $expression, $variable ) && in_array( $variable[1], $escaped_variables, true ) ) {
				continue;
			}
			$this->fail( "{$file} echoes unescaped output: {$expression}" );
		}

		$this->addToAssertionCount( 1 ); // Static patterns may print nothing from PHP.
	}

	/**
	 * @dataProvider pattern_files
	 *
	 * @param string $file Pattern path.
	 */
	public function test_pattern_php_has_no_stray_output_or_side_effects( $file ) {
		$source = Artifact_Theme_Files::read( $file );

		$this->assertStringStartsWith( '<?php', $source );
		$this->assertDoesNotMatchRegularExpression( '/\b(var_dump|print_r|error_log|console\.log|die|exit)\s*\(/', $source );
		$this->assertDoesNotMatchRegularExpression( '/\b(add_action|add_filter|register_[a-z_]+)\s*\(/', $source );
	}

	/**
	 * @dataProvider pattern_files
	 *
	 * @param string $file Pattern path.
	 */
	public function test_translation_calls_use_the_artifact_text_domain( $file ) {
		$calls = Artifact_Theme_Files::translation_calls( Artifact_Theme_Files::read( $file ) );
		$this->addToAssertionCount( 1 ); // Patterns made only of pattern references have no strings.

		foreach ( $calls as $call ) {
			$this->assertSame( 'artifact', $call['domain'], "{$file}: \"{$call['text']}\" uses the wrong text domain" );
		}
	}

	public function test_translatable_strings_are_in_the_pot_file() {
		$msgids  = Artifact_Theme_Files::pot_msgids();
		$missing = array();

		foreach ( array_merge( Artifact_Theme_Files::files_in( 'patterns', 'php' ), array( 'functions.php' ) ) as $file ) {
			foreach ( Artifact_Theme_Files::translation_calls( Artifact_Theme_Files::read( $file ) ) as $call ) {
				if ( ! in_array( $call['text'], $msgids, true ) ) {
					$missing[] = "{$file}: {$call['text']}";
				}
			}
		}

		$this->assertSame( array(), $missing, 'Regenerate languages/artifact.pot (wp i18n make-pot . languages/artifact.pot)' );
	}

	public function test_pot_file_declares_the_theme_text_domain() {
		$this->assertStringContainsString( '"X-Domain: artifact\n"', Artifact_Theme_Files::read( 'languages/artifact.pot' ) );
	}

	public static function pattern_files() {
		$cases = array();
		foreach ( Artifact_Theme_Files::files_in( 'patterns', 'php' ) as $file ) {
			$cases[ $file ] = array( $file );
		}
		return $cases;
	}
}
