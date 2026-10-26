<?php
/**
 * Tests complete rendered pages: document structure, accessibility basics and
 * the "nothing remote, nothing scripted by the theme" rules.
 *
 * @package Artifact
 */

class PageRenderTest extends Artifact_Test_Case {

	/**
	 * Post id used by the single-post cases.
	 *
	 * @var int
	 */
	private static $post_id;

	/**
	 * Create a post to render.
	 *
	 * @param WP_UnitTest_Factory $factory Factory.
	 */
	public static function wpSetUpBeforeClass( $factory ) {
		self::$post_id = $factory->post->create( array( 'post_title' => 'Render Post' ) );
	}

	/**
	 * Pages worth checking for structure.
	 *
	 * @return array<string,array{0:string}>
	 */
	public static function pages() {
		return array(
			'front page'     => array( '/' ),
			'single post'    => array( '/?p=%post%' ),
			'search results' => array( '/?s=Render' ),
			'empty search'   => array( '/?s=zzzz-no-such-thing' ),
			'404'            => array( '/?p=999999' ),
		);
	}

	/**
	 * Render a page from one of the `pages()` URLs.
	 *
	 * @param string $url URL that may contain %post%.
	 * @return string HTML document.
	 */
	private function page( $url ) {
		return $this->render_page( str_replace( '%post%', (string) self::$post_id, $url ) );
	}

	/**
	 * @dataProvider pages
	 *
	 * @param string $url URL.
	 */
	public function test_document_has_the_basics( $url ) {
		$html  = $this->page( $url );
		$xpath = $this->xpath( $html );

		$this->assertStringStartsWith( '<!DOCTYPE html>', ltrim( $html ) );
		$this->assertSame( 'en-US', $xpath->query( '/html/@lang' )->item( 0 )->nodeValue );
		$this->assertSame( 1, $xpath->query( '//meta[@name="viewport"]' )->length );
		$this->assertSame( 1, $xpath->query( '/html/head/title' )->length );
		$this->assertNotSame( '', trim( $xpath->query( '/html/head/title' )->item( 0 )->textContent ) );
	}

	/**
	 * @dataProvider pages
	 *
	 * @param string $url URL.
	 */
	public function test_each_page_has_one_header_one_main_and_one_footer_landmark( $url ) {
		$xpath = $this->xpath( $this->page( $url ) );

		$this->assertSame( 1, $xpath->query( '//header' )->length, 'banner landmark' );
		$this->assertSame( 1, $xpath->query( '//main' )->length, 'main landmark' );
		$this->assertSame( 1, $xpath->query( '//footer' )->length, 'contentinfo landmark' );
	}

	/**
	 * @dataProvider pages
	 *
	 * @param string $url URL.
	 */
	public function test_skip_link_is_first_and_targets_the_main_landmark( $url ) {
		$xpath = $this->xpath( $this->page( $url ) );

		$skip = $xpath->query( '//a[contains(@class,"skip-link")]' );
		$this->assertSame( 1, $skip->length, 'Expected a skip link' );
		$this->assertSame( '#wp--skip-link--target', $skip->item( 0 )->getAttribute( 'href' ) );
		$this->assertSame( 'wp--skip-link--target', $xpath->query( '//main' )->item( 0 )->getAttribute( 'id' ) );
		$this->assertNotSame( '', trim( $skip->item( 0 )->textContent ) );
		$this->assertSame( 0, $xpath->query( '//a[contains(@class,"skip-link")]/preceding::a' )->length, 'The skip link must be the first link in the page' );
	}

	/**
	 * @dataProvider pages
	 *
	 * @param string $url URL.
	 */
	public function test_each_page_has_exactly_one_h1_and_no_skipped_heading_levels( $url ) {
		$xpath = $this->xpath( $this->page( $url ) );

		$this->assertSame( 1, $xpath->query( '//main//h1' )->length, 'one h1 inside main' );
		$this->assertSame( 1, $xpath->query( '//h1' )->length, 'one h1 on the page' );

		// WordPress prints the comment form title as an h3 regardless of the
		// surrounding structure, so it is not the theme's to fix here.
		$previous = 0;
		foreach ( $xpath->query( '//*[self::h1 or self::h2 or self::h3 or self::h4 or self::h5 or self::h6][not(@id="reply-title")]' ) as $heading ) {
			$level = (int) substr( $heading->nodeName, 1 );
			$this->assertLessThanOrEqual( $previous + 1, $level, "Heading jumps from h{$previous} to h{$level}: " . trim( $heading->textContent ) );
			$previous = $level;
		}
	}

	/**
	 * @dataProvider pages
	 *
	 * @param string $url URL.
	 */
	public function test_ids_are_unique_and_images_have_alt_attributes( $url ) {
		$xpath = $this->xpath( $this->page( $url ) );

		$seen = array();
		foreach ( $xpath->query( '//@id' ) as $id ) {
			$this->assertArrayNotHasKey( $id->nodeValue, $seen, "Duplicate id {$id->nodeValue}" );
			$seen[ $id->nodeValue ] = true;
		}
		$this->assertSame( 0, $xpath->query( '//img[not(@alt)]' )->length, 'Every image needs an alt attribute' );
	}

	/**
	 * @dataProvider pages
	 *
	 * @param string $url URL.
	 */
	public function test_every_navigation_landmark_has_a_meaningful_label( $url ) {
		$xpath = $this->xpath( $this->page( $url ) );

		$navs = $xpath->query( '//nav' );
		$this->assertGreaterThanOrEqual( 2, $navs->length );
		foreach ( $navs as $nav ) {
			$label = trim( $nav->getAttribute( 'aria-label' ) );
			$this->assertMatchesRegularExpression( '/[A-Za-z]{3,}/', $label, "A <nav> has no readable aria-label (got '{$label}')" );
		}
	}

	public function test_navigation_labels_are_unique_so_screen_readers_can_tell_landmarks_apart() {
		$xpath  = $this->xpath( $this->page( '/' ) );
		$labels = array();
		foreach ( $xpath->query( '//nav' ) as $nav ) {
			$labels[] = trim( $nav->getAttribute( 'aria-label' ) );
		}

		$this->assertSame( $labels, array_values( array_unique( $labels ) ) );
	}

	public function test_mobile_menu_toggle_is_a_labelled_button() {
		$xpath = $this->xpath( $this->page( '/' ) );

		$open  = $xpath->query( '//button[contains(@class,"wp-block-navigation__responsive-container-open")]' );
		$close = $xpath->query( '//button[contains(@class,"wp-block-navigation__responsive-container-close")]' );

		$this->assertSame( 1, $open->length );
		$this->assertSame( 'Open menu', $open->item( 0 )->getAttribute( 'aria-label' ) );
		$this->assertSame( 'Close menu', $close->item( 0 )->getAttribute( 'aria-label' ) );
	}

	/**
	 * @dataProvider pages
	 *
	 * @param string $url URL.
	 */
	public function test_page_loads_no_stylesheets_scripts_or_images_from_other_hosts( $url ) {
		$xpath = $this->xpath( $this->page( $url ) );
		$host  = wp_parse_url( home_url(), PHP_URL_HOST );

		$references = $xpath->query( '//link[@rel="stylesheet"]/@href|//script/@src|//img/@src|//source/@src|//iframe/@src' );
		foreach ( $references as $reference ) {
			$reference_host = wp_parse_url( $reference->nodeValue, PHP_URL_HOST );
			$this->assertTrue( null === $reference_host || $host === $reference_host, "Remote asset: {$reference->nodeValue}" );
		}
	}

	public function test_theme_enqueues_no_scripts_of_its_own() {
		$html = $this->page( '/' );

		$this->assertStringNotContainsString( '/themes/artifact/assets/js', $html );
		$this->assertDoesNotMatchRegularExpression( '#<script[^>]+src=["\'][^"\']*/themes/artifact/#', $html );
		$this->assertDoesNotMatchRegularExpression( '#<link[^>]+href=["\'][^"\']*/themes/artifact/style\.css#', $html, 'style.css is a header only and should not need loading' );
	}

	public function test_head_declares_the_self_hosted_fonts() {
		$html = $this->page( '/' );

		$this->assertStringContainsString( '/themes/artifact/assets/fonts/Poppins-Regular.woff2', $html );
		$this->assertStringContainsString( '/themes/artifact/assets/fonts/Poppins-Bold.woff2', $html );
		$this->assertStringNotContainsString( 'fonts.googleapis.com', $html );
		$this->assertStringNotContainsString( 'fonts.gstatic.com', $html );
	}

	public function test_front_page_renders_every_homepage_section_in_order() {
		$html = $this->page( '/' );

		$expected = array(
			'Creating',                // Hero.
			'Our latest',              // Latest articles.
		);
		$offset   = 0;
		foreach ( $expected as $needle ) {
			$position = strpos( $html, $needle, $offset );
			$this->assertNotFalse( $position, "Homepage is missing '{$needle}'" );
			$offset = $position;
		}

		$xpath = $this->xpath( $html );
		$this->assertSame(
			count( Artifact_Theme_Files::HOMEPAGE_PATTERNS ),
			$xpath->query( '//main/div[contains(@class,"alignfull")]|//main/*[contains(@class,"alignfull")]' )->length,
			'One full-width section per homepage pattern'
		);
	}

	public function test_front_page_hero_cta_and_header_cta_are_links_not_empty_buttons() {
		$xpath = $this->xpath( $this->page( '/' ) );

		foreach ( $xpath->query( '//a[contains(@class,"wp-block-button__link")]' ) as $button ) {
			$this->assertNotSame( '', trim( $button->textContent ), 'Button without a label' );
			$this->assertTrue( $button->hasAttribute( 'href' ) );
		}
	}

	public function test_single_post_template_shows_the_post_and_a_comment_form() {
		$xpath = $this->xpath( $this->page( '/?p=%post%' ) );

		$this->assertSame( 'Render Post', trim( $xpath->query( '//main//h1' )->item( 0 )->textContent ) );
		$this->assertSame( 1, $xpath->query( '//main//form[@id="commentform"]' )->length );
	}

	public function test_single_post_labels_its_tags() {
		$post = self::factory()->post->create( array( 'post_title' => 'Tagged Post', 'tags_input' => array( 'Branding', 'Design' ) ) );
		$xpath = $this->xpath( $this->render_page( '/?p=' . $post ) );
		$tags  = $xpath->query( '//main//div[contains(@class,"artifact-tag-list")]' )->item( 0 );

		$this->assertNotNull( $tags );
		$this->assertSame( 'Tags:', trim( $xpath->query( './/span[contains(@class,"wp-block-post-terms__prefix")]', $tags )->item( 0 )->textContent ) );
		$this->assertSame( 2, $xpath->query( './/a[@rel="tag"]', $tags )->length );
	}

	public function test_single_post_without_tags_shows_no_tag_label() {
		$xpath = $this->xpath( $this->page( '/?p=%post%' ) );

		$this->assertSame( 0, $xpath->query( '//main//*[contains(@class,"wp-block-post-terms__prefix")]' )->length );
	}

	public function test_404_page_returns_the_404_template_with_a_search_form() {
		$xpath = $this->xpath( $this->page( '/?p=999999' ) );

		$this->assertSame( 'Page not found', trim( $xpath->query( '//main//h1' )->item( 0 )->textContent ) );
		$this->assertSame( 1, $xpath->query( '//main//form[@role="search"]' )->length );
	}
}
