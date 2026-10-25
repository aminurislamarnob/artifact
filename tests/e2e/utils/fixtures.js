// @ts-check
const fs = require( 'fs' );
const path = require( 'path' );

const FIXTURE_FILE = path.join( __dirname, '..', '.fixtures.json' );
const AUTH_FILE = path.join( __dirname, '..', '.auth', 'admin.json' );

/**
 * @typedef {Object} Fixtures
 * @property {{id:number,title:string,slug:string,url:string}} post   Published post with comments open.
 * @property {{id:number,title:string,slug:string,url:string}} page   Published page.
 * @property {{id:number,title:string,url:string}}             services Page built from the Services starter pattern.
 * @property {{id:number,labels:string[]}}                       menu   Newest saved menu, so the header shows these labels.
 * @property {{id:number,name:string,slug:string,url:string}}  category Category the post belongs to.
 * @property {{login:string,password:string,id:number}}        admin  Administrator created for the run.
 */

/**
 * Content created by global setup, so tests do not depend on what the dev
 * site happens to contain.
 *
 * @return {Fixtures} Fixture description.
 */
function readFixtures() {
	return JSON.parse( fs.readFileSync( FIXTURE_FILE, 'utf8' ) );
}

module.exports = { FIXTURE_FILE, AUTH_FILE, readFixtures };
