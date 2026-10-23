<?php
/**
 * Tests that WordPress loads the theme correctly.
 *
 * @package Artifact
 */

class ThemeSetupTest extends Artifact_Test_Case {

	public function test_artifact_is_the_active_block_theme() {
		$this->assertSame( 'artifact', get_stylesheet() );
		$this->assertSame( 'artifact', get_template() );
		$this->assertTrue( wp_is_block_theme() );
	}

	public function test_wordpress_reads_the_theme_without_errors() {
		$theme = wp_get_theme( 'artifact' );

		$this->assertTrue( $theme->exists() );
		$this->assertFalse( $theme->errors(), 'WP_Theme reported errors' );
		$this->assertSame( 'Artifact', $theme->get( 'Name' ) );
		$this->assertSame( 'artifact', $theme->get( 'TextDomain' ) );
		$this->assertSame( '/languages', $theme->get( 'DomainPath' ) );
		$this->assertSame( '6.7', $theme->get( 'RequiresWP' ) );
		$this->assertSame( '7.4', $theme->get( 'RequiresPHP' ) );
		$this->assertTrue( $theme->is_block_theme() );
	}

	public function test_theme_declares_itself_compatible_with_this_wordpress_and_php() {
		$theme = wp_get_theme( 'artifact' );

		$this->assertTrue( is_wp_version_compatible( $theme->get( 'RequiresWP' ) ) );
		$this->assertTrue( is_php_version_compatible( $theme->get( 'RequiresPHP' ) ) );
	}

	public function test_functions_php_registers_the_setup_hook() {
		$this->assertTrue( function_exists( 'artifact_setup' ) );
		$this->assertSame( 10, has_action( 'after_setup_theme', 'artifact_setup' ) );
	}

	public function test_setup_registers_the_theme_languages_folder_as_the_text_domain_path() {
		global $wp_textdomain_registry;

		artifact_setup();

		$this->assertSame(
			trailingslashit( get_template_directory() . '/languages' ),
			$wp_textdomain_registry->get( 'artifact', 'de_DE' )
		);
	}

	public function test_a_translation_file_in_the_languages_folder_is_used() {
		$locale  = 'xx_ARTIFACT';
		$mo_file = get_template_directory() . '/languages/' . $locale . '.mo';

		// A minimal valid .mo catalogue with one entry: "Home" => "Startseite".
		$original    = 'Home';
		$translation = 'Startseite';
		$mo          = pack( 'V*', 0x950412de, 0, 1, 28, 28 + 8, 0, 28 + 16 )
			. pack( 'V*', strlen( $original ), 28 + 16 )
			. pack( 'V*', strlen( $translation ), 28 + 16 + strlen( $original ) + 1 )
			. $original . "\0" . $translation . "\0";
		file_put_contents( $mo_file, $mo ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		$this->assertFileExists( $mo_file );

		try {
			$force_locale = static function () use ( $locale ) {
				return $locale;
			};
			add_filter( 'locale', $force_locale );
			unload_textdomain( 'artifact', true );
			artifact_setup();

			$this->assertSame( 'Startseite', __( 'Home', 'artifact' ) );
			$this->assertSame( 'About', __( 'About', 'artifact' ), 'Untranslated strings fall back to the source text' );
		} finally {
			remove_filter( 'locale', $force_locale );
			unlink( $mo_file ); // phpcs:ignore WordPress.WP.AlternativeFunctions
			unload_textdomain( 'artifact', true );
		}
	}

	public function test_the_only_block_style_comes_from_the_json_partial() {
		// Registered lazily, the first time global styles are computed.
		WP_Theme_JSON_Resolver::clean_cached_data();
		wp_get_global_stylesheet();

		$registry = WP_Block_Styles_Registry::get_instance();

		$this->assertTrue( $registry->is_registered( 'core/button', 'rounded' ), 'styles/blocks/button-rounded.json should register the Rounded button style' );
		$this->assertSame( array( 'rounded' ), array_keys( $registry->get_registered_styles_for_block( 'core/button' ) ) );
	}

	public function test_core_provides_the_theme_supports_so_the_theme_adds_none() {
		$this->assertTrue( current_theme_supports( 'editor-styles' ) );
		$this->assertTrue( current_theme_supports( 'post-thumbnails' ) );
		$this->assertTrue( current_theme_supports( 'responsive-embeds' ) );
	}
}
