<?php
/**
 * Tests that markup only uses presets that theme.json defines.
 *
 * @package Artifact
 */

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * A typo in a preset slug fails silently in the editor and on the front end
 * (the style is simply dropped), so check every reference against theme.json.
 */
class PresetUsageTest extends TestCase {

	/**
	 * @dataProvider markup_files
	 *
	 * @param string $file Theme-relative path.
	 */
	public function test_every_preset_reference_resolves_to_a_theme_json_slug( $file ) {
		$defined = Artifact_Theme_Files::defined_presets();
		$this->addToAssertionCount( 1 ); // Files such as templates may use no presets at all.

		foreach ( Artifact_Theme_Files::used_presets( Artifact_Theme_Files::read( $file ) ) as $pair ) {
			list( $category, $slug ) = $pair;

			$this->assertArrayHasKey( $category, $defined, "{$file} uses unknown preset category '{$category}'" );
			$this->assertContains( $slug, $defined[ $category ], "{$file} uses undefined {$category} preset '{$slug}'" );
		}
	}

	public function test_the_extractor_understands_every_reference_style() {
		$used = Artifact_Theme_Files::used_presets(
			'<!-- wp:group {"backgroundColor":"main-bg","fontSize":"heading-03","style":{"spacing":{"padding":{"top":"var:preset|spacing|70"}}}} -->'
			. '<div class="has-main-bg-background-color has-text-color-color has-text-color has-heading-03-font-size" style="padding:var(--wp--preset--spacing--20)">'
		);

		$this->assertEqualsCanonicalizing(
			array(
				array( 'color', 'main-bg' ),
				array( 'font-size', 'heading-03' ),
				array( 'spacing', '70' ),
				array( 'spacing', '20' ),
				array( 'color', 'main-bg' ),
				array( 'color', 'text-color' ),
				array( 'font-size', 'heading-03' ),
			),
			$used
		);
	}

	public function test_the_extractor_catches_a_misspelled_slug() {
		$used = Artifact_Theme_Files::used_presets( '<!-- wp:paragraph {"textColor":"text-colour"} -->' );

		$this->assertSame( array( array( 'color', 'text-colour' ) ), $used );
		$this->assertNotContains( 'text-colour', Artifact_Theme_Files::defined_presets()['color'] );
	}

	public static function markup_files() {
		$cases = array();
		foreach ( Artifact_Theme_Files::markup_files() as $file ) {
			$cases[ $file ] = array( $file );
		}
		return $cases;
	}
}
