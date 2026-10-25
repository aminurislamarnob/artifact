// @ts-check
const os = require( 'os' );
const path = require( 'path' );
const { defineConfig, devices } = require( '@playwright/test' );

/**
 * Playwright configuration for the Artifact theme.
 *
 * The tests run against a real WordPress site that has Artifact active. By
 * default that is the local Herd site from CLAUDE.md; override it with:
 *
 *   WP_BASE_URL  Front-end URL of the site (default https://woocommerce.test), also
 *              passed to WP-CLI as --url
 *   WP_PATH      Filesystem path of the same WordPress install, used by WP-CLI
 *                to create and remove test content (default ~/Herd/woocommerce)
 *   WP_CLI_BIN   WP-CLI executable (default "wp")
 */
const baseURL = process.env.WP_BASE_URL || 'https://woocommerce.test';

process.env.WP_BASE_URL = baseURL;
process.env.WP_PATH =
	process.env.WP_PATH || path.join( os.homedir(), 'Herd', 'woocommerce' );

module.exports = defineConfig( {
	testDir: './tests/e2e',
	outputDir: './test-results',
	globalSetup: require.resolve( './tests/e2e/global-setup.js' ),
	globalTeardown: require.resolve( './tests/e2e/global-teardown.js' ),

	fullyParallel: true,
	forbidOnly: !! process.env.CI,
	retries: process.env.CI ? 2 : 0,
	// Herd sends every request, static files included, through a small PHP-FPM
	// pool. Over HTTPS the browser fires dozens at once, so a second worker
	// already causes 502s and aborted scripts. One worker is also the fastest.
	workers: 1,
	reporter: process.env.CI
		? [ [ 'github' ], [ 'html', { open: 'never' } ] ]
		: [ [ 'list' ], [ 'html', { open: 'never' } ] ],

	expect: { timeout: 10_000 },

	use: {
		baseURL,
		ignoreHTTPSErrors: true,
		trace: 'retain-on-failure',
		screenshot: 'only-on-failure',
		video: 'off',
	},

	projects: [
		{
			name: 'chromium',
			use: {
				...devices[ 'Desktop Chrome' ],
				viewport: { width: 1440, height: 900 },
			},
		},
	],
} );
