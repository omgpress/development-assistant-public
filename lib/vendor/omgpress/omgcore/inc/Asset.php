<?php

namespace WPDevAssist\OmgCore;

use Exception;
defined('ABSPATH') || exit;
/**
 * Asset manager.
 */
class Asset extends OmgFeature
{
    protected string $asset_dir = 'asset';
    protected string $js_dir = 'js';
    protected string $css_dir = 'css';
    protected string $postfix = '.min';
    protected string $key;
    protected Fs $fs;
    /**
     * @throws Exception
     * @ignore
     */
    public function __construct(string $key, Fs $fs, callable $get_config)
    {
        parent::__construct($get_config);
        $this->key = $key;
        $this->fs = $fs;
    }
    /**
     * Enqueues a script asset.
     *
     * @param string $name The name of the script asset.
     * @param array $deps An array of dependencies for the script.
     * @param array $args An associative array of arguments to be localized with the script.
     * @param bool $in_footer Whether to enqueue the script in the footer (default: true).
     * @param string|null $args_object_name The name of the JavaScript object to which.
     *
     * @return self
     * @throws Exception If the script asset file does not exist.
     */
    public function enqueue_script(string $name, array $deps = array(), array $args = array(), bool $in_footer = \true, ?string $args_object_name = null): self
    {
        $key = $this->get_key($name);
        $filename = $name . $this->postfix . '.js';
        $rel = $this->asset_dir . '/' . $this->js_dir . '/' . $filename;
        $url = $this->fs->get_url($rel);
        $path = $this->fs->get_path($rel);
        if (!file_exists($path)) {
            throw new Exception(esc_html("The {$path} script asset file does not exist"));
        }
        wp_enqueue_script($key, $url, $deps, filemtime($path), $in_footer);
        if ($args) {
            wp_localize_script($key, is_string($args_object_name) ? $args_object_name : $key, $args);
        }
        return $this;
    }
    /**
     * Enqueues an inline script for a parent script.
     *
     * @param string $parent_name The name of the parent script.
     * @param string $js_code The JavaScript code to enqueue inline.
     * @param string $position The position to insert the inline script ('before' or 'after').
     *
     * @return self
     */
    public function enqueue_inline_script(string $parent_name, string $js_code, string $position = 'after'): self
    {
        wp_add_inline_script($this->key . "_{$parent_name}", $js_code, $position);
        return $this;
    }
    /**
     * Enqueues a style asset.
     *
     * @param string $name The name of the style asset.
     * @param array $deps An array of dependencies for the style.
     * @param string|array|null $addition Additional CSS to be added inline or as CSS variables.
     *
     * @return self
     * @throws Exception If the style asset file does not exist or if the addition parameter is invalid.
     */
    public function enqueue_style(string $name, array $deps = array(), $addition = null): self
    {
        $key = $this->get_key($name);
        $filename = $name . $this->postfix . '.css';
        $rel = $this->asset_dir . '/' . $this->css_dir . '/' . $filename;
        $url = $this->fs->get_url($rel);
        $path = $this->fs->get_path($rel);
        if (!file_exists($path)) {
            throw new Exception(esc_html("The {$path} style asset file does not exist"));
        }
        wp_enqueue_style($key, $url, $deps, filemtime($path));
        if (is_string($addition)) {
            wp_add_inline_style($key, $addition);
        } elseif (is_array($addition)) {
            $css_vars = ':root{';
            foreach ($addition as $var_name => $var_val) {
                $css_vars .= '--' . str_replace('_', '-', $this->key . "_{$var_name}") . ':' . $var_val . ';';
            }
            wp_add_inline_style($key, "{$css_vars}}");
        } elseif (!is_null($addition)) {
            throw new Exception('The $addition parameter must be a string, array or null');
        }
        return $this;
    }
    /**
     * Enqueues an external script.
     *
     * @param string $name The name of the script.
     * @param string $url The URL of the external script.
     * @param bool $in_footer Whether to enqueue the script in the footer (default: true).
     *
     * @return self
     */
    public function enqueue_external_script(string $name, string $url, bool $in_footer = \true): self
    {
        wp_enqueue_script($this->get_key($name), $url, \false, null, $in_footer);
        // phpcs:ignore
        return $this;
    }
    /**
     * Enqueues an external style.
     *
     * @param string $name The name of the style.
     * @param string $url The URL of the external style.
     *
     * @return self
     */
    public function enqueue_external_style(string $name, string $url): self
    {
        wp_enqueue_style($this->get_key($name), $url, \false, null);
        // phpcs:ignore
        return $this;
    }
    /**
     * Generates a unique key for the asset based on the name.
     *
     * @param string $name The name of the asset.
     *
     * @return string The generated key.
     */
    public function get_key(string $name): string
    {
        return $this->key . '_' . str_replace('-', '_', $name);
    }
}
