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
			array_merge( Artifact_Theme_Files::HOMEPAGE_PATTERNS, Artifact_Theme_Files::HIDDEN_PATTERNS ),
			Artifact_Theme_Files::pattern_slugs()
		);
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
