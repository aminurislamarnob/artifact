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
 *   WP_BASE_URL  Front-end URL of the site (default http://fse-theme-dev.test)
 *   WP_PATH      Filesystem path of the same WordPress install, used by WP-CLI
 *                to create and remove test content (default ~/Herd/fse-theme-dev)
 *   WP_CLI_BIN   WP-CLI executable (default "wp")
 */
const baseURL = process.env.WP_BASE_URL || 'http://fse-theme-dev.test';

process.env.WP_BASE_URL = baseURL;
process.env.WP_PATH =
	process.env.WP_PATH || path.join( os.homedir(), 'Herd', 'fse-theme-dev' );

module.exports = defineConfig( {
	testDir: './tests/e2e',
	outputDir: './test-results',
	globalSetup: require.resolve( './tests/e2e/global-setup.js' ),
	globalTeardown: require.resolve( './tests/e2e/global-teardown.js' ),

	fullyParallel: true,
	forbidOnly: !! process.env.CI,
	retries: process.env.CI ? 2 : 0,
	workers: process.env.CI ? 2 : undefined,
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
