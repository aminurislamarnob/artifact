// @ts-check
const fs = require( 'fs' );
const { wp } = require( './utils/wp-cli' );
const { FIXTURE_FILE, AUTH_FILE } = require( './utils/fixtures' );

/**
 * Remove everything global setup created, even when specs failed.
 */
module.exports = async function globalTeardown() {
	if ( ! fs.existsSync( FIXTURE_FILE ) ) {
		return;
	}
	const fixtures = JSON.parse( fs.readFileSync( FIXTURE_FILE, 'utf8' ) );

	// Deleting a post also deletes the comments the specs left on it.
	for ( const id of [ fixtures.post.id, fixtures.page.id, fixtures.service.id, fixtures.services.id, fixtures.about.id, fixtures.menu.id ] ) {
		wp( [ 'post', 'delete', String( id ), '--force' ] );
	}
	wp( [ 'term', 'delete', 'category', String( fixtures.category.id ) ] );
	wp( [ 'user', 'delete', String( fixtures.admin.id ), '--yes' ] );

	// Pages the editor spec created, if its own cleanup was interrupted.
	const leftovers = wp( [
		'post',
		'list',
		'--post_type=page',
		'--post_status=any',
		'--s=Artifact E2E pattern:',
		'--field=ID',
	] );
	if ( leftovers ) {
		wp( [ 'post', 'delete', ...leftovers.split( /\s+/ ), '--force' ] );
	}

	fs.rmSync( FIXTURE_FILE, { force: true } );
	fs.rmSync( AUTH_FILE, { force: true } );
};
