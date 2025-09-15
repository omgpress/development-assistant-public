<?php

namespace WPDevAssist\OmgCore\Helper;

defined('ABSPATH') || exit;
trait ConvertIso8601ToMin
{
    /**
     * Converts an ISO 8601 duration string to minutes.
     *
     * @param string $iso_duration The ISO 8601 duration string (e.g., "PT1H30M").
     *
     * @return int The total duration in minutes.
     */
    public function convert_iso8601_to_min(string $iso_duration): int
    {
        preg_match('/PT(\d+H)?(\d+M)?(\d+S)?/', $iso_duration, $matches);
        $hours = isset($matches[1]) ? intval($matches[1]) : 0;
        $minutes = isset($matches[2]) ? intval($matches[2]) : 0;
        $seconds = isset($matches[3]) ? intval($matches[3]) : 0;
        return $hours * 60 + $minutes + $seconds / 60;
    }
}
