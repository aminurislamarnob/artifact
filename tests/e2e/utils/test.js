// @ts-check
const base = require( '@playwright/test' );
const { readFixtures } = require( './fixtures' );

/**
 * Extends Playwright's test with:
 * - `fixtures`: content created by global setup.
 * - `problems`: an automatic fixture that fails any test during which the page
 *   logged a console error, threw, or failed to load a sub-resource.
 */
const test = base.test.extend( {
	// Set `test.use( { watchProblems: false } )` for wp-admin specs: the admin
	// screens are noisy in ways the theme does not control.
	watchProblems: [ true, { option: true } ],

	// eslint-disable-next-line no-empty-pattern
	fixtures: async ( {}, use ) => {
		await use( readFixtures() );
	},

	problems: [
		async ( { page, watchProblems }, use ) => {
			if ( ! watchProblems ) {
				await use( [] );
				return;
			}

			/** @type {string[]} */
			const problems = [];

			// Documents that legitimately answer 4xx (the 404 template) make the
			// browser log "Failed to load resource" for themselves.
			const expectedErrorDocuments = new Set();

			page.on( 'console', ( message ) => {
				if (
					message.type() === 'error' &&
					! expectedErrorDocuments.has( message.location().url )
				) {
					problems.push( `console error: ${ message.text() }` );
				}
			} );
			page.on( 'pageerror', ( error ) => {
				problems.push( `uncaught exception: ${ error.message }` );
			} );
			page.on( 'requestfailed', ( request ) => {
				problems.push(
					`request failed: ${ request.url() } (${ request.failure()?.errorText })`
				);
			} );
			page.on( 'response', ( response ) => {
				const request = response.request();
				if (
					response.status() >= 400 &&
					request.resourceType() === 'document'
				) {
					expectedErrorDocuments.add( request.url() );
				}
				if (
					response.status() >= 400 &&
					request.resourceType() !== 'document' &&
					! request.url().endsWith( '/favicon.ico' )
				) {
					problems.push(
						`HTTP ${ response.status() }: ${ request.url() }`
					);
				}
			} );

			await use( problems );

			base.expect(
				problems,
				'The page should load without console errors or failed requests'
			).toEqual( [] );
		},
		{ auto: true },
	],
} );

module.exports = { test, expect: base.expect };
