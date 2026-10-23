<?php
/**
 * Tests for the theme header, readme and required files.
 *
 * @package Artifact
 */

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * Metadata that WordPress.org review and the theme loader read.
 */
class ThemeHeadersTest extends TestCase {

	/**
	 * Parsed style.css header.
	 *
	 * @var array<string,string>
	 */
	private $header;

	/**
	 * Parse the style.css header comment.
	 */
	protected function set_up() {
		parent::set_up();
		$this->header = array();
		preg_match_all( '/^\s*\*?\s*([A-Za-z ]+):\s*(.+?)\s*$/m', Artifact_Theme_Files::read( 'style.css' ), $matches, PREG_SET_ORDER );
		foreach ( $matches as $match ) {
			$this->header[ $match[1] ] = $match[2];
		}
	}

	public function test_identity_fields() {
		$this->assertSame( 'Artifact', $this->header['Theme Name'] );
		$this->assertSame( 'artifact', $this->header['Text Domain'] );
		$this->assertSame( '/languages', $this->header['Domain Path'] );
	}

	public function test_minimum_requirements() {
		$this->assertSame( '6.7', $this->header['Requires at least'] );
		$this->assertSame( '7.4', $this->header['Requires PHP'] );
	}

	public function test_it_is_gpl_licensed() {
		$this->assertStringContainsString( 'GNU General Public License', $this->header['License'] );
		$this->assertStringContainsString( 'gnu.org/licenses/gpl', $this->header['License URI'] );
	}

	public function test_version_is_semver() {
		$this->assertMatchesRegularExpression( '/^\d+\.\d+\.\d+$/', $this->header['Version'] );
	}

	public function test_readme_stable_tag_matches_the_theme_version() {
		$this->assertMatchesRegularExpression( '/^Stable tag:\s*(.+)$/m', Artifact_Theme_Files::read( 'readme.txt' ) );
		preg_match( '/^Stable tag:\s*(.+)$/m', Artifact_Theme_Files::read( 'readme.txt' ), $match );

		$this->assertSame( $this->header['Version'], trim( $match[1] ) );
	}

	public function test_readme_requirements_match_the_theme_header() {
		$readme = Artifact_Theme_Files::read( 'readme.txt' );

		$this->assertStringContainsString( 'Requires at least: ' . $this->header['Requires at least'], $readme );
		$this->assertStringContainsString( 'Requires PHP: ' . $this->header['Requires PHP'], $readme );
		$this->assertStringContainsString( 'Tested up to: ' . $this->header['Tested up to'], $readme );
	}

	public function test_readme_changelog_has_an_entry_for_the_current_version() {
		$this->assertStringContainsString( '= ' . $this->header['Version'] . ' =', Artifact_Theme_Files::read( 'readme.txt' ) );
	}

	/**
	 * The theme is LTR-only and not an e-commerce theme, so the tags that
	 * promise otherwise must not be claimed.
	 *
	 * @dataProvider forbidden_tags
	 *
	 * @param string $tag Tag that must be absent.
	 */
	public function test_it_does_not_claim_tags_it_cannot_honour( $tag ) {
		$tags = array_map( 'trim', explode( ',', $this->header['Tags'] ) );

		$this->assertNotContains( $tag, $tags );
	}

	public static function forbidden_tags() {
		return array(
			array( 'accessibility-ready' ),
			array( 'rtl-language-support' ),
			array( 'e-commerce' ),
		);
	}

	public function test_it_claims_full_site_editing() {
		$this->assertContains( 'full-site-editing', array_map( 'trim', explode( ',', $this->header['Tags'] ) ) );
	}

	/**
	 * @dataProvider required_files
	 *
	 * @param string $file Theme-relative path.
	 */
	public function test_required_files_exist( $file ) {
		$this->assertFileExists( Artifact_Theme_Files::path( $file ) );
	}

	public static function required_files() {
		$files = array(
			'style.css',
			'theme.json',
			'functions.php',
			'readme.txt',
			'screenshot.png',
			'languages/artifact.pot',
			'assets/fonts/OFL.txt',
		);
		foreach ( array( 'index', 'front-page', 'page', 'single', 'archive', 'search', '404' ) as $template ) {
			$files[] = "templates/{$template}.html";
		}
		$files[] = 'parts/header.html';
		$files[] = 'parts/footer.html';

		return array_map(
			static function ( $file ) {
				return array( $file );
			},
			$files
		);
	}

	public function test_screenshot_is_the_size_wordpress_org_expects() {
		$size = getimagesize( Artifact_Theme_Files::path( 'screenshot.png' ) );

		$this->assertSame( 1200, $size[0] );
		$this->assertSame( 900, $size[1] );
		$this->assertSame( 'image/png', $size['mime'] );
	}

	public function test_screenshot_is_under_the_one_megabyte_limit() {
		$this->assertLessThan( 1024 * 1024, filesize( Artifact_Theme_Files::path( 'screenshot.png' ) ) );
	}
}
