<?php

namespace WPDevAssist\OmgCore\Helper;

defined('ABSPATH') || exit;
trait DashToCamelcase
{
    /**
     * Converts a dash-separated string to camelCase.
     *
     * @param string $str The input string in dash format.
     * @param bool $ucfirst Whether to capitalize the first letter of the result.
     *
     * @return string The converted camelCase string.
     */
    public function dash_to_camelcase(string $str, bool $ucfirst = \false): string
    {
        $words = explode('-', $str);
        $words = array_map('ucfirst', $words);
        $words[0] = $ucfirst ? ucfirst($words[0]) : lcfirst($words[0]);
        return implode('', $words);
    }
}
