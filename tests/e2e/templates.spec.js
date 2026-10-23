// @ts-check
const { test, expect } = require( './utils/test' );

/**
 * The generic templates: single, page, archive, search and 404.
 */
test.describe( 'Single post', () => {
	test( 'shows the title as the only h1, the body, and the document title', async ( {
		page,
		fixtures,
	} ) => {
		const response = await page.goto( fixtures.post.url );

		expect( response.status() ).toBe( 200 );
		await expect( page.getByRole( 'heading', { level: 1 } ) ).toHaveCount( 1 );
		await expect( page.getByRole( 'heading', { level: 1 } ) ).toHaveText( fixtures.post.title );
		await expect( page.locator( 'main' ) ).toContainText( 'Body text for the end-to-end post.' );
		await expect( page ).toHaveTitle( new RegExp( fixtures.post.title ) );
	} );

	test( 'wraps the content in header, main and footer landmarks', async ( {
		page,
		fixtures,
	} ) => {
		await page.goto( fixtures.post.url );

		await expect( page.getByRole( 'banner' ) ).toHaveCount( 1 );
		await expect( page.getByRole( 'main' ) ).toHaveCount( 1 );
		await expect( page.getByRole( 'contentinfo' ) ).toHaveCount( 1 );
	} );

	test( 'lists the post category and links to its archive', async ( {
		page,
		fixtures,
	} ) => {
		await page.goto( fixtures.post.url );

		const category = page.locator( 'main' ).getByRole( 'link', { name: fixtures.category.name } );
		await expect( category ).toBeVisible();
		await category.click();

		await expect( page ).toHaveURL( fixtures.category.url );
	} );

	test( 'a visitor can leave a comment', async ( { page, fixtures } ) => {
		const comment = `Playwright comment ${ Date.now() }`;
		await page.goto( fixtures.post.url );

		const form = page.locator( '#commentform' );
		await expect( form ).toBeVisible();
		await form.getByRole( 'textbox', { name: /comment/i } ).fill( comment );
		await form.getByRole( 'textbox', { name: /name/i } ).fill( 'Playwright Visitor' );
		await form.getByRole( 'textbox', { name: /email/i } ).fill( 'visitor@example.test' );
		await form.getByRole( 'button', { name: /post comment/i } ).click();

		// Either shown at once, or held for moderation, depending on site settings.
		await expect( page ).toHaveURL( /#comment-\d+$/ );
		await expect( page.locator( '.wp-block-comments' ) ).toContainText( comment );
	} );

	test( 'the comment form fields are readable on the dark surface', async ( {
		page,
		fixtures,
	} ) => {
		await page.goto( fixtures.post.url );

		const field = page.locator( '#commentform textarea' );
		expect( await field.evaluate( ( node ) => getComputedStyle( node ).backgroundColor ) ).toBe( 'rgb(17, 17, 17)' );
		expect( await field.evaluate( ( node ) => getComputedStyle( node ).color ) ).toBe( 'rgb(255, 255, 255)' );
	} );
} );

test.describe( 'Page', () => {
	test( 'renders the page title and content', async ( { page, fixtures } ) => {
		const response = await page.goto( fixtures.page.url );

		expect( response.status() ).toBe( 200 );
		await expect( page.getByRole( 'heading', { level: 1 } ) ).toHaveText( fixtures.page.title );
		await expect( page.locator( 'main' ) ).toContainText( 'Body text for the end-to-end page.' );
		await expect( page.getByRole( 'main' ) ).toHaveCount( 1 );
	} );

	test( 'keeps long-form content to the 800px content width', async ( {
		page,
		fixtures,
	} ) => {
		await page.goto( fixtures.page.url );

		const width = await page
			.locator( 'main .wp-block-post-content > p' )
			.first()
			.evaluate( ( node ) => node.getBoundingClientRect().width );
		expect( width ).toBeLessThanOrEqual( 800 );
		expect( width ).toBeGreaterThan( 300 );
	} );
} );

test.describe( 'Archive', () => {
	test( 'a category archive lists its posts under a heading', async ( {
		page,
		fixtures,
	} ) => {
		const response = await page.goto( fixtures.category.url );

		expect( response.status() ).toBe( 200 );
		await expect( page.locator( 'main .wp-block-query-title' ) ).toContainText( fixtures.category.name );
		await expect(
			page.locator( 'main .wp-block-post-template' ).getByRole( 'link', { name: fixtures.post.title, exact: true } )
		).toBeVisible();
	} );

	test( 'an empty archive says that no posts were found', async ( {
		page,
		fixtures,
	} ) => {
		// A freshly created category with no posts is the real-world empty state.
		await page.goto( '/?s=' + encodeURIComponent( `nothing-matches-${ Date.now() }` ) );

		await expect( page.locator( 'main' ) ).toContainText( 'No posts were found.' );
		expect( fixtures ).toBeTruthy();
	} );
} );

test.describe( 'Search', () => {
	test( 'finds a post by its title', async ( { page, fixtures } ) => {
		await page.goto( '/?s=' + encodeURIComponent( fixtures.post.title ) );

		await expect( page.locator( 'main .wp-block-query-title' ) ).toContainText( /search results for/i );
		await expect(
			page.locator( 'main .wp-block-post-template' ).getByRole( 'link', { name: fixtures.post.title, exact: true } )
		).toBeVisible();
	} );

	test( 'the search form on the results page searches again', async ( {
		page,
		fixtures,
	} ) => {
		await page.goto( '/?s=anything' );

		await page.locator( 'main' ).getByRole( 'searchbox' ).fill( fixtures.page.title );
		await page.locator( 'main' ).getByRole( 'button', { name: 'Search' } ).click();

		await expect( page ).toHaveURL( /\?s=/ );
		await expect( page.locator( 'main .wp-block-query-title' ) ).toContainText( /search results for/i );
	} );

	test( 'search input is styled for the dark theme', async ( { page } ) => {
		await page.goto( '/?s=anything' );

		const input = page.locator( 'main' ).getByRole( 'searchbox' );
		expect( await input.evaluate( ( node ) => getComputedStyle( node ).backgroundColor ) ).toBe( 'rgb(17, 17, 17)' );
		expect( await input.evaluate( ( node ) => getComputedStyle( node ).color ) ).toBe( 'rgb(255, 255, 255)' );
	} );
} );

test.describe( '404', () => {
	test( 'returns 404 with a helpful message and a search form', async ( {
		page,
	} ) => {
		const response = await page.goto( `/definitely-not-here-${ Date.now() }/` );

		expect( response.status() ).toBe( 404 );
		await expect( page.getByRole( 'heading', { level: 1 } ) ).toHaveText( 'Page not found' );
		await expect( page.locator( 'main' ).getByRole( 'searchbox' ) ).toBeVisible();
		await expect( page.getByRole( 'banner' ) ).toBeVisible();
		await expect( page.getByRole( 'contentinfo' ) ).toBeVisible();
	} );

	test( 'searching from the 404 page reaches the search results', async ( {
		page,
		fixtures,
	} ) => {
		await page.goto( `/definitely-not-here-${ Date.now() }/` );

		await page.locator( 'main' ).getByRole( 'searchbox' ).fill( fixtures.post.title );
		await page.keyboard.press( 'Enter' );

		await expect( page ).toHaveURL( /\?s=/ );
		await expect(
			page.locator( 'main .wp-block-post-template' ).getByRole( 'link', { name: fixtures.post.title, exact: true } )
		).toBeVisible();
	} );
} );
