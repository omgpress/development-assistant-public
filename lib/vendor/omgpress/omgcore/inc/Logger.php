<?php

namespace WPDevAssist\OmgCore;

use InvalidArgumentException;
use WPDevAssist\WP_Filesystem_Direct;
defined('ABSPATH') || exit;
class Logger extends OmgFeature
{
    protected Fs $fs;
    protected ActionQuery $action_query;
    protected AdminNotice $admin_notice;
    protected Info $info;
    protected string $dir_path;
    protected string $enabled_option_key;
    protected string $delete_log_query_key;
    protected string $download_log_query_key;
    protected string $notice_delete_log_error;
    protected string $notice_delete_log_all_success;
    protected string $notice_delete_log_group_success;
    protected string $notice_download_log_error;
    protected string $delete_log_action_capability;
    protected string $download_log_action_capability;
    protected array $config_props = array('notice_delete_log_error' => 'An error occurred while trying to delete %s log file(s).', 'notice_delete_log_all_success' => 'All %s log files have been successfully deleted.', 'notice_delete_log_group_success' => 'The %1$s %2$s log file has been successfully deleted.', 'notice_download_log_error' => 'An error occurred while trying to download %s log file.', 'delete_log_action_capability' => 'manage_options', 'download_log_action_capability' => 'manage_options');
    public function __construct(string $key, Fs $fs, ActionQuery $action_query, AdminNotice $admin_notice, Info $info, array $config = array())
    {
        parent::__construct($config);
        $this->fs = $fs;
        $this->action_query = $action_query;
        $this->admin_notice = $admin_notice;
        $this->info = $info;
        $this->dir_path = WP_CONTENT_DIR . '/uploads/' . str_replace('_', '-', $key) . '-log';
        $this->enabled_option_key = "{$key}_omg_core_logger_enabled";
        $this->delete_log_query_key = "{$key}_omg_core_logger_delete_log";
        $this->download_log_query_key = "{$key}_omg_core_logger_download_log";
        $action_query->add($this->delete_log_query_key, $this->handle_delete_log(), \true, $this->delete_log_action_capability);
        $action_query->add($this->download_log_query_key, $this->handle_download_log(), \true, $this->download_log_action_capability);
    }
    public function get_log_file_path(string $group = 'debug'): string
    {
        return "{$this->dir_path}/{$group}.log";
    }
    public function is_log_file_exists(string $group = 'debug'): bool
    {
        return file_exists($this->get_log_file_path($group));
    }
    public function get_content(string $group = 'debug'): string
    {
        return $this->fs->read_text_file("{$this->dir_path}/{$group}.log");
    }
    public function get_delete_log_action_url(string $group = 'debug'): string
    {
        return $this->action_query->get_url($this->delete_log_query_key, null, $group);
    }
    public function get_download_log_action_url(string $group = 'debug'): string
    {
        return $this->action_query->get_url($this->download_log_query_key, null, $group);
    }
    public function get_enabled_option_key(): string
    {
        return $this->enabled_option_key;
    }
    /**
     * @param mixed $message
     * @throws InvalidArgumentException
     */
    public function success($message, string $group = 'debug'): self
    {
        return $this->log($message, 'success', $group);
    }
    /**
     * @param mixed $message
     * @throws InvalidArgumentException
     */
    public function info($message, string $group = 'debug'): self
    {
        return $this->log($message, 'info', $group);
    }
    /**
     * @param mixed $message
     * @throws InvalidArgumentException
     */
    public function warning($message, string $group = 'debug'): self
    {
        return $this->log($message, 'warning', $group);
    }
    /**
     * @param mixed $message
     * @throws InvalidArgumentException
     */
    public function error($message, string $group = 'debug'): self
    {
        return $this->log($message, 'error', $group);
    }
    /**
     * @param mixed $message
     * @throws InvalidArgumentException
     */
    public function log($message, string $level, string $group = 'debug'): self
    {
        if ('yes' !== get_option($this->enabled_option_key, 'no')) {
            return $this;
        }
        $content = $this->fs->read_text_file($this->get_log_file_path($group));
        $content .= $this->format_message($message, $level);
        $this->maybe_create_dir();
        $this->fs->write_text_file($this->get_log_file_path($group), $content);
        return $this;
    }
    public function delete_log_dir(): bool
    {
        if (!class_exists('WPDevAssist\WP_Filesystem_Base')) {
            require_once ABSPATH . '/wp-admin/includes/class-wp-filesystem-base.php';
        }
        if (!class_exists('WPDevAssist\WP_Filesystem_Direct')) {
            require_once ABSPATH . '/wp-admin/includes/class-wp-filesystem-direct.php';
        }
        if (!is_dir($this->dir_path) || !(new WP_Filesystem_Direct(array()))->rmdir($this->dir_path, \true)) {
            return \false;
        }
        return \true;
    }
    public function delete_log_file(string $group = 'debug'): bool
    {
        $file_path = $this->get_log_file_path($group);
        if (!file_exists($file_path) || !wp_delete_file($file_path)) {
            return \false;
        }
        return \true;
    }
    public function reset(): void
    {
        $this->delete_log_dir();
        delete_option($this->enabled_option_key);
    }
    /**
     * @param mixed $message
     * @throws InvalidArgumentException
     */
    protected function format_message($message, string $level): string
    {
        if (is_array($message) || is_object($message)) {
            $message = wp_json_encode($message, \JSON_UNESCAPED_UNICODE | \JSON_UNESCAPED_SLASHES);
        } elseif (is_callable($message)) {
            throw new InvalidArgumentException('The message cannot be a callable function');
        } else {
            $message = strval($message);
        }
        return '[' . gmdate('n/j/Y H:i:s') . '] ' . ucfirst($level) . ": {$message}\n";
    }
    protected function maybe_create_dir(): void
    {
        if (is_dir($this->dir_path)) {
            return;
        }
        wp_mkdir_p($this->dir_path);
        $htaccess_path = "{$this->dir_path}/.htaccess";
        if (file_exists($htaccess_path)) {
            return;
        }
        $this->fs->write_text_file($htaccess_path, 'deny from all');
    }
    protected function handle_delete_log(): callable
    {
        return function (array $data): void {
            if (!is_string($data[$this->delete_log_query_key])) {
                $this->admin_notice->add_transient(sprintf($this->notice_delete_log_error, $this->info->get_name()), 'error');
                return;
            }
            if ('all' === $data[$this->delete_log_query_key]) {
                if ($this->delete_log_dir()) {
                    $this->admin_notice->add_transient(sprintf($this->notice_delete_log_all_success, $this->info->get_name()), 'success');
                } else {
                    $this->admin_notice->add_transient(sprintf($this->notice_delete_log_error, $this->info->get_name()), 'error');
                }
                return;
            }
            if ($this->delete_log_file($data[$this->delete_log_query_key])) {
                $this->admin_notice->add_transient(sprintf($this->notice_delete_log_group_success, $this->info->get_name(), $data[$this->delete_log_query_key]), 'success');
            } else {
                $this->admin_notice->add_transient(sprintf($this->notice_delete_log_error, $this->info->get_name()), 'error');
            }
        };
    }
    protected function handle_download_log(): callable
    {
        return function (array $data): void {
            if (!is_string($data[$this->download_log_query_key]) || !$this->is_log_file_exists($data[$this->download_log_query_key])) {
                $this->admin_notice->add_transient(sprintf($this->notice_download_log_error, $this->info->get_name()), 'error');
                return;
            }
            $group = $data[$this->download_log_query_key];
            $file_name = str_replace('.', '_', str_replace(array('http://', 'https://'), '', home_url())) . '_' . str_replace('-', '_', $this->info->get_textdomain()) . "_{$group}.log";
            $file_path = $this->get_log_file_path($group);
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename="' . $file_name . '"');
            header('Content-Length: ' . filesize($file_path));
            flush();
            readfile($file_path);
            // phpcs:ignore
            exit;
        };
    }
}
