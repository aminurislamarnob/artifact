<?php
/**
 * Tests for the architecture rules in CLAUDE.md.
 *
 * @package Artifact
 */

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * Keeps the theme inside its own constraints: tokens in theme.json only, no
 * remote assets, no theme JavaScript, self-hosted WOFF2 fonts, and a thin
 * functions.php.
 */
class ThemeStandardsTest extends TestCase {

	public function test_functions_php_only_loads_the_text_domain() {
		$source = Artifact_Theme_Files::read( 'functions.php' );

		$this->assertStringContainsString( 'load_theme_textdomain', $source );
		$this->assertSame( 1, preg_match_all( '/add_action\(/', $source ), 'functions.php should hook only the text domain loader' );
	}

	/**
	 * @dataProvider forbidden_in_functions_php
	 *
	 * @param string $needle Function name that must not appear.
	 */
	public function test_functions_php_does_not_redo_what_core_or_theme_json_does( $needle ) {
		$this->assertStringNotContainsString( $needle, Artifact_Theme_Files::read( 'functions.php' ) );
	}

	public static function forbidden_in_functions_php() {
		return array(
			'block styles are JSON'          => array( 'register_block_style' ),
			'supports are core defaults'     => array( 'add_theme_support' ),
			'no theme scripts'               => array( 'wp_enqueue_script' ),
			'no stylesheet dump'             => array( 'wp_enqueue_style' ),
			'no remote font loading'         => array( 'fonts.googleapis.com' ),
			'no editor-style registration'   => array( 'add_editor_style' ),
		);
	}

	public function test_functions_php_blocks_direct_access() {
		$this->assertMatchesRegularExpression(
			'/if \( ! defined\( \'ABSPATH\' \) \) \{\s*exit;/',
			Artifact_Theme_Files::read( 'functions.php' )
		);
	}

	public function test_the_theme_ships_no_javascript() {
		$scripts = array_filter(
			Artifact_Theme_Files::all_files(),
			static function ( $file ) {
				return (bool) preg_match( '/\.(m?js|jsx|ts|tsx)$/', $file );
			}
		);

		$this->assertSame( array(), array_values( $scripts ) );
	}

	public function test_the_only_stylesheet_is_the_theme_header() {
		$stylesheets = array_filter(
			Artifact_Theme_Files::all_files(),
			static function ( $file ) {
				return (bool) preg_match( '/\.(css|scss|less)$/', $file );
			}
		);

		$this->assertSame( array( 'style.css' ), array_values( $stylesheets ) );
	}

	public function test_style_css_is_only_a_header_with_no_rules() {
		$css = preg_replace( '/\/\*.*?\*\//s', '', Artifact_Theme_Files::read( 'style.css' ) );

		$this->assertSame( '', trim( $css ), 'Styling belongs in theme.json, not style.css' );
	}

	public function test_fonts_are_woff2_only() {
		$fonts = array_filter(
			Artifact_Theme_Files::all_files(),
			static function ( $file ) {
				return 0 === strpos( $file, 'assets/fonts/' ) && 'assets/fonts/OFL.txt' !== $file;
			}
		);

		$this->assertNotEmpty( $fonts );
		foreach ( $fonts as $font ) {
			$this->assertStringEndsWith( '.woff2', $font );
		}
	}

	public function test_woff2_files_are_real_woff2_data() {
		foreach ( glob( Artifact_Theme_Files::path( 'assets/fonts/*.woff2' ) ) as $font ) {
			$this->assertSame( 'wOF2', substr( file_get_contents( $font ), 0, 4 ), basename( $font ) . ' is not a WOFF2 file' );
		}
	}

	public function test_the_font_licence_is_bundled_with_the_fonts() {
		$this->assertStringContainsString( 'SIL OPEN FONT LICENSE', strtoupper( Artifact_Theme_Files::read( 'assets/fonts/OFL.txt' ) ) );
	}

	/**
	 * @dataProvider markup_files
	 *
	 * @param string $file Theme-relative path.
	 */
	public function test_markup_loads_nothing_from_remote_hosts( $file ) {
		preg_match_all( '#(?:https?:)?//[a-z0-9.-]+\.[a-z]{2,}[^\s"\'<>)]*#i', Artifact_Theme_Files::read( $file ), $matches );

		$this->assertSame( array(), $matches[0], "{$file} references a remote URL" );
	}

	/**
	 * Colours come from theme.json presets, never literals.
	 *
	 * @dataProvider markup_files
	 *
	 * @param string $file Theme-relative path.
	 */
	public function test_markup_has_no_hardcoded_colors( $file ) {
		$source = Artifact_Theme_Files::read( $file );

		// Ignore numeric character references such as &#8217; and href="#".
		$this->assertDoesNotMatchRegularExpression( '/(?<![&\w])#[0-9a-fA-F]{3,8}\b(?!;)/', $source, "{$file} contains a hex colour" );
		$this->assertDoesNotMatchRegularExpression( '/\b(?:rgba?|hsla?)\(/i', $source, "{$file} contains an rgb/hsl colour" );
	}

	/**
	 * @dataProvider markup_files
	 *
	 * @param string $file Theme-relative path.
	 */
	public function test_markup_has_no_script_tags_or_inline_event_handlers( $file ) {
		$source = Artifact_Theme_Files::read( $file );

		$this->assertDoesNotMatchRegularExpression( '/<script\b/i', $source );
		$this->assertDoesNotMatchRegularExpression( '/\son[a-z]+\s*=/i', $source );
	}

	public static function markup_files() {
		$cases = array();
		foreach ( Artifact_Theme_Files::markup_files() as $file ) {
			$cases[ $file ] = array( $file );
		}
		return $cases;
	}

	public function test_bundled_images_are_documented_in_the_readme() {
		$readme = Artifact_Theme_Files::read( 'readme.txt' );
		$images = Artifact_Theme_Files::files_in( 'assets/images', 'jpg' );
		$images = array_merge( $images, Artifact_Theme_Files::files_in( 'assets/images', 'svg' ), Artifact_Theme_Files::files_in( 'assets/images', 'png' ) );

		$this->assertNotEmpty( $images );
		foreach ( $images as $image ) {
			$this->assertStringContainsString( basename( $image ), $readme, "{$image} has no licence entry in readme.txt" );
		}
	}

	public function test_no_disallowed_image_services_are_referenced() {
		$readme = Artifact_Theme_Files::read( 'readme.txt' );

		// WordPress.org prohibited asset services (non-GPL compatible).
		$prohibited = array( 'uns' . 'plash.com', 'pix' . 'abay.com', 'free' . 'pik.com', 'flat' . 'icon.com', 'split' . 'shire.com' );
		foreach ( $prohibited as $domain ) {
			$this->assertStringNotContainsString( $domain, $readme, "Prohibited domain {$domain} must not be referenced in readme.txt" );
		}
	}

	public function test_images_referenced_by_markup_exist() {
		$referenced = array();
		foreach ( Artifact_Theme_Files::markup_files() as $file ) {
			preg_match_all( '#assets/images/([A-Za-z0-9._-]+\.[a-z]+)#', Artifact_Theme_Files::read( $file ), $matches );
			$referenced = array_merge( $referenced, $matches[1] );
		}

		$this->assertNotEmpty( $referenced );
		foreach ( array_unique( $referenced ) as $image ) {
			$this->assertFileExists( Artifact_Theme_Files::path( "assets/images/{$image}" ) );
		}
	}

	public function test_no_development_files_leak_into_the_theme_assets() {
		foreach ( Artifact_Theme_Files::all_files() as $file ) {
			$this->assertDoesNotMatchRegularExpression( '/\.(ttf|otf|eot|woff|map|zip|log|bak|orig)$/', $file, "{$file} should not ship" );
		}
	}
}
