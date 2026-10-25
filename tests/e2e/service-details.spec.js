// @ts-check
const AxeBuilder = require( '@axe-core/playwright' ).default;
const { test, expect } = require( './utils/test' );

/**
 * A single service page: the Service Details template around a body built
 * from artifact/page-service-details, as in Figma node 9153:182446.
 */
test.describe( 'Service details page', () => {
	test.beforeEach( async ( { page, fixtures } ) => {
		await page.goto( fixtures.service.url );
	} );

	test( 'uses the page title as its only h1, under the Service Details label', async ( {
		page,
		fixtures,
	} ) => {
		await expect( page.getByRole( 'main' ) ).toHaveCount( 1 );
		const h1 = page.getByRole( 'heading', { level: 1 } );
		await expect( h1 ).toHaveCount( 1 );
		await expect( h1 ).toHaveText( fixtures.service.title );
		await expect( page.locator( 'main .artifact-page-hero' ) ).toContainText( 'Service Details' );
	} );

	test( 'shows every section of the design in order, then the call to action', async ( {
		page,
	} ) => {
		const headings = await page.locator( 'main h2' ).allInnerTexts();
		const expected = [
			'How we approach it',
			'Service features',
			'Problems we solve',
			'What we deliver',
			'How you can start',
		];
		expect( headings.slice( 0, expected.length ) ).toEqual( expected );
		await expect( page.locator( 'main .artifact-service-list' ) ).toHaveCount( 4 );
		await expect( page.locator( 'main .artifact-cta-box' ) ).toBeVisible();
	} );

	test( 'shows three described photos', async ( { page } ) => {
		const photos = page.locator( 'main .artifact-service-details img' );
		await expect( photos ).toHaveCount( 3 );
		for ( const photo of await photos.all() ) {
			await expect( photo ).toHaveAttribute( 'alt', /\w{4,}/ );
		}
	} );

	test( 'keeps the design spacing instead of the blog article styles', async ( {
		page,
	} ) => {
		await page.setViewportSize( { width: 1600, height: 900 } );
		const photo = page.locator( 'main .artifact-service-details img' ).first();

		// Figma: 1170 x 447 photo, no border, 30px headings on a 42px line.
		const box = await photo.boundingBox();
		expect( Math.round( box.width ) ).toBe( 1170 );
		expect( Math.round( box.height ) ).toBe( 447 );
		await expect( photo ).toHaveCSS( 'border-top-width', '0px' );
		await expect( page.locator( 'main .artifact-service-details h2' ).first() ).toHaveCSS( 'font-size', '30px' );
		await expect( page.locator( 'main .artifact-service-details h2' ).first() ).toHaveCSS( 'line-height', '42px' );
	} );

	test( 'stacks the two-column sections on a phone without sideways scrolling', async ( {
		page,
	} ) => {
		await page.setViewportSize( { width: 375, height: 812 } );
		const columns = await page
			.locator( 'main .artifact-service-details .wp-block-column' )
			.evaluateAll( ( nodes ) => nodes.map( ( node ) => Math.round( node.getBoundingClientRect().left ) ) );

		expect( new Set( columns ).size ).toBe( 1 );
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
