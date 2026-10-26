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

	// A single service: a child of the Services page using the Service
	// Details template and the matching starter body.
	const serviceTitle = `Artifact E2E Service ${ RUN }`;
	const serviceId = Number(
		wp( [
			'post',
			'create',
			'--post_type=page',
			'--post_status=publish',
			`--post_title=${ serviceTitle }`,
			`--post_parent=${ servicesId }`,
			'--page_template=page-service-details',
			`--post_content=${ wpEval(
				"echo WP_Block_Patterns_Registry::get_instance()->get_registered( 'artifact/page-service-details' )['content'];"
			) }`,
			'--porcelain',
		] )
	);

	// The About page, built from its starter pattern the same way.
	const aboutTitle = `Artifact E2E About ${ RUN }`;
	const aboutId = Number(
		wp( [
			'post',
			'create',
			'--post_type=page',
			'--post_status=publish',
			`--post_title=${ aboutTitle }`,
			'--page_template=page-no-title',
			`--post_content=${ wpEval(
				"echo WP_Block_Patterns_Registry::get_instance()->get_registered( 'artifact/page-about' )['content'];"
			) }`,
			'--porcelain',
		] )
	);

	// The Portfolio page and one project under it, built the same way.
	const portfolioTitle = `Artifact E2E Portfolio ${ RUN }`;
	const portfolioId = Number(
		wp( [
			'post',
			'create',
			'--post_type=page',
			'--post_status=publish',
			`--post_title=${ portfolioTitle }`,
			'--page_template=page-no-title',
			`--post_content=${ wpEval(
				"echo WP_Block_Patterns_Registry::get_instance()->get_registered( 'artifact/page-portfolio' )['content'];"
			) }`,
			'--porcelain',
		] )
	);

	const projectTitle = `Artifact E2E Project ${ RUN }`;
	const projectId = Number(
		wp( [
			'post',
			'create',
			'--post_type=page',
			'--post_status=publish',
			`--post_title=${ projectTitle }`,
			`--post_parent=${ portfolioId }`,
			'--page_template=page-portfolio-details',
			`--post_content=${ wpEval(
				"echo WP_Block_Patterns_Registry::get_instance()->get_registered( 'artifact/page-portfolio-details' )['content'];"
			) }`,
			'--porcelain',
		] )
	);

	// The Contact page, built from its starter pattern with the mailto panel.
	const contactTitle = `Artifact E2E Contact ${ RUN }`;
	const contactId = Number(
		wp( [
			'post',
			'create',
			'--post_type=page',
			'--post_status=publish',
			`--post_title=${ contactTitle }`,
			'--page_template=page-no-title',
			`--post_content=${ wpEval(
				"echo WP_Block_Patterns_Registry::get_instance()->get_registered( 'artifact/page-contact' )['content'];"
			) }`,
			'--porcelain',
		] )
	);

	// With Contact Form 7 active, a second Contact page whose message panel
	// holds a CF7 form, the way the readme tells site owners to set it up.
	// WP-CLI runs without plugins, so the form is stored as CF7 stores it.
	let contactForm = null;
	if ( wp( [ 'option', 'get', 'active_plugins', '--format=json' ] ).includes( 'wp-contact-form-7.php' ) ) {
		const formTitle = `Artifact E2E form ${ RUN }`;
		const formId = Number(
			wp( [
				'post',
				'create',
				'--post_type=wpcf7_contact_form',
				'--post_status=publish',
				`--post_title=${ formTitle }`,
				'--porcelain',
			] )
		);
		wp( [
			'post',
			'meta',
			'update',
			String( formId ),
			'_form',
			[
				'<label> First Name [text first-name placeholder "Enter first name"] </label>',
				'<label> Last Name [text last-name placeholder "Enter last name"] </label>',
				'<label> Company Name [text company-name placeholder "Your company"] </label>',
				'<label> Email [email* your-email placeholder "Enter email"] </label>',
				'<label> Your Message [textarea* your-message placeholder "Tell us about your idea"] </label>',
				'[submit "Send Inquiry"]',
			].join( '\n\n' ),
		] );

		const formPageTitle = `Artifact E2E Contact Form ${ RUN }`;
		const formPageId = Number(
			wp( [
				'post',
				'create',
				'--post_type=page',
				'--post_status=publish',
				`--post_title=${ formPageTitle }`,
				'--page_template=page-no-title',
				`--post_content=${ wpEval( `
					$registry = WP_Block_Patterns_Registry::get_instance();
					$block    = '<!-- wp:contact-form-7/contact-form-selector {"id":${ formId },"title":"${ formTitle }"} --><div class="wp-block-contact-form-7-contact-form-selector">[contact-form-7 id="${ formId }" title="${ formTitle }"]</div><!-- /wp:contact-form-7/contact-form-selector -->';
					$panel    = preg_replace( '/(<!-- \\/wp:heading -->\\s*)<!-- wp:paragraph.*?<!-- \\/wp:buttons -->/s', '$1' . $block, $registry->get_registered( 'artifact/contact-info' )['content'], 1 );
					if ( false === strpos( $panel, 'wp:contact-form-7' ) ) {
						fwrite( STDERR, 'The contact-info panel markup changed; update the CF7 fixture in global-setup.js.' );
						exit( 1 );
					}
					echo str_replace( '<!-- wp:pattern {"slug":"artifact/contact-info"} /-->', $panel, $registry->get_registered( 'artifact/page-contact' )['content'] );
				` ) }`,
				'--porcelain',
			] )
		);
		contactForm = { id: formPageId, formId, title: formPageTitle, url: '' };
	}

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
			`--post_content=${ menuLink( 'About', aboutId ) }${ menuLink( 'Services', servicesId ) }${ menuLink( 'Portfolio', portfolioId ) }${ menuLink( 'Contact', contactId ) }`,
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
		service: {
			id: serviceId,
			title: serviceTitle,
			url: permalink( serviceId ),
		},
		about: {
			id: aboutId,
			title: aboutTitle,
			url: permalink( aboutId ),
		},
		portfolio: {
			id: portfolioId,
			title: portfolioTitle,
			url: permalink( portfolioId ),
		},
		project: {
			id: projectId,
			title: projectTitle,
			url: permalink( projectId ),
		},
		contact: {
			id: contactId,
			title: contactTitle,
			url: permalink( contactId ),
		},
		contactForm: contactForm && { ...contactForm, url: permalink( contactForm.id ) },
		menu: { id: menuId, labels: [ 'About', 'Services', 'Portfolio', 'Contact' ] },
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
