<?php

namespace WPDevAssist\OmgCore;

defined('ABSPATH') || exit;
class FsTheme extends Fs
{
    public function get_url(string $rel = '', bool $stamp = \false): string
    {
        $url = get_theme_file_uri($rel);
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
        $path = get_stylesheet_directory() . '/';
        return $rel ? "{$path}{$rel}" : rtrim($path, '/\\');
    }
}
