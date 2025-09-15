<?php

namespace WPDevAssist\OmgCore;

use Exception;
defined('ABSPATH') || exit;
/**
 * Admin notice manager.
 */
class AdminNotice extends OmgFeature
{
    protected string $key;
    /**
     * @throws Exception
     * @ignore
     */
    public function __construct(string $key)
    {
        parent::__construct();
        $this->key = "{$key}_admin_transient_notices";
        add_action('admin_init', $this->render_transients());
    }
    /**
     * Adds a transient notice to be displayed in the admin area.
     *
     * @param string $message The message to display.
     * @param string $level The level of the notice (e.g., 'warning', 'error', 'success').
     *
     * @return self
     */
    public function add_transient(string $message, string $level = 'warning'): self
    {
        $notices = $this->get_transients();
        $notices[$level][] = $message;
        update_option($this->key, $notices);
        return $this;
    }
    /**
     * Renders a notice in the admin area.
     *
     * @param string $message The message to display.
     * @param string $level The level of the notice (e.g., 'warning', 'error', 'success').
     * @param bool $is_dismissible Whether the notice is dismissible.
     *
     * @return self
     */
    public function render(string $message, string $level = 'warning', bool $is_dismissible = \true): self
    {
        add_action('admin_notices', function () use ($message, $level, $is_dismissible): void {
            ?>
				<div
					class="notice notice-<?php 
            echo esc_attr($level) . ($is_dismissible ? ' is-dismissible' : '');
            ?>"
					style="padding-top: 10px; padding-bottom: 10px;"
				>
					<?php 
            echo wp_kses_post($message);
            ?>
				</div>
				<?php 
        });
        return $this;
    }
    /**
     * Resets the stored transient notices.
     *
     * @return void
     */
    public function reset(): void
    {
        delete_option($this->key);
    }
    protected function render_transients(): callable
    {
        return function (): void {
            $notices = $this->get_transients();
            if (empty($notices)) {
                return;
            }
            foreach ($notices as $level => $messages) {
                foreach ($messages as $message) {
                    $this->render($message, $level);
                }
            }
            delete_option($this->key);
        };
    }
    protected function get_transients(): array
    {
        return get_option($this->key, array());
    }
}
