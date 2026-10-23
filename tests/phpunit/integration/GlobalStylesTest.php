<?php
/**
 * Tests how WordPress resolves theme.json into settings and CSS.
 *
 * @package Artifact
 */

class GlobalStylesTest extends Artifact_Test_Case {

	/**
	 * Start every test from freshly compiled theme data.
	 */
	public function set_up() {
		parent::set_up();
		WP_Theme_JSON_Resolver::clean_cached_data();
	}

	public function test_wordpress_keeps_every_setting_and_style_from_theme_json() {
		$file = Artifact_Theme_Files::json();
		$raw  = WP_Theme_JSON_Resolver::get_theme_data()->get_raw_data();

		// Presets are wrapped in an origin ("theme") once resolved, and
		// appearanceTools expands into individual flags; both are checked below.
		$wrapped = array( 'palette', 'fontSizes', 'fontFamilies', 'spacingSizes', 'appearanceTools' );

		$this->assertSame( array(), $this->dropped_paths( $file['settings'], $raw['settings'], 'settings', $wrapped ) );
		$this->assertSame( array(), $this->dropped_paths( $file['styles'], $raw['styles'], 'styles', array() ) );
	}

	public function test_presets_are_registered_under_the_theme_origin() {
		$file = Artifact_Theme_Files::json()['settings'];
		$raw  = WP_Theme_JSON_Resolver::get_theme_data()->get_raw_data()['settings'];

		$this->assertSame( $file['color']['palette'], $raw['color']['palette']['theme'] );
		$this->assertSame( $file['typography']['fontSizes'], $raw['typography']['fontSizes']['theme'] );
		$this->assertSame( $file['spacing']['spacingSizes'], $raw['spacing']['spacingSizes']['theme'] );
		$this->assertSame( 'poppins', $raw['typography']['fontFamilies']['theme'][0]['slug'] );
	}

	public function test_core_default_presets_are_switched_off() {
		$this->assertFalse( wp_get_global_settings( array( 'color', 'defaultPalette' ) ) );
		$this->assertFalse( wp_get_global_settings( array( 'color', 'defaultGradients' ) ) );
		$this->assertFalse( wp_get_global_settings( array( 'color', 'defaultDuotone' ) ) );
		$this->assertFalse( wp_get_global_settings( array( 'typography', 'defaultFontSizes' ) ) );
		$this->assertFalse( wp_get_global_settings( array( 'spacing', 'defaultSpacingSizes' ) ) );
	}

	public function test_layout_sizes() {
		$this->assertSame( '800px', wp_get_global_settings( array( 'layout', 'contentSize' ) ) );
		$this->assertSame( '1170px', wp_get_global_settings( array( 'layout', 'wideSize' ) ) );
		$this->assertTrue( wp_get_global_settings( array( 'useRootPaddingAwareAlignments' ) ) );
	}

	public function test_global_stylesheet_outputs_every_theme_preset_as_a_css_variable() {
		$css = wp_get_global_stylesheet();

		foreach ( Artifact_Theme_Files::json()['settings']['color']['palette'] as $color ) {
			$this->assertStringContainsString( "--wp--preset--color--{$color['slug']}: {$color['color']}", $css );
		}
		foreach ( Artifact_Theme_Files::json()['settings']['typography']['fontSizes'] as $size ) {
			$this->assertStringContainsString( "--wp--preset--font-size--{$size['slug']}: {$size['size']}", $css );
		}
		foreach ( Artifact_Theme_Files::json()['settings']['spacing']['spacingSizes'] as $space ) {
			$this->assertStringContainsString( "--wp--preset--spacing--{$space['slug']}: {$space['size']}", $css );
		}
		$this->assertStringContainsString( '--wp--preset--font-family--poppins: Poppins, sans-serif', $css );
	}

	public function test_the_page_is_black_with_grey_poppins_text() {
		$css = wp_get_global_stylesheet();

		$this->assertStringContainsString( 'background-color: var(--wp--preset--color--main-bg)', $css );
		$this->assertStringContainsString( 'color: var(--wp--preset--color--text-color)', $css );
		$this->assertStringContainsString( 'font-family: var(--wp--preset--font-family--poppins)', $css );
		$this->assertStringContainsString( 'font-size: var(--wp--preset--font-size--medium-paragraph)', $css );
	}

	public function test_headings_and_buttons_use_the_documented_tokens() {
		$css = wp_get_global_stylesheet();

		$this->assertStringContainsString( 'font-size: var(--wp--preset--font-size--heading-01)', $css );
		$this->assertStringContainsString( 'color: var(--wp--preset--color--heading-color)', $css );
		$this->assertStringContainsString( 'background-color: var(--wp--preset--color--primary)', $css );
		$this->assertStringContainsString( 'color: var(--wp--preset--color--link-color)', $css );
	}

	public function test_theme_fonts_resolve_to_four_bundled_woff2_faces() {
		// One font family, so the resolver returns a single list of faces.
		$fonts = WP_Font_Face_Resolver::get_fonts_from_theme_json();

		$this->assertCount( 1, $fonts );
		$this->assertCount( 4, $fonts[0] );

		foreach ( $fonts[0] as $face ) {
			$this->assertSame( 'Poppins', $face['font-family'] );
			$this->assertSame( 'normal', $face['font-style'] );
			$this->assertCount( 1, $face['src'] );
			$this->assertStringStartsWith( get_template_directory_uri() . '/assets/fonts/', $face['src'][0] );
			$this->assertFileExists( get_theme_file_path( 'assets/fonts/' . basename( $face['src'][0] ) ) );
		}
	}

	public function test_fonts_are_printed_in_the_head_without_any_remote_font_host() {
		ob_start();
		wp_print_font_faces();
		$output = ob_get_clean();

		$this->assertStringContainsString( '@font-face', $output );
		$this->assertStringContainsString( 'Poppins', $output );
		$this->assertStringContainsString( '/assets/fonts/Poppins-Regular.woff2', $output );
		$this->assertStringNotContainsString( 'googleapis', $output );
		$this->assertStringNotContainsString( 'gstatic', $output );
	}

	public function test_the_rounded_button_variation_is_defined_by_the_json_partial() {
		$variations = WP_Theme_JSON_Resolver::get_style_variations( 'block' );

		$this->assertCount( 1, $variations );
		$this->assertSame( 'rounded', $variations[0]['slug'] );
		$this->assertSame( array( 'core/button' ), $variations[0]['blockTypes'] );
		$this->assertSame( '12px', $variations[0]['styles']['border']['radius'] );
	}

	public function test_the_theme_offers_no_global_style_variations() {
		$this->assertSame( array(), WP_Theme_JSON_Resolver::get_style_variations( 'theme' ) );
	}

	/**
	 * Paths present in the expected array that are missing or different in the
	 * resolved one. WordPress silently drops invalid properties, so this is how
	 * a typo in theme.json shows up.
	 *
	 * @param array  $expected Decoded theme.json section.
	 * @param array  $actual   Section as resolved by WordPress.
	 * @param string $path     Path prefix for messages.
	 * @param array  $skip     Keys to skip at any depth.
	 * @return string[]
	 */
	private function dropped_paths( array $expected, array $actual, $path, array $skip ) {
		$dropped = array();
		foreach ( $expected as $key => $value ) {
			if ( in_array( $key, $skip, true ) ) {
				continue;
			}
			if ( ! array_key_exists( $key, $actual ) ) {
				$dropped[] = "{$path}.{$key}";
			} elseif ( is_array( $value ) && is_array( $actual[ $key ] ) && ! array_is_list( $value ) ) {
				$dropped = array_merge( $dropped, $this->dropped_paths( $value, $actual[ $key ], "{$path}.{$key}", $skip ) );
			} elseif ( $value !== $actual[ $key ] ) {
				$dropped[] = "{$path}.{$key}";
			}
		}
		return $dropped;
	}
}
