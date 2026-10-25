// @ts-check
const { execFileSync } = require( 'child_process' );
const fs = require( 'fs' );
const os = require( 'os' );
const path = require( 'path' );

/**
 * Run WP-CLI against the site under test and return trimmed stdout.
 *
 * @param {string[]} args WP-CLI arguments, without the executable.
 * @return {string} Command output.
 */
function wp( args ) {
	const wpPath = process.env.WP_PATH;
	if ( ! wpPath || ! fs.existsSync( path.join( wpPath, 'wp-load.php' ) ) ) {
		throw new Error(
			`WP_PATH does not point at a WordPress install: "${ wpPath }". ` +
				'Set WP_PATH to the site that WP_BASE_URL serves.'
		);
	}

	try {
		return execFileSync(
			process.env.WP_CLI_BIN || 'wp',
			// --url lets wp-config.php files that build WP_HOME from the
			// request host work outside a web request.
			[
				`--path=${ wpPath }`,
				...( process.env.WP_BASE_URL ? [ `--url=${ process.env.WP_BASE_URL }` ] : [] ),
				'--skip-plugins',
				...args,
			],
			{ encoding: 'utf8', stdio: [ 'ignore', 'pipe', 'pipe' ] }
		).trim();
	} catch ( error ) {
		throw new Error(
			`WP-CLI failed: wp ${ args.join( ' ' ) }\n${ error.stderr || error.message }`
		);
	}
}

/**
 * Run a PHP snippet inside WordPress and return its stdout.
 *
 * @param {string} php PHP code without the opening tag.
 * @return {string} Output.
 */
function wpEval( php ) {
	const file = path.join(
		os.tmpdir(),
		`artifact-e2e-${ process.pid }-${ Date.now() }.php`
	);
	fs.writeFileSync( file, `<?php\n${ php }\n` );
	try {
		return wp( [ 'eval-file', file ] );
	} finally {
		fs.unlinkSync( file );
	}
}

module.exports = { wp, wpEval };
