<?php
/**
 * Setup shared by the unit and integration bootstraps.
 *
 * @package Artifact
 */

define( 'ARTIFACT_THEME_DIR', dirname( __DIR__, 2 ) );
define( 'ARTIFACT_TESTS_DIR', __DIR__ );

require_once ARTIFACT_THEME_DIR . '/vendor/autoload.php';
require_once ARTIFACT_TESTS_DIR . '/includes/class-theme-files.php';
