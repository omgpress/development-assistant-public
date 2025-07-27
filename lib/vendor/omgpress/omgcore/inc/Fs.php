<?php

namespace WPDevAssist\OmgCore;

defined('ABSPATH') || exit;
abstract class Fs extends OmgFeature
{
    abstract public function get_url(string $rel, bool $stamp = \false): string;
    abstract public function get_path(string $rel): string;
    public function write_text_file(string $path, string $text, int $permissions = 0600): string
    {
        $output = error_log('/*test*/', '3', $path);
        // phpcs:ignore
        if ($output) {
            unlink($path);
            // phpcs:ignore
            error_log($text, '3', $path);
            // phpcs:ignore
            chmod($path, $permissions);
            // phpcs:ignore
        }
        return $output;
    }
    public function read_text_file(string $path): string
    {
        if (!file_exists($path)) {
            return '';
        }
        $file = fopen($path, 'r');
        // phpcs:ignore
        $response = '';
        fseek($file, -1048576, \SEEK_END);
        while (!feof($file)) {
            $response .= fgets($file);
        }
        fclose($file);
        // phpcs:ignore
        return $response;
    }
}
