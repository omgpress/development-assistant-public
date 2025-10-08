<?php

namespace WPDevAssist\OmgCore;

use Exception;
defined('ABSPATH') || exit;
/**
 * @ignore
 */
class FsPlugin extends Fs
{
    protected string $root_file;
    public function __construct(string $root_file)
    {
        parent::__construct();
        $this->root_file = $root_file;
    }
    public function get_url(string $rel = '', bool $stamp = \false): string
    {
        $url = plugin_dir_url($this->root_file);
        $url = $rel ? $url . $rel : rtrim($url, '/\\');
        if ($stamp) {
            $path = $this->get_path($rel);
            if (!file_exists($path)) {
                return $url;
            }
            return add_query_arg(array('ver' => filemtime($path)), $url);
        }
        return $url;
    }
    public function get_path(string $rel = ''): string
    {
        $path = plugin_dir_path($this->root_file);
        return $rel ? "{$path}{$rel}" : rtrim($path, '/\\');
    }
}
