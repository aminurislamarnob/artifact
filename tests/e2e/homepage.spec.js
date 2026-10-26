// @ts-check
const { test, expect } = require( './utils/test' );

/**
 * The Homepage dark composition served by templates/front-page.html.
 */
test.describe( 'Homepage', () => {
	test.beforeEach( async ( { page } ) => {
		await page.goto( '/' );
	} );

	test( 'has a language, a document title element and a mobile viewport', async ( {
		page,
	} ) => {
		await expect( page.locator( 'html' ) ).toHaveAttribute( 'lang', /^[a-z]{2}/ );
		// The text depends on the site title setting, so only require the element.
		await expect( page.locator( 'head > title' ) ).toHaveCount( 1 );
		await expect(
			page.locator( 'meta[name="viewport"]' )
		).toHaveAttribute( 'content', /width=device-width/ );
	} );

	test( 'shows the hero with a single h1, supporting copy and a call to action', async ( {
		page,
	} ) => {
		const h1 = page.getByRole( 'heading', { level: 1 } );
		await expect( h1 ).toHaveCount( 1 );
		await expect( h1 ).toContainText( 'Creating' );
		await expect( h1 ).toContainText( 'Digital Excellence' );

		const hero = page.locator( 'main > .alignfull' ).first();
		await expect( hero.getByRole( 'img' ).first() ).toBeVisible();
		await expect( hero.getByRole( 'link', { name: /talk with us/i } ) ).toBeVisible();
	} );

	test( 'renders all ten sections, stacked in the designed order', async ( {
		page,
	} ) => {
		const sections = page.locator( 'main > .alignfull' );
		await expect( sections ).toHaveCount( 10 );

		const tops = [];
		for ( let i = 0; i < 10; i++ ) {
			const box = await sections.nth( i ).boundingBox();
			expect( box && box.height, `section ${ i + 1 } has height` ).toBeGreaterThan( 50 );
			tops.push( box.y );
		}
		expect( tops, 'sections are laid out top to bottom' ).toEqual(
			[ ...tops ].sort( ( a, b ) => a - b )
		);

		// One landmark heading per content section, in order.
		const headings = await page.locator( 'main h2' ).evaluateAll( ( nodes ) =>
			nodes.map( ( node ) => node.innerText.replace( /\s+/g, ' ' ).trim() )
		);
		const expected = [
			/accelerate your business growth/i,
			/digital services/i,
			/how we work/i,
			/expert team/i,
			/client stories/i,
			/latest\s*articles/i,
		];
		let cursor = 0;
		for ( const pattern of expected ) {
			const found = headings.findIndex( ( text, index ) => index >= cursor && pattern.test( text ) );
			expect( found, `heading ${ pattern } appears in order` ).toBeGreaterThanOrEqual( cursor );
			cursor = found + 1;
		}
	} );

	test( 'header offers the logo, the site menu and a call to action', async ( {
		page,
		fixtures,
	} ) => {
		const header = page.locator( 'header' );
		await expect( header.locator( '.artifact-site-brand a:visible' ).first() ).toBeVisible();

		const nav = header.getByRole( 'navigation', { name: 'Primary menu' } );
		for ( const label of fixtures.menu.labels ) {
			await expect( nav.getByRole( 'link', { name: label, exact: true } ) ).toBeVisible();
		}
		await expect( header.getByRole( 'link', { name: 'Start A Project' } ) ).toBeVisible();
	} );

	test( 'a long site menu never squeezes the call to action onto two lines', async ( {
		page,
	} ) => {
		await page.setViewportSize( { width: 1600, height: 900 } );
		const button = page.locator( 'header' ).getByRole( 'link', { name: 'Start A Project' } );
		const oneLine = ( await button.boundingBox() ).height;

		// Ten pages' worth of links, like a shop site's default menu.
		await page.locator( 'header .wp-block-navigation__container' ).evaluate( ( list ) => {
			const item = list.querySelector( 'li' );
			for ( let i = 0; i < 10; i++ ) {
				const copy = item.cloneNode( true );
				copy.querySelector( '.wp-block-navigation-item__label' ).textContent = `Storefront Dashboard ${ i }`;
				list.append( copy );
			}
		} );

		expect( ( await button.boundingBox() ).height ).toBe( oneLine );
	} );

	test( 'the site logo, or the site title without one, links back to the home page', async ( { page, fixtures } ) => {
		await page.goto( fixtures.post.url );
		await page.locator( 'header .artifact-site-brand a:visible' ).first().click();

		await expect( page ).toHaveURL( /\/$/ );
		await expect( page.getByRole( 'heading', { level: 1 } ) ).toContainText( 'Creating' );
	} );

	test( 'the latest articles section links to real posts', async ( {
		page,
		fixtures,
	} ) => {
		const articles = page.locator( 'main .wp-block-post-template' );
		await expect( articles.getByRole( 'link' ).first() ).toBeVisible();

		// The post created for this run is the newest, so it leads the list.
		const link = articles.getByRole( 'link', { name: fixtures.post.title, exact: true } );
		await expect( link ).toBeVisible();
		await link.click();

		await expect( page ).toHaveURL( fixtures.post.url );
		await expect( page.getByRole( 'heading', { level: 1 } ) ).toHaveText( fixtures.post.title );
	} );

	test( 'the footer has working contact links and labelled social icons', async ( {
		page,
	} ) => {
		const footer = page.locator( 'footer' );

		await expect( footer.locator( '.artifact-footer-contact a[href^="mailto:"]' ) ).toHaveAttribute(
			'href',
			/^mailto:[^@\s]+@[^@\s]+\.[a-z]+$/i
		);
		await expect( footer.locator( 'a[href^="tel:"]' ) ).toHaveAttribute( 'href', /^tel:\+?\d+$/ );

		for ( const network of [ 'Facebook', 'X', 'LinkedIn', 'Instagram' ] ) {
			await expect( footer.getByRole( 'link', { name: network, exact: true } ) ).toBeVisible();
		}
	} );

	test( 'the footer newsletter is a Brevo form styled like the theme, or a feed link without Brevo', async ( {
		page,
	} ) => {
		const column = page.locator( 'footer .artifact-footer-newsletter' );
		await expect( column.locator( 'form:not(.sib_signup_form)' ) ).toHaveCount( 0 );

		const brevo = column.locator( '.sib_signup_form' );
		if ( ! ( await brevo.count() ) ) {
			await expect( column.getByRole( 'link', { name: 'Subscribe via RSS' } ) ).toHaveAttribute( 'href', /feed/ );
			return;
		}

		const email = brevo.locator( 'input[type=email]' );
		const submit = brevo.locator( 'input[type=submit]' );
		await expect( email ).toHaveCSS( 'background-color', 'rgb(17, 17, 17)' );
		await expect( email ).toHaveCSS( 'border-radius', '12px' );
		await expect( submit ).toHaveCSS( 'background-color', 'rgb(255, 72, 1)' );
		await expect( submit ).toHaveCSS( 'background-image', /data:image\/svg/ );
		await expect( submit ).toHaveAccessibleName( /\S/ );

		const field = await email.boundingBox();
		const button = await submit.boundingBox();
		expect( Math.round( button.height ) ).toBe( Math.round( field.height ) );
		expect( Math.round( button.y ) ).toBe( Math.round( field.y ) );
		expect( button.x ).toBeGreaterThan( field.x + field.width );
	} );

	test( 'every image on the page is bundled and actually loads', async ( {
		page,
	} ) => {
		// Scroll the whole page so lazy images start loading.
		await page.evaluate( async () => {
			for ( let y = 0; y < document.body.scrollHeight; y += 600 ) {
				window.scrollTo( 0, y );
				await new Promise( ( resolve ) => setTimeout( resolve, 50 ) );
			}
		} );

		const images = await page.locator( 'img' ).evaluateAll( ( nodes ) =>
			nodes.map( ( node ) => ( {
				src: node.currentSrc || node.src,
				alt: node.getAttribute( 'alt' ),
			} ) )
		);
		expect( images.length ).toBeGreaterThanOrEqual( 8 );
		for ( const image of images ) {
			expect( image.alt, `${ image.src } has an alt attribute` ).not.toBeNull();
			// Icons beside text are decorative; photos and artwork need a description.
			if ( ! /\/icon-[^/]+\.svg$/.test( image.src ) ) {
				expect( image.alt, `${ image.src } has alt text` ).toBeTruthy();
			}
		}

		await expect
			.poll( () =>
				page.locator( 'img' ).evaluateAll( ( nodes ) =>
					nodes.filter( ( node ) => ! node.complete || node.naturalWidth === 0 ).map( ( node ) => node.src )
				)
			)
			.toEqual( [] );
	} );

	test( 'nothing is requested from another host', async ( { page, baseURL } ) => {
		const hosts = new Set();
		page.on( 'request', ( request ) => {
			if ( request.url().startsWith( 'http' ) ) {
				hosts.add( new URL( request.url() ).host );
			}
		} );
		await page.reload( { waitUntil: 'networkidle' } );

		// Author avatars come from core's avatar block and Gravatar, not the theme.
		hosts.delete( 'secure.gravatar.com' );
		// Brevo, when active for the footer newsletter, loads its own tracking and push scripts.
		for ( const host of [ 'in-automate.brevo.com', 'cdn.brevo.com', 'cdn.by.wonderpush.com', 'sibautomation.com' ] ) {
			hosts.delete( host );
		}
		expect( [ ...hosts ] ).toEqual( [ new URL( baseURL ).host ] );
	} );
} );

/**
 * What theme.json should produce in a real browser.
 */
test.describe( 'Homepage design tokens', () => {
	test.beforeEach( async ( { page } ) => {
		await page.goto( '/' );
		await page.evaluate( () => document.fonts.ready );
	} );

	const style = ( page, selector, property ) =>
		page.locator( selector ).first().evaluate( ( node, prop ) => getComputedStyle( node )[ prop ], property );

	test( 'the page is black with grey Poppins body text', async ( { page } ) => {
		expect( await style( page, 'body', 'backgroundColor' ) ).toBe( 'rgb(10, 10, 10)' );
		expect( await style( page, 'body', 'color' ) ).toBe( 'rgb(153, 153, 153)' );
		expect( await style( page, 'body', 'fontFamily' ) ).toContain( 'Poppins' );
		expect( await style( page, 'body', 'fontSize' ) ).toBe( '16px' );
		expect( await style( page, 'body', 'lineHeight' ) ).toBe( '28px' );
	} );

	test( 'headings are white, bold, and use the heading scale', async ( { page } ) => {
		expect( await style( page, 'main h1', 'color' ) ).toBe( 'rgb(255, 255, 255)' );
		expect( await style( page, 'main h1', 'fontSize' ) ).toBe( '94px' );
		expect( await style( page, 'main h1', 'fontWeight' ) ).toBe( '700' );
		expect( await style( page, 'main h2', 'fontSize' ) ).toBe( '60px' );
	} );

	test( 'primary buttons use the orange accent with white text', async ( { page } ) => {
		const button = 'main .wp-block-button__link';

		expect( await style( page, button, 'backgroundColor' ) ).toBe( 'rgb(255, 72, 1)' );
		expect( await style( page, button, 'color' ) ).toBe( 'rgb(255, 255, 255)' );
		expect( await style( page, button, 'fontWeight' ) ).toBe( '600' );
	} );

	test( 'the hero button uses the Rounded block style variation', async ( { page } ) => {
		const radius = await page
			.locator( 'main .wp-block-button.is-style-rounded .wp-block-button__link' )
			.first()
			.evaluate( ( node ) => getComputedStyle( node ).borderRadius );

		expect( radius ).toBe( '12px' );
	} );

	test( 'links are white and turn orange on hover', async ( { page } ) => {
		const link = page.locator( 'footer .artifact-footer-contact a[href^="mailto:"]' );
		expect( await link.evaluate( ( node ) => getComputedStyle( node ).color ) ).toBe( 'rgb(255, 255, 255)' );

		await link.hover();
		await expect
			.poll( () => link.evaluate( ( node ) => getComputedStyle( node ).color ) )
			.toBe( 'rgb(255, 72, 1)' );
	} );

	test( 'Poppins loads from the theme as WOFF2 and nothing else', async ( {
		page,
		baseURL,
	} ) => {
		const fonts = [];
		page.on( 'response', ( response ) => {
			const type = response.headers()[ 'content-type' ] || '';
			if ( /font|woff/i.test( type ) || /\.(woff2?|ttf|otf)(\?|$)/.test( response.url() ) ) {
				fonts.push( { url: response.url(), status: response.status() } );
			}
		} );
		await page.reload( { waitUntil: 'networkidle' } );
		await page.evaluate( () => document.fonts.ready );

		expect( fonts.length ).toBeGreaterThan( 0 );
		for ( const font of fonts ) {
			expect( font.status ).toBe( 200 );
			expect( font.url ).toContain( '/themes/artifact/assets/fonts/' );
			expect( font.url ).toMatch( /\.woff2(\?|$)/ );
			expect( new URL( font.url ).host ).toBe( new URL( baseURL ).host );
		}
		expect( await page.evaluate( () => document.fonts.check( '700 20px Poppins' ) ) ).toBe( true );
	} );
} );
