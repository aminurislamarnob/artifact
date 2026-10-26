// @ts-check
const { test, expect } = require( './utils/test' );
const { AUTH_FILE } = require( './utils/fixtures' );
const { wp, wpEval } = require( './utils/wp-cli' );

/**
 * The patterns are hand-written block markup. WordPress only validates that
 * markup in the browser, so a pattern can render fine on the front end and still
 * show "This block contains unexpected or invalid content" in the editor (a
 * misspelled wrapper class, a wrong tag, a missing element). These specs open
 * every pattern in the block editor and ask it. Class names that come from block
 * supports (colours, font sizes) are re-derived by the editor, so a typo in a
 * preset slug is caught by the PHPUnit PresetUsageTest instead.
 */
test.use( { storageState: AUTH_FILE, watchProblems: false } );

/** @type {Record<string, number>} Page id by pattern slug. */
let patternPages = {};

test.beforeAll( () => {
	const output = wpEval( `
		$pages = array();
		foreach ( glob( get_template_directory() . '/patterns/*.php' ) as $file ) {
			$source = file_get_contents( $file );
			if ( ! preg_match( '/Slug:\\s*(\\S+)/', $source, $slug ) ) {
				continue;
			}
			ob_start();
			include $file;
			$content = ob_get_clean();
			$pages[ $slug[1] ] = wp_insert_post( wp_slash( array(
				'post_type'    => 'page',
				'post_status'  => 'draft',
				'post_title'   => 'Artifact E2E pattern: ' . $slug[1],
				'post_content' => $content,
			) ) );
		}
		echo wp_json_encode( $pages );
	` );
	patternPages = JSON.parse( output.slice( output.indexOf( '{' ) ) );
} );

test.afterAll( () => {
	const ids = Object.values( patternPages );
	if ( ids.length ) {
		wp( [ 'post', 'delete', ...ids.map( String ), '--force' ] );
	}
} );

/**
 * Wait for the block editor, close the welcome guide, and report every block
 * that failed validation.
 *
 * @param {import('@playwright/test').Page} page Page showing an editor.
 * @return {Promise<{total:number,invalid:string[]}>} Block counts.
 */
async function invalidBlocks( page ) {
	await page.waitForFunction(
		() =>
			// @ts-ignore
			window.wp?.data?.select( 'core/block-editor' )?.getBlocks().length > 0
	);
	return page.evaluate( () => {
		// @ts-ignore
		const { select } = window.wp.data;
		const invalid = [];
		let total = 0;
		const walk = ( blocks ) => {
			for ( const block of blocks ) {
				total++;
				if ( ! block.isValid || block.name === 'core/freeform' || block.name === 'core/missing' ) {
					invalid.push( `${ block.name } (${ block.clientId })` );
				}
				walk( block.innerBlocks );
			}
		};
		walk( select( 'core/block-editor' ).getBlocks() );
		return { total, invalid };
	} );
}

test.describe( 'Patterns in the block editor', () => {
	const slugs = [
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
		'artifact/contact-info',
		'artifact/page-contact',
		'artifact/header',
		'artifact/footer',
		'artifact/hidden-404',
		'artifact/hidden-no-results',
		'artifact/hidden-blog-heading',
		'artifact/hidden-archive-heading',
		'artifact/hidden-more-articles-heading',
		'artifact/hidden-search',
	];

	for ( const slug of slugs ) {
		test( `${ slug } contains only valid blocks`, async ( { page } ) => {
			expect( patternPages[ slug ], `page created for ${ slug }` ).toBeTruthy();

			await page.goto( `/wp-admin/post.php?post=${ patternPages[ slug ] }&action=edit` );
			// Keep the welcome guide from covering the canvas.
			await page.evaluate( () =>
				// @ts-ignore
				window.wp.data.dispatch( 'core/preferences' ).set( 'core/edit-post', 'welcomeGuide', false )
			);

			const { total, invalid } = await invalidBlocks( page );

			expect( total ).toBeGreaterThan( 0 );
			expect( invalid, `invalid blocks in ${ slug }` ).toEqual( [] );
		} );
	}
} );

test.describe( 'Site Editor', () => {
	test( 'the front page template opens with every block valid', async ( {
		page,
	} ) => {
		await page.goto(
			'/wp-admin/site-editor.php?p=%2Fwp_template%2Fartifact%2F%2Ffront-page&canvas=edit'
		);
		await page.evaluate( () =>
			// @ts-ignore
			window.wp.data.dispatch( 'core/preferences' ).set( 'core/edit-site', 'welcomeGuide', false )
		);

		const { total, invalid } = await invalidBlocks( page );
		expect( total ).toBeGreaterThan( 20 );
		expect( invalid ).toEqual( [] );
	} );

	test( 'the theme palette, Poppins and the Rounded button style are offered to editors', async ( {
		page,
	} ) => {
		await page.goto( '/wp-admin/site-editor.php?canvas=edit' );
		await page.waitForFunction( () =>
			// @ts-ignore
			Boolean( window.wp?.apiFetch && window.wp?.data?.select( 'core/blocks' )?.getBlockStyles )
		);

		const result = await page.evaluate( async () => {
			// @ts-ignore
			const { apiFetch, data } = window.wp;
			const globalStyles = await apiFetch( {
				path: '/wp/v2/global-styles/themes/artifact',
			} );
			return {
				colors: globalStyles.settings.color.palette.theme.map( ( c ) => c.slug ),
				fontFamilies: globalStyles.settings.typography.fontFamilies.theme.map( ( f ) => f.slug ),
				defaultPalette: globalStyles.settings.color.defaultPalette,
				buttonStyles: data.select( 'core/blocks' ).getBlockStyles( 'core/button' ).map( ( style ) => style.name ),
			};
		} );

		expect( result.colors ).toEqual(
			expect.arrayContaining( [ 'primary', 'main-bg', 'text-color', 'heading-color' ] )
		);
		expect( result.fontFamilies ).toEqual( [ 'poppins' ] );
		expect( result.defaultPalette ).toBe( false );
		expect( result.buttonStyles ).toContain( 'rounded' );
	} );
} );
