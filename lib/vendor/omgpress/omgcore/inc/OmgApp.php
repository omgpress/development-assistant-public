<?php

namespace WPDevAssist\OmgCore;

use Exception;
defined('ABSPATH') || exit;
abstract class OmgApp
{
    protected string $root_file;
    protected string $key;
    protected bool $is_plugin;
    protected ActionQuery $action_query;
    protected AdminNotice $admin_notice;
    protected Asset $asset;
    protected Dependency $dependency;
    protected Env $env;
    protected Fs $fs;
    protected Info $info;
    protected View $view;
    protected array $config_prop_keys = array(Asset::class, Dependency::class, View::class);
    protected static ?self $instance = null;
    public static function get_instance(): self
    {
        if (!static::$instance instanceof self) {
            static::$instance = new static();
        }
        return static::$instance;
    }
    /**
     * @throws Exception
     */
    protected function __construct(string $root_file, string $key, bool $is_plugin = \true)
    {
        $this->root_file = $root_file;
        $this->key = $key;
        $this->is_plugin = $is_plugin;
        add_action('init', $this->init());
    }
    public function fs(): Fs
    {
        return $this->fs;
    }
    public function info(): Info
    {
        return $this->info;
    }
    public function view(): View
    {
        return $this->view;
    }
    protected function init(): callable
    {
        return function (): void {
            $config = $this->get_config();
            foreach ($config as $key => $value) {
                if (!in_array($key, $this->config_prop_keys, \true)) {
                    throw new Exception(esc_html("The \"{$key}\" is not a valid configuration property."));
                }
                if (!is_array($value)) {
                    throw new Exception(esc_html("The \"{$key}\" configuration must be an array."));
                }
            }
            $this->action_query = new ActionQuery($this->key);
            $this->admin_notice = new AdminNotice($this->key);
            $this->fs = $this->is_plugin ? new FsPlugin($this->root_file) : new FsTheme($this->root_file);
            $this->asset = new Asset($this->key, $this->fs, $config[Asset::class] ?? array());
            $this->info = $this->is_plugin ? new InfoPlugin($this->root_file) : new InfoTheme($this->fs->get_path('style.css'));
            $this->dependency = new Dependency($this->info, $this->admin_notice, $this->action_query, $config[Dependency::class] ?? array());
            $this->env = new Env();
            $this->view = $this->is_plugin ? new ViewPlugin($this->fs, $config[View::class] ?? array()) : new ViewTheme($config[View::class] ?? array());
            if ($this->is_plugin) {
                load_plugin_textdomain($this->info->get_textdomain(), \false, $this->fs->get_path('lang'));
                register_activation_hook($this->root_file, $this->activate());
                register_deactivation_hook($this->root_file, $this->deactivate());
            } else {
                load_theme_textdomain($this->info->get_textdomain(), $this->fs->get_path('lang'));
                add_action('after_switch_theme', $this->activate());
                add_action('switch_theme', $this->deactivate());
            }
        };
    }
    protected function activate(): callable
    {
        return function (): void {
        };
    }
    protected function deactivate(): callable
    {
        return function (): void {
            $this->admin_notice->reset();
        };
    }
    protected function get_config(): array
    {
        return array();
    }
}
