<?php
/**
 * Tests for theme.json, the theme's only token source.
 *
 * @package Artifact
 */

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * The tokens documented in CLAUDE.md are a contract: patterns, parts and
 * templates reference these slugs, so renaming or dropping one breaks them.
 */
class ThemeJsonTest extends TestCase {

	/**
	 * Decoded theme.json.
	 *
	 * @var array
	 */
	private $json;

	/**
	 * Load theme.json.
	 */
	protected function set_up() {
		parent::set_up();
		$this->json = Artifact_Theme_Files::json();
	}

	public function test_it_is_valid_json_with_schema_version_3() {
		$this->assertSame( 3, $this->json['version'] );
		$this->assertStringContainsString( 'schemas.wp.org', $this->json['$schema'] );
	}

	public function test_it_enables_the_layout_features_the_theme_relies_on() {
		$settings = $this->json['settings'];

		$this->assertTrue( $settings['appearanceTools'] );
		$this->assertTrue( $settings['useRootPaddingAwareAlignments'] );
		$this->assertSame( '800px', $settings['layout']['contentSize'] );
		$this->assertSame( '1170px', $settings['layout']['wideSize'] );
	}

	public function test_it_switches_off_every_core_default_preset() {
		$settings = $this->json['settings'];

		$this->assertFalse( $settings['color']['defaultPalette'] );
		$this->assertFalse( $settings['color']['defaultGradients'] );
		$this->assertFalse( $settings['color']['defaultDuotone'] );
		$this->assertFalse( $settings['spacing']['defaultSpacingSizes'] );
		$this->assertFalse( $settings['typography']['defaultFontSizes'] );
	}

	public function test_color_palette_keeps_the_documented_slugs() {
		$this->assertEqualsCanonicalizing(
			array( 'primary', 'secondary', 'main-bg', 'light-bg', 'dark-bg', 'heading-color', 'text-white', 'text-color', 'link-color', 'border' ),
			Artifact_Theme_Files::defined_presets()['color']
		);
	}

	public function test_font_size_scale_keeps_the_documented_slugs() {
		$this->assertEqualsCanonicalizing(
			array(
				'small-paragraph',
				'medium-paragraph',
				'large-paragraph',
				'small-title',
				'medium-title',
				'large-title',
				'heading-01',
				'heading-02',
				'heading-03',
				'heading-04',
				'heading-05',
				'heading-06',
				'button-large',
				'button-small',
			),
			Artifact_Theme_Files::defined_presets()['font-size']
		);
	}

	public function test_spacing_scale_keeps_the_documented_slugs() {
		$this->assertEqualsCanonicalizing(
			array( '10', '20', '30', '50', '60', '70', '100' ),
			Artifact_Theme_Files::defined_presets()['spacing']
		);
	}

	public function test_poppins_is_the_only_font_family() {
		$this->assertSame( array( 'poppins' ), Artifact_Theme_Files::defined_presets()['font-family'] );
	}

	public function test_every_preset_slug_is_unique_within_its_category() {
		foreach ( Artifact_Theme_Files::defined_presets() as $category => $slugs ) {
			$this->assertSame( $slugs, array_values( array_unique( $slugs ) ), "Duplicate slug in {$category}" );
		}
	}

	public function test_palette_colors_are_six_digit_hex_values() {
		foreach ( $this->json['settings']['color']['palette'] as $color ) {
			$this->assertMatchesRegularExpression( '/^#[0-9a-f]{6}$/', $color['color'], $color['slug'] );
		}
	}

	public function test_font_sizes_are_pixel_values() {
		foreach ( $this->json['settings']['typography']['fontSizes'] as $size ) {
			$this->assertMatchesRegularExpression( '/^\d+px$/', $size['size'], $size['slug'] );
		}
	}

	public function test_font_faces_are_self_hosted_woff2_files_that_exist() {
		$faces = $this->json['settings']['typography']['fontFamilies'][0]['fontFace'];
		$this->assertNotEmpty( $faces );

		$weights = array();
		foreach ( $faces as $face ) {
			$weights[] = $face['fontWeight'];
			foreach ( $face['src'] as $src ) {
				$this->assertStringStartsWith( 'file:./assets/fonts/', $src, 'Fonts must be bundled, not remote' );
				$this->assertStringEndsWith( '.woff2', $src );
				$this->assertFileExists( Artifact_Theme_Files::path( substr( $src, strlen( 'file:./' ) ) ) );
			}
		}
		$this->assertEqualsCanonicalizing( array( '400', '500', '600', '700' ), $weights );
	}

	public function test_template_parts_are_registered_with_the_right_areas() {
		$areas = array();
		foreach ( $this->json['templateParts'] as $part ) {
			$areas[ $part['name'] ] = $part['area'];
			$this->assertFileExists( Artifact_Theme_Files::path( "parts/{$part['name']}.html" ) );
		}
		$this->assertSame(
			array(
				'header' => 'header',
				'footer' => 'footer',
			),
			$areas
		);
	}

	public function test_page_surface_uses_main_bg_and_text_color_presets() {
		$styles = $this->json['styles'];

		$this->assertSame( 'var(--wp--preset--color--main-bg)', $styles['color']['background'] );
		$this->assertSame( 'var(--wp--preset--color--text-color)', $styles['color']['text'] );
		$this->assertSame( 'var(--wp--preset--font-family--poppins)', $styles['typography']['fontFamily'] );
	}

	public function test_every_preset_the_styles_reference_is_defined() {
		$encoded = json_encode( $this->json['styles'] );
		$defined = Artifact_Theme_Files::defined_presets();

		$this->assertNotEmpty( Artifact_Theme_Files::used_presets( $encoded ) );
		foreach ( Artifact_Theme_Files::used_presets( $encoded ) as $pair ) {
			list( $category, $slug ) = $pair;
			$this->assertContains( $slug, $defined[ $category ], "styles reference undefined {$category} preset '{$slug}'" );
		}
	}

	public function test_hex_values_live_only_in_the_palette() {
		$without_palette = $this->json;
		unset( $without_palette['settings']['color']['palette'] );

		$this->assertDoesNotMatchRegularExpression(
			'/#[0-9a-fA-F]{3,8}\b/',
			json_encode( $without_palette ),
			'Colours belong in the palette; reference them as presets elsewhere.'
		);
	}

	/**
	 * @dataProvider text_on_surface_pairs
	 *
	 * @param string $text    Text colour slug.
	 * @param string $surface Surface colour slug.
	 */
	public function test_text_colors_meet_wcag_aa_on_the_surfaces_they_sit_on( $text, $surface ) {
		$colors = array_column( $this->json['settings']['color']['palette'], 'color', 'slug' );

		$this->assertGreaterThanOrEqual(
			4.5,
			Artifact_Theme_Files::contrast_ratio( $colors[ $text ], $colors[ $surface ] ),
			"{$text} on {$surface} is below WCAG AA for body text"
		);
	}

	public static function text_on_surface_pairs() {
		return array(
			'body text on page'        => array( 'text-color', 'main-bg' ),
			'body text on light panel' => array( 'text-color', 'light-bg' ),
			'body text on dark panel'  => array( 'text-color', 'dark-bg' ),
			'headings on page'         => array( 'heading-color', 'main-bg' ),
			'links on page'            => array( 'link-color', 'main-bg' ),
			'white text on page'       => array( 'text-white', 'main-bg' ),
			'white text on panels'     => array( 'text-white', 'light-bg' ),
			// CLAUDE.md: primary is text only where contrast meets AA.
			'primary as text on page'  => array( 'primary', 'main-bg' ),
			'primary as text on panel' => array( 'primary', 'light-bg' ),
		);
	}

	public function test_button_label_meets_the_wcag_threshold_for_large_text() {
		$colors = array_column( $this->json['settings']['color']['palette'], 'color', 'slug' );

		// Buttons are 16px/600, so they need 4.5:1 to be "normal" text. The
		// brand orange only reaches the 3:1 large-text/UI threshold with white.
		$this->assertGreaterThanOrEqual(
			3.0,
			Artifact_Theme_Files::contrast_ratio( $colors['text-white'], $colors['primary'] )
		);
	}

	public function test_button_style_variations_are_defined_as_block_json_files() {
		$variations = Artifact_Theme_Files::files_in( 'styles/blocks', 'json' );
		$this->assertNotEmpty( $variations );

		foreach ( $variations as $file ) {
			$variation = Artifact_Theme_Files::json( $file );
			$this->assertArrayHasKey( 'blockTypes', $variation, "{$file} must declare blockTypes" );
			$this->assertNotEmpty( $variation['blockTypes'] );
			$this->assertArrayHasKey( 'title', $variation );
			$this->assertArrayHasKey( 'slug', $variation );
			$this->assertSame( 3, $variation['version'] );
		}
	}

	public function test_there_are_no_theme_style_variations() {
		$this->assertSame(
			array(),
			Artifact_Theme_Files::files_in( 'styles', 'json' ),
			'Only block style variations (styles/blocks/*.json) are allowed.'
		);
	}
}
