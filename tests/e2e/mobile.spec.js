// @ts-check
const { test, expect } = require( './utils/test' );

/**
 * Phone-sized viewport behaviour: the header collapses into an overlay menu
 * (navigation overlayMenu is "mobile") and the layout must not spill sideways.
 */
test.describe( 'Mobile (375px)', () => {
	test.use( {
		viewport: { width: 375, height: 812 },
		hasTouch: true,
		isMobile: true,
	} );

	test( 'the header shows a menu button instead of the link row', async ( {
		page,
	} ) => {
		await page.goto( '/' );

		const header = page.locator( 'header' );
		await expect( header.getByRole( 'button', { name: 'Open menu' } ) ).toBeVisible();
		await expect( header.getByRole( 'link', { name: 'Services', exact: true } ) ).toBeHidden();
		await expect( header.getByRole( 'img', { name: 'weLabs' } ) ).toBeVisible();
	} );

	test( 'the menu opens as a dialog with every link, and closes with the close button', async ( {
		page,
	} ) => {
		await page.goto( '/' );

		await page.getByRole( 'button', { name: 'Open menu' } ).click();
		const dialog = page.getByRole( 'dialog' );
		await expect( dialog ).toBeVisible();
		for ( const label of [ 'Home', 'About', 'Services', 'Portfolio', 'Blog', 'Contacts' ] ) {
			await expect( dialog.getByRole( 'link', { name: label, exact: true } ) ).toBeVisible();
		}
		await expect( page.locator( 'html' ) ).toHaveClass( /has-modal-open/ );

		await dialog.getByRole( 'button', { name: 'Close menu' } ).click();
		await expect( dialog ).toBeHidden();
		await expect( page.locator( 'html' ) ).not.toHaveClass( /has-modal-open/ );
	} );

	test( 'the menu closes with Escape and returns focus to the menu button', async ( {
		page,
	} ) => {
		await page.goto( '/' );
		const open = page.getByRole( 'button', { name: 'Open menu' } );

		await open.focus();
		await page.keyboard.press( 'Enter' );
		await expect( page.getByRole( 'dialog' ) ).toBeVisible();

		await page.keyboard.press( 'Escape' );
		await expect( page.getByRole( 'dialog' ) ).toBeHidden();
		await expect( open ).toBeFocused();
	} );

	test( 'the overlay menu uses the dark surface with white text', async ( {
		page,
	} ) => {
		await page.goto( '/' );
		await page.getByRole( 'button', { name: 'Open menu' } ).click();

		const container = page.locator( '.wp-block-navigation__responsive-container.is-menu-open' );
		await expect( container ).toBeVisible();
		expect( await container.evaluate( ( node ) => getComputedStyle( node ).backgroundColor ) ).toBe( 'rgb(10, 10, 10)' );
		expect( await container.evaluate( ( node ) => getComputedStyle( node ).color ) ).toBe( 'rgb(255, 255, 255)' );
	} );

	for ( const [ name, url ] of [
		[ 'home', () => '/' ],
		[ 'single post', ( f ) => f.post.url ],
		[ '404', () => '/not-a-real-page-artifact/' ],
	] ) {
		test( `${ name } does not scroll sideways`, async ( { page, fixtures } ) => {
			await page.goto( url( fixtures ) );

			const overflow = await page.evaluate( () => ( {
				scroll: document.documentElement.scrollWidth,
				viewport: window.innerWidth,
			} ) );
			expect( overflow.scroll ).toBeLessThanOrEqual( overflow.viewport );
		} );
	}

	test( 'homepage columns stack into one column', async ( { page } ) => {
		await page.goto( '/' );

		const hero = page.locator( 'main > .alignfull' ).first();
		const copy = await hero.locator( '.wp-block-column' ).nth( 0 ).boundingBox();
		const image = await hero.locator( '.wp-block-column' ).nth( 1 ).boundingBox();

		expect( image.y ).toBeGreaterThan( copy.y + copy.height - 1 );
		expect( copy.width ).toBeGreaterThan( 250 );
	} );

	/**
	 * Known defect: heading sizes are fixed pixel values (theme.json
	 * typography.fontSizes has no fluid sizes), so the 94px hero heading is
	 * wider than a phone screen and the browser breaks words mid-letter.
	 * `test.fail` keeps the suite green while the defect exists and turns red
	 * the moment it is fixed, at which point remove the `test.fail` line.
	 */
	test( 'no heading word is wider than its container', async ( { page } ) => {
		test.fail( true, 'Known defect: heading font sizes are not fluid on small screens' );

		await page.goto( '/' );
		await page.evaluate( () => document.fonts.ready );

		const tooWide = await page.locator( 'main h1, main h2, main h3' ).evaluateAll( ( headings ) => {
			const context = document.createElement( 'canvas' ).getContext( '2d' );
			const wide = [];
			for ( const heading of headings ) {
				const style = getComputedStyle( heading );
				context.font = `${ style.fontWeight } ${ style.fontSize } ${ style.fontFamily }`;
				const available = heading.clientWidth - parseFloat( style.paddingLeft ) - parseFloat( style.paddingRight );
				for ( const word of heading.innerText.split( /\s+/ ).filter( Boolean ) ) {
					if ( context.measureText( word ).width > available + 1 ) {
						wide.push( word );
					}
				}
			}
			return wide;
		} );

		expect( tooWide ).toEqual( [] );
	} );
} );

test.describe( 'Tablet (768px)', () => {
	test.use( { viewport: { width: 768, height: 1024 } } );

	test( 'the header keeps the full navigation row and nothing spills sideways', async ( {
		page,
	} ) => {
		await page.goto( '/' );

		await expect( page.locator( 'header' ).getByRole( 'link', { name: 'Services', exact: true } ) ).toBeVisible();
		await expect( page.getByRole( 'button', { name: 'Open menu' } ) ).toBeHidden();
		expect(
			await page.evaluate( () => document.documentElement.scrollWidth <= window.innerWidth )
		).toBe( true );
	} );
} );
