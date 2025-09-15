<?php

namespace WPDevAssist\OmgCore;

defined('ABSPATH') || exit;
/**
 * Action Query manager.
 */
class ActionQuery extends OmgFeature
{
    /**
     * Adds a query action handler.
     *
     * @param string $query_key The key for the query parameter.
     * @param callable $handler The function to handle the query action.
     * @param bool $use_redirect Whether to redirect after handling the action.
     * @param string $capability The capability required to execute the action.
     * @param bool $admin_only Whether the action should only be available to administrators.
     */
    public function add(string $query_key, callable $handler, bool $use_redirect = \true, string $capability = 'administrator', bool $admin_only = \true): void
    {
        add_action($admin_only ? 'admin_init' : 'init', function () use ($query_key, $handler, $use_redirect, $capability): void {
            if (empty($_GET['_wpnonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), $query_key) || empty($_GET[$query_key]) || !current_user_can($capability)) {
                return;
            }
            $handler($_GET, $_POST, $query_key);
            if ($use_redirect) {
                wp_safe_redirect(remove_query_arg(array($query_key, '_wpnonce')));
            }
            exit;
        }, 1);
    }
    /**
     * Generates a URL with nonce for a specific query action.
     *
     * @param string $query_key The key for the query parameter.
     * @param string|null $base_url Optional base URL to append the query to.
     * @param mixed $value The value to set for the query key, defaults to 'yes'.
     * @param array $args Additional arguments to include in the query.
     *
     * @return string The generated URL with the nonce.
     */
    public function get_url(string $query_key, ?string $base_url = null, $value = 'yes', array $args = array()): string
    {
        $args = wp_parse_args(array($query_key => $value), $args);
        return wp_nonce_url(is_null($base_url) ? add_query_arg($args) : add_query_arg($args, $base_url), $query_key);
    }
}
