// @ts-check
const AxeBuilder = require( '@axe-core/playwright' ).default;
const { test, expect } = require( './utils/test' );

/**
 * The About page: a page built from the artifact/page-about starter pattern
 * with the Page No Title template, as in Figma node 9146:115186.
 */
test.describe( 'About page', () => {
	test.beforeEach( async ( { page, fixtures } ) => {
		await page.goto( fixtures.about.url );
	} );

	test( 'labels the hero with the page title and has one h1', async ( { page, fixtures } ) => {
		await expect( page.getByRole( 'main' ) ).toHaveCount( 1 );
		const h1 = page.getByRole( 'heading', { level: 1 } );
		await expect( h1 ).toHaveCount( 1 );
		await expect( h1 ).toContainText( 'We build bridges' );
		await expect( page.locator( 'main .artifact-page-hero .wp-block-post-title' ) ).toHaveText( fixtures.about.title );
	} );

	test( 'shows every section of the design in order, then the call to action', async ( {
		page,
	} ) => {
		const main = page.locator( 'main' );

		await expect( main.locator( '.artifact-about-photo img' ) ).toHaveAttribute( 'alt', /\w{4,}/ );
		await expect( main.locator( '.artifact-brands p' ) ).toHaveCount( 6 );
		await expect( main.locator( '.artifact-values h3' ) ).toHaveText( [ 'Expertise', 'Communication', 'Reliability', 'Growth driven' ] );
		await expect( main.locator( '.artifact-fact' ) ).toHaveCount( 5 );
		await expect( main.locator( '.artifact-fact-photo img' ) ).toHaveAttribute( 'alt', /\w{4,}/ );
		await expect( main.locator( '.artifact-team-card' ) ).toHaveCount( 8 );
		await expect( main.locator( '.artifact-cta-box' ) ).toBeVisible();

		const headings = await main.locator( 'h2' ).allInnerTexts();
		expect( headings.slice( 0, 2 ).map( ( text ) => text.replace( /\s+/g, ' ' ) ) ).toEqual( [ 'Our values', 'Meet our expert team' ] );
	} );

	test( 'marks its own link in the header as the current page', async ( { page } ) => {
		const nav = page.locator( 'header' ).getByRole( 'navigation', { name: 'Primary menu' } );

		await expect( nav.getByRole( 'link', { name: 'About', exact: true } ) ).toHaveAttribute( 'aria-current', 'page' );
	} );

	test( 'lays out the figures as in the design on desktop', async ( { page } ) => {
		await page.setViewportSize( { width: 1600, height: 900 } );
		const boxes = await page
			.locator( '.artifact-fun-facts > *' )
			.evaluateAll( ( nodes ) => nodes.map( ( node ) => {
				const box = node.getBoundingClientRect();
				return { x: Math.round( box.left ), y: Math.round( box.top ), w: Math.round( box.width ), h: Math.round( box.height ) };
			} ) );

		// Figma: a 1170px grid of 270px tracks, 30px apart, in two rows of 268px.
		expect( boxes.map( ( box ) => box.w ) ).toEqual( [ 570, 270, 270, 270, 570, 270 ] );
		expect( new Set( boxes.slice( 0, 3 ).map( ( box ) => box.y ) ).size ).toBe( 1 );
		expect( boxes[ 3 ].y - boxes[ 0 ].y ).toBe( 298 );
		for ( const box of boxes ) {
			expect( box.h ).toBe( 268 );
		}

		// Two values per row beside the introduction.
		const values = await page
			.locator( '.artifact-values h3' )
			.evaluateAll( ( nodes ) => nodes.map( ( node ) => Math.round( node.getBoundingClientRect().top ) ) );
		expect( values[ 0 ] ).toBe( values[ 1 ] );
		expect( values[ 2 ] ).toBeGreaterThan( values[ 0 ] );
	} );

	test( 'stacks the figures in one column on a phone without sideways scrolling', async ( {
		page,
	} ) => {
		await page.setViewportSize( { width: 375, height: 812 } );
		const lefts = await page
			.locator( '.artifact-fun-facts > *' )
			.evaluateAll( ( nodes ) => nodes.map( ( node ) => Math.round( node.getBoundingClientRect().left ) ) );

		expect( new Set( lefts ).size ).toBe( 1 );
		expect(
			await page.evaluate( () => document.documentElement.scrollWidth <= window.innerWidth )
		).toBe( true );
	} );

	test( 'has no accessibility violations beyond the known button contrast gap', async ( {
		page,
	} ) => {
		await page.evaluate( () => document.fonts.ready );
		const results = await new AxeBuilder( { page } )
			.withTags( [ 'wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa' ] )
			.exclude( '[class*="wc-block-"]' )
			.exclude( '#herd-ai-host' )
			.disableRules( [ 'document-title' ] )
			.analyze();

		const unexpected = results.violations.filter(
			( violation ) =>
				violation.id !== 'color-contrast' ||
				violation.nodes.some( ( node ) => ! node.html.includes( 'wp-block-button__' ) )
		);
		expect(
			unexpected.map( ( violation ) => ( {
				rule: violation.id,
				targets: violation.nodes.slice( 0, 3 ).map( ( node ) => node.target.join( ' ' ) ),
			} ) )
		).toEqual( [] );
	} );
} );
