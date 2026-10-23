<?php
/**
 * PHPUnit bootstrap for the integration suite.
 *
 * Loads WordPress through wp-phpunit with the theme active, so the tests run
 * against real WordPress theme, block, pattern and template APIs.
 *
 * @package Artifact
 */

require_once __DIR__ . '/bootstrap-common.php';

define( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH', ARTIFACT_THEME_DIR . '/vendor/yoast/phpunit-polyfills' );
define( 'WP_TESTS_CONFIG_FILE_PATH', __DIR__ . '/wp-tests-config.php' );

require_once getenv( 'WP_PHPUNIT__DIR' ) . '/includes/bootstrap.php';

require_once ARTIFACT_TESTS_DIR . '/includes/class-artifact-test-case.php';
