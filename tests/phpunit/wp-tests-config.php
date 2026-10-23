<?php
/**
 * WordPress test-suite configuration for the Artifact theme.
 *
 * Everything can be overridden with environment variables, so CI and local
 * machines can point at their own WordPress checkout and database.
 *
 * WARNING: the WordPress test suite DROPS every table in the configured
 * database. Use a database that exists only for these tests.
 *
 * @package Artifact
 */

/**
 * Read an environment variable with a fallback.
 *
 * @param string $name     Variable name.
 * @param string $fallback Value when the variable is unset or empty.
 * @return string
 */
function artifact_tests_env( $name, $fallback ) {
	$value = getenv( $name );
	return ( false === $value || '' === $value ) ? $fallback : $value;
}

/**
 * Find the WordPress root that contains this theme: WP_CORE_DIR, or the
 * nearest parent of the theme that has wp-settings.php.
 *
 * @return string Absolute path with a trailing slash.
 */
function artifact_tests_find_wordpress() {
	$configured = getenv( 'WP_CORE_DIR' );
	if ( $configured ) {
		return rtrim( $configured, '/\\' ) . '/';
	}

	$dir = realpath( dirname( __DIR__, 2 ) );
	while ( $dir && dirname( $dir ) !== $dir ) {
		$dir = dirname( $dir );
		if ( is_file( $dir . '/wp-settings.php' ) ) {
			return $dir . '/';
		}
	}

	echo 'Error: could not find WordPress. Set WP_CORE_DIR to a WordPress install that has this theme in wp-content/themes.' . PHP_EOL;
	exit( 1 );
}

$artifact_tests_db_name = artifact_tests_env( 'WP_TESTS_DB_NAME', 'artifact_tests' );

// Refuse to run against anything that does not look like a throwaway database.
if ( false === stripos( $artifact_tests_db_name, 'test' ) ) {
	echo sprintf( 'Error: database "%s" does not contain "test" in its name. The test suite wipes the database, so it refuses to run.', $artifact_tests_db_name ) . PHP_EOL;
	exit( 1 );
}

define( 'ABSPATH', artifact_tests_find_wordpress() );

define( 'DB_NAME', $artifact_tests_db_name );
define( 'DB_USER', artifact_tests_env( 'WP_TESTS_DB_USER', 'root' ) );
define( 'DB_PASSWORD', artifact_tests_env( 'WP_TESTS_DB_PASSWORD', 'root' ) );
define( 'DB_HOST', artifact_tests_env( 'WP_TESTS_DB_HOST', 'localhost' ) );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

define( 'WP_TESTS_DOMAIN', 'example.org' );
define( 'WP_TESTS_EMAIL', 'admin@example.org' );
define( 'WP_TESTS_TITLE', 'Artifact Test Site' );
define( 'WP_PHP_BINARY', 'php' );

// The theme under test is the active theme for the whole run.
define( 'WP_DEFAULT_THEME', 'artifact' );

define( 'WP_DEBUG', true );
define( 'WPLANG', '' );

define( 'AUTH_KEY', 'artifact-tests' );
define( 'SECURE_AUTH_KEY', 'artifact-tests' );
define( 'LOGGED_IN_KEY', 'artifact-tests' );
define( 'NONCE_KEY', 'artifact-tests' );
define( 'AUTH_SALT', 'artifact-tests' );
define( 'SECURE_AUTH_SALT', 'artifact-tests' );
define( 'LOGGED_IN_SALT', 'artifact-tests' );
define( 'NONCE_SALT', 'artifact-tests' );

$table_prefix = 'wptests_';
