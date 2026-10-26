<?php
/**
 * Tests the block patterns as WordPress registers and renders them.
 *
 * @package Artifact
 */

class PatternsTest extends Artifact_Test_Case {

	/**
	 * Registry of block patterns.
	 *
	 * @return WP_Block_Patterns_Registry
	 */
	private function registry() {
		return WP_Block_Patterns_Registry::get_instance();
	}

	public function test_every_pattern_file_is_registered_by_wordpress() {
		foreach ( Artifact_Theme_Files::pattern_slugs() as $slug ) {
			$this->assertTrue( $this->registry()->is_registered( $slug ), "{$slug} was not registered" );
		}
	}

	public function test_registered_patterns_carry_their_header_metadata() {
		$hero = $this->registry()->get_registered( 'artifact/hero' );

		$this->assertSame( 'Hero', $hero['title'] );
		$this->assertSame( array( 'banner', 'featured' ), $hero['categories'] );
		$this->assertNotEmpty( $hero['description'] );
		$this->assertNotEmpty( $hero['content'] );
	}

	/**
	 * @dataProvider hidden_patterns
	 *
	 * @param string $slug Pattern slug.
	 */
	public function test_template_only_patterns_are_hidden_from_the_inserter( $slug ) {
		$pattern = $this->registry()->get_registered( $slug );

		$this->assertFalse( $pattern['inserter'] );
	}

	public static function hidden_patterns() {
		return array_map(
			static function ( $slug ) {
				return array( $slug );
			},
			Artifact_Theme_Files::HIDDEN_PATTERNS
		);
	}

	public function test_homepage_patterns_are_visible_in_the_inserter() {
		foreach ( Artifact_Theme_Files::HOMEPAGE_PATTERNS as $slug ) {
			$pattern = $this->registry()->get_registered( $slug );

			$this->assertNotFalse( $pattern['inserter'] ?? true, "{$slug} should be insertable" );
		}
	}

	public function test_header_and_footer_patterns_are_offered_for_the_template_part_areas() {
		$this->assertSame( array( 'core/template-part/header' ), $this->registry()->get_registered( 'artifact/header' )['blockTypes'] );
		$this->assertSame( array( 'core/template-part/footer' ), $this->registry()->get_registered( 'artifact/footer' )['blockTypes'] );
	}

	public function test_every_pattern_category_exists() {
		$categories = WP_Block_Pattern_Categories_Registry::get_instance();

		foreach ( Artifact_Theme_Files::pattern_slugs() as $slug ) {
			foreach ( $this->registry()->get_registered( $slug )['categories'] ?? array() as $category ) {
				$this->assertTrue( $categories->is_registered( $category ), "{$slug} uses unregistered category '{$category}'" );
			}
		}
	}

	/**
	 * @dataProvider all_patterns
	 *
	 * @param string $slug Pattern slug.
	 */
	public function test_pattern_parses_into_known_blocks_only( $slug ) {
		$blocks = $this->flatten_blocks( parse_blocks( $this->pattern_markup( $slug ) ) );
		$types  = WP_Block_Type_Registry::get_instance();

		$this->assertNotEmpty( $blocks );
		foreach ( $blocks as $block ) {
			if ( null === $block['blockName'] ) {
				$this->assertSame( '', trim( $block['innerHTML'] ), "{$slug} has loose HTML outside any block (it would become a Classic block)" );
				continue;
			}
			$this->assertTrue( $types->is_registered( $block['blockName'] ), "{$slug} uses unknown block {$block['blockName']}" );
		}
	}

	/**
	 * @dataProvider all_patterns
	 *
	 * @param string $slug Pattern slug.
	 */
	public function test_pattern_renders_without_remote_urls( $slug ) {
		$html = do_blocks( $this->pattern_markup( $slug ) );

		$this->assertNotSame( '', trim( $html ) );
		// Social profile links lead to the networks themselves.
		$html = preg_replace( '#<ul class="wp-block-social-links.*?</ul>#s', '', $html );
		preg_match_all( '#\b(?:src|href|srcset|action)=["\']([^"\']+)["\']#i', $html, $matches );
		foreach ( $matches[1] as $url ) {
			if ( preg_match( '#^(\#|mailto:|tel:)#', $url ) ) {
				continue;
			}
			$this->assertSame(
				wp_parse_url( home_url() )['host'],
				wp_parse_url( $url )['host'] ?? wp_parse_url( home_url() )['host'],
				"{$slug} renders a link or asset on another host: {$url}"
			);
		}
	}

	public function test_pattern_images_are_bundled_and_have_alt_text() {
		$checked = 0;

		foreach ( Artifact_Theme_Files::pattern_slugs() as $slug ) {
			$xpath = $this->xpath( do_blocks( $this->pattern_markup( $slug ) ) );

			foreach ( $xpath->query( '//img' ) as $image ) {
				$src = $image->getAttribute( 'src' );
				$this->assertStringStartsWith( get_template_directory_uri() . '/assets/images/', $src, "{$slug}: images must be bundled" );
				$this->assertFileExists( get_theme_file_path( 'assets/images/' . basename( $src ) ) );
				$this->assertTrue( $image->hasAttribute( 'alt' ), "{$slug}: {$src} needs an alt attribute" );
				// Icons and ornaments may be decorative (alt=""); photos and artwork need a description.
				if ( ! preg_match( '/^(icon-.*|hero-sparkle|hero-vector-pink)\.svg$/', basename( $src ) ) ) {
					$this->assertNotSame( '', trim( $image->getAttribute( 'alt' ) ), "{$slug}: {$src} needs alt text" );
				}
				++$checked;
			}
		}

		// Hero, about, team portraits and testimonials.
		$this->assertGreaterThanOrEqual( 8, $checked );
	}

	/**
	 * @dataProvider all_patterns
	 *
	 * @param string $slug Pattern slug.
	 */
	public function test_pattern_strings_all_go_through_the_artifact_text_domain( $slug ) {
		$translated = array();
		add_filter(
			'gettext',
			static function ( $text, $original, $domain ) use ( &$translated ) {
				if ( 'artifact' === $domain ) {
					$translated[] = $original;
					return '[[' . $text . ']]';
				}
				return $text;
			},
			10,
			3
		);

		$markup = $this->pattern_markup( $slug );

		// Static patterns have no PHP strings to translate.
		$this->assertSame( count( $translated ) > 0, false !== strpos( $markup, '[[' ), "{$slug}: translated strings should reach the output" );
		$this->assertSame(
			count( Artifact_Theme_Files::translation_calls( Artifact_Theme_Files::read( 'patterns/' . substr( $slug, 9 ) . '.php' ) ) ),
			count( $translated ),
			"{$slug}: every translation call in the source should run"
		);
	}

	/**
	 * Translated text is attacker-controlled in principle (a .po file), so
	 * output must stay escaped whatever the string contains.
	 *
	 * @dataProvider all_patterns
	 *
	 * @param string $slug Pattern slug.
	 */
	public function test_pattern_output_stays_safe_when_a_translation_contains_markup( $slug ) {
		add_filter(
			'gettext',
			static function ( $text, $original, $domain ) {
				return 'artifact' === $domain ? '"><script>alert(1)</script><img src=x onerror=alert(2)>' : $text;
			},
			10,
			3
		);

		$xpath = $this->xpath( do_blocks( $this->pattern_markup( $slug ) ) );

		$this->assertSame( 0, $xpath->query( '//script' )->length, "{$slug} printed an injected script element" );
		$this->assertSame( 0, $xpath->query( '//@*[starts-with(name(), "on")]' )->length, "{$slug} printed an injected event handler" );
	}

	public static function all_patterns() {
		$cases = array();
		foreach ( Artifact_Theme_Files::pattern_slugs() as $slug ) {
			$cases[ $slug ] = array( $slug );
		}
		return $cases;
	}

	public function test_hero_renders_the_only_h1_with_a_call_to_action() {
		$xpath = $this->xpath( do_blocks( $this->pattern_markup( 'artifact/hero' ) ) );

		$this->assertSame( 1, $xpath->query( '//h1' )->length );
		$this->assertStringContainsString( 'Software', $xpath->query( '//h1' )->item( 0 )->textContent );
		$this->assertSame( 1, $xpath->query( '//a[contains(@class,"wp-block-button__link")]' )->length );
		$this->assertSame( 1, $xpath->query( '//div[contains(@class,"is-style-rounded")]' )->length );
	}

	public function test_header_brands_the_site_with_its_own_title_linking_home_and_has_a_navigation() {
		$xpath = $this->xpath( do_blocks( $this->pattern_markup( 'artifact/header' ) ) );

		$title_link = $xpath->query( '//*[contains(@class,"artifact-site-brand")]//*[contains(@class,"wp-block-site-title")]/a' )->item( 0 );
		$this->assertNotNull( $title_link, 'Without a site logo the header shows the site title' );
		$this->assertSame( get_bloginfo( 'name' ), trim( $title_link->textContent ) );
		$this->assertSame( home_url( '/' ), trailingslashit( $title_link->getAttribute( 'href' ) ) );
		$this->assertSame( 0, $xpath->query( '//img[contains(@src,"/themes/")]' )->length, 'The header carries no theme brand image' );
		$this->assertSame( 1, $xpath->query( '//nav[contains(@class,"wp-block-navigation")]' )->length );
	}

	public function test_header_and_footer_calls_to_action_open_an_email() {
		foreach ( array( 'artifact/header', 'artifact/footer' ) as $slug ) {
			$xpath = $this->xpath( do_blocks( $this->pattern_markup( $slug ) ) );
			$cta   = $xpath->query( '//a[normalize-space()="Start A Project" or normalize-space()="Start a Project"]' )->item( 0 );

			$this->assertNotNull( $cta, "{$slug} has a Start a Project link" );
			$this->assertStringStartsWith( 'mailto:', $cta->getAttribute( 'href' ) );
		}
	}

	public function test_footer_offers_the_feed_instead_of_a_form_that_goes_nowhere() {
		$xpath = $this->xpath( do_blocks( $this->pattern_markup( 'artifact/footer' ) ) );

		$this->assertSame( 0, $xpath->query( '//form' )->length );
		$this->assertSame( get_feed_link(), $xpath->query( '//a[normalize-space()="Subscribe via RSS"]' )->item( 0 )->getAttribute( 'href' ) );
	}

	public function test_footer_links_the_privacy_policy_only_when_the_site_has_one() {
		$privacy = function () {
			$xpath = $this->xpath( do_blocks( $this->pattern_markup( 'artifact/footer' ) ) );
			return $xpath->query( '//a[normalize-space()="Privacy Policy"]' );
		};

		update_option( 'wp_page_for_privacy_policy', 0 );
		$this->assertSame( 0, $privacy()->length );

		$page = self::factory()->post->create( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Privacy Policy' ) );
		update_option( 'wp_page_for_privacy_policy', $page );
		$this->assertSame( get_permalink( $page ), $privacy()->item( 0 )->getAttribute( 'href' ) );
	}

	public function test_footer_social_links_point_somewhere_real() {
		$xpath = $this->xpath( do_blocks( $this->pattern_markup( 'artifact/footer' ) ) );

		foreach ( $xpath->query( '//ul[contains(@class,"wp-block-social-links")]//a' ) as $link ) {
			$this->assertStringStartsWith( 'https://', $link->getAttribute( 'href' ) );
		}
	}

	public function test_footer_contact_links_are_valid_mailto_and_tel_urls() {
		$xpath = $this->xpath( do_blocks( $this->pattern_markup( 'artifact/footer' ) ) );

		$mail = $xpath->query( '//a[starts-with(@href,"mailto:")]' )->item( 0 );
		$tel  = $xpath->query( '//a[starts-with(@href,"tel:")]' )->item( 0 );

		$this->assertNotNull( $mail );
		$this->assertNotFalse( is_email( substr( $mail->getAttribute( 'href' ), strlen( 'mailto:' ) ) ) );
		$this->assertNotNull( $tel );
		$this->assertMatchesRegularExpression( '/^tel:\+?\d+$/', $tel->getAttribute( 'href' ), 'tel: link must contain digits only' );
	}

	public function test_footer_social_links_are_labelled() {
		$xpath = $this->xpath( do_blocks( $this->pattern_markup( 'artifact/footer' ) ) );

		$links = $xpath->query( '//ul[contains(@class,"wp-block-social-links")]//a' );
		$this->assertGreaterThanOrEqual( 4, $links->length );
		foreach ( $links as $link ) {
			$this->assertNotSame( '', trim( $link->textContent ), 'Icon-only links need an accessible name' );
		}
	}

	public function test_the_404_pattern_offers_a_search_form() {
		$xpath = $this->xpath( do_blocks( $this->pattern_markup( 'artifact/hidden-404' ) ) );

		$this->assertSame( 1, $xpath->query( '//h1' )->length );
		$this->assertSame( 1, $xpath->query( '//form[@role="search"]' )->length );
	}
}
