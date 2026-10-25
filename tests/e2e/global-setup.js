// @ts-check
const crypto = require( 'crypto' );
const fs = require( 'fs' );
const path = require( 'path' );
const { chromium } = require( '@playwright/test' );
const { wp, wpEval } = require( './utils/wp-cli' );
const { FIXTURE_FILE, AUTH_FILE } = require( './utils/fixtures' );

const RUN = Date.now().toString( 36 );

/**
 * Create the posts, page, category and admin user the specs rely on, and sign
 * the admin in once so editor specs can reuse the session.
 *
 * @param {import('@playwright/test').FullConfig} config Playwright config.
 */
module.exports = async function globalSetup( config ) {
	const baseURL = config.projects[ 0 ].use.baseURL;

	// The theme under test must be the active one, or every spec is meaningless.
	const active = wp( [ 'option', 'get', 'stylesheet' ] );
	if ( active !== 'artifact' ) {
		throw new Error(
			`The Artifact theme is not active on ${ baseURL } (active: "${ active }"). ` +
				'Run: wp theme activate artifact'
		);
	}

	const categoryId = Number(
		wp( [
			'term',
			'create',
			'category',
			`Artifact E2E ${ RUN }`,
			'--porcelain',
		] )
	);
	const categoryInfo = JSON.parse(
		wp( [ 'term', 'get', 'category', String( categoryId ), '--format=json' ] )
	);

	const postTitle = `Artifact E2E Post ${ RUN }`;
	const postId = Number(
		wp( [
			'post',
			'create',
			'--post_type=post',
			'--post_status=publish',
			'--comment_status=open',
			`--post_title=${ postTitle }`,
			`--post_category=${ categoryId }`,
			'--post_content=<!-- wp:paragraph --><p>Body text for the end-to-end post.</p><!-- /wp:paragraph -->',
			'--porcelain',
		] )
	);

	const pageTitle = `Artifact E2E Page ${ RUN }`;
	const pageId = Number(
		wp( [
			'post',
			'create',
			'--post_type=page',
			'--post_status=publish',
			`--post_title=${ pageTitle }`,
			'--post_content=<!-- wp:paragraph --><p>Body text for the end-to-end page.</p><!-- /wp:paragraph -->',
			'--porcelain',
		] )
	);

	// A page built from the Services starter pattern, the way a site owner
	// would make it: pattern content plus the Page No Title template.
	const servicesTitle = `Artifact E2E Services ${ RUN }`;
	const servicesId = Number(
		wp( [
			'post',
			'create',
			'--post_type=page',
			'--post_status=publish',
			`--post_title=${ servicesTitle }`,
			'--page_template=page-no-title',
			`--post_content=${ wpEval(
				"echo WP_Block_Patterns_Registry::get_instance()->get_registered( 'artifact/page-services' )['content'];"
			) }`,
			'--porcelain',
		] )
	);

	const permalink = ( id ) =>
		wp( [ 'eval', `echo get_permalink( ${ id } );` ] );

	// The header navigation shows the newest saved menu, so this run's menu
	// wins over whatever the dev site has and the labels are known.
	const menuLink = ( label, id ) =>
		`<!-- wp:navigation-link ${ JSON.stringify( {
			label,
			type: 'page',
			id,
			url: permalink( id ),
			kind: 'post-type',
		} ) } /-->`;
	const menuId = Number(
		wp( [
			'post',
			'create',
			'--post_type=wp_navigation',
			'--post_status=publish',
			`--post_title=Artifact E2E menu ${ RUN }`,
			`--post_content=${ menuLink( 'About', pageId ) }${ menuLink( 'Services', servicesId ) }`,
			'--porcelain',
		] )
	);

	const login = `artifact-e2e-${ RUN }`;
	const password = crypto.randomBytes( 12 ).toString( 'hex' );
	const adminId = Number(
		wp( [
			'user',
			'create',
			login,
			`${ login }@example.test`,
			'--role=administrator',
			`--user_pass=${ password }`,
			'--porcelain',
		] )
	);

	const fixtures = {
		post: {
			id: postId,
			title: postTitle,
			slug: wp( [ 'post', 'get', String( postId ), '--field=post_name' ] ),
			url: permalink( postId ),
		},
		page: {
			id: pageId,
			title: pageTitle,
			slug: wp( [ 'post', 'get', String( pageId ), '--field=post_name' ] ),
			url: permalink( pageId ),
		},
		services: {
			id: servicesId,
			title: servicesTitle,
			url: permalink( servicesId ),
		},
		menu: { id: menuId, labels: [ 'About', 'Services' ] },
		category: {
			id: categoryId,
			name: categoryInfo.name,
			slug: categoryInfo.slug,
			url: wp( [
				'eval',
				`echo get_category_link( ${ categoryId } );`,
			] ),
		},
		admin: { login, password, id: adminId },
	};
	fs.mkdirSync( path.dirname( FIXTURE_FILE ), { recursive: true } );
	fs.writeFileSync( FIXTURE_FILE, JSON.stringify( fixtures, null, 2 ) );

	// Sign in once; editor specs reuse this session.
	const browser = await chromium.launch();
	try {
		const context = await browser.newContext( {
			baseURL,
			ignoreHTTPSErrors: true,
		} );
		const page = await context.newPage();
		await page.goto( '/wp-login.php' );
		await page.fill( '#user_login', login );
		await page.fill( '#user_pass', password );
		await Promise.all( [
			page.waitForURL( /wp-admin/ ),
			page.click( '#wp-submit' ),
		] );
		fs.mkdirSync( path.dirname( AUTH_FILE ), { recursive: true } );
		await context.storageState( { path: AUTH_FILE } );
	} finally {
		await browser.close();
	}
};
