<?php
/**
 * Read-only access to the theme's source files, for tests.
 *
 * Plain PHP only (no WordPress functions), so the unit suite can use it
 * without loading WordPress.
 *
 * @package Artifact
 */

/**
 * Reads and parses the files that make up the theme.
 */
final class Artifact_Theme_Files {

	/**
	 * Patterns that exist only to be referenced by templates and parts.
	 */
	const HIDDEN_PATTERNS = array( 'artifact/header', 'artifact/footer', 'artifact/hidden-404', 'artifact/hidden-no-results', 'artifact/hidden-service-hero' );

	/**
	 * Homepage section patterns, in page order.
	 */
	const HOMEPAGE_PATTERNS = array(
		'artifact/hero',
		'artifact/features',
		'artifact/about',
		'artifact/fun-facts',
		'artifact/services',
		'artifact/work-process',
		'artifact/team',
		'artifact/testimonials',
		'artifact/latest-articles',
		'artifact/project-cta',
	);

	/**
	 * Sections of the Services starter page, in page order.
	 */
	const SERVICES_PAGE_PATTERNS = array(
		'artifact/page-hero',
		'artifact/services-grid',
		'artifact/work-process',
		'artifact/project-cta',
	);

	/**
	 * Sections of the About starter page, in page order.
	 */
	const ABOUT_PAGE_PATTERNS = array(
		'artifact/page-hero',
		'artifact/brands',
		'artifact/values',
		'artifact/fun-facts-grid',
		'artifact/team',
		'artifact/project-cta',
	);

	/**
	 * Sections of the Portfolio starter page, in page order.
	 */
	const PORTFOLIO_PAGE_PATTERNS = array(
		'artifact/page-hero',
		'artifact/portfolio-grid',
		'artifact/project-cta',
	);

	/**
	 * Full-page starter patterns offered when a page is created.
	 */
	const PAGE_PATTERNS = array( 'artifact/page-services', 'artifact/page-service-details', 'artifact/page-about', 'artifact/page-portfolio', 'artifact/page-portfolio-details' );

	/**
	 * Theme root, without a trailing slash.
	 *
	 * @return string
	 */
	public static function root() {
		return ARTIFACT_THEME_DIR;
	}

	/**
	 * Absolute path for a theme-relative path.
	 *
	 * @param string $relative Path inside the theme.
	 * @return string
	 */
	public static function path( $relative ) {
		return self::root() . '/' . ltrim( $relative, '/' );
	}

	/**
	 * Raw contents of a theme file.
	 *
	 * @param string $relative Path inside the theme.
	 * @return string
	 */
	public static function read( $relative ) {
		$contents = file_get_contents( self::path( $relative ) );
		if ( false === $contents ) {
			throw new RuntimeException( "Cannot read {$relative}" );
		}
		return $contents;
	}

	/**
	 * Decoded theme.json (or another JSON file in the theme).
	 *
	 * @param string $relative Path inside the theme.
	 * @return array
	 */
	public static function json( $relative = 'theme.json' ) {
		$data = json_decode( self::read( $relative ), true );
		if ( ! is_array( $data ) ) {
			throw new RuntimeException( "{$relative} is not valid JSON: " . json_last_error_msg() );
		}
		return $data;
	}

	/**
	 * Theme-relative paths of files directly inside a directory.
	 *
	 * @param string $dir       Directory inside the theme.
	 * @param string $extension File extension without the dot.
	 * @return string[] Sorted relative paths.
	 */
	public static function files_in( $dir, $extension ) {
		$found = glob( self::path( $dir ) . '/*.' . $extension );
		$found = $found ? $found : array();
		sort( $found );
		return array_map(
			static function ( $file ) use ( $dir ) {
				return $dir . '/' . basename( $file );
			},
			$found
		);
	}

	/**
	 * Every shipped source file: pattern PHP, templates, parts and functions.php.
	 *
	 * Used by rules that apply to all markup the theme outputs.
	 *
	 * @return string[] Theme-relative paths.
	 */
	public static function markup_files() {
		return array_merge(
			array( 'functions.php' ),
			self::files_in( 'patterns', 'php' ),
			self::files_in( 'templates', 'html' ),
			self::files_in( 'parts', 'html' )
		);
	}

	/**
	 * Entries that do not ship, read from .distignore.
	 *
	 * @return string[] Names, one per line of .distignore.
	 */
	public static function distignored() {
		$lines = file( self::path( '.distignore' ), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
		return array_values(
			array_filter(
				array_map( 'trim', $lines ? $lines : array() ),
				static function ( $line ) {
					return '' !== $line && 0 !== strpos( $line, '#' );
				}
			)
		);
	}

	/**
	 * Every file the theme ships: everything not excluded by .distignore.
	 *
	 * @return string[] Theme-relative paths.
	 */
	public static function all_files() {
		$skip     = array_merge( self::distignored(), array( '.git' ) );
		$root     = self::root();
		$iterator = new RecursiveIteratorIterator(
			new RecursiveCallbackFilterIterator(
				new RecursiveDirectoryIterator( $root, FilesystemIterator::SKIP_DOTS ),
				static function ( $current ) use ( $skip, $root ) {
					$relative = substr( $current->getPathname(), strlen( $root ) + 1 );
					return ! in_array( $relative, $skip, true );
				}
			)
		);

		$files = array();
		foreach ( $iterator as $file ) {
			if ( $file->isFile() ) {
				$files[] = substr( $file->getPathname(), strlen( $root ) + 1 );
			}
		}
		sort( $files );
		return $files;
	}

	/**
	 * Parse the comment header of a pattern file.
	 *
	 * @param string $relative Pattern path such as patterns/hero.php.
	 * @return array<string,string> Header fields keyed by lower-case name.
	 */
	public static function pattern_headers( $relative ) {
		$source = self::read( $relative );
		$headers = array();
		if ( ! preg_match( '/\/\*\*(.*?)\*\//s', $source, $comment ) ) {
			return $headers;
		}
		foreach ( explode( "\n", $comment[1] ) as $line ) {
			if ( preg_match( '/^\s*\*\s*([A-Za-z ]+):\s*(.+?)\s*$/', $line, $match ) ) {
				$headers[ strtolower( $match[1] ) ] = $match[2];
			}
		}
		if ( preg_match( '/@package\s+(\S+)/', $comment[1], $package ) ) {
			$headers['package'] = $package[1];
		}
		return $headers;
	}

	/**
	 * Slugs of every pattern file, e.g. artifact/hero.
	 *
	 * @return string[]
	 */
	public static function pattern_slugs() {
		$slugs = array();
		foreach ( self::files_in( 'patterns', 'php' ) as $file ) {
			$headers = self::pattern_headers( $file );
			if ( isset( $headers['slug'] ) ) {
				$slugs[] = $headers['slug'];
			}
		}
		return $slugs;
	}

	/**
	 * Slugs of the patterns a template or part references, in order.
	 *
	 * @param string $relative Template or part path.
	 * @return string[]
	 */
	public static function referenced_patterns( $relative ) {
		preg_match_all( '/<!-- wp:pattern \{"slug":"([^"]+)"\}/', self::read( $relative ), $matches );
		return $matches[1];
	}

	/**
	 * Preset slugs defined in theme.json, grouped by category.
	 *
	 * Categories use the names from CSS variables and `var:preset|…` values:
	 * color, font-size, font-family, spacing.
	 *
	 * @return array<string,string[]>
	 */
	public static function defined_presets() {
		$settings = self::json()['settings'];
		return array(
			'color'       => self::slugs( $settings['color']['palette'] ),
			'font-size'   => self::slugs( $settings['typography']['fontSizes'] ),
			'font-family' => self::slugs( $settings['typography']['fontFamilies'] ),
			'spacing'     => self::slugs( $settings['spacing']['spacingSizes'] ),
		);
	}

	/**
	 * Slugs from a theme.json preset list.
	 *
	 * @param array $presets List of preset definitions.
	 * @return string[]
	 */
	private static function slugs( array $presets ) {
		return array_column( $presets, 'slug' );
	}

	/**
	 * Every preset slug a piece of markup or CSS uses.
	 *
	 * Reads block comment attributes ("backgroundColor":"main-bg"), preset
	 * classes (has-main-bg-background-color), `var:preset|…|slug` values and
	 * `var(--wp--preset--…--slug)` references.
	 *
	 * @param string $source File contents.
	 * @return array<int,array{0:string,1:string}> Pairs of [category, slug].
	 */
	public static function used_presets( $source ) {
		$used = array();

		// Block comment attributes that hold a bare preset slug.
		$attributes = array(
			'backgroundColor'        => 'color',
			'textColor'              => 'color',
			'borderColor'            => 'color',
			'iconColor'              => 'color',
			'iconBackgroundColor'    => 'color',
			'overlayBackgroundColor' => 'color',
			'overlayTextColor'       => 'color',
			'fontSize'               => 'font-size',
			'fontFamily'             => 'font-family',
		);
		foreach ( $attributes as $attribute => $category ) {
			if ( preg_match_all( '/"' . $attribute . '":"([a-z0-9-]+)"/', $source, $matches ) ) {
				foreach ( $matches[1] as $slug ) {
					$used[] = array( $category, $slug );
				}
			}
		}

		// `var:preset|category|slug` and `var(--wp--preset--category--slug)`.
		if ( preg_match_all( '/var:preset\|([a-z-]+)\|([a-z0-9-]+)/', $source, $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $match ) {
				$used[] = array( $match[1], $match[2] );
			}
		}
		if ( preg_match_all( '/var\(--wp--preset--([a-z-]+)--([a-z0-9-]+)\)/', $source, $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $match ) {
				$used[] = array( $match[1], $match[2] );
			}
		}

		// Preset utility classes. Classes such as `has-text-color` and
		// `has-icon-color` are core state classes, not presets.
		if ( preg_match_all( '/\bhas-([a-z0-9-]+?)-(background-color|border-color|font-size|color)(?![a-z0-9-])/', $source, $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $match ) {
				$class = $match[0];
				if ( in_array( $class, array( 'has-text-color', 'has-link-color', 'has-icon-color', 'has-border-color', 'has-custom-font-size' ), true ) ) {
					continue;
				}
				$used[] = array( 'font-size' === $match[2] ? 'font-size' : 'color', $match[1] );
			}
		}

		return $used;
	}

	/**
	 * Translation calls in a PHP file that use a literal string.
	 *
	 * @param string $source PHP source.
	 * @return array<int,array{function:string,text:string,domain:?string}>
	 */
	public static function translation_calls( $source ) {
		$calls   = array();
		$pattern = '/\b(esc_html__|esc_attr__|esc_html_e|esc_attr_e|__|_e)\(\s*\'((?:[^\'\\\\]|\\\\.)*)\'\s*(?:,\s*\'([^\']*)\'\s*)?\)/';
		if ( preg_match_all( $pattern, $source, $matches, PREG_SET_ORDER ) ) {
			foreach ( $matches as $match ) {
				$calls[] = array(
					'function' => $match[1],
					'text'     => stripcslashes( str_replace( "\\'", "'", $match[2] ) ),
					'domain'   => isset( $match[3] ) ? $match[3] : null,
				);
			}
		}
		return $calls;
	}

	/**
	 * Message ids declared in a .pot file.
	 *
	 * @param string $relative Path to the POT file.
	 * @return string[]
	 */
	public static function pot_msgids( $relative = 'languages/artifact.pot' ) {
		$ids     = array();
		$current = null;
		foreach ( explode( "\n", self::read( $relative ) ) as $line ) {
			if ( 0 === strpos( $line, 'msgid ' ) ) {
				$current = self::unquote_po( substr( $line, 6 ) );
			} elseif ( null !== $current && preg_match( '/^"(.*)"$/', $line ) ) {
				$current .= self::unquote_po( $line );
			} elseif ( null !== $current ) {
				$ids[]   = $current;
				$current = null;
			}
		}
		return $ids;
	}

	/**
	 * Decode one quoted PO string.
	 *
	 * @param string $quoted A string wrapped in double quotes.
	 * @return string
	 */
	private static function unquote_po( $quoted ) {
		$quoted = trim( $quoted );
		return stripcslashes( substr( $quoted, 1, -1 ) );
	}

	/**
	 * WCAG 2.x contrast ratio between two #rrggbb colours.
	 *
	 * @param string $foreground Hex colour.
	 * @param string $background Hex colour.
	 * @return float
	 */
	public static function contrast_ratio( $foreground, $background ) {
		$a = self::relative_luminance( $foreground );
		$b = self::relative_luminance( $background );
		return ( max( $a, $b ) + 0.05 ) / ( min( $a, $b ) + 0.05 );
	}

	/**
	 * Relative luminance of a #rrggbb colour.
	 *
	 * @param string $hex Hex colour.
	 * @return float
	 */
	private static function relative_luminance( $hex ) {
		$hex = ltrim( $hex, '#' );
		$rgb = array_map(
			static function ( $channel ) {
				$value = hexdec( $channel ) / 255;
				return $value <= 0.03928 ? $value / 12.92 : pow( ( $value + 0.055 ) / 1.055, 2.4 );
			},
			str_split( $hex, 2 )
		);
		return 0.2126 * $rgb[0] + 0.7152 * $rgb[1] + 0.0722 * $rgb[2];
	}
}
