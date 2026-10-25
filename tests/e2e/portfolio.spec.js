// @ts-check
const AxeBuilder = require( '@axe-core/playwright' ).default;
const { test, expect } = require( './utils/test' );

const axeViolations = async ( page ) => {
	await page.evaluate( () => document.fonts.ready );
	const results = await new AxeBuilder( { page } )
		.withTags( [ 'wcag2a', 'wcag2aa', 'wcag21a', 'wcag21aa' ] )
		.exclude( '[class*="wc-block-"]' )
		.exclude( '#herd-ai-host' )
		.disableRules( [ 'document-title' ] )
		.analyze();

	return results.violations
		.filter(
			( violation ) =>
				violation.id !== 'color-contrast' ||
				violation.nodes.some( ( node ) => ! node.html.includes( 'wp-block-button__' ) )
		)
		.map( ( violation ) => ( {
			rule: violation.id,
			targets: violation.nodes.slice( 0, 3 ).map( ( node ) => node.target.join( ' ' ) ),
		} ) );
};

const boxes = ( page, selector ) =>
	page.locator( selector ).evaluateAll( ( nodes ) =>
		nodes.map( ( node ) => {
			const box = node.getBoundingClientRect();
			return { x: Math.round( box.left ), y: Math.round( box.top ), w: Math.round( box.width ) };
		} )
	);

/**
 * The Portfolio page: a page built from the artifact/page-portfolio starter
 * pattern with the Page No Title template, as in Figma node 4300:79702.
 */
test.describe( 'Portfolio page', () => {
	test.beforeEach( async ( { page, fixtures } ) => {
		await page.goto( fixtures.portfolio.url );
	} );

	test( 'labels the hero with the page title and has one h1', async ( { page, fixtures } ) => {
		await expect( page.getByRole( 'heading', { level: 1 } ) ).toHaveCount( 1 );
		await expect( page.locator( 'main .artifact-page-hero .wp-block-post-title' ) ).toHaveText( fixtures.portfolio.title );
		await expect( page.locator( 'main .artifact-cta-box' ) ).toBeVisible();
	} );

	test( 'shows eight projects, each named by its own link with a described photo', async ( {
		page,
	} ) => {
		const cards = page.locator( 'main .artifact-portfolio-card' );
		await expect( cards ).toHaveCount( 8 );

		const names = await cards.locator( 'h2 a' ).allInnerTexts();
		expect( names ).toHaveLength( 8 );
		expect( new Set( names ).size, 'every link name is unique' ).toBe( 8 );
		expect( names[ 0 ] ).toBe( 'Real estate website for BuildX' );

		for ( const card of await cards.all() ) {
			await expect( card.getByRole( 'link' ) ).toHaveCount( 1 );
			await expect( card.locator( 'img' ).first() ).toHaveAttribute( 'alt', /\w{4,}/ );
			await expect( card.locator( '.artifact-portfolio-arrow img' ) ).toHaveAttribute( 'alt', '' );
		}
	} );

	test( 'marks its own link in the header as the current page', async ( { page } ) => {
		const nav = page.locator( 'header' ).getByRole( 'navigation', { name: 'Primary menu' } );

		await expect( nav.getByRole( 'link', { name: 'Portfolio', exact: true } ) ).toHaveAttribute( 'aria-current', 'page' );
	} );

	test( 'alternates wide and narrow cards on desktop, as in the design', async ( { page } ) => {
		await page.setViewportSize( { width: 1600, height: 900 } );
		const cards = await boxes( page, 'main .artifact-portfolio-card' );

		// Figma: rows of 670 + 469 with a 30px gap, mirrored on every other
		// row. Its rows are 1169px wide and the theme's are 1170px, so allow 1px.
		[ 670, 469, 469, 670, 670, 469, 469, 670 ].forEach( ( width, index ) => {
			expect( Math.abs( cards[ index ].w - width ), `card ${ index + 1 } width` ).toBeLessThanOrEqual( 1 );
		} );
		expect( cards[ 1 ].y ).toBe( cards[ 0 ].y );
		expect( Math.abs( cards[ 1 ].x - ( cards[ 0 ].x + cards[ 0 ].w ) - 30 ) ).toBeLessThanOrEqual( 1 );
		expect( cards[ 2 ].y ).toBeGreaterThan( cards[ 0 ].y );

		const photos = await page.locator( 'main .artifact-portfolio-card > .wp-block-image img' ).evaluateAll( ( nodes ) =>
			nodes.map( ( node ) => Math.round( node.getBoundingClientRect().height ) )
		);
		expect( new Set( photos ) ).toEqual( new Set( [ 340 ] ) );
	} );

	test( 'highlights the title and nudges the arrow together, by mouse or keyboard', async ( { page } ) => {
		const card = page.locator( 'main .artifact-portfolio-card' ).first();
		const link = card.locator( 'h2 a' );
		const arrow = card.locator( '.artifact-portfolio-arrow img' );
		await expect( link ).toHaveCSS( 'color', 'rgb(255, 255, 255)' );
		await expect( arrow ).toHaveCSS( 'transform', 'none' );

		await card.locator( 'img' ).first().hover();
		await expect( link ).toHaveCSS( 'color', 'rgb(255, 72, 1)' );
		await expect( arrow ).not.toHaveCSS( 'transform', 'none' );

		await page.mouse.move( 0, 0 );
		await link.focus();
		await expect( link ).toHaveCSS( 'color', 'rgb(255, 72, 1)' );
		await expect( arrow ).not.toHaveCSS( 'transform', 'none' );
	} );

	test( 'shows two equal columns on a tablet and one on a phone', async ( { page } ) => {
		await page.setViewportSize( { width: 900, height: 900 } );
		const tablet = await boxes( page, 'main .artifact-portfolio-card' );
		expect( new Set( tablet.map( ( card ) => card.w ) ).size ).toBe( 1 );
		expect( new Set( tablet.map( ( card ) => card.x ) ).size ).toBe( 2 );

		await page.setViewportSize( { width: 375, height: 812 } );
		const phone = await boxes( page, 'main .artifact-portfolio-card' );
		expect( new Set( phone.map( ( card ) => card.x ) ).size ).toBe( 1 );
		expect(
			await page.evaluate( () => document.documentElement.scrollWidth <= window.innerWidth )
		).toBe( true );
	} );

	test( 'has no accessibility violations beyond the known button contrast gap', async ( {
		page,
	} ) => {
		expect( await axeViolations( page ) ).toEqual( [] );
	} );
} );

/**
 * A single project: the Portfolio Details template around a body built from
 * artifact/page-portfolio-details, as in Figma node 4307:127482.
 */
test.describe( 'Portfolio details page', () => {
	test.beforeEach( async ( { page, fixtures } ) => {
		await page.goto( fixtures.project.url );
	} );

	test( 'uses the page title as its only h1, beside the project facts', async ( {
		page,
		fixtures,
	} ) => {
		const h1 = page.getByRole( 'heading', { level: 1 } );
		await expect( h1 ).toHaveCount( 1 );
		await expect( h1 ).toHaveText( fixtures.project.title );

		const facts = page.locator( 'main .artifact-project-facts' );
		for ( const label of [ 'Category', 'Client', 'Date', 'Location' ] ) {
			await expect( facts.getByText( label, { exact: true } ) ).toBeVisible();
		}
	} );

	test( 'shows every section of the design in order, then the call to action', async ( {
		page,
	} ) => {
		const headings = await page.locator( 'main h2' ).allInnerTexts();
		const expected = [ 'About project', 'Challenges', 'Solutions', 'Our process', 'Result driven' ];
		expect( headings.slice( 0, expected.length ) ).toEqual( expected );

		await expect( page.locator( 'main .artifact-portfolio-details ul' ) ).toHaveCount( 4 );
		const photos = page.locator( 'main .artifact-portfolio-details img' );
		await expect( photos ).toHaveCount( 3 );
		for ( const photo of await photos.all() ) {
			await expect( photo ).toHaveAttribute( 'alt', /\w{4,}/ );
		}
		await expect( page.locator( 'main .artifact-cta-box' ) ).toBeVisible();
	} );

	test( 'lays out the hero and the photo as in the design on desktop', async ( { page } ) => {
		await page.setViewportSize( { width: 1600, height: 900 } );

		const title = await page.locator( 'main h1' ).boundingBox();
		const facts = await page.locator( 'main .artifact-project-facts' ).boundingBox();
		expect( facts.x ).toBeGreaterThan( title.x + title.width );

		// Two facts per row, 273px apart as in Figma.
		const pairs = await boxes( page, 'main .artifact-project-facts > *' );
		expect( pairs[ 1 ].y ).toBe( pairs[ 0 ].y );
		expect( pairs[ 2 ].y ).toBeGreaterThan( pairs[ 0 ].y );
		expect( pairs[ 1 ].x - pairs[ 0 ].x ).toBe( 273 );

		// Figma: 1170 x 447 photo, 30px headings on a 42px line.
		const photo = await page.locator( 'main .artifact-portfolio-details img' ).first().boundingBox();
		expect( Math.round( photo.width ) ).toBe( 1170 );
		expect( Math.round( photo.height ) ).toBe( 447 );
		await expect( page.locator( 'main .artifact-portfolio-details h2' ).first() ).toHaveCSS( 'font-size', '30px' );
		await expect( page.locator( 'main .artifact-portfolio-details h2' ).first() ).toHaveCSS( 'line-height', '42px' );
	} );

	test( 'stacks the hero and the two-column sections on a phone without sideways scrolling', async ( {
		page,
	} ) => {
		await page.setViewportSize( { width: 375, height: 812 } );
		const columns = await boxes( page, 'main .artifact-portfolio-details .wp-block-column' );

		expect( new Set( columns.map( ( column ) => column.x ) ).size ).toBe( 1 );
		expect(
			await page.evaluate( () => document.documentElement.scrollWidth <= window.innerWidth )
		).toBe( true );
	} );

	test( 'has no accessibility violations beyond the known button contrast gap', async ( {
		page,
	} ) => {
		expect( await axeViolations( page ) ).toEqual( [] );
	} );
} );
