<?php

namespace WPDevAssist\OmgCore;

defined('ABSPATH') || exit;
/**
 * File system manager.
 */
abstract class Fs extends Feature
{
    /**
     * Returns the URL to a plugin or theme file.
     *
     * @param string $rel Relative path to append to the URL.
     * @param bool $stamp Optional. Whether to append a file modification timestamp.
     *
     * @return string The full URL of the plugin directory or file.
     */
    abstract public function get_url(string $rel, bool $stamp = \false): string;
    /**
     * Returns the absolute path to a plugin or theme file.
     *
     * @param string $rel Relative path to append to the directory path.
     *
     * @return string The full path of the plugin directory or file.
     */
    abstract public function get_path(string $rel): string;
    /**
     * Writes text to a file at the specified path.
     *
     * @param string $path The path to the file.
     * @param string $text The text to write to the file.
     * @param int $permissions The permissions to set for the file (default: 0600).
     *
     * @return string The output of the error_log function, or an empty string on failure.
     */
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
    /**
     * Reads the last 1MB of a text file.
     *
     * @param string $path The path to the file.
     *
     * @return string The content read from the file, or an empty string if the file does not exist.
     */
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
