<?php
/**
 * Tests template and template part registration and URL-to-template routing.
 *
 * @package Artifact
 */

class TemplatesTest extends Artifact_Test_Case {

	/**
	 * Fixture ids, keyed by name.
	 *
	 * @var array<string,int>
	 */
	private static $ids = array();

	/**
	 * Create the content the routing tests navigate to.
	 *
	 * @param WP_UnitTest_Factory $factory Factory.
	 */
	public static function wpSetUpBeforeClass( $factory ) {
		self::$ids['category'] = $factory->category->create( array( 'name' => 'Engineering' ) );
		self::$ids['tag']      = $factory->tag->create( array( 'name' => 'Launch' ) );
		self::$ids['author']   = $factory->user->create( array( 'role' => 'author', 'user_login' => 'artifact-author' ) );
		self::$ids['post']     = $factory->post->create(
			array(
				'post_title'    => 'Routing Post',
				'post_name'     => 'routing-post',
				'post_content'  => '<!-- wp:paragraph --><p>Routing body.</p><!-- /wp:paragraph -->',
				'post_author'   => self::$ids['author'],
				'post_category' => array( self::$ids['category'] ),
				'tags_input'    => array( 'launch' ),
			)
		);
		self::$ids['page']     = $factory->post->create(
			array(
				'post_type'  => 'page',
				'post_title' => 'Routing Page',
				'post_name'  => 'routing-page',
			)
		);
	}

	public function test_every_template_is_registered_from_the_theme_files() {
		$templates = get_block_templates( array(), 'wp_template' );
		$slugs     = array();
		foreach ( $templates as $template ) {
			if ( 'artifact' === $template->theme && 'theme' === $template->source ) {
				$slugs[] = $template->slug;
			}
		}

		$this->assertEqualsCanonicalizing( array( 'index', 'front-page', 'page', 'page-no-title', 'page-service-details', 'page-portfolio-details', 'single', 'archive', 'search', '404' ), $slugs );
	}

	public function test_template_content_matches_the_template_files() {
		foreach ( array( 'index', 'front-page', 'page', 'page-no-title', 'page-service-details', 'page-portfolio-details', 'single', 'archive', 'search', '404' ) as $slug ) {
			$template = get_block_template( "artifact//{$slug}", 'wp_template' );

			$this->assertNotNull( $template, "{$slug} template missing" );
			$this->assertSame( 'theme', $template->source, "{$slug} should come from the theme file, not a user customisation" );
			// WordPress stamps template-part blocks with the theme slug on load.
			$this->assertSame(
				trim( Artifact_Theme_Files::read( "templates/{$slug}.html" ) ),
				trim( str_replace( ',"theme":"artifact"', '', $template->content ) )
			);
		}
	}

	public function test_header_and_footer_template_parts_use_the_registered_areas() {
		$header = get_block_template( 'artifact//header', 'wp_template_part' );
		$footer = get_block_template( 'artifact//footer', 'wp_template_part' );

		$this->assertSame( WP_TEMPLATE_PART_AREA_HEADER, $header->area );
		$this->assertSame( WP_TEMPLATE_PART_AREA_FOOTER, $footer->area );
		$this->assertStringContainsString( 'artifact/header', $header->content );
		$this->assertStringContainsString( 'artifact/footer', $footer->content );
	}

	public function test_there_are_no_template_parts_beyond_header_and_footer() {
		$slugs = array();
		foreach ( get_block_templates( array(), 'wp_template_part' ) as $part ) {
			if ( 'artifact' === $part->theme ) {
				$slugs[] = $part->slug;
			}
		}

		$this->assertEqualsCanonicalizing( array( 'header', 'footer' ), $slugs );
	}

	/**
	 * @dataProvider routes
	 *
	 * @param string $url      Relative URL.
	 * @param string $expected Template slug WordPress should choose.
	 */
	public function test_urls_resolve_to_the_expected_template( $url, $expected ) {
		$url = $this->fill_ids( $url );

		$this->assertSame( "artifact//{$expected}", $this->resolve_template_id( $url ), "{$url} routed to the wrong template" );
	}

	public static function routes() {
		return array(
			'front page'            => array( '/', 'front-page' ),
			'single post'           => array( '/?p={post}', 'single' ),
			'page'                  => array( '/?page_id={page}', 'page' ),
			'category archive'      => array( '/?cat={category}', 'archive' ),
			'tag archive'           => array( '/?tag=launch', 'archive' ),
			'author archive'        => array( '/?author={author}', 'archive' ),
			'date archive'          => array( '/?year=' . gmdate( 'Y' ), 'archive' ),
			'search with results'   => array( '/?s=Routing', 'search' ),
			'search without result' => array( '/?s=zzzz-no-such-thing', 'search' ),
			'not found'             => array( '/?p=999999', '404' ),
		);
	}

	public function test_the_posts_page_falls_back_to_index_when_a_static_front_page_is_set() {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', self::$ids['page'] );
		$blog = self::factory()->post->create( array( 'post_type' => 'page', 'post_title' => 'Journal' ) );
		update_option( 'page_for_posts', $blog );

		$this->assertSame( 'artifact//index', $this->resolve_template_id( get_permalink( $blog ) ) );
		$this->assertSame( 'artifact//front-page', $this->resolve_template_id( home_url( '/' ) ), 'front-page.html wins even with a static front page' );
	}

	/**
	 * @dataProvider rendered_content
	 *
	 * @param string $url      Relative URL.
	 * @param string $expected Text that must appear in the rendered template.
	 */
	public function test_templates_render_the_expected_content( $url, $expected ) {
		$html = $this->render_page( $this->fill_ids( $url ) );

		$this->assertStringContainsString( $expected, $html );
	}

	public static function rendered_content() {
		return array(
			'single shows title'         => array( '/?p={post}', 'Routing Post' ),
			'single shows body'          => array( '/?p={post}', 'Routing body.' ),
			'single shows comment form'  => array( '/?p={post}', 'wp-block-post-comments-form' ),
			'page shows title'           => array( '/?page_id={page}', 'Routing Page' ),
			'category archive title'     => array( '/?cat={category}', 'Engineering' ),
			'category lists its posts'   => array( '/?cat={category}', 'Routing Post' ),
			'search lists matches'       => array( '/?s=Routing', 'Routing Post' ),
			'search shows its query'     => array( '/?s=Routing', 'Search results for: ' ),
			'empty search says so'       => array( '/?s=zzzz-no-such-thing', 'No posts were found.' ),
			'404 headline'               => array( '/?p=999999', 'Page not found' ),
			'404 offers search'          => array( '/?p=999999', 'wp-block-search' ),
			'front page hero'            => array( '/', 'Software' ),
			'front page latest articles' => array( '/', 'Routing Post' ),
		);
	}

	/**
	 * Replace {name} placeholders with fixture ids.
	 *
	 * @param string $url URL with placeholders.
	 * @return string
	 */
	private function fill_ids( $url ) {
		foreach ( self::$ids as $name => $id ) {
			$url = str_replace( '{' . $name . '}', (string) $id, $url );
		}
		return $url;
	}
}
