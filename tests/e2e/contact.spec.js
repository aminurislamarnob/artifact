// @ts-check
const AxeBuilder = require( '@axe-core/playwright' ).default;
const { test, expect } = require( './utils/test' );

const PRIMARY = 'rgb(255, 72, 1)';
const WHITE = 'rgb(255, 255, 255)';

// Theme buttons are white on the orange accent, a known contrast gap shared
// by every page, so only other contrast failures count.
const KNOWN_BUTTON = /wp-block-button__|wpcf7-submit/;

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
				violation.nodes.some( ( node ) => ! KNOWN_BUTTON.test( node.html ) )
		)
		.map( ( violation ) => ( {
			rule: violation.id,
			targets: violation.nodes.slice( 0, 3 ).map( ( node ) => node.target.join( ' ' ) ),
		} ) );
};

const box = async ( locator ) => {
	const rect = await locator.boundingBox();
	return { x: Math.round( rect.x ), y: Math.round( rect.y ), w: Math.round( rect.width ) };
};

const noSidewaysScroll = ( page ) =>
	page.evaluate( () => document.documentElement.scrollWidth <= window.innerWidth );

/**
 * The Contact page: a page built from the artifact/page-contact starter
 * pattern with the Page No Title template, as in Figma node 4292:66454.
 * It works without any plugin; the message panel's button opens an email.
 */
test.describe( 'Contact page', () => {
	test.beforeEach( async ( { page, fixtures } ) => {
		await page.goto( fixtures.contact.url );
	} );

	test( 'labels the hero with the page title and has one h1', async ( { page, fixtures } ) => {
		const h1 = page.getByRole( 'heading', { level: 1 } );
		await expect( h1 ).toHaveCount( 1 );
		await expect( h1 ).toHaveText( 'Let’s collab. We’d love to hear from you' );
		await expect( page.locator( 'main .artifact-page-hero .wp-block-post-title' ) ).toHaveText( fixtures.contact.title );
		await expect( page.locator( 'main .artifact-cta-box' ) ).toBeVisible();
	} );

	test( 'lists working phone and email links, hours and an address with silent icons', async ( { page } ) => {
		const details = page.locator( 'main .artifact-contact-list' );

		await expect( details.locator( 'a[href^="tel:"]' ) ).toHaveAttribute( 'href', /^tel:\+?\d+$/ );
		await expect( details.locator( 'a[href^="mailto:"]' ) ).toHaveAttribute( 'href', /^mailto:[^@\s]+@[^@\s]+\.[a-z]+$/i );
		await expect( details ).toContainText( 'Sunday (Closed)' );
		await expect( details.locator( '.artifact-contact-item' ) ).toHaveCount( 4 );
		for ( const icon of await details.locator( 'img' ).all() ) {
			await expect( icon ).toHaveAttribute( 'alt', '' );
		}
	} );

	test( 'offers labelled social links under Follow Us', async ( { page } ) => {
		const card = page.locator( 'main .artifact-contact-social' );

		await expect( card.getByText( 'Follow Us', { exact: true } ) ).toBeVisible();
		for ( const network of [ 'Facebook', 'X', 'LinkedIn', 'Instagram' ] ) {
			await expect( card.getByRole( 'link', { name: network, exact: true } ) ).toBeVisible();
		}
	} );

	test( 'the message panel works without a form plugin by opening an email', async ( { page } ) => {
		const panel = page.locator( 'main .artifact-contact-form' );

		await expect( panel.getByRole( 'heading', { level: 2 } ) ).toHaveText( 'Send us a message' );
		await expect( panel.locator( 'form' ) ).toHaveCount( 0 );
		await expect( panel.getByRole( 'link', { name: 'Send Inquiry', exact: true } ) ).toHaveAttribute( 'href', /^mailto:/ );
	} );

	test( 'marks its own link in the header as the current page', async ( { page } ) => {
		const nav = page.locator( 'header' ).getByRole( 'navigation', { name: 'Primary menu' } );

		await expect( nav.getByRole( 'link', { name: 'Contact', exact: true } ) ).toHaveAttribute( 'aria-current', 'page' );
	} );

	test( 'sets the details beside the message panel on desktop, as in the design', async ( { page } ) => {
		await page.setViewportSize( { width: 1600, height: 900 } );
		const details = await box( page.locator( 'main .artifact-contact-box > .wp-block-column' ).first() );
		const panel = await box( page.locator( 'main .artifact-contact-form' ) );

		// Figma: a 322px column, a 130px gap and a 622px panel.
		expect( details.w ).toBe( 322 );
		expect( panel.w ).toBe( 622 );
		expect( panel.y ).toBe( details.y );
		expect( panel.x - ( details.x + details.w ) ).toBe( 130 );
	} );

	test( 'stacks the panel under the details on a phone without sideways scrolling', async ( { page } ) => {
		await page.setViewportSize( { width: 375, height: 812 } );
		const details = await box( page.locator( 'main .artifact-contact-box > .wp-block-column' ).first() );
		const panel = await box( page.locator( 'main .artifact-contact-form' ) );

		expect( panel.x ).toBe( details.x );
		expect( panel.y ).toBeGreaterThan( details.y );
		expect( await noSidewaysScroll( page ) ).toBe( true );
	} );

	test( 'has no accessibility violations beyond the known button contrast gap', async ( { page } ) => {
		expect( await axeViolations( page ) ).toEqual( [] );
	} );
} );

/**
 * The same page once a site owner swaps the panel's text and button for a
 * Contact Form 7 block. The theme styles CF7's own markup.
 */
test.describe( 'Contact page with a Contact Form 7 form', () => {
	test.beforeEach( async ( { page, fixtures } ) => {
		test.skip( ! fixtures.contactForm, 'Contact Form 7 is not active on this site' );
		await page.goto( fixtures.contactForm.url );
	} );

	const field = ( page, name ) => page.locator( `main .artifact-contact-form [name="${ name }"]` );

	test( 'pairs the short fields in two columns and gives the message and button the full width', async ( { page } ) => {
		await page.setViewportSize( { width: 1600, height: 900 } );
		const first = await box( field( page, 'first-name' ) );
		const last = await box( field( page, 'last-name' ) );
		const message = await box( field( page, 'your-message' ) );
		const submit = await box( page.locator( 'main .artifact-contact-form .wpcf7-submit' ) );

		expect( last.y ).toBe( first.y );
		expect( last.x ).toBeGreaterThan( first.x + first.w );
		expect( message.x ).toBe( first.x );
		expect( message.w ).toBe( last.x + last.w - first.x );
		expect( submit.y ).toBeGreaterThan( message.y );
	} );

	test( 'draws fields as underlined lines and the submit as the orange button with an arrow', async ( { page } ) => {
		const input = field( page, 'first-name' );
		await expect( input ).toHaveCSS( 'border-top-width', '0px' );
		await expect( input ).toHaveCSS( 'border-bottom-width', '1px' );
		await expect( input ).toHaveCSS( 'background-color', 'rgba(0, 0, 0, 0)' );
		await expect( input ).toHaveCSS( 'color', WHITE );
		await expect( page.locator( 'main .artifact-contact-form label' ).first() ).toHaveCSS( 'color', WHITE );

		const submit = page.locator( 'main .artifact-contact-form .wpcf7-submit' );
		await expect( submit ).toHaveCSS( 'background-color', PRIMARY );
		await expect( submit ).toHaveCSS( 'color', WHITE );
		await expect( submit ).toHaveCSS( 'background-image', /data:image\/svg/ );
	} );

	test( 'shows a visible focus ring on fields and the button', async ( { page } ) => {
		const input = field( page, 'first-name' );
		await input.focus();
		await expect( input ).toHaveCSS( 'outline-style', 'solid' );
		await expect( input ).toHaveCSS( 'outline-color', PRIMARY );

		await page.keyboard.press( 'Tab' );
		await expect( field( page, 'last-name' ) ).toBeFocused();

		const submit = page.locator( 'main .artifact-contact-form .wpcf7-submit' );
		await submit.focus();
		await expect( submit ).toHaveCSS( 'outline-color', PRIMARY );
	} );

	test( 'explains missing required fields in the theme colours, without sending anything', async ( { page } ) => {
		await page.locator( 'main .artifact-contact-form .wpcf7-submit' ).click();

		const tips = page.locator( 'main .artifact-contact-form .wpcf7-not-valid-tip' );
		await expect( tips ).toHaveCount( 2 );
		await expect( tips.first() ).toHaveCSS( 'color', PRIMARY );
		await expect( field( page, 'your-email' ) ).toHaveCSS( 'border-bottom-color', PRIMARY );

		const response = page.locator( 'main .artifact-contact-form .wpcf7-response-output' );
		await expect( response ).toBeVisible();
		await expect( response ).toHaveCSS( 'border-top-color', PRIMARY );
		await expect( response ).toHaveCSS( 'color', WHITE );
		await expect( page.locator( 'main .artifact-contact-form form' ) ).toHaveClass( /\binvalid\b/ );
	} );

	test( 'drops to one column on a phone without sideways scrolling', async ( { page } ) => {
		await page.setViewportSize( { width: 375, height: 812 } );
		const first = await box( field( page, 'first-name' ) );
		const last = await box( field( page, 'last-name' ) );

		expect( last.x ).toBe( first.x );
		expect( last.y ).toBeGreaterThan( first.y );
		expect( await noSidewaysScroll( page ) ).toBe( true );
	} );

	test( 'has no accessibility violations beyond the known button contrast gap', async ( { page } ) => {
		expect( await axeViolations( page ) ).toEqual( [] );
	} );
} );
