// @ts-check
const AxeBuilder = require( '@axe-core/playwright' ).default;
const { test, expect } = require( './utils/test' );

/**
 * The Services list page: a page built from the artifact/page-services
 * starter pattern with the Page No Title template, as in Figma node
 * 9153:182157.
 */
test.describe( 'Services page', () => {
	test.beforeEach( async ( { page, fixtures } ) => {
		await page.goto( fixtures.services.url );
	} );

	test( 'has one banner, one main, one contentinfo and the hero heading as its only h1', async ( {
		page,
	} ) => {
		await expect( page.getByRole( 'banner' ) ).toHaveCount( 1 );
		await expect( page.getByRole( 'main' ) ).toHaveCount( 1 );
		await expect( page.getByRole( 'contentinfo' ) ).toHaveCount( 1 );

		const h1 = page.getByRole( 'heading', { level: 1 } );
		await expect( h1 ).toHaveCount( 1 );
		await expect( h1 ).toContainText( 'We build bridges' );
	} );

	test( 'labels the hero with the page title, as a paragraph rather than a heading', async ( {
		page,
		fixtures,
	} ) => {
		const label = page.locator( 'main .artifact-page-hero .wp-block-post-title' );

		await expect( label ).toHaveText( fixtures.services.title );
		expect( await label.evaluate( ( node ) => node.tagName ) ).toBe( 'P' );
	} );

	test( 'lists nine services, then the work process and the call to action', async ( {
		page,
	} ) => {
		const main = page.locator( 'main' );

		await expect( main.locator( '.artifact-service-card' ) ).toHaveCount( 9 );
		await expect( main.getByRole( 'heading', { level: 3, name: 'Page Speed Optimization' } ) ).toBeVisible();
		await expect( main.getByRole( 'heading', { level: 2, name: 'How we work' } ) ).toBeVisible();
		await expect( main.locator( '.artifact-cta-box' ) ).toBeVisible();
	} );

	test( 'shows the cards three to a row on desktop', async ( { page } ) => {
		await page.setViewportSize( { width: 1440, height: 900 } );
		const tops = await page
			.locator( '.artifact-service-card' )
			.evaluateAll( ( cards ) => cards.map( ( card ) => Math.round( card.getBoundingClientRect().top ) ) );

		expect( new Set( tops.slice( 0, 3 ) ).size, 'first row shares one top edge' ).toBe( 1 );
		expect( tops[ 3 ], 'fourth card starts a new row' ).toBeGreaterThan( tops[ 0 ] );
	} );

	test( 'keeps the card and heading sizes from the design, not the blog article styles', async ( {
		page,
	} ) => {
		await page.setViewportSize( { width: 1600, height: 900 } );
		const card = page.locator( '.artifact-service-card' ).first();

		// Figma: 370 x 316 cards, a 64px icon tile flush with the title group.
		expect( ( await card.boundingBox() ).height ).toBeLessThanOrEqual( 340 );
		await expect( card.locator( '.artifact-service-icon' ) ).toHaveCSS( 'margin-top', '0px' );
		await expect( card.locator( 'h3' ) ).toHaveCSS( 'margin-top', '0px' );
		await expect( page.locator( '.artifact-page-hero h1' ) ).toHaveCSS( 'line-height', '64px' );
		expect( ( await page.locator( '.artifact-page-hero h1' ).boundingBox() ).height ).toBeLessThanOrEqual( 200 );
	} );

	test( 'stacks the cards in one column on a phone', async ( { page } ) => {
		await page.setViewportSize( { width: 375, height: 812 } );
		const lefts = await page
			.locator( '.artifact-service-card' )
			.evaluateAll( ( cards ) => cards.map( ( card ) => Math.round( card.getBoundingClientRect().left ) ) );

		expect( new Set( lefts ).size ).toBe( 1 );
		expect(
			await page.evaluate( () => document.documentElement.scrollWidth <= window.innerWidth ),
			'nothing spills sideways'
		).toBe( true );
	} );

	test( 'gives every Learn More link a name that says which service it is about', async ( {
		page,
	} ) => {
		const links = page.locator( 'main .artifact-service-link' );
		await expect( links ).toHaveCount( 9 );

		const names = [];
		for ( const link of await links.all() ) {
			await expect( link ).toHaveAccessibleName( /^Learn More about \S/ );
			names.push( await link.evaluate( ( node ) => node.textContent ) );
		}
		expect( new Set( names ).size ).toBe( 9 );
		await expect( links.first() ).toHaveText( /Learn More/ );
		await expect( links.first().locator( '.screen-reader-text' ) ).not.toBeInViewport();
	} );

	test( 'marks its own link in the header as the current page, in the primary colour', async ( {
		page,
	} ) => {
		const nav = page.locator( 'header' ).getByRole( 'navigation', { name: 'Primary menu' } );
		const current = nav.getByRole( 'link', { name: 'Services', exact: true } );

		await expect( current ).toHaveAttribute( 'aria-current', 'page' );
		const primary = await page
			.locator( 'header .wp-block-button__link' )
			.evaluate( ( node ) => getComputedStyle( node ).backgroundColor );
		await expect( current ).toHaveCSS( 'color', primary );
		await expect( nav.getByRole( 'link', { name: 'About', exact: true } ) ).not.toHaveAttribute( 'aria-current', 'page' );
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
