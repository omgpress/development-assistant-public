<?php
namespace WPDevAssist;

use WPDevAssist\OmgCore\OmgApp;

defined( 'ABSPATH' ) || exit;

class App extends OmgApp {
	protected Assistant $assistant;
	protected Htaccess $htaccess;
	protected MailHog $mail_hog;
	protected PluginsScreen $plugins_screen;
	protected Setting $setting;
	protected WPDebug $wp_debug;

	public function __construct() {
		parent::__construct( ROOT_FILE, KEY );
	}

	protected function init(): callable {
		return function (): void {
			parent::init()();

			$this->htaccess       = new Htaccess( $this->fs );
			$this->mail_hog       = new MailHog( $this->action_query, $this->admin_notice );
			$this->wp_debug       = new WPDebug( $this->admin_notice, $this->fs, $this->htaccess );
			$this->setting        = new Setting(
				$this->action_query,
				$this->asset,
				$this->fs,
				$this->admin_notice,
				$this->htaccess,
				$this->mail_hog,
				$this->wp_debug
			);
			$this->plugins_screen = new PluginsScreen(
				$this->action_query,
				$this->asset,
				$this->admin_notice,
				$this->setting
			);
			$this->assistant      = new Assistant(
				$this->asset,
				$this->action_query,
				$this->setting,
				$this->htaccess,
				$this->mail_hog
			);
		};
	}

	protected function activate(): callable {
		return function (): void {
			parent::activate()();
			$this->setting->add_default_options();
			$this->setting->debug_log()->store_original_file_existence();
			$this->setting->support_user()->add_default_options();
			$this->wp_debug->store_original_config_const();

			if ( 'yes' === get_option( Setting::DISABLE_DIRECT_ACCESS_TO_LOG_KEY, Setting::DISABLE_DIRECT_ACCESS_TO_LOG_DEFAULT ) ) {
				$this->wp_debug->add_htaccess_directives();
			}
		};
	}

	protected function deactivate(): callable {
		return function (): void {
			$this->wp_debug->remove_htaccess_directives();

			if ( 'yes' !== get_option( Setting::RESET_KEY, Setting::RESET_DEFAULT ) ) {
				return;
			}

			parent::deactivate()();
			$this->wp_debug->reset_config_const();
			$this->setting->debug_log()->delete_file_if_originally_not_exists();
			$this->setting->support_user()->reset();
			$this->setting->reset();
		};
	}

	protected function get_config(): array {
		return array();
	}
}
