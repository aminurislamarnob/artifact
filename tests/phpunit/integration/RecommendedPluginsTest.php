<?php
/**
 * Tests for the plugins the theme recommends through TGM Plugin Activation.
 *
 * @package Artifact
 */

/**
 * The Contact page is designed for Contact Form 7, so the theme recommends it,
 * and only it, without ever requiring or installing it on its own.
 */
class RecommendedPluginsTest extends Artifact_Test_Case {

	/**
	 * TGMPA keeps one instance per request, so give each test a clean one.
	 */
	public function set_up() {
		parent::set_up();
		$tgmpa                = $GLOBALS['tgmpa'];
		$tgmpa->plugins       = array();
		$tgmpa->is_automatic  = false;
		$tgmpa->dismissable   = true;
		$tgmpa->has_notices   = true;
	}

	public function test_the_theme_registers_its_recommendations_with_tgmpa() {
		$this->assertSame( 10, has_action( 'tgmpa_register', 'artifact_register_recommended_plugins' ) );
	}

	public function test_contact_form_7_is_the_only_recommended_plugin_and_it_is_optional() {
		artifact_register_recommended_plugins();
		$plugins = $GLOBALS['tgmpa']->plugins;

		$this->assertSame( array( 'contact-form-7' ), array_keys( $plugins ) );
		$this->assertSame( 'repo', $plugins['contact-form-7']['source'] );
		$this->assertFalse( $plugins['contact-form-7']['required'] );
		$this->assertFalse( $plugins['contact-form-7']['force_activation'] );
	}

	public function test_the_recommendation_is_a_dismissable_notice_that_installs_nothing_by_itself() {
		artifact_register_recommended_plugins();
		$tgmpa = $GLOBALS['tgmpa'];

		$this->assertSame( 'artifact', $tgmpa->id );
		$this->assertFalse( $tgmpa->is_automatic );
		$this->assertTrue( $tgmpa->dismissable );
		$this->assertTrue( $tgmpa->has_notices );
		$this->assertStringContainsString( 'page=artifact-install-plugins', $tgmpa->get_tgmpa_url() );
	}
}
